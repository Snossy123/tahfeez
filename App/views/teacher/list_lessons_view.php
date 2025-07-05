<div class="col-md-9 ms-sm-auto col-lg-9 main-content">
    <h2 class="mb-4">📚 دروسك</h2>

    <?php if (!empty($_SESSION['success'])): ?>
      <div class="alert alert-success"><?= $_SESSION['success'] ?></div>
      <?php unset($_SESSION['success']); ?>
    <?php elseif (!empty($_SESSION['error'])): ?>
      <div class="alert alert-danger"><?= $_SESSION['error'] ?></div>
      <?php unset($_SESSION['error']); ?>
    <?php endif; ?>


    <a href="add_lesson.php" class="btn btn-success mb-3">➕ إضافة درس جديد</a>

    <table class="table table-bordered bg-white">
        <thead>
            <tr>
                <th>📅 التاريخ</th>
                <th>⏰ الوقت</th>
                <th>⏳ المدة</th>
                <th>👥 الطلاب</th>
                <th>🔗 رابط Google Meet</th>
                <th>📝 ملاحظات</th>
                <th>⚙️ الإجراءات</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($lessons as $lesson): ?>
                <tr>
                    <td><?= htmlspecialchars($lesson['date']) ?></td>
                    <td><?= htmlspecialchars($lesson['time']) ?></td>
                    <td><?= htmlspecialchars($lesson['duration']) ?> دقيقة</td>
                    <td><?= htmlspecialchars($lesson['student_names']) ?></td>
                    <td><a href="<?= htmlspecialchars($lesson['google_meet_link']) ?>" target="_blank">رابط</a></td>
                    <td><?= htmlspecialchars($lesson['notes']) ?></td>
                    <td>
                        <a href="edit_lesson.php?id=<?= $lesson['id'] ?>" class="btn btn-sm btn-primary">تعديل</a>
                        <a href="delete_lesson.php?id=<?= $lesson['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('هل أنت متأكد من حذف الدرس؟')">حذف</a>
                        <?php
                            $stmt = $pdo->prepare("
                                SELECT students.id, users.name
                                FROM lesson_student
                                JOIN students ON lesson_student.student_id = students.id
                                JOIN users ON students.user_id = users.id
                                WHERE lesson_student.lesson_id = ?
                            ");
                            $stmt->execute([$lesson['id']]);
                            $students = $stmt->fetchAll(PDO::FETCH_ASSOC);
                        ?>
                        <button class="btn btn-sm btn-warning open-eval-modal"
                            data-bs-toggle="modal"
                            data-bs-target="#evaluationModal"
                            data-lesson-id="<?= $lesson['id'] ?>"
                            data-lesson-students='<?= htmlspecialchars(json_encode($students), ENT_QUOTES, "UTF-8") ?>'
                            data-lesson-date="<?= htmlspecialchars($lesson['date']) ?>">
                            ➕ تقييم
                        </button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>


<!-- ✅ Modal التقييم الموحد -->
<div class="modal fade" id="evaluationModal" tabindex="-1" aria-labelledby="evaluationModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="evalution_meeting.php" method="POST" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="evaluationModalLabel">إضافة تقييم</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="إغلاق"></button>
      </div>
      <div class="modal-body">

        <input type="hidden" name="lesson_id" id="evalLessonId">

        <div class="mb-3">
          <label class="form-label">📅 تاريخ الدرس:</label>
          <input type="text" id="evalLessonDate" class="form-control" disabled>
        </div>

        <div class="mb-3">
          <label class="form-label">👤 اختر الطالب:</label>
          <select name="student_id" id="studentSelect" class="form-select" required>
            <option value="" disabled selected>اختر الطالب</option>
          </select>
        </div>

        <div class="mb-3">
          <label class="form-label">📌 الحضور:</label>
          <select name="attendance" class="form-select" required>
            <option value="" disabled selected>اختر الحالة</option>
            <option value="present">حضر</option>
            <option value="absent">لم يحضر</option>
          </select>
        </div>

        <div class="mb-3">
          <label class="form-label">⭐ التقييم (1-5):</label>
          <input type="number" name="rating" class="form-control" min="1" max="5" required>
        </div>

        <div class="mb-3">
          <label class="form-label">📝 ملاحظات:</label>
          <textarea name="notes" class="form-control" rows="3"></textarea>
        </div>

      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-success">💾 حفظ التقييم</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
      </div>
    </form>
  </div>
</div>
