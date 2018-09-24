<?php
  require '../../config/db_connect.php';
  include '../../includes/html/head.php';
  include '../../check_session.php';
  include '../../includes/header.php';

  $grade_level = isset($_GET['grade_level']) ? $_GET['grade_level'] : null;
  $subject_id = isset($_GET['subject_id']) ? $_GET['subject_id'] : null;
  $video_id = isset($_GET['video_id']) ? $_GET['video_id'] : null;
?>

<div id="Coordinator" class="wrapper">
  <?php include '../../includes/sidebar.php'; ?>
  <div id="ManageEducationalVideos" class="page">
    <?php 
      if($subject_id) {
        include '../../includes/videos/educationalvideos.php';
      } else {
        include '../../includes/videos/subjects.php';
      }
    ?>
  </div>
</div>

<?php include '../../includes/videos/modals.php' ?>
<?php include '../../includes/html/scripts.php'?>
<script src="/public/js/modules/educationalvideo.js"></script>
<?php include '../../includes/html/footer.php' ?>