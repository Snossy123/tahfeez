<?php
// achievements.php

function getStudentStreak($student_id, $pdo) {
    $dates = $pdo->prepare("SELECT DISTINCT log_date FROM daily_logs 
                            WHERE student_id = ? AND type = 'memorize' 
                            ORDER BY log_date DESC LIMIT 10");
    $dates->execute([$student_id]);
    $dates = $dates->fetchAll(PDO::FETCH_COLUMN);

    $today = new DateTime();
    $streak = 0;

    foreach ($dates as $d) {
        $date = new DateTime($d);
        if ($date->format('Y-m-d') === $today->format('Y-m-d')) {
            $streak++;
        } elseif ($date->format('Y-m-d') === $today->modify('-1 day')->format('Y-m-d')) {
            $streak++;
        } else {
            break;
        }
    }

    return $streak;
}

function awardAchievement($student_id, $code, $pdo) {
    $ach_id = $pdo->prepare("SELECT id FROM achievements WHERE code = ?");
    $ach_id->execute([$code]);
    $ach_id = $ach_id->fetchColumn();

    $stmt = $pdo->prepare("INSERT IGNORE INTO student_achievements (student_id, achievement_id) VALUES (?, ?)");
    $stmt->execute([$student_id, $ach_id]);
}

function getStudentAchievements($student_id, $pdo) {
    $earned = $pdo->prepare("
        SELECT a.title, a.description, sa.awarded_at 
        FROM student_achievements sa
        JOIN achievements a ON sa.achievement_id = a.id
        WHERE sa.student_id = ?
    ");
    $earned->execute([$student_id]);
    return $earned->fetchAll();
}
