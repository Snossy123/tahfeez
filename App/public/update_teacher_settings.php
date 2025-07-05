<?php
require_once '../config/db.php';
session_start();

// تحقق من الصلاحيات (مثال: فقط المعلمين)
if ($_SESSION['user']['role'] !== 'teacher') {
    header('Location: unauthorized.php');
    exit;
}

$user_id = $_POST['user_id'];
$name = trim($_POST['name']);
$email = trim($_POST['email']);
$whatsapp = trim($_POST['whatsapp_number']);
$new_password = $_POST['new_password'];

// تحديث البيانات
if (!empty($new_password)) {
    $hashed = password_hash($new_password, PASSWORD_BCRYPT);
    $stmt = $pdo->prepare("UPDATE users SET name = ?, email = ?, whatsapp_number = ?, password = ? WHERE id = ?");
    $stmt->execute([$name, $email, $whatsapp, $hashed, $user_id]);
} else {
    $stmt = $pdo->prepare("UPDATE users SET name = ?, email = ?, whatsapp_number = ? WHERE id = ?");
    $stmt->execute([$name, $email, $whatsapp, $user_id]);
}

// جلب البيانات المحدثة وتحديث الجلسة
$stmt = $pdo->prepare("SELECT id, name, email, whatsapp_number, role FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$updatedUser = $stmt->fetch(PDO::FETCH_ASSOC);

$_SESSION['user'] = $updatedUser;

$_SESSION['success'] = "تم تحديث البيانات بنجاح.";
header("Location: settings_teacher.php");
exit;
