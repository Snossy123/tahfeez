<?php 
    include_once 'header.php';
    include_once 'navbar.php';
?>
<div class="container-fluid">
  <div class="row">
    <?php 
        include_once 'sidebar.php'; 
        if ($pageTitle === 'admin_dashboard') {
            require_once 'dashboard_view.php';
        } else if ($pageTitle === 'manage_subscriptions_page_title') {
            require_once 'manage_subscriptions_view.php';
        } else {
            // require_once 'add_lesson_view.php';
        }
    ?>
  </div>
</div>
<?php 
    include_once 'footer.php';
?>



