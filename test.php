<?php
// ملف إعداد الحسابات التجريبية (run once)
include 'App/Config/db.php';

$passwords = [
    'admin' => 'admin123',
    'teacher1' => 'teacher123',
    'student1' => 'student123',
    'parent1' => 'parent123'
];

foreach ($passwords as $username => $pass) {
    $role = explode('1', $username)[0] ?? $username;
    $stmt = $pdo->prepare("INSERT IGNORE INTO users (username, password, role, full_name) VALUES (?, ?, ?, ?)");
    $stmt->execute([$username, password_hash($pass, PASSWORD_DEFAULT), $role, ucfirst($username)]);
}
echo "Users inserted.";

// -- ربط ولي الأمر (id=4) بالطالب (id=2 و id=3 مثلًا)
// INSERT INTO parent_students (parent_id, student_id) VALUES (4, 2), (4, 3);