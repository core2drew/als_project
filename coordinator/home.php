<?php
  require '../config/db_connect.php';
  include '../includes/html/head.php';
  include '../check_session.php';
  include '../includes/header.php';

  $grade_level = isset($_GET['grade_level']) ? $_GET['grade_level'] : null;
  $type = isset($_GET['type']) ? $_GET['type'] : null;
  $sub_page = isset($_GET['sub_page']) ? $_GET['sub_page'] : null;
  $user_id = $_SESSION['user_id'];
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

<?php include '../includes/html/scripts.php'?>
<?php if($sub_page == 'activities'): ?>
  <script src="/public/js/modules/activity.js"></script>
  <?php include '../includes/home/modals.php' ?>
<?php else: ?>
  <script src="/public/js/modules/announcement.js"></script>
  <?php include '../includes/home/announcement-modals.php' ?>
<?php endif ?>
<?php include '../includes/profile/modals.php';?>
<?php include '../includes/html/footer.php' ?>