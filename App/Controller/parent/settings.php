<?php include 'header.php'; include '../../Config/db.php'; ?>

<h3>إعدادات الحساب</h3>

<form method="post">
    الاسم الكامل: <input name="full_name" value="<?= $_SESSION['user']['full_name'] ?>" required><br><br>
    كلمة المرور الجديدة (اختياري): <input type="password" name="new_password"><br><br>
    <button type="submit">حفظ التعديلات</button>
</form>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_SESSION['user']['id'];
    $full_name = $_POST['full_name'];
    $new_password = $_POST['new_password'];

    if (!empty($new_password)) {
        $hashed = password_hash($new_password, PASSWORD_DEFAULT);
        $pdo->prepare("UPDATE users SET full_name = ?, password = ? WHERE id = ?")
            ->execute([$full_name, $hashed, $id]);
    } else {
        $pdo->prepare("UPDATE users SET full_name = ? WHERE id = ?")
            ->execute([$full_name, $id]);
    }

    $_SESSION['user']['full_name'] = $full_name;
    echo "<p>✅ تم تحديث البيانات بنجاح!</p>";
}
?>

<?php include 'footer.php'; ?>
