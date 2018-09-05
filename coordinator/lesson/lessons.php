<?php
  require '../../config/db_connect.php';
  include '../../includes/html/head.php';
  include '../../check_session.php';
  include '../../includes/header.php';

  $grade_level = isset($_GET['grade_level']) ? $_GET['grade_level'] : null;
?>

<div id="Coordinator" class="wrapper">
  <?php include '../../includes/sidebar.php'; ?>
  <div id="ManageLessons" class="page">
    <div class="tabs">
      <a class="tab <?php echo $grade_level == 1 ? 'active' : null ?>" href="/coordinator/lesson/lessons.php?page=lessons&grade_level=1">Elementary</a>
      <a class="tab <?php echo $grade_level == 2 ? 'active' : null ?>" href="/coordinator/lesson/lessons.php?page=lessons&grade_level=2">High School</a>
    </div>
  </div>
</div>
<?php
  include '../../includes/html/footer.php';
?>