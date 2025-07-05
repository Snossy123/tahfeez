<?php include 'header.php'; include '../../Config/db.php'; ?>

<h2>مرحباً، <?= $_SESSION['user']['full_name'] ?></h2>

<?php
$user_id = $_SESSION['user']['id'];
$stmt = $pdo->prepare("SELECT progress FROM students WHERE user_id = ?");
$stmt->execute([$user_id]);
$progress = $stmt->fetchColumn();
?>

<h3>تقدمك في الحفظ:</h3>
<p><?= $progress ? nl2br(htmlspecialchars($progress)) : 'لم يتم تسجيل تقدم بعد.' ?></p>

<?php include 'footer.php'; ?>
