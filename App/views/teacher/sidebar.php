    <!-- Sidebar - Visible on md+, Offcanvas on sm -->
    <div class="col-md-3 d-none d-md-block sidebar text-center">
      <img src="<?= htmlspecialchars($imageToShow) ?>" alt="Profile">
      <h5 class="mb-4"><?= htmlspecialchars($_SESSION['user']['name'] ?? 'Teacher') ?></h5>
      <a href="teacher_dashboard.php"><?= $t['teacher_dashboard'] ?></a>
      <a href="view_teacher_lessons.php"><?= $t['your_lessons_page_title'] ?></a>
      <a href="add_lesson.php"><?= $t['add_lesson'] ?></a>
      <a href="settings_teacher.php"><?= $t['profile_settings'] ?? 'إعدادات الحساب' ?></a>
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
        <a href="teacher_dashboard.php"><?= $t['teacher_dashboard'] ?></a>
        <a href="view_teacher_lessons.php"><?= $t['your_lessons_page_title'] ?></a>
        <a href="add_lesson.php"><?= $t['add_lesson'] ?></a>
        <a href="settings_teacher.php"><?= $t['profile_settings'] ?? 'إعدادات الحساب' ?></a>
        <a href="logout.php"><?= $t['logout'] ?? 'تسجيل الخروج' ?></a>
        <div class="mt-4">
          <a href="?lang=<?= $otherLang ?>" class="btn btn-outline-light btn-sm"><?= $t['language_toggle'] ?></a>
        </div>
      </div>
    </div>