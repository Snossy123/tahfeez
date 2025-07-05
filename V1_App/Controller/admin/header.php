<?php
session_start();
include '../../Config/db.php';
$pending_count = $pdo->query("SELECT COUNT(*) FROM users WHERE is_approved = 0")->fetchColumn();

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>لوحة الإدارة</title>
    <style>
        body { font-family: 'Arial'; direction: rtl; }
        nav a { margin: 10px; text-decoration: none; }
    </style>
</head>
<body>
<nav>
    <a href="home.php">الرئيسية</a>
    <a href="users.php">المستخدمين</a>
    <a href="link_parent.php">ربط ولي بالأبناء</a>
    <a href="content.php">المحتوى</a>
    <a href="reports.php">التقارير</a>
    <a href="settings.php">الإعدادات</a>
    <a href="../logout.php">🚪 تسجيل الخروج</a>
</nav>
<?php if ($pending_count > 0): ?>
    <div style="background: #ffeb3b; padding: 10px; color: #000; margin: 10px 0; border-radius: 8px;">
        ⚠️ يوجد <strong><?= $pending_count ?></strong> حساب جديد بانتظار التفعيل.
        <a href="users.php" style="margin-right: 20px; font-weight: bold;">🔧 اذهب للتفعيل</a>
    </div>
<?php endif; ?>

<hr>
