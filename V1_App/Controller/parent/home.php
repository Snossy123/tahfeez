<?php include 'header.php'; include '../../Config/db.php'; ?>

<h3>تقدم الأبناء</h3>

<?php
$parent_id = $_SESSION['user']['id'];

$stmt = $pdo->prepare("
    SELECT u.full_name, s.progress
    FROM parent_students ps
    JOIN students s ON ps.student_id = s.id
    JOIN users u ON s.user_id = u.id
    WHERE ps.parent_id = ?
");
$stmt->execute([$parent_id]);
$children = $stmt->fetchAll();
?>

<?php if (!$children): ?>
    <p>❌ لا يوجد أبناء مرتبطون بهذا الحساب.</p>
<?php else: ?>
    <table border="1" cellpadding="8">
        <tr>
            <th>اسم الطالب</th>
            <th>التقدم في الحفظ</th>
        </tr>
        <?php foreach ($children as $child): ?>
        <tr>
            <td><?= $child['full_name'] ?></td>
            <td><?= nl2br(htmlspecialchars($child['progress'])) ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>

<?php include 'footer.php'; ?>
