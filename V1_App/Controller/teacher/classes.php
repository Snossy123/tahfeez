<?php include 'header.php'; include '../../Config/db.php'; ?>

<h3>جدول الحلقات</h3>

<form method="post">
    <label>الوصف:</label><br>
    <textarea name="description" required></textarea><br>
    <label>الموعد:</label><br>
    <input type="datetime-local" name="class_time" required><br>
    <button type="submit">إنشاء حلقة</button>
</form>
<hr>

<?php
// إنشاء الحلقة
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $teacher_id = $_SESSION['user']['id'];
    $description = $_POST['description'];
    $class_time = $_POST['class_time'];

    $stmt = $pdo->prepare("INSERT INTO classes (teacher_id, class_time, description) VALUES (?, ?, ?)");
    $stmt->execute([$teacher_id, $class_time, $description]);
    echo "<p>✅ تم إنشاء الحلقة بنجاح!</p>";
}

// عرض الحلقات
$stmt = $pdo->prepare("SELECT * FROM classes WHERE teacher_id = ?");
$stmt->execute([$_SESSION['user']['id']]);
$classes = $stmt->fetchAll();
?>

<h4>الحلقات القادمة</h4>
<table border="1" cellpadding="8">
    <tr>
        <th>الوصف</th>
        <th>التاريخ والوقت</th>
    </tr>
    <?php foreach ($classes as $c): ?>
    <tr>
        <td><?= htmlspecialchars($c['description']) ?></td>
        <td><?= $c['class_time'] ?></td>
    </tr>
    <?php endforeach; ?>
</table>

<?php include 'footer.php'; ?>
