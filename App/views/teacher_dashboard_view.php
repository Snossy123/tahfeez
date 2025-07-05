<?php
// اللغة الحالية (ar أو en)
$lang = $_GET['lang'] ?? 'ar';

// مصفوفة الترجمة
$translations = [
  'ar' => [
    'dashboard_title' => 'لوحة تحكم المحفظ',
    'welcome' => 'مرحبًا',
    'add_lesson' => '➕ إضافة درس جديد',
    'your_students' => '📚 طلابك',
    'name' => 'الاسم',
    'grade' => 'الصف الدراسي',
    'no_students' => 'لا يوجد طلاب مسجلين حاليًا.',
    'language_toggle' => 'English',
    
    // جديد:
    'profile_settings' => '⚙️ إعدادات الحساب',
    'logout' => '🚪 تسجيل الخروج',
    'dashboard_link' => '🏠 الصفحة الرئيسية'
  ],
  'en' => [
    'dashboard_title' => 'Teacher Dashboard',
    'welcome' => 'Welcome',
    'add_lesson' => '➕ Add New Lesson',
    'your_students' => '📚 Your Students',
    'name' => 'Name',
    'grade' => 'Grade',
    'no_students' => 'No students are currently assigned.',
    'language_toggle' => 'العربية',

    // New:
    'profile_settings' => '⚙️ Profile Settings',
    'logout' => '🚪 Logout',
    'dashboard_link' => '🏠 Home'
  ]
];


$t = $translations[$lang];
$otherLang = ($lang === 'ar') ? 'en' : 'ar';

// بيانات تجريبية إن لم تكن موجودة
if (!isset($students)) {
  $students = [
    ['name' => 'محمد أحمد', 'grade' => 'الصف الرابع'],
    ['name' => 'سارة علي', 'grade' => 'الصف الخامس']
  ];
}

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
  <title><?= $t['dashboard_title'] ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap<?= $lang === 'ar' ? '.rtl' : '' ?>.min.css" rel="stylesheet">
  <style>
    body {
      font-family: 'Cairo', sans-serif;
      background-color: #f8f9fa;
    }
    .sidebar {
      background-color: #1c6758;
      color: #fff;
      padding: 30px 20px;
      height: 100vh;
    }
    .sidebar a {
      color: #fff;
      text-decoration: none;
      display: block;
      margin-bottom: 15px;
      font-weight: bold;
    }
    .sidebar a:hover {
      text-decoration: underline;
    }
    .sidebar img {
      width: 100px;
      height: 100px;
      object-fit: cover;
      border-radius: 50%;
      margin-bottom: 15px;
    }
    .main-content {
      padding: 30px;
    }
    .table th, .table td {
      vertical-align: middle;
    }
  </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-light bg-white shadow-sm px-3">
  <button class="btn btn-outline-secondary d-md-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarMenu">
    ☰
  </button>
  <span class="navbar-brand ms-3 fw-bold"><?= $t['dashboard_title'] ?></span>
</nav>

<div class="container-fluid">
  <div class="row">
    <!-- Sidebar - Visible on md+, Offcanvas on sm -->
    <div class="col-md-3 d-none d-md-block sidebar text-center">
      <img src="<?= htmlspecialchars($imageToShow) ?>" alt="Profile">
      <h5 class="mb-4"><?= htmlspecialchars($_SESSION['user']['name'] ?? 'Teacher') ?></h5>
      <a href="add_lesson.php"><?= $t['add_lesson'] ?></a>
      <a href="profile.php"><?= $t['profile_settings'] ?? 'إعدادات الحساب' ?></a>
      <a href="logout.php"><?= $t['logout'] ?? 'تسجيل الخروج' ?></a>
      <div class="mt-4">
        <a href="?lang=<?= $otherLang ?>" class="btn btn-outline-light btn-sm"><?= $t['language_toggle'] ?></a>
      </div>
    </div>

    <!-- Offcanvas Sidebar for small screens -->
    <div class="offcanvas offcanvas-start d-md-none" tabindex="-1" id="sidebarMenu">
      <div class="offcanvas-header">
        <h5 class="offcanvas-title"><?= htmlspecialchars($_SESSION['user']['name'] ?? 'Teacher') ?></h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"></button>
      </div>
      <div class="offcanvas-body sidebar text-center">
        <img src="<?= htmlspecialchars($imageToShow) ?>" alt="Profile">
        <a href="add_lesson.php"><?= $t['add_lesson'] ?></a>
        <a href="profile.php"><?= $t['profile_settings'] ?? 'إعدادات الحساب' ?></a>
        <a href="logout.php"><?= $t['logout'] ?? 'تسجيل الخروج' ?></a>
        <div class="mt-4">
          <a href="?lang=<?= $otherLang ?>" class="btn btn-outline-light btn-sm"><?= $t['language_toggle'] ?></a>
        </div>
      </div>
    </div>

    <!-- Main Content -->
    <div class="col-md-9 ms-sm-auto col-lg-9 main-content">
      <h2 class="fw-bold mb-4">👋 <?= $t['welcome'] ?>، <?= htmlspecialchars($_SESSION['user']['name'] ?? 'Teacher') ?></h2>

      <div class="card shadow-sm">
        <div class="card-header bg-white">
          <h4 class="mb-0"><?= $t['your_students'] ?></h4>
        </div>
        <div class="card-body p-0">
          <?php if (!empty($students)): ?>
            <table class="table table-hover table-bordered mb-0">
              <thead class="table-light">
                <tr>
                  <th><?= $t['name'] ?></th>
                  <th><?= $t['grade'] ?></th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($students as $student): ?>
                  <tr>
                    <td><?= htmlspecialchars($student['name']) ?></td>
                    <td><?= htmlspecialchars($student['grade']) ?></td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          <?php else: ?>
            <div class="p-3 text-muted"><?= $t['no_students'] ?></div>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

