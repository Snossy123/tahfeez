<?php
require_once '../config/db.php';
session_start();
// حذف الاشتراك
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'delete') {
    $id = (int) $_POST['id'];
    try {
        $stmt = $pdo->prepare("DELETE FROM subscriptions WHERE id = ?");
        $stmt->execute([$id]);
        $_SESSION['success'] = 'تم إلغاء الاشتراك.';
    } catch (Exception $e) {
        $_SESSION['error'] = 'فشل الحذف: ' . $e->getMessage();
    }
    header("Location: manage_subscriptions.php");
    exit;
}

$action = filter_input(INPUT_GET, 'action');

$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_id = filter_input(INPUT_POST, 'student_id', FILTER_VALIDATE_INT);
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $total_lessons = filter_input(INPUT_POST, 'total_lessons', FILTER_VALIDATE_INT);

    try {
        if ($action === 'add') {
            $stmt = $pdo->prepare("INSERT INTO subscriptions (student_id, start_date, end_date, total_lessons) VALUES (?, ?, ?, ?)");
            $stmt->execute([$student_id, $start_date, $end_date, $total_lessons]);
            $_SESSION['success'] = 'تم إضافة الاشتراك بنجاح.';
        } elseif ($action === 'edit' && $id) {
            $stmt = $pdo->prepare("UPDATE subscriptions SET start_date=?, end_date=?, total_lessons=? WHERE id=?");
            $stmt->execute([$start_date, $end_date, $total_lessons, $id]);
            $_SESSION['success'] = 'تم تعديل الاشتراك.';
        } elseif ($action === 'renew' && $id) {
            $stmt = $pdo->prepare("INSERT INTO subscriptions (student_id, start_date, end_date, total_lessons) VALUES (?, ?, ?, ?)");
            $stmt->execute([$student_id, $start_date, $end_date, $total_lessons]);
            $_SESSION['success'] = 'تم تجديد الاشتراك.';
        }
    } catch (Exception $e) {
        $_SESSION['error'] = 'حدث خطأ: ' . $e->getMessage();
    }

    header("Location: manage_subscriptions.php");
    exit;
}
?>
