<?php include 'header.php'; include '../../Config/db.php'; ?>

<h3>ربط ولي أمر بأبنائه</h3>

<form method="post">
    <label>ولي الأمر:</label>
    <select name="parent_id" required>
        <?php
        $parents = $pdo->query("SELECT id, full_name FROM users WHERE role = 'parent'")->fetchAll();
        foreach ($parents as $p) {
            echo "<option value='{$p['id']}'>{$p['full_name']}</option>";
        }
        ?>
    </select><br><br>

    <label>اختر طالبًا:</label>
    <select name="student_id" required>
        <?php
        $students = $pdo->query("SELECT s.id, u.full_name FROM students s JOIN users u ON s.user_id = u.id")->fetchAll();
        foreach ($students as $s) {
            echo "<option value='{$s['id']}'>{$s['full_name']}</option>";
        }
        ?>
    </select><br><br>

    <button type="submit">ربط</button>
</form>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pdo->prepare("INSERT IGNORE INTO parent_students (parent_id, student_id) VALUES (?, ?)")
        ->execute([$_POST['parent_id'], $_POST['student_id']]);
    echo "<p>✅ تم الربط بنجاح.</p>";
}
?>

<?php include 'footer.php'; ?>
