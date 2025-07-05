<?php
require_once '../config/db.php';
session_start();

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'teacher') {
    header("Location: login.php");
    exit;
}

$lesson_id = $_POST['lesson_id'];
$date = $_POST['date'];
$time = $_POST['time'];
$duration = $_POST['duration'];
$link = $_POST['google_meet_link'];
$notes = $_POST['notes'];
$teacher_id = $_SESSION['user']['id'];

$selected_students = $_POST['students'] ?? [];

try {
    $pdo->beginTransaction();

    // 1. تحديث بيانات الدرس
    $stmt = $pdo->prepare("UPDATE lessons SET date = ?, time = ?, duration = ?, google_meet_link = ?, notes = ? WHERE id = ? AND teacher_id = ?");
    $stmt->execute([$date, $time, $duration, $link, $notes, $lesson_id, $teacher_id]);

    // 2. جلب الطلاب السابقين المرتبطين بالدرس
    $stmt = $pdo->prepare("SELECT student_id FROM lesson_student WHERE lesson_id = ?");
    $stmt->execute([$lesson_id]);
    $old_students = $stmt->fetchAll(PDO::FETCH_COLUMN);

    // 3. حذف كل الربط السابق
    $stmt = $pdo->prepare("DELETE FROM lesson_student WHERE lesson_id = ?");
    $stmt->execute([$lesson_id]);

    // 4. إعادة الحصة للمحذوفين من الدرس
    $removed_students = array_diff($old_students, $selected_students);
    foreach ($removed_students as $student_id) {
        $pdo->prepare("UPDATE students SET used_lessons = used_lessons - 1 WHERE id = ?")
            ->execute([$student_id]);
    }

    // 5. ربط الطلاب الجدد وخصم الحصة لو لسه عنده حصص
    foreach ($selected_students as $student_id) {
        $pdo->prepare("INSERT INTO lesson_student (lesson_id, student_id) VALUES (?, ?)")
            ->execute([$lesson_id, $student_id]);

        if (!in_array($student_id, $old_students)) {
            // خصم حصة لو الطالب جديد في الدرس
            $stmt = $pdo->prepare("SELECT remaining_sessions FROM students WHERE id = ?");
            $stmt->execute([$student_id]);
            $remaining = $stmt->fetchColumn();

            if ($remaining > 0) {
                $pdo->prepare("UPDATE students SET used_lessons = used_lessons + 1 WHERE id = ?")
                    ->execute([$student_id]);
            }
        }
    }

    $pdo->commit();
    $_SESSION['success'] = "تم تحديث الدرس بنجاح.";
    header("Location: view_teacher_lessons.php");
    exit;

} catch (Exception $e) {
    $pdo->rollBack();
    echo "خطأ: " . $e->getMessage();
}
