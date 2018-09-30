<?php
  require '../config/db_connect.php';
  include '../includes/html/head.php';
  include '../check_session.php';
  include '../includes/header.php';

  $grade_level = isset($_GET['grade_level']) ? $_GET['grade_level'] : null;
  $type = isset($_GET['type']) ? $_GET['type'] : null;
  $sub_page = isset($_GET['sub_page']) ? $_GET['sub_page'] : null;
?>

<div id="Coordinator" class="wrapper">
  <?php include '../includes/sidebar.php' ?>
  <div id="ManageHome" class="page">
    <?php 
      if($sub_page == 'activities') {
        include '../includes/home/activities.php';
      } elseif($sub_page == 'announcements') {
        include '../includes/home/announcements.php';
      }
    ?>
  </div>
</div>

<?php include '../includes/home/modals.php' ?>
<?php include '../includes/html/scripts.php'?>
<?php if($sub_page == 'activities'): ?>
  <script src="/public/js/modules/activity.js"></script>
<?php else: ?>
  <script src="/public/js/modules/annoucement.js"></script>
<?php endif ?>

<?php include '../includes/html/footer.php' ?>