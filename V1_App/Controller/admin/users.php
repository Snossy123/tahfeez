<?php
// معالجة حذف المستخدم
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once '../../Config/db.php';

    if (isset($_POST['delete_id'])) {
        $pdo->prepare("DELETE FROM users WHERE id = ?")->execute([$_POST['delete_id']]);
        header("Location: users.php?deleted=1");
        exit;
    }

    if (isset($_POST['approve_id'])) {
        $pdo->prepare("UPDATE users SET is_approved = 1 WHERE id = ?")->execute([$_POST['approve_id']]);
        header("Location: users.php?approved=1");
        exit;
    }
}
?>

<?php include 'header.php'; require_once '../../Config/db.php'; ?>

<h3>قائمة المستخدمين</h3>
<a href="add_user.php">+ إضافة مستخدم جديد</a><br><br>

<?php if (isset($_GET['deleted'])): ?>
    <p style="color: red;">🗑️ تم حذف المستخدم بنجاح.</p>
<?php endif; ?>

<?php if (isset($_GET['approved'])): ?>
    <p style="color: green;">✅ تم تفعيل الحساب بنجاح.</p>
<?php endif; ?>

<table border="1" cellpadding="8">
    <tr>
        <th>الاسم</th>
        <th>اسم المستخدم</th>
        <th>الدور</th>
        <th>إجراءات</th>
    </tr>
    <?php
    $stmt = $pdo->query("SELECT * FROM users");
    foreach ($stmt as $user):
    ?>
    <tr>
        <td><?= htmlspecialchars($user['full_name']) ?></td>
        <td><?= htmlspecialchars($user['username']) ?></td>
        <td><?= htmlspecialchars($user['role']) ?></td>
        <td>
            <form method="post" style="display:inline">
                <input type="hidden" name="delete_id" value="<?= $user['id'] ?>">
                <button onclick="return confirm('هل أنت متأكد من حذف هذا المستخدم؟')">🗑 حذف</button>
            </form>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

<h4>🚫 حسابات بانتظار الموافقة</h4>

<table border="1" cellpadding="8">
    <tr>
        <th>الاسم</th>
        <th>الدور</th>
        <th>تفعيل</th>
    </tr>
    <?php
    $pending = $pdo->query("SELECT * FROM users WHERE is_approved = 0")->fetchAll();
    foreach ($pending as $u):
    ?>
    <tr>
        <td><?= htmlspecialchars($u['full_name']) ?></td>
        <td><?= htmlspecialchars($u['role']) ?></td>
        <td>
            <form method="post" style="display:inline">
                <input type="hidden" name="approve_id" value="<?= $u['id'] ?>">
                <button>✅ تفعيل</button>
            </form>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

<?php include 'footer.php'; ?>
