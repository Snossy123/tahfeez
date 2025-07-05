<div class="col-md-9 ms-sm-auto col-lg-9 main-content">
<h2>تعديل الدرس</h2>

<form method="POST" action="update_lesson.php">
    <input type="hidden" name="lesson_id" value="<?= $lesson['id'] ?>">

    <div class="mb-3">
        <label>التاريخ:</label>
        <input type="date" name="date" class="form-control" value="<?= $lesson['date'] ?>" required>
    </div>

    <div class="mb-3">
        <label>الوقت:</label>
        <input type="time" name="time" class="form-control" value="<?= $lesson['time'] ?>" required>
    </div>

    <div class="mb-3">
        <label>المدة (بالدقائق):</label>
        <input type="number" name="duration" class="form-control" value="<?= $lesson['duration'] ?>" required>
    </div>

    <div class="mb-3">
        <label>رابط Google Meet:</label>
        <input type="url" name="google_meet_link" class="form-control" value="<?= $lesson['google_meet_link'] ?>">
    </div>

    <div class="mb-3">
        <label>ملاحظات:</label>
        <textarea name="notes" class="form-control"><?= $lesson['notes'] ?></textarea>
    </div>

    <div class="mb-3">
        <label>الطلاب المشاركين:</label>
        <?php foreach ($students as $student): ?>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="students[]" value="<?= $student['id'] ?>"
                    <?= in_array($student['id'], $current_students) ? 'checked' : '' ?>>
                <label class="form-check-label">
                    <?= htmlspecialchars($student['student_name']) ?> (حصص باقية: <?= ($student['total_lessons'] - $student['used_lessons']) ?>)
                </label>
            </div>
        <?php endforeach; ?>
    </div>

    <button type="submit" class="btn btn-success">حفظ التعديلات</button>
    <a href="view_teacher_lessons.php" class="btn btn-secondary">رجوع</a>
</form>
</div>