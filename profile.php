<?php 
  require 'config/db_connect.php';
  include 'includes/html/head.php';
  include 'check_session.php';
  include 'includes/header.php';
  include 'resources/_global.php';
  include 'resources/profile/update.php';

  $id = isset($_GET['id']) ? $_GET['id'] : null;
  $type = isset($_SESSION['type']) ? $_SESSION['type'] : null;
  $grade_level = isset($_SESSION['grade_level']) ? $_SESSION['grade_level'] : null;

  $form_action = htmlspecialchars($_SERVER["PHP_SELF"])."?id=$id";

  //Diplay specific student or teacher
  $query = "SELECT
    users.id,
    users.lastname,
    users.firstname,
    users.address,
    users.contactno,
    users.email,
    users.password,
    users.profile_image_url
    FROM users WHERE users.id = $id";

    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

    $back_link = "/profile.php?id=$id";

    $profile_image_url = !empty($row['profile_image_url']) ? $row['profile_image_url'] : '/public/images/profile-placeholder-image.png';
?>

<div id="Coordinator" class="wrapper">
  <?php include './includes/sidebar.php'; ?>
  <div id="AccountForm" class="page">
    <?php if(isset($is_success) && $is_success): ?>
      <div class="message">
        <h1>Account Updated Successfully</h1>
        <a href=<?php echo $back_link ?>>Back</a>
      </div>
    <?php else: ?>
      <h1 class='title'>Update Account</h1>
      <form class="form" method="POST" action="<?php echo $form_action ?>" enctype="multipart/form-data">
        <div class="input" id="ProfileImage">
          <img class="image" src="<?php echo $profile_image_url ?>" />
          <input type="file" name="profile_image" accept="image/*" />
          <button class="btn upload-btn">Upload Image</button>
          <?php echo isset($error_fields['lastname']) ? "<label class='error'>$error_fields[lastname]</label>" : null ?>
        </div>
        <div class="input">
          <label class="label">Last name</label>
          <input type="text" name="lastname" value="<?php echo isset($_POST['lastname']) ? $_POST['lastname'] : $row['lastname'] ?>"/>
          <?php echo isset($error_fields['lastname']) ? "<label class='error'>$error_fields[lastname]</label>" : null ?>
        </div>
        <div class="input">
          <label class="label">First name</label>
          <input type="text" name="firstname" value="<?php echo isset($_POST['firstname']) ? $_POST['firstname'] : $row['firstname'] ?>"/>
          <?php echo isset($error_fields['firstname']) ? "<label class='error'>$error_fields[firstname]</label>" : null ?>
        </div>
        <div class="input">
          <label class="label">Address</label>
          <input type="text" name="address" value="<?php echo isset($_POST['address']) ? $_POST['address'] : $row['address'] ?>"/>
          <?php echo isset($error_fields['address']) ? "<label class='error'>$error_fields[address]</label>" : null ?>
        </div>
        <div class="input">
          <label class="label">Contact No.</label>
          <input type="text" name="contactno" value="<?php echo isset($_POST['contactno']) ? $_POST['contactno'] : $row['contactno'] ?>"/>
          <?php echo isset($error_fields['contactno']) ? "<label class='error'>$error_fields[contactno]</label>" : null ?>
        </div>
        <div class="input">
          <label class="label">Email</label>
          <input type="text" name="email" value="<?php echo isset($_POST['email']) ? $_POST['email'] : $row['email'] ?>"/>
          <input type="hidden" name="current_email" value="<?php echo $row['email'] ?>"/>
          <?php echo isset($error_fields['email']) ? "<label class='error'>$error_fields[email]</label>" : null ?>
        </div>
        <div class="input">
          <label class="label">Password</label>
          <input type="password" name="password" value="<?php echo $row['password'] ?>"/>
          <input type="hidden" name="current_password" value="<?php echo $row['password'] ?>"/>
          <span class="button show-password">Show Password</span>
          <?php echo isset($error_fields['password']) ? "<label class='error'>$error_fields[password]</label>" : null ?>
        </div>
        <input type="hidden" name="id" value=<?php echo $id ?> />
        <input type="hidden" name="type" value=<?php echo $type ?> />
        <input type="hidden" name="grade_level" value=<?php echo $grade_level ?> />
        <button class='button' type="submit">Update</button>
        <a class="button" href="/dashboard.php">Cancel</a>
      </form>
    <?php endif; ?>
  </div>
</div>
<?php include 'includes/html/scripts.php';?>
<script src="/public/js/modules/account.js"></script>
<?php include 'includes/html/footer.php'; ?>