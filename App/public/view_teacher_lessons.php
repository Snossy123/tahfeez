<?php
require_once '../config/db.php';
session_start();

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'teacher') {
    header("Location: login.php");
    exit;
}

$teacher_id = $_SESSION['user']['id'];

// جلب الدروس الخاصة بالمحفظ
$stmt = $pdo->prepare("
    SELECT l.*, 
        GROUP_CONCAT(u.name SEPARATOR ', ') AS student_names
    FROM lessons l
    LEFT JOIN lesson_student ls ON l.id = ls.lesson_id
    LEFT JOIN students s ON ls.student_id = s.id
    LEFT JOIN users u ON s.user_id = u.id
    WHERE l.teacher_id = ?
    GROUP BY l.id
    ORDER BY l.date DESC, l.time DESC;
");
$stmt->execute([$teacher_id]);
$lessons = $stmt->fetchAll(PDO::FETCH_ASSOC);

require_once '../includes/language.php';
require_once '../includes/avatar.php';

$pageTitle = 'list_lessons';
require_once '../views/teacher/layout.php';
