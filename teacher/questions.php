<?php
  require '../config/db_connect.php';
  include '../includes/html/head.php';
  include '../check_session.php';
  include '../includes/header.php';
  $grade_level = $_SESSION['grade_level'];
  $user_id = $_SESSION['user_id'];
  $subject_id = isset($_GET['subject_id']) ? $_GET['subject_id'] : null;
  $quiz_id = isset($_GET['quiz_id']) ? $_GET['quiz_id'] : null;
  
  $is_teacher = $_SESSION['type'] === 'teacher' ? true : false;
  $is_student = $_SESSION['type'] === 'student' ? true : false;
?>

<div id="Teacher" class="wrapper">
  <?php include '../includes/sidebar.php' ?>
  <div id="ManageQuiz" class="page">
    <?php
      include '../includes/quiz/questions.php';
    ?>
  </div>
</div>

<?php include '../includes/question/modals.php' ?>
<?php include '../includes/html/scripts.php'?>
<?php include '../includes/profile/modals.php';?>
<script src="/public/js/modules/quiz-question.js"></script>
<?php include '../includes/html/footer.php' ?>