<?php
  require '../../config/db_connect.php';
  include '../../includes/html/head.php';
  include '../../check_session.php';
  include '../../includes/header.php';

  $grade_level = isset($_GET['grade_level']) ? $_GET['grade_level'] : null;
  $subject_id = isset($_GET['subject_id']) ? $_GET['subject_id'] : null;
  $question_id = isset($_GET['question_id']) ? $_GET['question_id'] : null;
?>

<div id="Coordinator" class="wrapper">
  <?php include '../../includes/sidebar.php'; ?>
  <div id="ManageQuestions" class="page">
    <?php 
      if($subject_id) {
        include '../../includes/question/questions.php';
      } else {
        include '../../includes/question/subjects.php';
      }
    ?>
  </div>
</div>

<?php include '../../includes/question/modals.php'; ?>
<?php include '../../includes/html/scripts.php';?>
<script src="/public/js/modules/question.js"></script>
<?php include '../../includes/html/footer.php'; ?>