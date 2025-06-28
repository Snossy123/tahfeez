<?php include 'header.php'; include '../../Config/db.php'; ?>

<h2>مرحباً، <?= $_SESSION['user']['full_name'] ?></h2>

<?php
// إحصائيات
$teacher_id = $_SESSION['user']['id'];
$total_students = $pdo->query("SELECT COUNT(*) FROM students")->fetchColumn();
$total_classes = $pdo->query("SELECT COUNT(*) FROM classes WHERE teacher_id = $teacher_id")->fetchColumn();
$total_messages = $pdo->query("SELECT COUNT(*) FROM messages WHERE receiver_id = $teacher_id")->fetchColumn();
?>

<ul>
    <li>إجمالي الطلاب: <?= $total_students ?></li>
    <li>عدد الحلقات: <?= $total_classes ?></li>
    <li>عدد الرسائل الجديدة: <?= $total_messages ?></li>
</ul>

<?php include 'footer.php'; ?>
