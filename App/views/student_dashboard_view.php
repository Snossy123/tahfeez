<?php
$lang = $_GET['lang'] ?? 'ar';

$translations = [
  'ar' => [
    'page_title' => 'لوحة تحكم الطالب',
    'greeting' => 'مرحبًا،',
    'lessons' => '📅 دروسك القادمة',
    'date' => 'التاريخ',
    'time' => 'الوقت',
    'duration' => 'المدة',
    'teacher' => 'المحفظ',
    'join_link' => 'رابط الدخول',
    'minutes' => 'دقيقة',
    'no_lessons' => 'لا توجد دروس مجدولة.',
    'profile' => 'تعديل الحساب',
    'language_toggle' => 'English',
    'notes' => 'ملاحظات',
    'logout' => 'تسجيل الخروج',
    'dashboard' => 'لوحة التحكم'
  ],
  'en' => [
    'page_title' => 'Student Dashboard',
    'greeting' => 'Welcome,',
    'lessons' => '📅 Your Upcoming Lessons',
    'date' => 'Date',
    'time' => 'Time',
    'duration' => 'Duration',
    'teacher' => 'Teacher',
    'join_link' => 'Join Link',
    'minutes' => 'minutes',
    'no_lessons' => 'No scheduled lessons.',
    'profile' => 'Edit Profile',
    'language_toggle' => 'العربية',
    'notes' => 'Notes',
    'logout' => 'Logout',
    'dashboard' => 'Dashboard'
  ]
];

$t = $translations[$lang];
$otherLang = $lang === 'ar' ? 'en' : 'ar';
$studentName = $_SESSION['user']['name'] ?? 'طالب';


// الصورة الخاصة بالمستخدم (لو كانت موجودة في الجلسة مثلاً)
$userImage = $_SESSION['user']['image'] ?? null;

// رابط الصورة الافتراضية
$defaultImage = 'https://www.gravatar.com/avatar/00000000000000000000000000000000?d=mp&f=y';

// استخدام الصورة الخاصة إن وجدت، وإلا الصورة الافتراضية
$imageToShow = $userImage ?: $defaultImage;
?>

<!DOCTYPE html>
<html lang="<?= $lang ?>" dir="<?= $lang === 'ar' ? 'rtl' : 'ltr' ?>">
<head>
  <meta charset="UTF-8">
  <title><?= $t['page_title'] ?></title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap<?= $lang === 'ar' ? '.rtl' : '' ?>.min.css">
</head>
<body class="bg-light">

<!-- ✅ Navbar -->
<?php include 'student_navbar.php'; ?>

<div class="container mt-4">
  <div class="mb-4">
    <h2><?= $t['greeting'] . ' ' . htmlspecialchars($studentName) ?> 👋</h2>
  </div>

  <h4><?= $t['lessons'] ?></h4>
  <?php if (!empty($lessons)): ?>
    <table class="table table-bordered">
      <thead class="table-light">
        <tr>
          <th><?= $t['date'] ?></th>
          <th><?= $t['time'] ?></th>
          <th><?= $t['duration'] ?></th>
          <th><?= $t['teacher'] ?></th>
          <th><?= $t['notes'] ?></th>
          <th><?= $t['join_link'] ?></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($lessons as $lesson): ?>
          <tr>
            <td><?= htmlspecialchars($lesson['date']) ?></td>
            <td><?= htmlspecialchars($lesson['time']) ?></td>
            <td><?= htmlspecialchars($lesson['duration']) . ' ' . $t['minutes'] ?></td>
            <td><?= htmlspecialchars($lesson['teacher_name']) ?></td>
            <td><?= htmlspecialchars($lesson['notes']) ?></td>
            <td><a href="<?= htmlspecialchars($lesson['google_meet_link']) ?>" target="_blank">🌐</a></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php else: ?>
    <div class="alert alert-info"><?= $t['no_lessons'] ?></div>
  <?php endif; ?>
</div>

</body>
</html>
