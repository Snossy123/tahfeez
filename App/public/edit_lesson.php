<?php
require_once '../config/db.php';
session_start();

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'teacher') {
    header("Location: login.php");
    exit;
}

$lesson_id = $_GET['id'] ?? null;
$teacher_id = $_SESSION['user']['id'];

if (!$lesson_id) {
    header("Location: teacher_dashboard.php");
    exit;
}

// 1. جلب بيانات الدرس
$stmt = $pdo->prepare("SELECT * FROM lessons WHERE id = ? AND teacher_id = ?");
$stmt->execute([$lesson_id, $teacher_id]);
$lesson = $stmt->fetch();

if (!$lesson) {
    echo "الدرس غير موجود";
    exit;
}

// 2. جلب الطلاب المرتبطين حاليًا بالدرس
$stmt = $pdo->prepare("SELECT student_id FROM lesson_student WHERE lesson_id = ?");
$stmt->execute([$lesson_id]);
$current_students = $stmt->fetchAll(PDO::FETCH_COLUMN);

// 3. جلب طلاب المحفظ
$stmt = $pdo->prepare("
  SELECT 
    students.*,
    users.name AS student_name,
    students.grade,
    subscriptions.id AS subscription_id,
    subscriptions.start_date,
    subscriptions.end_date,
    subscriptions.total_lessons,
    subscriptions.used_lessons
  FROM students
  JOIN users ON students.user_id = users.id
  LEFT JOIN subscriptions ON students.id = subscriptions.student_id
  WHERE students.teacher_id = ?
");
$stmt->execute([$teacher_id]);
$students = $stmt->fetchAll();

require_once '../includes/language.php';
require_once '../includes/avatar.php';

$pageTitle = 'edit_lesson_page_title';
require_once '../views/teacher/layout.php';