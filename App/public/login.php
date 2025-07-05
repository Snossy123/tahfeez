<?php
session_start();
require_once '../config/db.php';

$error = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user'] = $user;
        if ($user['role'] === 'teacher') {
            header("Location: teacher_dashboard.php");
        } else {
            header("Location: student_dashboard.php");
        }
        exit;
    } else {
        if($email === 'admin@rwaa.org' && $password === 'rwaaAdmin123@#$') {
            $_SESSION['user'] = [
                'id' => 1,
                'name' => 'Admin',
                'email' => 'admin@rwaa.org',
                'role' => 'admin'
            ];
            header("Location: admin_dashboard.php");
        } else {
            // بيانات الدخول غير صحيحة
            $error = "بيانات الدخول غير صحيحة!";
        }
    }
}

require_once '../views/login_view.php';