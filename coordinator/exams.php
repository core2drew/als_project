<?php
  require '../config/db_connect.php';
  include '../includes/html/head.php';
  include '../check_session.php';
  include '../includes/header.php';
  
  $is_coordinator = $_SESSION['type'] === 'coordinator' ? true : false;
  $grade_level = isset($_GET['grade_level']) ? $_GET['grade_level'] : null;
  $subject_id = isset($_GET['subject_id']) ? $_GET['subject_id'] : null;
  $exam_id = isset($_GET['exam_id']) ? $_GET['exam_id'] : null;
?>

<div id="Coordinator" class="wrapper">
  <?php include '../includes/sidebar.php' ?>
  <div id="ManageExams" class="page">
    <?php
      if($subject_id) {
        if($exam_id) {
          include '../includes/exam/questions.php';
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
<script src="/public/js/modules/exam.js"></script>
<?php include '../includes/html/footer.php' ?>