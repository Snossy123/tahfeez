<?php
require_once '../config/db.php';
session_start();

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'teacher') {
  header("Location: login.php");
  exit;
}

$user_id = $_SESSION['user']['id'];

$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

require_once '../includes/language.php';
require_once '../includes/avatar.php';

$pageTitle = 'setting_teacher_page_title';
require_once '../views/teacher/layout.php';
