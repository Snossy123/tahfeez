<?php
// جلب بيانات الدروس مع الحضور والتقييم للطالب
$stmt = $pdo->prepare("
    SELECT l.*, ls.attendance, ls.rating, ls.notes
    FROM lessons l
    JOIN lessons_students ls ON l.id = ls.lesson_id
    WHERE ls.student_id = ?
    ORDER BY l.date, l.time
");
$stmt->execute([$student_id]);
$lessons = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($lessons as $lesson) {
    echo "<div class='lesson'>";
    echo "<h4>درس بتاريخ: {$lesson['date']} الساعة {$lesson['time']}</h4>";
    echo "<p>رابط الدرس: <a href='{$lesson['google_meet_link']}' target='_blank'>انضم للدرس</a></p>";

    if ($lesson['attendance']) {
        echo "<p>الحضور: " . ($lesson['attendance'] == 'present' ? "حضر" : "لم يحضر") . "</p>";
        if ($lesson['rating']) echo "<p>التقييم: {$lesson['rating']}</p>";
        if ($lesson['notes']) echo "<p>ملاحظات: " . nl2br(htmlspecialchars($lesson['notes'])) . "</p>";
    } else {
        echo "<p>لم يتم تسجيل الحضور بعد.</p>";
    }
    echo "</div><hr>";
}
