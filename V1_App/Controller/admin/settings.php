<?php include 'header.php'; include '../../Config/db.php'; ?>

<h3>🛠 إعدادات النظام</h3>

<?php
// حفظ الإعدادات عند الإرسال
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $settings = [
        'platform_name' => $_POST['platform_name'],
    ];

    foreach ($settings as $key => $value) {
        $stmt = $pdo->prepare("INSERT INTO settings (`key`, `value`) VALUES (?, ?) 
                               ON DUPLICATE KEY UPDATE `value` = VALUES(`value`)");
        $stmt->execute([$key, $value]);
    }

    // رفع الشعار
    if (!empty($_FILES['logo']['name'])) {
        $logo_path = '../uploads/logo.png';
        if (move_uploaded_file($_FILES['logo']['tmp_name'], $logo_path)) {
            $stmt = $pdo->prepare("INSERT INTO settings (`key`, `value`) VALUES ('logo_path', ?) 
                                   ON DUPLICATE KEY UPDATE `value` = VALUES(`value`)");
            $stmt->execute([$logo_path]);
        }
    }

    echo "<p>✅ تم تحديث الإعدادات بنجاح.</p>";
}

// استدعاء القيم الحالية
$platform_name = '';
$logo_path = '';
$stmt = $pdo->query("SELECT * FROM settings");
foreach ($stmt as $s) {
    if ($s['key'] === 'platform_name') $platform_name = $s['value'];
    if ($s['key'] === 'logo_path') $logo_path = $s['value'];
}
?>

<form method="post" enctype="multipart/form-data">
    <label>اسم المنصة:</label><br>
    <input name="platform_name" value="<?= htmlspecialchars($platform_name) ?>" required><br><br>

    <label>شعار المنصة (PNG فقط):</label><br>
    <?php if ($logo_path && file_exists($logo_path)): ?>
        <img src="<?= $logo_path ?>" alt="الشعار الحالي" width="120"><br>
    <?php endif; ?>
    <input type="file" name="logo" accept="image/png"><br><br>

    <button type="submit">💾 حفظ الإعدادات</button>
</form>

<?php include 'footer.php'; ?>
