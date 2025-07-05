<?php
require_once '../config/db.php';
session_start();

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'student') {
    header("Location: ../login.php");
    exit;
}

$lessons = [];
// الخطوة 1: جلب student_id الحقيقي من جدول students
$user_id = $_SESSION['user']['id'];

$stmt = $pdo->prepare("SELECT id FROM students WHERE user_id = ?");
$stmt->execute([$user_id]);
$student = $stmt->fetch();

if ($student) {
    $student_id = $student['id'];
    // الخطوة 2: جلب الدروس المرتبطة بالطالب
    $stmt = $pdo->prepare("
        SELECT lessons.*, users.name AS teacher_name 
        FROM lessons
        JOIN lesson_student ON lessons.id = lesson_student.lesson_id
        JOIN users ON lessons.teacher_id = users.id
        WHERE lesson_student.student_id = ?
        ORDER BY lessons.date, lessons.time
    ");
    $stmt->execute([$student_id]);
    $lessons = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

require_once '../views/student_dashboard_view.php';
// عرض الدروس القادمة للطالب