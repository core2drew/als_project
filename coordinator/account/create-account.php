<?php 
  require '../../config/db_connect.php';
  include '../../includes/html/head.php';
  include '../../check_session.php';
  include '../../includes/header.php';
  include '../../resources/account/add.php';

  $type = isset($_GET['type']) ? $_GET['type'] : null;
  $grade_level = isset($_GET['grade_level']) ? $_GET['grade_level'] : null;

  $form_action = htmlspecialchars($_SERVER["PHP_SELF"])."?page=$type&type=$type&grade_level=$grade_level";

  //Query all Teachers
  $teachers_query = "SELECT users.id,
  CONCAT(users.lastname,', ',users.firstname) as name
  FROM users WHERE users.type = 'teacher' AND users.grade_level=$grade_level AND deleted_at IS NULL";

  $back_link = "/coordinator/account/account.php?page=$type&type=$type&grade_level=$grade_level";
?> 
<div id="Coordinator" class="wrapper">
  <?php include '../../includes/sidebar.php'; ?>
  <div id="AccountForm" class="page">
    <?php if(isset($is_success) && $is_success): ?>
      <div class="message">
        <h1>Account Created Successfully</h1>
        <a href=<?php echo $back_link ?>>Back</a>
      </div>
    <?php else: ?>
      <h1 class='title'>Create <?php echo $type ?> Account</h1>
      <form class="form" method="POST" action="<?php echo $form_action ?>">
        <div class="input">
          <label class="label">Last name</label>
          <input type="text" name="lastname" value="<?php echo isset($_POST['lastname']) ? $_POST['lastname'] : '' ?>"/>
          <?php echo isset($error_fields['lastname']) ? "<label class='error'>$error_fields[lastname]</label>" : null ?>
        </div>
        <div class="input">
          <label class="label">First name</label>
          <input type="text" name="firstname" value="<?php echo isset($_POST['firstname']) ? $_POST['firstname'] : '' ?>"/>
          <?php echo isset($error_fields['firstname']) ? "<label class='error'>$error_fields[firstname]</label>" : null ?>
        </div>
        <div class="input">
          <label class="label">Address</label>
          <input type="text" name="address" value="<?php echo isset($_POST['address']) ? $_POST['address'] : '' ?>"/>
          <?php echo isset($error_fields['address']) ? "<label class='error'>$error_fields[address]</label>" : null ?>
        </div>
        <div class="input">
          <label class="label">Contact No.</label>
          <input type="text" name="contactno" value="<?php echo isset($_POST['contactno']) ? $_POST['contactno'] : '' ?>"/>
          <?php echo isset($error_fields['contactno']) ? "<label class='error'>$error_fields[contactno]</label>" : null ?>
        </div>
        <?php if($type == 'student'): ?>
          <div class="input">
            <label class="label">Teacher</label>
            <select name="teacher_id">
              <?php 
                $teachers_result = mysqli_query($conn, $teachers_query);
                $teachers_count = mysqli_num_rows($teachers_result);

                while($teacher_row = mysqli_fetch_array($teachers_result, MYSQLI_ASSOC)) {
                  if($row['teacher_id'] == $teacher_row['id'] ) {
                    echo "<option value='$teacher_row[id]' selected>$teacher_row[name]</option>";
                  }else {
                    echo "<option value='$teacher_row[id]'>$teacher_row[name]</option>";
                  }
                }
              ?>
            </select>
            <?php echo isset($error_fields['teacher_id']) ? "<label class='error'>$error_fields[teacher_id]</label>" : null ?>
          </div>
        <?php endif; ?>
        <div class="input">
          <label class="label">Email</label>
          <input type="text" name="email" value="<?php echo isset($_POST['email']) ? $_POST['email'] : '' ?>"/>
          <?php echo isset($error_fields['email']) ? "<label class='error'>$error_fields[email]</label>" : null ?>
        </div>
        <div class="input">
          <label class="label">Password</label>
          <input type="password" name="password"/>
          <span class="button show-password">Show Password</span>
          <?php echo isset($error_fields['password']) ? "<label class='error'>$error_fields[password]</label>" : null ?>
        </div>
        <input type="hidden" name="grade_level" value=<?php echo $grade_level ?> />
        <input type="hidden" name="type" value=<?php echo $type ?> />
        <button class='button' type="submit">Create</button>
      </form>
    <?php endif; ?>
  </div>
</div>
<?php
  include '../../includes/html/footer.php';
?>