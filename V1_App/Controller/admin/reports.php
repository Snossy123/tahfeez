<?php include 'header.php'; include '../../Config/db.php'; ?>

<h3>📊 التقارير والإحصائيات العامة</h3>

<?php
// إحصاء المستخدمين حسب الدور
$roles = ['admin', 'teacher', 'student', 'parent'];
$counts = [];
foreach ($roles as $role) {
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE role = ?");
    $stmt->execute([$role]);
    $counts[$role] = $stmt->fetchColumn();
}

// أفضل 5 طلاب حسب التقدم (طول النص في progress كمؤشر مبدئي)
$top_students = $pdo->query("
    SELECT u.full_name, LENGTH(s.progress) AS progress_length 
    FROM students s 
    JOIN users u ON s.user_id = u.id 
    ORDER BY progress_length DESC 
    LIMIT 5
")->fetchAll();

// إحصائيات الحضور
$attendance_stats = $pdo->query("
    SELECT status, COUNT(*) AS total 
    FROM attendance 
    GROUP BY status
")->fetchAll();
$present = 0; $absent = 0;
foreach ($attendance_stats as $row) {
    if ($row['status'] === 'present') $present = $row['total'];
    if ($row['status'] === 'absent') $absent = $row['total'];
}
?>

<h4>إجمالي المستخدمين</h4>
<ul>
    <li>مديرين: <?= $counts['admin'] ?></li>
    <li>محفظين: <?= $counts['teacher'] ?></li>
    <li>طلاب: <?= $counts['student'] ?></li>
    <li>أولياء أمور: <?= $counts['parent'] ?></li>
</ul>

<hr>

<h4>🏆 أفضل 5 طلاب تقدمًا</h4>
<table border="1" cellpadding="8">
    <tr>
        <th>الاسم</th>
        <th>مؤشر التقدم (طول البيانات)</th>
    </tr>
    <?php foreach ($top_students as $s): ?>
        <tr>
            <td><?= $s['full_name'] ?></td>
            <td><?= $s['progress_length'] ?></td>
        </tr>
    <?php endforeach; ?>
</table>

<hr>

<h4>📈 إحصائيات الحضور</h4>
<ul>
    <li>✅ حضور: <?= $present ?></li>
    <li>❌ غياب: <?= $absent ?></li>
</ul>

<hr>

<h4>📥 تصدير (مستقبلي)</h4>
<p>لاحقًا يمكنك تصدير هذه الإحصائيات إلى PDF أو Excel باستخدام مكتبات مثل:
<ul>
    <li><code>mpdf/mpdf</code> لـ PDF</li>
    <li><code>phpoffice/phpspreadsheet</code> لـ Excel</li>
</ul>
</p>

<?php include 'footer.php'; ?>
