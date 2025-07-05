<?php
require_once '../config/db.php';
session_start();

// تأكد إن المستخدم مسجل الدخول ومحفظ
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'teacher') {
    header("Location: login.php");
    exit;
}

$teacher_id = $_SESSION['user']['id'];

// جلب الطلاب المرتبطين بالمحفظ
$stmt = $pdo->prepare("SELECT students.id, users.name, students.grade FROM students JOIN users ON students.user_id = users.id WHERE students.teacher_id = ?");
$stmt->execute([$teacher_id]);
$students = $stmt->fetchAll();

require_once '../includes/language.php';
require_once '../includes/avatar.php';

$pageTitle = 'teacher_dashboard';
require_once '../views/teacher/layout.php';
