<?php
  require '../../config/db_connect.php';
  include '../../includes/html/head.php';
  include '../../check_session.php';
  include '../../includes/header.php';

  $grade_level = isset($_GET['grade_level']) ? $_GET['grade_level'] : null;
?>

<div id="Coordinator" class="wrapper">
  <?php include '../../includes/sidebar.php'; ?>
  <div id="ManageLearningVideos" class="page">
    <div class="tabs">
      <?php 
        for($i = 1; $i <= 2; $i++) {
          $href = "/coordinator/learningvideo/learningvideos.php?page=learningvideos&grade_level=$i";
          $label = $i <= 1 ? 'Elementary' : 'High School';
          $active_class = $grade_level == $i ? " active'" : "'";
          $link = "<a class='tab". $active_class ." href='$href'>$label</a>";
          echo $link;
        }
      ?>
    </div>
    <div class="table-actions">
      <?php
        $create_link = "/coordinator/learningvideo/create.php?page=learningvideos&grade_level=$grade_level";
        echo "<a class='button' href=$create_link>Create Learning Videos</a>";
      ?>
    </div>
  </div>
</div>
<?php
  include '../../includes/html/footer.php';
?>