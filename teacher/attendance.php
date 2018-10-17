<?php
  require '../config/db_connect.php';
  include '../includes/html/head.php';
  include '../check_session.php';
  include '../includes/header.php';
?>

<div id="Teacher" class="wrapper">
  <?php include '../includes/sidebar.php' ?>
  <div id="Attendance" class="page">
    <?php include '../includes/attendance/attendance.php' ?>
  </div>
</div>

<?php include '../includes/profile/modals.php';?>
<?php include '../includes/html/scripts.php'?>
<?php include '../includes/html/footer.php' ?>