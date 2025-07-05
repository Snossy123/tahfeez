<?php 
    include_once 'header.php';
    include_once 'navbar.php';
?>
<div class="container-fluid">
  <div class="row">
    <?php 
        include_once 'sidebar.php'; 
        if ($pageTitle === 'teacher_dashboard') {
            require_once 'dashboard_view.php';
        } else if ($pageTitle === 'list_lessons') {
            require_once 'list_lessons_view.php';
        } else if ($pageTitle === 'edit_lesson_page_title') {
            require_once 'edit_lessons_view.php';
        } else if ($pageTitle === 'setting_teacher_page_title') {
            require_once 'setting_teacher_view.php';
        } else {
            require_once 'add_lesson_view.php';
        }
    ?>
  </div>
</div>
<?php 
    include_once 'footer.php';
?>



