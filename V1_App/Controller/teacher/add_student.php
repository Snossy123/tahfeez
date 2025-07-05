<?php include 'header.php'; include '../../Config/db.php'; ?>

<h3>إضافة طالب جديد</h3>

<form method="post">
    الاسم الكامل: <input name="full_name" required><br>
    اسم المستخدم: <input name="username" required><br>
    كلمة المرور: <input type="password" name="password" required><br>
    <button type="submit">إضافة</button>
</form>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = $_POST['full_name'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $pdo->prepare("INSERT INTO users (username, password, role, full_name) VALUES (?, ?, 'student', ?)")
        ->execute([$username, $password, $full_name]);

    $user_id = $pdo->lastInsertId();
    $pdo->prepare("INSERT INTO students (user_id, progress) VALUES (?, '')")->execute([$user_id]);

    echo "<p>تمت إضافة الطالب بنجاح!</p>";
}
?>

<?php include 'footer.php'; ?>
