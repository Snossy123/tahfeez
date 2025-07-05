<nav class="navbar navbar-expand-lg navbar-dark bg-dark px-3">
  <a class="navbar-brand d-flex align-items-center" href="#">
    <img src="<?= htmlspecialchars($imageToShow) ?>" alt="User Image" class="rounded-circle" width="40" height="40">
    <span class="ms-2"><?= htmlspecialchars($studentName) ?></span>
  </a>

  <div class="ms-auto d-flex gap-2">
    <a href="?lang=<?= $otherLang ?>" class="btn btn-outline-light btn-sm"><?= $t['language_toggle'] ?></a>
    <a href="student_dashboard.php" class="btn btn-outline-light btn-sm"><?= $t['dashboard'] ?></a>
    <a href="settings_student.php" class="btn btn-outline-light btn-sm"><?= $t['profile'] ?></a>
    <a href="logout.php" class="btn btn-outline-danger btn-sm"><?= $t['logout'] ?></a>
  </div>
</nav>