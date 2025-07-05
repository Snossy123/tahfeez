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