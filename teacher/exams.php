<?php
  require '../config/db_connect.php';
  include '../includes/html/head.php';
  include '../check_session.php';
  include '../includes/header.php';
  $grade_level = $_SESSION['grade_level'];
  $subject_id = isset($_GET['subject_id']) ? $_GET['subject_id'] : null;
  $exam_id = isset($_GET['exam_id']) ? $_GET['exam_id'] : null;
  $is_report = isset($_GET['is_report']) ? $_GET['is_report'] : null;
  $teacher_id = isset($_GET['teacher_id']) ? $_GET['teacher_id'] : null;

  $is_coordinator = $_SESSION['type'] === 'coordinator' ? true : false;
  $is_teacher = $_SESSION['type'] === 'teacher' ? true : false;
  $is_student = $_SESSION['type'] === 'student' ? true : false;

?>

<div id="Teacher" class="wrapper">
  <?php include '../includes/sidebar.php' ?>
  <div id="ManageExams" class="page">
    <?php
      if($subject_id) {
        if($exam_id) {
          if($is_report) {
            include '../includes/reports/exam/students.php';
          } else {
            include '../includes/exam/exam.php';
          }
        } else {
          include '../includes/exam/exams.php';
        }
      } else {
        include '../includes/exam/subjects.php';
      }
    ?>
  </div>
</div>

<?php include '../includes/teacher/modals.php' ?>
<?php include '../includes/html/scripts.php'?>
<?php include '../includes/profile/modals.php';?>
<script src="/public/js/modules/teacher.js"></script>
<?php include '../includes/html/footer.php' ?>