<?php
  require 'config/db_connect.php';
  include 'includes/html/head.php';
  include 'check_session.php';
  include 'includes/header.php';

  $grade_level = $_SESSION['grade_level'];
  $subject_id = isset($_GET['subject_id']) ? $_GET['subject_id'] : null;
  $lesson_id = isset($_GET['lesson_id']) ? $_GET['lesson_id'] : null;
?>
  <div id="Lessons" class="wrapper">
    <?php include 'includes/sidebar.php'; ?>
    <div id="ManageLessons" class="page">
      <?php 
        if(isset($subject_id)) {
          if(isset($lesson_id)) {
            include 'includes/lesson/view.php';
          } else {
            include 'includes/lesson/lessons.php';
          }
        } else {
          include 'includes/lesson/subjects.php';
        }
      ?>
    </div>
  </div>

<?php include 'includes/html/scripts.php';?>
<script src="/public/ckeditor5/ckeditor.js"></script>
<script src="/public/js/modules/lesson.js"></script>
<?php include 'includes/html/footer.php'; ?>