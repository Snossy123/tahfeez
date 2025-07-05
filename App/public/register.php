<?php
require_once '../config/db.php';

$errors = [];
$success = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name     = $_POST['name'];
    $email    = $_POST['email'];
    $password = $_POST['password'];
    $whatsapp_number = $_POST['whatsapp_number'] ?? null;
    $role     = $_POST['role'];
    $grade    = $_POST['grade'] ?? null;
    $teacher_id = $_POST['teacher_id'] ?? null;

    $errors = [];

    // تحقق إن الإيميل غير مستخدم
    $check = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $check->execute([$email]);
    if ($check->fetch()) {
        $errors[] = "هذا البريد الإلكتروني مسجّل بالفعل.";
    }

    // ✅ تحقق من تنسيق رقم الواتساب الدولي (مثل: +201001234567)
    if ($whatsapp_number && !preg_match('/^\+\d{10,15}$/', $whatsapp_number)) {
        $errors[] = "يرجى إدخال رقم واتساب بصيغة دولية صحيحة مثل: +201001234567";
    }

    if (empty($errors)) {
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        // 1. أنشئ المستخدم
        $stmt = $pdo->prepare("INSERT INTO users (name, email, password, whatsapp_number, role) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$name, $email, $hashed_password, $whatsapp_number, $role]);
        $user_id = $pdo->lastInsertId();

        // 2. لو طالب، احفظ بيانات إضافية
        if ($role === 'student') {
            $stmt2 = $pdo->prepare("INSERT INTO students (user_id, grade, teacher_id) VALUES (?, ?, ?)");
            $stmt2->execute([$user_id, $grade, $teacher_id]);
        }

        $success = "تم إنشاء الحساب بنجاح! يمكنك الآن تسجيل الدخول.";
    }
}

require_once '../views/register_view.php'; 