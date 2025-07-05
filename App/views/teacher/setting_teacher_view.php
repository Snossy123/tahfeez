<div class="col-md-9 ms-sm-auto col-lg-9 main-content">
  <h2 class="mb-4">إعدادات المعلم</h2>

    <?php if (!empty($_SESSION['success'])): ?>
        <div class="alert alert-success"><?= $_SESSION['success'] ?></div>
    <?php unset($_SESSION['success']); ?>
    <?php elseif (!empty($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?= $_SESSION['error'] ?></div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

  <form action="update_teacher_settings.php" method="POST" class="needs-validation" novalidate>
    <input type="hidden" name="user_id" value="<?= $user['id'] ?>">

    <div class="mb-3">
      <label for="name" class="form-label">الاسم</label>
      <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($user['name']) ?>" required>
    </div>

    <div class="mb-3">
      <label for="email" class="form-label">البريد الإلكتروني</label>
      <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
    </div>

    <div class="mb-3">
      <label for="whatsapp_number" class="form-label">رقم واتساب</label>
      <input type="text" class="form-control" id="whatsapp_number" name="whatsapp_number" value="<?= htmlspecialchars($user['whatsapp_number']) ?>" placeholder="+201234567890">
    </div>

    <div class="mb-3">
      <label for="new_password" class="form-label">كلمة المرور الجديدة (اختياري)</label>
      <input type="password" class="form-control" id="new_password" name="new_password">
    </div>

    <button type="submit" class="btn btn-primary">💾 حفظ</button>
  </form>
</div>
