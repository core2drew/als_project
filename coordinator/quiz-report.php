<?php
  require '../config/db_connect.php';
  include '../includes/html/head.php';
  include '../check_session.php';
  include '../includes/header.php';
  
  $is_coordinator = $_SESSION['type'] === 'coordinator' ? true : false;
  $grade_level = isset($_GET['grade_level']) ? $_GET['grade_level'] : null;
  $subject_id = isset($_GET['subject_id']) ? $_GET['subject_id'] : null;
  $quiz_id = isset($_GET['quiz_id']) ? $_GET['quiz_id'] : null;
?>

<div id="Coordinator" class="wrapper">
  <?php include '../includes/sidebar.php' ?>
  <div id="ManageReports" class="page">
    <?php
      if($subject_id) {
        if($quiz_id) {
          include '../includes/reports/quiz/students.php';
        } else {
          include '../includes/reports/quiz/quizzes.php';
        }
      } else {
        include '../includes/reports/quiz/subjects.php';
      }
    ?>
  </div>
</div>

<?php include '../includes/exam/modals.php' ?>
<?php include '../includes/profile/modals.php';?>
<?php include '../includes/html/scripts.php'?>
<script src="/public/js/modules/exam.js"></script>
<?php include '../includes/html/footer.php' ?>