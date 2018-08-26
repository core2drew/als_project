<?php
  include 'includes/html/head.php';
  include 'check_session.php';
  include 'includes/header.php';
  include 'includes/sidebar.php';
?>
  <div id="Dashboard" class="wrapper">
    <?php
      if($_SESSION['user_type'] == 'teacher') {
        echo "<a href='admin/question.php'>Question</a>";
      }
    ?>
  </div>
<?php
  include 'includes/html/footer.php';
?>