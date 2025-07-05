<?php include 'header.php'; include '../../Config/db.php'; ?>

<h3>سجلات الحضور</h3>

<?php
$parent_id = $_SESSION['user']['id'];

$stmt = $pdo->prepare("
    SELECT u.full_name, a.date, a.status
    FROM parent_students ps
    JOIN students s ON ps.student_id = s.id
    JOIN attendance a ON a.student_id = s.id
    JOIN users u ON s.user_id = u.id
    WHERE ps.parent_id = ?
    ORDER BY a.date DESC
");
$stmt->execute([$parent_id]);
$records = $stmt->fetchAll();
?>

<table border="1" cellpadding="8">
    <tr>
        <th>اسم الطالب</th>
        <th>التاريخ</th>
        <th>الحالة</th>
    </tr>
    <?php foreach ($records as $rec): ?>
        <tr>
            <td><?= $rec['full_name'] ?></td>
            <td><?= $rec['date'] ?></td>
            <td><?= $rec['status'] === 'present' ? '✅ حاضر' : '❌ غائب' ?></td>
        </tr>
    <?php endforeach; ?>
</table>

<?php include 'footer.php'; ?>
