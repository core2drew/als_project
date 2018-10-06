<?php
  require 'config/db_connect.php';
  include 'includes/html/head.php';
  include 'check_session.php';
  include 'includes/header.php';
  $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
  $exam_id = isset($_GET['exam_id']) ? $_GET['exam_id'] : null;
  $view_result = isset($_GET['view_result']) ? $_GET['view_result'] : null;

  $is_coordinator = $_SESSION['type'] === 'coordinator' ? true : false;
  $is_teacher = $_SESSION['type'] === 'teacher' ? true : false;
  $is_student = $_SESSION['type'] === 'student' ? true : false;
?>
<div id="Dashboard" class="wrapper">
  <?php include 'includes/sidebar.php'; ?>
  <div id="ManageHome" class="page">

    <div id="ActivityContainer">
      <h3 class="title">ALS Activities</h3>
      <div id="ActivitySlider"></div>
      <div id="NoActivity">
        <h3 class="message">No Activities</h3>
      </div>
    </div>
  </div>
</div>

<?php include 'includes/html/scripts.php'?>
<script src="/public/slick/slick.min.js"></script>
<script src="/public/js/modules/home.js"></script>
<?php include 'includes/html/footer.php' ?>