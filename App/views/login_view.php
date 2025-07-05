<?php
$lang = $_GET['lang'] ?? 'ar';
// ثم بناء الترجمة بناءً على $lang
$t = [
  'login_title' => $lang === 'ar' ? 'تسجيل الدخول' : 'Login',
  'quran_verse' => $lang === 'ar' ? '﴿ وَقُلْ رَبِّ زِدْنِي عِلْمًا ﴾' : '﴾ وَقُلْ رَبِّ زِدْنِي عِلْمًا ﴿',
  'email' => $lang === 'ar' ? 'البريد الإلكتروني' : 'Email',
  'password' => $lang === 'ar' ? 'كلمة المرور' : 'Password',
  'login_button' => $lang === 'ar' ? 'دخول' : 'Login',
  'register_button' => $lang === 'ar' ? 'إنشاء حساب جديد' : 'Register',
  'home' => $lang === 'ar' ? 'الصفحة الرئيسية' : 'Home'
];
?>

<!DOCTYPE html>
<html lang="<?= $lang ?>" dir="<?= $lang === 'ar' ? 'rtl' : 'ltr' ?>">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= $t['login_title'] ?> - دروس القرآن</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap<?= $lang === 'ar' ? '.rtl' : '' ?>.min.css" rel="stylesheet">
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
    }
    .login-card {
      background: white;
      border-radius: 16px;
      box-shadow: 0 0 20px rgba(0,0,0,0.05);
      padding: 30px;
      max-width: 400px;
      width: 100%;
    }
    .login-title {
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
    .btn-primary {
      background-color: #1c6758;
      border: none;
    }
    .btn-primary:hover {
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
</head>
<body>
  <div class="login-card">
    <h2 class="login-title"><?= $t['login_title'] ?></h2>
    <div class="quran-verse"><?= $t['quran_verse'] ?></div>

    <?php if (!empty($error)): ?>
      <div class="alert alert-danger text-center"><?= $error ?></div>
    <?php endif; ?>

    <form method="post">
      <div class="mb-3">
        <label class="form-label"><?= $t['email'] ?></label>
        <input type="email" name="email" class="form-control" placeholder="example@email.com" required>
      </div>

      <div class="mb-3">
        <label class="form-label"><?= $t['password'] ?></label>
        <input type="password" name="password" class="form-control" placeholder="••••••••" required>
      </div>

      <div class="d-grid">
        <button type="submit" class="btn btn-primary"><?= $t['login_button'] ?></button>
      </div>
    </form>
    <div class="text-center mt-3">
      <a href="../public/register.php?lang=<?= $lang ?>" class="btn btn-outline-success">
        <?= $t['register_button'] ?>
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
