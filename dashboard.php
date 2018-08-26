<?php
  include 'includes/html/head.php';
  include 'check_session.php';
?>
  <div class="wrapper">
    <h1>Dashboard</h1>
    <?php
      if($_SESSION['user_type'] == 'teacher') {
        echo "<a href='admin/question.php'>Question</a>";
      }
    ?>
    <a href="logout.php">Logout</a>
  </div>
<?php
  include 'includes/html/footer.php';
?>