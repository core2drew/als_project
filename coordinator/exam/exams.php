<?php
  require '../../config/db_connect.php';
  include '../../includes/html/head.php';
  include '../../check_session.php';
  include '../../includes/header.php';
  include '../../resources/_global.php';
  include '../../includes/exam/modals.php';

  $grade_level = isset($_GET['grade_level']) ? $_GET['grade_level'] : null;
  $subject_id = isset($_GET['subject_id']) ? $_GET['subject_id'] : null;
  $action = isset($_GET['action']) ? $_GET['action'] : null;
?>

<div id="Coordinator" class="wrapper">
  <?php include '../../includes/sidebar.php' ?>
  <div id="ManageExams" class="page">
    <?php
      if(!$action){
        if($subject_id) {
          include '../../includes/exam/exams.php';
        } else {
          include '../../includes/exam/subjects.php';
        }
      } else if($action == 'create') {
        include '../../includes/exam/create.php';
      }
    ?>
  </div>
</div>


<?php include '../../includes/html/scripts.php';?>
<script src="/public/js/modules/exam.js"></script>
<?php include '../../includes/html/footer.php'; ?>