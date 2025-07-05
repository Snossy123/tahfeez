<?php include 'header.php'; include '../../Config/db.php'; ?>

<h3>إدارة الطلاب</h3>
<a href="add_student.php">+ إضافة طالب</a><br><br>

<table border="1" cellpadding="8">
    <tr>
        <th>الاسم</th>
        <th>التقدم</th>
    </tr>
    <?php
    $stmt = $pdo->query("SELECT s.id, u.full_name, s.progress FROM students s JOIN users u ON s.user_id = u.id");
    foreach ($stmt as $row) {
        echo "<tr>
            <td>{$row['full_name']}</td>
            <td>{$row['progress']}</td>
        </tr>";
    }
    ?>
</table>

<?php include 'footer.php'; ?>
