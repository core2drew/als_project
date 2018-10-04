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
?>

<div id="Teacher" class="wrapper">
  <?php include '../includes/sidebar.php' ?>
  <div id="ManageQuiz" class="page">
    <?php
      if($subject_id) {
        include '../includes/quiz/quizzes.php';
      } else {
        include '../includes/quiz/subjects.php';
      }
    ?>
  </div>
</div>

<?php include '../includes/quiz/modals.php' ?>
<?php include '../includes/html/scripts.php'?>
<script src="/public/js/modules/quiz.js"></script>
<?php include '../includes/html/footer.php' ?>