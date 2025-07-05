<?php
require_once '../config/db.php';
session_start();

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'teacher') {
    header("Location: login.php");
    exit;
}

$teacher_id = $_SESSION['user']['id'];

// جلب الطلاب المؤهلين (اشتراك شغال + باقي حصص)
$query = "
SELECT students.id AS student_id, users.name, subscriptions.total_lessons, subscriptions.used_lessons, subscriptions.end_date
FROM students
JOIN users ON students.user_id = users.id
JOIN subscriptions ON subscriptions.student_id = students.id
WHERE students.teacher_id = ?
  AND subscriptions.end_date >= CURDATE()
  AND subscriptions.used_lessons < subscriptions.total_lessons
";

$stmt = $pdo->prepare($query);
$stmt->execute([$teacher_id]);
$students = $stmt->fetchAll();

require_once '../includes/language.php';
require_once '../includes/avatar.php';

$pageTitle = 'add_lesson_page_title';
require_once '../views/teacher/layout.php';