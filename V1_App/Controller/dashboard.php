<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$user = $_SESSION['user'];
$role = $user['role'];

switch ($role) {
    case 'admin':
        header("Location: admin/home.php");
        break;
    case 'teacher':
        header("Location: teacher/home.php");
        break;
    case 'student':
        header("Location: student/home.php");
        break;
    case 'parent':
        header("Location: parent/home.php");
        break;
}
exit;
