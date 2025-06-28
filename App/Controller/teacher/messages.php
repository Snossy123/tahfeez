<?php include 'header.php'; include '../../Config/db.php'; ?>

<h3>الرسائل</h3>

<!-- نموذج إرسال رسالة -->
<form method="post">
    <label>إلى (ولي أمر):</label>
    <select name="receiver_id" required>
        <?php
        $parents = $pdo->query("SELECT id, full_name FROM users WHERE role = 'parent'")->fetchAll();
        foreach ($parents as $p) {
            echo "<option value='{$p['id']}'>{$p['full_name']}</option>";
        }
        ?>
    </select><br><br>
    <label>الرسالة:</label><br>
    <textarea name="message" rows="4" required></textarea><br>
    <button type="submit">إرسال</button>
</form>
<hr>

<?php
// إرسال الرسالة
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sender_id = $_SESSION['user']['id'];
    $receiver_id = $_POST['receiver_id'];
    $message = $_POST['message'];

    $stmt = $pdo->prepare("INSERT INTO messages (sender_id, receiver_id, message) VALUES (?, ?, ?)");
    $stmt->execute([$sender_id, $receiver_id, $message]);

    echo "<p>✅ تم إرسال الرسالة بنجاح!</p>";
}
?>

<!-- عرض الرسائل المستلمة -->
<h4>الرسائل الواردة</h4>
<table border="1" cellpadding="8">
    <tr>
        <th>من</th>
        <th>الرسالة</th>
        <th>التاريخ</th>
    </tr>
    <?php
    $current_id = $_SESSION['user']['id'];
    $stmt = $pdo->prepare("
        SELECT m.message, m.created_at, u.full_name 
        FROM messages m 
        JOIN users u ON m.sender_id = u.id 
        WHERE m.receiver_id = ?
        ORDER BY m.created_at DESC
    ");
    $stmt->execute([$current_id]);
    $messages = $stmt->fetchAll();

    foreach ($messages as $msg) {
        echo "<tr>
            <td>{$msg['full_name']}</td>
            <td>{$msg['message']}</td>
            <td>{$msg['created_at']}</td>
        </tr>";
    }
    ?>
</table>

<?php include 'footer.php'; ?>
