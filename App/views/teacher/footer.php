<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('evaluationModal');
    const lessonIdInput = document.getElementById('evalLessonId');
    const lessonDateInput = document.getElementById('evalLessonDate');
    const studentSelect = document.getElementById('studentSelect');

    document.querySelectorAll('.open-eval-modal').forEach(button => {
        button.addEventListener('click', function () {
            const lessonId = this.getAttribute('data-lesson-id');
            const lessonDate = this.getAttribute('data-lesson-date');
            const studentsData = this.getAttribute('data-lesson-students');

            // حط القيم في المودال
            lessonIdInput.value = lessonId;
            lessonDateInput.value = lessonDate;

            // فضّي السلكت الأول
            studentSelect.innerHTML = '<option value="" disabled selected>اختر الطالب</option>';

            try {
                const students = JSON.parse(studentsData);

                if (students.length === 0) {
                    studentSelect.innerHTML = '<option disabled>لا يوجد طلاب</option>';
                } else {
                    students.forEach(student => {
                        const option = document.createElement('option');
                        option.value = student.id;
                        option.textContent = student.name;
                        studentSelect.appendChild(option);
                    });
                }

            } catch (e) {
                studentSelect.innerHTML = '<option disabled>فشل تحميل الطلاب</option>';
            }
        });
    });
});
</script>


</body>
</html>