<?php include 'header.php'; include '../../Config/db.php'; ?>

<h3>🎧 مكتبة التلاوات</h3>

<?php
$stmt = $pdo->query("SELECT * FROM recitations ORDER BY surah_name ASC, reciter_name ASC");
$recitations = $stmt->fetchAll();
?>

<?php if (!$recitations): ?>
    <p>❌ لا توجد تلاوات متاحة حاليًا.</p>
<?php else: ?>
    <table border="1" cellpadding="8">
        <tr>
            <th>السورة</th>
            <th>القارئ</th>
            <th>تشغيل</th>
        </tr>
        <?php foreach ($recitations as $r): ?>
        <tr>
            <td><?= htmlspecialchars($r['surah_name']) ?></td>
            <td><?= htmlspecialchars($r['reciter_name']) ?></td>
            <td>
                <audio controls preload="none">
                    <source src="../<?= $r['audio_path'] ?>" type="audio/mpeg">
                    المتصفح لا يدعم تشغيل الصوت.
                </audio>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
<?php endif; ?>

<?php include 'footer.php'; ?>
