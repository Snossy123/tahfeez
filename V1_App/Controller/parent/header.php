<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'parent') {
    header("Location: ../login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>لوحة ولي الأمر</title>
    <style>
        body { font-family: 'Arial'; direction: rtl; }
        nav a { margin: 10px; text-decoration: none; }
    </style>
</head>
<body>
<nav>
    <a href="home.php">أبنائي</a>
    <a href="attendance.php">الحضور</a>
    <a href="messages.php">التواصل مع المحفظ</a>
    <a href="settings.php">الإعدادات</a>
    <a href="../logout.php">🚪 تسجيل الخروج</a>
</nav>
<hr>
