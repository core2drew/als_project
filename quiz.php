<?php
  require 'config/db_connect.php';
  include 'includes/html/head.php';
  include 'check_session.php';
  include 'includes/header.php';
  $subject_id = isset($_GET['subject_id']) ? $_GET['subject_id'] : null;
  $quiz_id = isset($_GET['quiz_id']) ? $_GET['quiz_id'] : null;
  $grade_level = isset($_SESSION['grade_level']) ? $_SESSION['grade_level'] : null;
  $user_type = isset($_SESSION['user_type']) ? $_SESSION['user_type'] : null;
  $user_id = $_SESSION['user_id'];
  $user_type = $_SESSION['type'];
?>
<div id="Teacher" class="wrapper">
  <?php include 'includes/sidebar.php' ?>
  <div id="ManageQuiz" class="page">
    <?php
      if($quiz_id) {
        include 'includes/quiz/quiz.php';
      } else {
        include 'includes/quiz/quizzes.php';
      }
    ?>
  </div>
</div>

<?php include 'includes/student/modals.php' ?>
<?php include 'includes/html/scripts.php'?>
<?php include 'includes/profile/modals.php';?>
<script src="/public/js/easytimer.min.js"></script>
<script src="/public/js/modules/student-quiz.js"></script>
<?php include 'includes/html/footer.php' ?>