<?php
  require '../config/db_connect.php';
  include '../includes/html/head.php';
  include '../check_session.php';
  include '../includes/header.php';
?>

<div id="Coordinator" class="wrapper">
  <?php include '../includes/sidebar.php'; ?>
  <div id="ManageLessons" class="page">
    <h1 class='title'>Manage Lessons</h1>
  </div>
</div>
<?php
  include '../includes/html/footer.php';
?>