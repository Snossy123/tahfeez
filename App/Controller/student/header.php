<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'student') {
    header("Location: ../login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>لوحة الطالب</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            direction: rtl;
            margin: 0;
            padding: 0;
        }
        nav {
            background-color: #f0f0f0;
            padding: 10px 20px;
            display: flex;
            justify-content: flex-end;
            gap: 15px;
        }
        nav a {
            text-decoration: none;
            color: #333;
            font-weight: bold;
        }
        nav a:hover {
            color: #007bff;
        }
        hr {
            margin: 0;
        }
    </style>
</head>
<body>
<nav>
    <a href="home.php">التقدم</a>
    <a href="recitations.php">التلاوات</a>
    <a href="messages.php">التواصل</a>
    <a href="settings.php">الإعدادات</a>
    <a href="memorize.php">📖 الحفظ</a>
    <a href="../logout.php">🚪 تسجيل الخروج</a>
</nav>
<hr>