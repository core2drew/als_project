<?php
  require '../config/db_connect.php';
  include '../includes/html/head.php';
  include '../check_session.php';
  include '../includes/header.php';
  
  $grade_level = isset($_GET['grade_level']) ? $_GET['grade_level'] : null;
  $subject_id = isset($_GET['subject_id']) ? $_GET['subject_id'] : null;
  $exam_id = isset($_GET['exam_id']) ? $_GET['exam_id'] : null;
?>

<div id="Teacher" class="wrapper">
  <?php include '../../includes/sidebar.php' ?>
  <div id="ManageExams" class="page">
    <?php
      if($subject_id) {
        include '../includes/exam/exams.php';
      } else {
        include '../includes/exam/subjects.php';
      }
    ?>
  </div>
</div>