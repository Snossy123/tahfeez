<?php
// memorize.php
include 'header.php';
include '../../Config/db.php';
include 'achievements.php';

function getStudentId($pdo) {
    $stmt = $pdo->prepare("SELECT id FROM students WHERE user_id = ?");
    $stmt->execute([$_SESSION['user']['id']]);
    return $stmt->fetchColumn();
}

function getRecitation($pdo) {
    $stmt = $pdo->prepare("SELECT * FROM recitations WHERE surah_name = 'النبأ' LIMIT 1");
    $stmt->execute();
    return $stmt->fetch();
}

$student_id = getStudentId($pdo);
$recitation = getRecitation($pdo);
$streak = getStudentStreak($student_id, $pdo);

if ($streak == 3) awardAchievement($student_id, 'streak_3', $pdo);
if ($streak == 5) awardAchievement($student_id, 'streak_5', $pdo);
$achievements = getStudentAchievements($student_id, $pdo);
?>

<h3>صفحة الحفظ - جزء عمّ</h3>
<img src="../../../Public/assets/quran/images/سوره الفجر.png" alt="جزء عم" width="50%" style="border: 1px solid #ccc; border-radius: 8px;">
<hr>

<h4>استمع للشيخ</h4>
<?php if ($recitation): ?>
    <audio id="recitationPlayer" controls>
        <source src="../<?= htmlspecialchars($recitation['audio_path']) ?>" type="audio/mpeg">
    </audio>
    <br><br>
    <label>عدد مرات التكرار:</label>
    <select id="repeatCount">
        <?php for ($i = 1; $i <= 10; $i++): ?>
            <option value="<?= $i ?>"><?= $i ?> مرات</option>
        <?php endfor; ?>
    </select>
    <button onclick="startRepeating()">ابدأ التكرار</button>
    <p id="repeatStatus">لم يبدأ التكرار بعد</p>

    <script>
    let repeatCount = 0;
    let currentCount = 0;
    let player = document.getElementById("recitationPlayer");

    function startRepeating() {
        repeatCount = parseInt(document.getElementById("repeatCount").value);
        currentCount = 0;
        document.getElementById("repeatStatus").textContent = "التكرار جاري...";
        player.currentTime = 0;
        player.play();
    }

    player.addEventListener('ended', () => {
        currentCount++;
        if (currentCount < repeatCount) {
            player.currentTime = 0;
            player.play();
        } else {
            document.getElementById("repeatStatus").textContent = "\u2705 تم التكرار " + repeatCount + " مرة!";
        }
    });
    </script>
<?php else: ?>
    <p>❌ لا توجد تلاوة متاحة لهذا الجزء.</p>
<?php endif; ?>

<hr>
<h3>🏅إنجازاتي</h3>
<p>🔥 سلسلة الأيام المتتالية الحالية: <strong><?= $streak ?></strong> يوم</p>
<h4> الإنجازات التي حصلت عليها:</h4>
<?php if (!$achievements): ?>
    <p>لم تحقق أي إنجاز بعد.</p>
<?php else: ?>
    <ul>
        <?php foreach ($achievements as $a): ?>
            <li>
                <strong><?= htmlspecialchars($a['title']) ?></strong> - 
                <?= htmlspecialchars($a['description']) ?> 
                (<?= $a['awarded_at'] ?>)
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
<?php include 'footer.php'; ?>
