<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'teacher') {
    header("Location: ../login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>لوحة المحفظ</title>
    <style>
        body { font-family: 'Arial'; direction: rtl; }
        nav a { margin: 10px; text-decoration: none; }
    </style>
</head>
<body>
<nav>
    <a href="home.php">الرئيسية</a>
    <a href="students.php">الطلاب</a>
    <a href="classes.php">الحلقات</a>
    <a href="attendance.php">الحضور</a>
    <a href="messages.php">الرسائل</a>
    <a href="settings.php">الإعدادات</a>
    <a href="../logout.php">🚪 تسجيل الخروج</a>
</nav>
<hr>
