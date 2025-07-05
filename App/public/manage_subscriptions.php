<?php
require_once '../config/db.php';

// جلب الطلاب واشتراكاتهم
$stmt = $pdo->query("
    SELECT s.id AS student_id, u.name AS student_name, sub.*
    FROM students s
    JOIN users u ON s.user_id = u.id
    LEFT JOIN subscriptions sub ON s.id = sub.student_id
");
$subscriptions = $stmt->fetchAll(PDO::FETCH_ASSOC);

// جلب كل الطلاب من قاعدة البيانات لاستخدامهم في النموذج
$studentsStmt = $pdo->query("
  SELECT s.id AS student_id, u.name AS student_name
  FROM students s
  JOIN users u ON s.user_id = u.id
");
$allStudents = $studentsStmt->fetchAll(PDO::FETCH_ASSOC);

require_once '../includes/language.php';
require_once '../includes/avatar.php';

$pageTitle = 'manage_subscriptions_page_title';
require_once '../views/admin/layout.php';