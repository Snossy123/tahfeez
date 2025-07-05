<?php include 'header.php'; include '../../Config/db.php'; ?>

<h2>مرحبًا، مدير النظام</h2>

<?php
$total_users = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
$total_students = $pdo->query("SELECT COUNT(*) FROM students")->fetchColumn();
$total_classes = $pdo->query("SELECT COUNT(*) FROM classes")->fetchColumn();
$total_messages = $pdo->query("SELECT COUNT(*) FROM messages")->fetchColumn();
?>

<ul>
    <li>عدد المستخدمين: <?= $total_users ?></li>
    <li>عدد الطلاب: <?= $total_students ?></li>
    <li>عدد الحلقات: <?= $total_classes ?></li>
    <li>عدد الرسائل: <?= $total_messages ?></li>
</ul>

<?php include 'footer.php'; ?>
