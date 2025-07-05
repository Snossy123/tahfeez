<?php
require_once '../config/db.php';
date_default_timezone_set('Africa/Cairo');

// وقت الآن + 30 دقيقة
$now = date('Y-m-d H:i');
$after30 = date('Y-m-d H:i', strtotime('+30 minutes'));

// جلب الحصص اللي هتبدأ خلال 30 دقيقة
$stmt = $pdo->prepare("
    SELECT lessons.*, users.name as teacher_name, users.email as teacher_email 
    FROM lessons 
    JOIN users ON lessons.teacher_id = users.id
    WHERE CONCAT(lessons.date, ' ', lessons.time) BETWEEN ? AND ? 
    AND lessons.notified = 0
");
$stmt->execute([$now, $after30]);
$lessons = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($lessons as $lesson) {
    // جلب الطلاب المشتركين
    $stmt = $pdo->prepare("
        SELECT users.name, users.email 
        FROM lesson_student 
        JOIN users ON users.id = lesson_student.student_id 
        WHERE lesson_id = ?
    ");
    $stmt->execute([$lesson['id']]);
    $students = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $lessonTime = date('g:i A', strtotime($lesson['time']));
    $lessonDate = date('d/m/Y', strtotime($lesson['date']));

    // إرسال للمحفظ
    mail(
        $lesson['teacher_email'],
        "⏰ تذكير بحصة قريبة",
        "معاد حصتك مع الطلاب يوم $lessonDate الساعة $lessonTime",
        "From: no-reply@yourapp.com"
    );

    // إرسال لكل طالب
    foreach ($students as $student) {
        mail(
            $student['email'],
            "📚 تذكير بحصتك اليوم",
            "عندك حصة مع المحفظ {$lesson['teacher_name']} يوم $lessonDate الساعة $lessonTime",
            "From: no-reply@yourapp.com"
        );
    }

    // تحديث: تم إرسال الإشعار
    $pdo->prepare("UPDATE lessons SET notified = 1 WHERE id = ?")->execute([$lesson['id']]);
}
