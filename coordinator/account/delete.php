<?php
    require '../../config/db_connect.php';
    include '../../includes/html/head.php';
    include '../../check_session.php';
    include '../../includes/header.php';
    include '../../resources/account/delete.php';

    $id = isset($_GET['id']) ? $_GET['id'] : null;
    $type = isset($_GET['type']) ? $_GET['type'] : null;
    $grade_level = isset($_GET['grade_level']) ? $_GET['grade_level'] : null;
    $form_action = htmlspecialchars($_SERVER["PHP_SELF"])."?page=accounts&sub_page=$type&type=$type&id=$id";
    $back_link = "/coordinator/account/account.php?page=accounts&sub_page=$type&type=$type&grade_level=$grade_level";

    if($type == 'coordinator') {
      $back_link = "/coordinator/account/account.php?page=accounts&sub_page=$type&type=$type";
    }

    $query = "SELECT
      users.id,
      users.lastname,
      users.firstname,
      users.email
      FROM users WHERE users.id = $id";

    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
?>

<div id="Coordinator" class="wrapper">
  <?php include '../../includes/sidebar.php'; ?>
  <div id="AccountForm" class="page">
    <?php if(isset($is_success) && $is_success): ?>
      <div class="message">
        <h1>Account Deleted Successfully</h1>
        <a href=<?php echo $back_link ?>>Back</a>
      </div>
    <?php else: ?>
      <h1 class='title'>Delete <?php echo $type ?> Account</h1>
      <form class="form" method="POST" action="<?php echo $form_action ?>">
      <div class="input" id="ProfileImage">
        <img class="image" src="/public/images/profile-placeholder-image.png" />
      </div>
      <div class="input">
          <label class="label">Last name</label>
          <?php 
            echo "<p class='field'>$row[lastname]</p>";
          ?>
        </div>
        <div class="input">
          <label class="label">First name</label>
          <?php 
            echo "<p class='field'>$row[firstname]</p>";
          ?>
        </div>
        <div class="input">
          <label class="label">Email</label>
          <?php 
            echo "<p class='field'>$row[email]</p>";
          ?>
        </div>
        <input type="hidden" name="id" value=<?php echo $row['id'] ?> />
        <p>Are you sure you want to delete this account?</p>
        <button class='button confirm-delete' type="submit">Yes</button>
        <a class='button cancel-delete' href="<?php echo $back_link ?>">No</a>
      </form>
    <?php endif; ?>
  </div>
</div>
<?php
  include '../../includes/html/footer.php';
?>