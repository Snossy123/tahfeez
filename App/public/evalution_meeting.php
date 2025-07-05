<?php
require_once '../config/db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $attendance = $_POST['attendance']; // 'present' أو 'absent'
    $rating = isset($_POST['rating']) ? (int)$_POST['rating'] : null;
    $notes = $_POST['notes'];
    $lesson_id = (int)$_POST['lesson_id'];
    $student_id = (int)$_POST['student_id'];

    // تحديث جدول lessons_students
    $stmt = $pdo->prepare("UPDATE lesson_student SET attendance = ?, rating = ?, notes = ? WHERE lesson_id = ? AND student_id = ?");
    $stmt->execute([$attendance, $rating, $notes, $lesson_id, $student_id]);

    $_SESSION['success'] = 'تم تحديث الحضور والتقييم.';
    header("Location: view_teacher_lessons.php");
    exit;
}
?>