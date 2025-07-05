<?php
require_once '../config/db.php';
session_start();

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'teacher') {
    header("Location: login.php");
    exit;
}

$lesson_id = $_GET['id'] ?? null;
$teacher_id = $_SESSION['user']['id'];

if ($lesson_id) {
    // تأكد أن الدرس يخص المحفظ الحالي
    $stmt = $pdo->prepare("SELECT * FROM lessons WHERE id = ? AND teacher_id = ?");
    $stmt->execute([$lesson_id, $teacher_id]);
    $lesson = $stmt->fetch();

    if ($lesson) {
        // 1. جيب الطلاب المشاركين في الدرس
        $stmtStudents = $pdo->prepare("SELECT student_id FROM lesson_student WHERE lesson_id = ?");
        $stmtStudents->execute([$lesson_id]);
        $students = $stmtStudents->fetchAll(PDO::FETCH_COLUMN);

        // 2. زود لكل طالب حصة واحدة
        foreach ($students as $student_id) {
            $pdo->prepare("UPDATE subscriptions SET used_lessons = used_lessons - 1 WHERE student_id = ?")->execute([$student_id]);
        }

        // 3. احذف الربط بين الدرس والطلاب
        $pdo->prepare("DELETE FROM lesson_student WHERE lesson_id = ?")->execute([$lesson_id]);

        // 4. احذف الدرس نفسه
        $pdo->prepare("DELETE FROM lessons WHERE id = ?")->execute([$lesson_id]);
    }
}

header("Location: view_teacher_lessons.php");
exit;
