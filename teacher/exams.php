<?php
  require '../config/db_connect.php';
  include '../includes/html/head.php';
  include '../check_session.php';
  include '../includes/header.php';
  
  $grade_level = $_SESSION['grade_level'];
  $is_coordinator = $_SESSION['type'] === 'coordinator' ? true : false;
  $subject_id = isset($_GET['subject_id']) ? $_GET['subject_id'] : null;
  $exam_id = isset($_GET['exam_id']) ? $_GET['exam_id'] : null;
?>

<div id="Teacher" class="wrapper">
  <?php include '../includes/sidebar.php' ?>
  <div id="ManageExams" class="page">
    <?php
      if($subject_id) {
        if($exam_id) {
          include '../includes/exam/exam.php';
        } else {
          include '../includes/exam/exams.php';
        }
      } else {
        include '../includes/exam/subjects.php';
      }
    ?>
  </div>
</div>

<?php include '../includes/exam/modals.php' ?>
<?php include '../includes/html/scripts.php'?>
<script src="/public/js/modules/teacher.js"></script>
<?php include '../includes/html/footer.php' ?>