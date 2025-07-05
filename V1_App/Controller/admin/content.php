<?php include 'header.php'; include '../../Config/db.php'; ?>

<h3>📥 رفع تلاوة جديدة</h3>

<form method="post" enctype="multipart/form-data">
    <label>اسم السورة:</label>
    <input name="surah_name" required><br><br>

    <label>اسم القارئ:</label>
    <input name="reciter_name" required><br><br>

    <label>ملف الصوت (MP3 فقط):</label>
    <input type="file" name="audio_file" accept="audio/mpeg" required><br><br>

    <button type="submit">رفع التلاوة</button>
</form>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['audio_file'])) {
    $surah = $_POST['surah_name'];
    $reciter = $_POST['reciter_name'];
    $file = $_FILES['audio_file'];

    if ($file['type'] === 'audio/mpeg') {
        $targetDir = "../../Public/uploads/recitations/";
        $filename = uniqid() . "_" . basename($file['name']);
        $targetFile = $targetDir . $filename;

        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        if (move_uploaded_file($file['tmp_name'], $targetFile)) {
            $path = "uploads/recitations/" . $filename;
            $stmt = $pdo->prepare("INSERT INTO recitations (surah_name, reciter_name, audio_path) VALUES (?, ?, ?)");
            $stmt->execute([$surah, $reciter, $path]);
            echo "<p>✅ تم رفع التلاوة بنجاح.</p>";
        } else {
            echo "<p>❌ حدث خطأ أثناء رفع الملف.</p>";
        }
    } else {
        echo "<p>❌ يرجى رفع ملف بصيغة MP3 فقط.</p>";
    }
}
?>

<hr>

<h3>🎧 التلاوات المرفوعة</h3>

<table border="1" cellpadding="8">
    <tr>
        <th>السورة</th>
        <th>القارئ</th>
        <th>الملف</th>
        <th>تاريخ الرفع</th>
        <th>إجراء</th>
    </tr>

    <?php
    $recitations = $pdo->query("SELECT * FROM recitations ORDER BY uploaded_at DESC")->fetchAll();
    foreach ($recitations as $r):
    ?>
    <tr>
        <td><?= htmlspecialchars($r['surah_name']) ?></td>
        <td><?= htmlspecialchars($r['reciter_name']) ?></td>
        <td>
            <audio controls>
                <source src="../<?= $r['audio_path'] ?>" type="audio/mpeg">
            </audio>
        </td>
        <td><?= $r['uploaded_at'] ?></td>
        <td>
            <form method="post" style="display:inline">
                <input type="hidden" name="delete_id" value="<?= $r['id'] ?>">
                <button onclick="return confirm('هل تريد حذف هذه التلاوة؟')">🗑 حذف</button>
            </form>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    $id = $_POST['delete_id'];
    $stmt = $pdo->prepare("SELECT audio_path FROM recitations WHERE id = ?");
    $stmt->execute([$id]);
    $file = $stmt->fetchColumn();

    if ($file && file_exists("../$file")) {
        unlink("../$file");
    }

    $pdo->prepare("DELETE FROM recitations WHERE id = ?")->execute([$id]);
    echo "<p>✅ تم حذف التلاوة.</p>";
    header("Refresh:0");
}
?>

<?php include 'footer.php'; ?>
