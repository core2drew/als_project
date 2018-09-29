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
    <div class="header">
      <img src="/public/images/als_header.png" />
    </div>
    <div id="LoginFormContainer">
      <img class="logo" src="/public/images/school-logo.png" />
      <form id="LoginForm" method="POST" autocomplete="off">
        <div class="field">
          <input class="input" type="text" name="email" placeholder="Email"/>
        </div>
        <div class="field">
          <input class="input" type="password" name="password" placeholder="Password"/>
        </div>
        <?php echo isset($error_fields['login']) ? "<p class='error_message'>$error_fields[login]</p>" : null ?>
        <button class="button" type="submit">Login</button>
      </form>
    </div>
  </div>
<?php
  include 'includes/html/footer.php';
?>