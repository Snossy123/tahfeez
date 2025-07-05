<?php include 'header.php'; include '../db.php'; ?>

<h3>🏆 لوحة الشرف - الطلاب الأكثر اجتهادًا</h3>

<?php
// استعلام لجلب الطلاب وترتيبهم حسب عدد الأيام التي حفظوا فيها
$stmt = $pdo->query("
    SELECT u.full_name, COUNT(DISTINCT d.log_date) AS active_days
    FROM daily_logs d
    JOIN students s ON d.student_id = s.id
    JOIN users u ON s.user_id = u.id
    WHERE d.type = 'memorize'
    GROUP BY d.student_id
    ORDER BY active_days DESC
    LIMIT 10
");

$rank = 1;
?>

<table border="1" cellpadding="8">
    <tr>
        <th>الترتيب</th>
        <th>الطالب</th>
        <th>عدد الأيام النشطة</th>
    </tr>

    <?php foreach ($stmt as $row): ?>
        <tr>
            <td><?= $rank++ ?></td>
            <td><?= htmlspecialchars($row['full_name']) ?></td>
            <td><?= $row['active_days'] ?></td>
        </tr>
    <?php endforeach; ?>
</table>

<?php include 'footer.php'; ?>
