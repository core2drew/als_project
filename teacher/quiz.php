<?php
  require '../config/db_connect.php';
  include '../includes/html/head.php';
  include '../check_session.php';
  include '../includes/header.php';
  $grade_level = $_SESSION['grade_level'];
  $user_id = $_SESSION['user_id'];
  $user_type = $_SESSION['type'];
  $subject_id = isset($_GET['subject_id']) ? $_GET['subject_id'] : null;
  $quiz_id = isset($_GET['quiz_id']) ? $_GET['quiz_id'] : null;
  $is_report = isset($_GET['is_report']) ? $_GET['is_report'] : null;
  $teacher_id = isset($_GET['teacher_id']) ? $_GET['teacher_id'] : null;
?>

<div id="Teacher" class="wrapper">
  <?php include '../includes/sidebar.php' ?>
  <div id="ManageQuiz" class="page">
    <?php
      if($subject_id) {
        if($is_report) {
          include '../includes/reports/quiz/students.php';
        } else {
          include '../includes/quiz/quizzes.php';
        }
      } else {
        include '../includes/quiz/subjects.php';
      }
    ?>
  </div>
</div>

<?php include '../includes/quiz/modals.php' ?>
<?php include '../includes/html/scripts.php'?>
<?php include '../includes/profile/modals.php';?>
<script src="/public/js/modules/quiz.js"></script>
<?php include '../includes/html/footer.php' ?>