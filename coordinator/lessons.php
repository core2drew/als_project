<?php
  require '../config/db_connect.php';
  include '../includes/html/head.php';
  include '../check_session.php';
  include '../includes/header.php';
  include '../resources/lesson/lesson.php';

  $grade_level = isset($_GET['grade_level']) ? $_GET['grade_level'] : null;
  $subject_id = isset($_GET['subject_id']) ? $_GET['subject_id'] : null;
  $lesson_id = isset($_GET['lesson_id']) ? $_GET['lesson_id'] : null;
  $action = isset($_GET['action']) ? $_GET['action'] : null;
?>

<div id="Coordinator" class="wrapper">
  <?php include '../includes/sidebar.php'; ?>
  <div id="ManageLessons" class="page">
    <?php 
      if($subject_id) {
        include '../includes/lesson/lessons.php';
      } else {
        include '../includes/lesson/subjects.php';
      }
    ?>
  </div>
</div>

<?php include '../includes/lesson/modals.php'; ?>
<?php include '../includes/html/scripts.php';?>
<script src="/public/ckeditor5/ckeditor.js"></script>
<script src="/public/js/modules/lesson.js"></script>
<?php include '../includes/html/footer.php'; ?>