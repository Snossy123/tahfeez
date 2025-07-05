<?php
$lang = $_GET['lang'] ?? 'ar';

$translations = [
  'ar' => [
    'register_title' => 'تسجيل حساب جديد',
    'login' => 'تسجيل الدخول',
    'name' => 'الاسم',
    'email' => 'البريد الإلكتروني',
    'password' => 'كلمة المرور',
    'whatsapp' => 'رقم واتساب (مع كود الدولة)',
    'role' => 'الدور',
    'teacher' => 'محفظ',
    'student' => 'طالب',
    'grade' => 'الصف الدراسي',
    'choose_teacher' => 'اختر المحفظ المسؤول',
    'select_teacher' => '--اختر المحفظ--',
    'submit' => 'تسجيل',
    'quran_verse' => '﴿ نَرْفَعُ دَرَجَاتٍ مَّن نَّشَاءُ ﴾',
    'home' => 'الصفحة الرئيسية'
  ],
  'en' => [
    'register_title' => 'Create New Account',
    'login' => 'Login',
    'name' => 'Name',
    'email' => 'Email',
    'password' => 'Password',
    'whatsapp' => 'WhatsApp Number (with country code)',
    'role' => 'Role',
    'teacher' => 'Teacher',
    'student' => 'Student',
    'grade' => 'Grade',
    'choose_teacher' => 'Select Responsible Teacher',
    'select_teacher' => '--Select Teacher--',
    'submit' => 'Register',
    'quran_verse' => '﴿ نَرْفَعُ دَرَجَاتٍ مَّن نَّشَاءُ ﴾',
    'home' => 'Home'
  ]
];
$t = $translations[$lang];
?>

<!DOCTYPE html>
<html lang="<?= $lang ?>" dir="<?= $lang === 'ar' ? 'rtl' : 'ltr' ?>">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>تسجيل حساب جديد - دروس القرآن</title>
  <?php if ($lang === 'ar'): ?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css" rel="stylesheet">
  <?php else: ?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <?php endif; ?>
  <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Cairo', sans-serif;
      background-image: url('../public/assets/images/rm194-aew-01.jpg');
      background-size: cover;
      background-position: center center;
      background-repeat: no-repeat;
      background-attachment: fixed;
      background-color: #f9f7f1;
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 20px;
    }
    .register-card {
      background: white;
      border-radius: 16px;
      box-shadow: 0 0 20px rgba(0,0,0,0.05);
      padding: 30px;
      max-width: 500px;
      width: 100%;
    }
    .register-title {
      text-align: center;
      font-weight: bold;
      color: #1c6758;
      margin-bottom: 20px;
    }
    .quran-verse {
      font-size: 0.9rem;
      color: #555;
      text-align: center;
      margin-bottom: 10px;
      font-style: italic;
    }
    .btn-success {
      background-color: #1c6758;
      border: none;
    }
    .btn-success:hover {
      background-color: #145144;
    }
    .btn-outline-success {
      background-color: #f9f7f1;
      border: none;
    }
    .btn-outline-success:hover {
      background-color: #145144;
    }
  </style>
  <script>
    function toggleStudentFields() {
      const role = document.querySelector('select[name="role"]').value;
      document.getElementById('student-fields').style.display = (role === 'student') ? 'block' : 'none';
    }
    document.addEventListener("DOMContentLoaded", toggleStudentFields); // لتفعيل عند التحميل إذا تم اختيار "طالب"
  </script>
</head>
<body style="direction: <?= $lang === 'ar' ? 'rtl' : 'ltr' ?>">
  <div class="register-card">
    <h2 class="register-title"><?= $t['register_title'] ?></h2>
    <div class="quran-verse"><?= $t['quran_verse'] ?></div>

    <?php if (!empty($errors)): ?>
      <div class="alert alert-danger">
        <ul class="mb-0">
          <?php foreach ($errors as $e): ?>
            <li><?= $e ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
    <?php endif; ?>

    <?php if (!empty($success)): ?>
      <div class="alert alert-success text-center"><?= $success ?></div>
    <?php endif; ?>

    <form method="post">
      <div class="mb-3">
        <label class="form-label"><?= $t['name'] ?></label>
        <input type="text" name="name" class="form-control" required>
      </div>

      <div class="mb-3">
        <label class="form-label"><?= $t['email'] ?></label>
        <input type="email" name="email" class="form-control" required>
      </div>

      <div class="mb-3">
        <label class="form-label"><?= $t['password'] ?></label>
        <input type="password" name="password" class="form-control" required>
      </div>

      <div class="mb-3">
        <label class="form-label"><?= $t['whatsapp'] ?></label>
        <input type="text" name="whatsapp_number" class="form-control" placeholder="+201001234567">
      </div>

      <div class="mb-3">
        <label class="form-label"><?= $t['role'] ?></label>
        <select name="role" class="form-select" onchange="toggleStudentFields()" required>
          <option value="teacher"><?= $t['teacher'] ?></option>
          <option value="student"><?= $t['student'] ?></option>
        </select>
      </div>

      <div id="student-fields" style="display: none;">
        <div class="mb-3">
          <label class="form-label"><?= $t['grade'] ?></label>
          <input type="text" name="grade" class="form-control">
        </div>

        <div class="mb-3">
          <label class="form-label"><?= $t['choose_teacher'] ?></label>
          <select name="teacher_id" class="form-select">
            <option value=""><?= $t['select_teacher'] ?></option>
            <?php
            $teachers = $pdo->query("SELECT id, name FROM users WHERE role = 'teacher'")->fetchAll();
            foreach ($teachers as $tch):
            ?>
              <option value="<?= $tch['id'] ?>"><?= htmlspecialchars($tch['name']) ?></option>
            <?php endforeach; ?>
          </select>
        </div>
      </div>

      <div class="d-grid">
        <button type="submit" class="btn btn-success"><?php print_r($t['submit']) ?></button>
      </div>
    </form>
    
    <div class="text-center mt-3">
      <a href="../public/login.php?lang=<?= $lang ?>" class="btn btn-outline-success">
        <?= $t['login'] ?>
      </a>
    </div>
    <div class="text-center mt-3">
      <a href="?lang=ar">العربية</a> | <a href="?lang=en">English</a>
    </div>
    <div class="text-center mt-3">
      <a href="/"><?= $t['home'] ?></a>
    </div>
  </div>
</body>
</html>
