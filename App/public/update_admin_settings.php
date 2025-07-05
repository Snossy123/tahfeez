<?php
require_once '../config/db.php';
session_start();

if ($_SESSION['user']['role'] !== 'admin') {
    header('Location: unauthorized.php');
    exit;
}

$user_id = $_POST['user_id'];
$name = trim($_POST['name']);
$email = trim($_POST['email']);
$whatsapp = trim($_POST['whatsapp_number']);
$new_password = $_POST['new_password'];

if (!empty($new_password)) {
    $hashed = password_hash($new_password, PASSWORD_BCRYPT);
    $stmt = $pdo->prepare("UPDATE users SET name = ?, email = ?, whatsapp_number = ?, password = ? WHERE id = ?");
    $stmt->execute([$name, $email, $whatsapp, $hashed, $user_id]);
} else {
    $stmt = $pdo->prepare("UPDATE users SET name = ?, email = ?, whatsapp_number = ? WHERE id = ?");
    $stmt->execute([$name, $email, $whatsapp, $user_id]);
}

$_SESSION['success'] = "تم تحديث بيانات المشرف بنجاح.";
header("Location: admin_settings.php");
exit;
