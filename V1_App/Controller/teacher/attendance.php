<?php include 'header.php'; include '../../Config/db.php'; ?>

<h3>تسجيل الحضور</h3>

<form method="post">
    <label>اختر التاريخ:</label>
    <input type="date" name="date" required>
    <br><br>
    <table border="1" cellpadding="8">
        <tr>
            <th>اسم الطالب</th>
            <th>الحالة</th>
        </tr>
        <?php
        $students = $pdo->query("SELECT s.id, u.full_name FROM students s JOIN users u ON s.user_id = u.id")->fetchAll();
        foreach ($students as $student):
        ?>
            <tr>
                <td><?= htmlspecialchars($student['full_name']) ?></td>
                <td>
                    <select name="attendance[<?= $student['id'] ?>]">
                        <option value="present">حاضر</option>
                        <option value="absent">غائب</option>
                    </select>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
    <br>
    <button type="submit">حفظ الحضور</button>
</form>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $date = $_POST['date'];
    $attendance = $_POST['attendance'] ?? [];

    foreach ($attendance as $student_id => $status) {
        $stmt = $pdo->prepare("INSERT INTO attendance (student_id, date, status) VALUES (?, ?, ?)");
        $stmt->execute([$student_id, $date, $status]);
    }
    echo "<p>✅ تم حفظ الحضور بنجاح!</p>";
}
?>

<?php include 'footer.php'; ?>
