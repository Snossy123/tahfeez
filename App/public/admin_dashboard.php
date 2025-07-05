<?php
require_once '../config/db.php';

// تأكد إن المستخدم مسجل الدخول ومحفظ
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

$admin = $_SESSION['user']['id'];

require_once '../includes/language.php';
require_once '../includes/avatar.php';

$pageTitle = 'admin_dashboard';
require_once '../views/admin/layout.php';
