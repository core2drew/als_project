<?php
  require '../config/db_connect.php';
  include '../includes/html/head.php';
  include '../check_session.php';
  include '../includes/header.php';
  $grade_level = isset($_GET['grade_level']) ? $_GET['grade_level'] : null;
?>

<div id="Coordinator" class="wrapper">
  <?php include '../includes/sidebar.php'; ?>
  <div id="ManageSubjects" class="page">
    <?php 
      include '../includes/subjects/subjects.php';
    ?>
  </div>
</div>

<?php include '../includes/subjects/modals.php'; ?>
<?php include '../includes/html/scripts.php';?>
<script src="/public/js/modules/subject.js"></script>
<?php include '../includes/html/footer.php'; ?>
