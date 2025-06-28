<?php include 'header.php'; include '../../Config/db.php'; ?>

<h3>إضافة مستخدم</h3>

<form method="post">
    الاسم الكامل: <input name="full_name" required><br>
    اسم المستخدم: <input name="username" required><br>
    كلمة المرور: <input type="password" name="password" required><br>
    الدور:
    <select name="role" required>
        <option value="admin">إدارة</option>
        <option value="teacher">محفظ</option>
        <option value="student">طالب</option>
        <option value="parent">ولي أمر</option>
    </select><br>
    <button type="submit">إضافة</button>
</form>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare("INSERT INTO users (username, password, role, full_name) VALUES (?, ?, ?, ?)");
    $stmt->execute([
        $_POST['username'],
        password_hash($_POST['password'], PASSWORD_DEFAULT),
        $_POST['role'],
        $_POST['full_name']
    ]);

    if ($_POST['role'] === 'student') {
        $pdo->prepare("INSERT INTO students (user_id, progress) VALUES (?, '')")->execute([$pdo->lastInsertId()]);
    }

    echo "<p>✅ تم إنشاء المستخدم.</p>";
}
?>

<?php include 'footer.php'; ?>
