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
  <div class="card shadow">
    <div class="card-body">
      <h3 class="card-title mb-4 text-center">إعدادات الطالب</h3>

      <?php if (!empty($_SESSION['success'])): ?>
        <div class="alert alert-success text-center"><?= $_SESSION['success'] ?></div>
        <?php unset($_SESSION['success']); ?>
      <?php elseif (!empty($_SESSION['error'])): ?>
        <div class="alert alert-danger text-center"><?= $_SESSION['error'] ?></div>
        <?php unset($_SESSION['error']); ?>
      <?php endif; ?>

      <form action="update_student_settings.php" method="POST">
        <input type="hidden" name="user_id" value="<?= $user['id'] ?>">

        <div class="mb-3">
          <label class="form-label">الاسم:</label>
          <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($user['name']) ?>" required>
        </div>

        <div class="mb-3">
          <label class="form-label">البريد الإلكتروني:</label>
          <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($user['email']) ?>" required>
        </div>

        <div class="mb-3">
          <label class="form-label">رقم واتساب:</label>
          <input type="text" name="whatsapp_number" class="form-control" value="<?= htmlspecialchars($user['whatsapp_number']) ?>" placeholder="+201234567890">
        </div>

        <div class="mb-3">
          <label class="form-label">الصف الدراسي:</label>
          <input type="text" name="grade" class="form-control" value="<?= htmlspecialchars($student['grade'] ?? '') ?>">
        </div>

        <div class="mb-3">
          <label class="form-label">كلمة المرور الجديدة (اختياري):</label>
          <input type="password" name="new_password" class="form-control">
        </div>

        <div class="text-center">
          <button type="submit" class="btn btn-primary px-4">حفظ</button>
        </div>
      </form>
    </div>
  </div>
</div>


</body>
</html>
