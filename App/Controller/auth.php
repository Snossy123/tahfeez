<?php
session_start();
include '../Config/db.php';

$mode = $_GET['mode'] ?? 'login';
$errors = [];

// تسجيل الدخول
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $mode === 'login') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        if ($user['role'] !== 'admin' && !$user['is_approved']) {
            $errors[] = "❌ حسابك قيد المراجعة. سيتم تفعيله بعد موافقة الإدارة.";
        } else {
            $_SESSION['user'] = $user;
            header("Location: dashboard.php");
            exit;
        }
    } else {
        $errors[] = "❌ اسم المستخدم أو كلمة المرور غير صحيحة.";
    }

}

// إنشاء حساب جديد
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $mode === 'register') {
    $full_name = $_POST['full_name'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    // تحقق من عدم تكرار اسم المستخدم
    $check = $pdo->prepare("SELECT COUNT(*) FROM users WHERE username = ?");
    $check->execute([$username]);
    if ($check->fetchColumn() > 0) {
        $errors[] = "❌ اسم المستخدم مستخدم بالفعل.";
    } else {
        $stmt = $pdo->prepare("INSERT INTO users (username, password, role, full_name) VALUES (?, ?, ?, ?)");
        $stmt->execute([$username, $password, $role, $full_name]);
        $user_id = $pdo->lastInsertId();

        if ($role === 'student') {
            $pdo->prepare("INSERT INTO students (user_id, progress) VALUES (?, '')")->execute([$user_id]);
        }

        $_SESSION['user'] = [
            'id' => $user_id,
            'username' => $username,
            'role' => $role,
            'full_name' => $full_name
        ];

        header("Location: auth.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title><?= $mode === 'register' ? 'إنشاء حساب جديد' : 'تسجيل الدخول' ?></title>
    <style>
        body { font-family: 'Arial'; direction: rtl; background: #f2f2f2; padding: 50px; }
        form { max-width: 400px; margin: auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
        input, select { width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 6px; }
        button { width: 100%; background: #1e3c72; color: white; padding: 10px; border: none; border-radius: 6px; font-weight: bold; }
        .toggle { text-align: center; margin-top: 20px; }
        .errors { color: red; margin-bottom: 10px; }
    </style>
</head>
<body>

<form method="post">
    <h2 style="text-align:center;"><?= $mode === 'register' ? '📝 إنشاء حساب جديد' : '🔐 تسجيل الدخول' ?></h2>

    <?php foreach ($errors as $e): ?>
        <div class="errors"><?= $e ?></div>
    <?php endforeach; ?>

    <?php if ($mode === 'register'): ?>
        <input name="full_name" placeholder="الاسم الكامل" required>
    <?php endif; ?>

    <input name="username" placeholder="اسم المستخدم" required>
    <input type="password" name="password" placeholder="كلمة المرور" required>

    <?php if ($mode === 'register'): ?>
        <select name="role" required>
            <option value="">اختر الدور</option>
            <option value="student">طالب</option>
            <option value="teacher">محفظ</option>
            <option value="parent">ولي أمر</option>
        </select>
    <?php endif; ?>

    <button type="submit"><?= $mode === 'register' ? 'إنشاء الحساب' : 'تسجيل الدخول' ?></button>

    <div class="toggle">
        <?php if ($mode === 'login'): ?>
            ليس لديك حساب؟ <a href="?mode=register">إنشاء حساب جديد</a>
        <?php else: ?>
            لديك حساب؟ <a href="?mode=login">تسجيل الدخول</a>
        <?php endif; ?>
    </div>
    <div style="text-align: center; margin-top: 20px;">
        <a href="../../Public/index.php">العودة للصفحة الرئيسية</a>
    </div>
</form>

</body>
</html>
