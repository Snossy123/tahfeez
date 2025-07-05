<?php
require_once '../config/db.php';
session_start();

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'teacher') {
    header("Location: login.php");
    exit;
}

$teacher_id = $_SESSION['user']['id'];
$students = $_POST['students'] ?? [];
$date = $_POST['date'] ?? '';
$time = $_POST['time'] ?? '';
$duration = $_POST['duration'] ?? 0;
$meet_link = $_POST['meet_link'] ?? '';
$notes = $_POST['notes'] ?? '';

if (empty($students) || !$date || !$time || !$duration) {
    die("❌ جميع الحقول مطلوبة.");
}

try {
    $pdo->beginTransaction();

    // إدراج الدرس
    $stmt = $pdo->prepare("INSERT INTO lessons (teacher_id, date, time, duration, google_meet_link, notes) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$teacher_id, $date, $time, $duration, $meet_link, $notes]);
    $lesson_id = $pdo->lastInsertId();

    // ربط الطلاب بالدرس وتحديث عدد الحصص المستخدمة
    $lesson_student_stmt = $pdo->prepare("INSERT INTO lesson_student (lesson_id, student_id) VALUES (?, ?)");
    $update_subscription_stmt = $pdo->prepare("
        UPDATE subscriptions
        SET used_lessons = used_lessons + 1
        WHERE student_id = ? AND end_date >= CURDATE() AND used_lessons < total_lessons
        ORDER BY end_date DESC
        LIMIT 1
    ");

    foreach ($students as $student_id) {
        $lesson_student_stmt->execute([$lesson_id, $student_id]);
        $update_subscription_stmt->execute([$student_id]);
    }

    $pdo->commit();
    header("Location: view_teacher_lessons.php?success=1");
    exit;

} catch (Exception $e) {
    $pdo->rollBack();
    die("❌ حصل خطأ أثناء حفظ الدرس: " . $e->getMessage());
}
