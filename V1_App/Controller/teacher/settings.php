<?php include 'header.php'; include '../../Config/db.php'; ?>

<h3>الإعدادات الشخصية</h3>

<form method="post">
    <label>الاسم الكامل:</label>
    <input name="full_name" value="<?= $_SESSION['user']['full_name'] ?>" required><br><br>

    <label>كلمة المرور الجديدة:</label>
    <input type="password" name="new_password" placeholder="اتركها فارغة إن لم ترغب في تغييرها"><br><br>

    <button type="submit">تحديث</button>
</form>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_SESSION['user']['id'];
    $full_name = $_POST['full_name'];
    $new_password = $_POST['new_password'];

    if (!empty($new_password)) {
        $hashed = password_hash($new_password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("UPDATE users SET full_name = ?, password = ? WHERE id = ?");
        $stmt->execute([$full_name, $hashed, $id]);
    } else {
        $stmt = $pdo->prepare("UPDATE users SET full_name = ? WHERE id = ?");
        $stmt->execute([$full_name, $id]);
    }

    $_SESSION['user']['full_name'] = $full_name;
    echo "<p>✅ تم تحديث البيانات بنجاح!</p>";
}
?>

<?php include 'footer.php'; ?>
