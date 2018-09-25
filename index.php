<?php
  include 'includes/html/head.php';
  include './login.php';
  if(isset($_SESSION['is_logged_in'])) {
    switch($_SESSION['type']) {
      case 'student':
        header("Location: lessons.php");
        break;
      case 'teacher':
        header("Location: teacher/students.php");
        break;
      case 'coordinator':
        if($_SESSION['is_admin']) {
          header("Location: /coordinator/account.php?page=accounts&sub_page=coordinator&type=coordinator");
         
        } else {
          header("Location: /coordinator/account.php?page=accounts&sub_page=teacher&type=teacher&grade_level=1");
        }
        
        break;
    }
  }
?>
  <div id="LoginWrapper">
    <div id="LoginFormContainer">
      <h2 class="title">Login</h2>
      <form id="LoginForm" method="POST" action="">
        <div class="field">
          <label class="label">Email</label>
          <input class="input" type="text" name="email"/>
        </div>
        <div class="field">
          <label class="label">Password</label>
          <input class="input" type="password" name="password" />
        </div>
        <?php echo isset($error_fields['login']) ? "<p class='error_message'>$error_fields[login]</p>" : null ?>
        <button class="button" type="submit">Login</button>
      </form>
    </div>
  </div>
<?php
  include 'includes/html/footer.php';
?>