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
  <div id="Attendance" class="page">
    <?php include '../includes/attendance/attendance.php' ?>
  </div>
</div>

<?php include '../includes/account/modals.php' ?>
<?php include '../includes/profile/modals.php';?>
<?php include '../includes/html/scripts.php'?>
<script src="/public/js/modules/account.js"></script>
<?php include '../includes/html/footer.php' ?>