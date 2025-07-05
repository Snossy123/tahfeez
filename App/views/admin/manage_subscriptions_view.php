<?php session_start(); ?>
<div class="col-md-9 ms-sm-auto col-lg-9 main-content">
  <h2 class="mb-4">إدارة اشتراكات الطلاب</h2>

  <?php if (!empty($_SESSION['success'])): ?>
    <div class="alert alert-success"><?= $_SESSION['success'] ?></div>
    <?php unset($_SESSION['success']); ?>
  <?php elseif (!empty($_SESSION['error'])): ?>
    <div class="alert alert-danger"><?= $_SESSION['error'] ?></div>
    <?php unset($_SESSION['error']); ?>
  <?php endif; ?>

  <!-- زر إضافة -->
  <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addSubscriptionModal">إضافة اشتراك جديد</button>

  <table class="table table-bordered">
    <thead>
      <tr>
        <th>اسم الطالب</th>
        <th>تاريخ البدء</th>
        <th>تاريخ الانتهاء</th>
        <th>عدد الحصص</th>
        <th>المستخدمة</th>
        <th>التحكم</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($subscriptions as $sub): ?>
        <tr>
          <td><?= htmlspecialchars($sub['student_name']) ?></td>
          <td><?= $sub['start_date'] ?: '—' ?></td>
          <td><?= $sub['end_date'] ?: '—' ?></td>
          <td><?= $sub['total_lessons'] ?: '—' ?></td>
          <td><?= $sub['used_lessons'] ?? 0 ?></td>
          <td>
            <button class="btn btn-warning btn-sm"
              onclick="openEditModal(<?= $sub['id'] ?>, '<?= $sub['start_date'] ?>', '<?= $sub['end_date'] ?>', <?= $sub['total_lessons'] ?>)">
              تعديل
            </button>
            <form method="POST" action="subscription_form.php" style="display:inline;" onsubmit="return confirm('هل أنت متأكد من الإلغاء؟');">
                <input type="hidden" name="action" value="delete">
                <input type="hidden" name="id" value="<?= $sub['id'] ?>">
                <button type="submit" class="btn btn-danger btn-sm">إلغاء</button>
            </form>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>



<!-- Modal إضافة الاشتراك -->
<div class="modal fade" id="addSubscriptionModal" tabindex="-1" aria-labelledby="addSubscriptionLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" action="subscription_form.php?action=add" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addSubscriptionLabel">إضافة اشتراك جديد</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="إغلاق"></button>
      </div>
      <div class="modal-body">

        <div class="mb-3">
          <label class="form-label">اختر الطالب</label>
          <select name="student_id" class="form-select" required>
            <option value="">-- اختر الطالب --</option>
            <?php foreach ($allStudents as $student): ?>
              <option value="<?= $student['student_id'] ?>"><?= htmlspecialchars($student['student_name']) ?></option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="mb-3">
          <label class="form-label">تاريخ البدء</label>
          <input type="date" name="start_date" class="form-control" required>
        </div>

        <div class="mb-3">
          <label class="form-label">تاريخ الانتهاء</label>
          <input type="date" name="end_date" class="form-control" required>
        </div>

        <div class="mb-3">
          <label class="form-label">عدد الحصص</label>
          <input type="number" name="total_lessons" class="form-control" required>
        </div>

      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-success">حفظ الاشتراك</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
      </div>
    </form>
  </div>
</div>

<!-- Modal تعديل الاشتراك -->
<div class="modal fade" id="editSubscriptionModal" tabindex="-1" aria-labelledby="editSubscriptionLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" action="subscription_form.php?action=edit" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editSubscriptionLabel">تعديل الاشتراك</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="إغلاق"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" name="id" id="edit-id">
        <div class="mb-3">
          <label class="form-label">تاريخ البدء</label>
          <input type="date" name="start_date" id="edit-start-date" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">تاريخ الانتهاء</label>
          <input type="date" name="end_date" id="edit-end-date" class="form-control" required>
        </div>
        <div class="mb-3">
          <label class="form-label">عدد الحصص</label>
          <input type="number" name="total_lessons" id="edit-total-lessons" class="form-control" required>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-success">حفظ التعديلات</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
      </div>
    </form>
  </div>
</div>