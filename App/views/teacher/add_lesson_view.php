<div class="col-md-9 ms-sm-auto col-lg-9 main-content">
  <h2>➕ إضافة درس جديد</h2>
  <form action="store_lesson.php" method="POST">
    <div class="mb-3">
      <label for="students">اختر الطلاب:</label>
      <select name="students[]" id="students" multiple class="form-control" required>
        <?php foreach ($students as $student): ?>
          <option value="<?= $student['student_id'] ?>">
            <?= htmlspecialchars($student['name']) ?> (باقي: <?= $student['total_lessons'] - $student['used_lessons'] ?>)
          </option>
        <?php endforeach; ?>
      </select>
      <small class="form-text text-muted">يمكنك اختيار أكثر من طالب باستخدام Ctrl أو Shift.</small>
    </div>

    <div class="mb-3">
      <label for="date">تاريخ الدرس:</label>
      <input type="date" name="date" class="form-control" required>
    </div>

    <div class="mb-3">
      <label for="time">الوقت:</label>
      <input type="time" name="time" class="form-control" required>
    </div>

    <div class="mb-3">
      <label for="duration">المدة (بالدقائق):</label>
      <input type="number" name="duration" class="form-control" required>
    </div>

    <div class="mb-3">
      <label for="meet_link">رابط Google Meet:</label>
      <input type="url" name="meet_link" class="form-control">
    </div>

    <div class="mb-3">
      <label for="notes">ملاحظات:</label>
      <textarea name="notes" class="form-control" rows="3"></textarea>
    </div>

    <button type="submit" class="btn btn-success">إضافة الدرس</button>
  </form>
</div>