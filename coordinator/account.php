<?php
  require '../config/db_connect.php';
  include '../includes/html/head.php';
  include '../check_session.php';
  include '../includes/header.php';

  $grade_level = isset($_GET['grade_level']) ? $_GET['grade_level'] : null;
  $type = isset($_GET['type']) ? $_GET['type'] : null;
  $sub_page = isset($_GET['sub_page']) ? $_GET['sub_page'] : null;
  //$create_link = "/coordinator/account/create.php?page=accounts&sub_page=$type&type=$type&grade_level=$grade_level";
?>

<div id="Coordinator" class="wrapper">
  <?php include '../includes/sidebar.php' ?>
  <div id="ManageAccounts" class="page">
    <?php include '../includes/account/accounts.php' ?>
  </div>
</div>

<?php include '../includes/account/modals.php' ?>
<?php include '../includes/html/scripts.php'?>
<script src="/public/js/modules/account.js"></script>
<?php include '../includes/html/footer.php' ?>