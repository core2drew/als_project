<?php
  require '../../config/db_connect.php';
  include '../../includes/html/head.php';
  include '../../check_session.php';
  include '../../includes/header.php';
  include '../../resources/exam/add.php';

  $grade_level = isset($_GET['grade_level']) ? $_GET['grade_level'] : null;
  $subject_id = isset($_GET['subject_id']) ? $_GET['subject_id'] : null;

  function handleErrorMessage($field, $error_fields = null){
    if(isset($error_fields)) {
      echo isset($error_fields[$field]) ? "<label class='error'>$error_fields[$field]</label>" : null;
    }
  }
?>

<div id="Coordinator" class="wrapper">
  <?php include '../../includes/sidebar.php'; ?>
  <div id="ManageExam" class="page">
    
  </div>
</div>
<?php
  include '../../includes/html/footer.php';
?>