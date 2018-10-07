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
    <div id="Home">
      <div id="ActivityAnnouncement">
        <div id="ActivityContainer" class="content">
          <h3 class="title">Activities</h3>
          <div id="ActivitySlider"></div>
        </div>
        <div id="AnnouncementContainer" class="content">
          <h3 class="title">Announcement</h3>
          <div id="Announcements"></div>
        </div>
      </div>
      <div id="MissionVision">
        <div class="content">
          <h3 class="title">Vision</h3>
          <p class="description">
            In partnership with other producers of learning, 
            the Bureau of Alternative Learning System will 
            develop exemplary programs and open creative 
            learning opportunities to achieve multiple 
            literacy for all.
          </p>
        </div>
        <div class="content">
          <h3 class="title">Mission</h3>
          <p class="description">
            The Bureau of Alternative Learning System envisions 
            itself to be the leading producers of Filipino lifelong 
            learners.
          </p>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include 'includes/html/scripts.php'?>
<script src="/public/slick/slick.min.js"></script>
<script src="/public/js/modules/home.js"></script>
<?php include 'includes/html/footer.php' ?>