<?php
  include 'includes/html/head.php';
  include 'check_session.php';
  include 'includes/header.php';
?>
  <div id="Dashboard" class="wrapper">
    <?php include 'includes/sidebar.php'; ?>
    <div class="page">
      <h1>Dashboard</h1>
      <?php
        if($_SESSION['type'] == 'teacher') {
          echo "<a href='teacher/question.php'>Question</a>";
        }
      ?>
    </div>
  </div>
<?php
  include 'includes/html/footer.php';
?>