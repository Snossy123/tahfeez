<?php
require 'db.php';
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
  header("Location: login.php");
  exit;
}

// تعديل أي مستخدم عبر ?id=XX
$target_user_id = $_GET['id'] ?? null;
if (!$target_user_id) {
  die("يجب تحديد معرف المستخدم.");
}

$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$target_user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
  die("المستخدم غير موجود.");
}

$is_student = ($user['role'] === 'student');
$student = null;

if ($is_student) {
  $stmt = $pdo->prepare("SELECT * FROM students WHERE user_id = ?");
  $stmt->execute([$target_user_id]);
  $student = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>

<h2>إعدادات المستخدم (المشرف)</h2>
<form action="update_admin_settings.php" method="POST">
  <input type="hidden" name="user_id" value="<?= $user['id'] ?>">

  <label>الاسم:</label>
  <input type="text" name="name" value="<?= htmlspecialchars($user['name']) ?>" required><br>

  <label>البريد الإلكتروني:</label>
  <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required><br>

  <label>رقم واتساب:</label>
  <input type="text" name="whatsapp_number" value="<?= htmlspecialchars($user['whatsapp_number']) ?>" placeholder="+201234567890"><br>

  <?php if ($is_student): ?>
    <label>الصف الدراسي:</label>
    <input type="text" name="grade" value="<?= htmlspecialchars($student['grade'] ?? '') ?>"><br>
  <?php endif; ?>

  <label>كلمة المرور الجديدة:</label>
  <input type="password" name="new_password"><br>

  <button type="submit">تحديث</button>
</form>
