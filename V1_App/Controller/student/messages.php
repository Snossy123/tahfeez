<?php include 'header.php'; include '../../Config/db.php'; ?>

<h3>رسائل مع المحفظ</h3>

<form method="post">
    <label>اختر محفظك:</label>
    <select name="receiver_id" required>
        <?php
        $teachers = $pdo->query("SELECT id, full_name FROM users WHERE role = 'teacher'")->fetchAll();
        foreach ($teachers as $t) {
            echo "<option value='{$t['id']}'>{$t['full_name']}</option>";
        }
        ?>
    </select><br><br>
    <textarea name="message" rows="4" required placeholder="اكتب رسالتك هنا..."></textarea><br>
    <button type="submit">إرسال</button>
</form>
<hr>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sender_id = $_SESSION['user']['id'];
    $receiver_id = $_POST['receiver_id'];
    $msg = $_POST['message'];

    $pdo->prepare("INSERT INTO messages (sender_id, receiver_id, message) VALUES (?, ?, ?)")
        ->execute([$sender_id, $receiver_id, $msg]);

    echo "<p>✅ تم إرسال الرسالة.</p>";
}
?>

<h4>الرسائل الواردة</h4>
<table border="1" cellpadding="8">
    <tr>
        <th>من</th>
        <th>الرسالة</th>
        <th>التاريخ</th>
    </tr>
    <?php
    $stmt = $pdo->prepare("
        SELECT m.message, m.created_at, u.full_name 
        FROM messages m 
        JOIN users u ON m.sender_id = u.id 
        WHERE m.receiver_id = ?
        ORDER BY m.created_at DESC
    ");
    $stmt->execute([$_SESSION['user']['id']]);
    foreach ($stmt as $msg) {
        echo "<tr>
            <td>{$msg['full_name']}</td>
            <td>{$msg['message']}</td>
            <td>{$msg['created_at']}</td>
        </tr>";
    }
    ?>
</table>

<?php include 'footer.php'; ?>
