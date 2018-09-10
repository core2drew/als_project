<?php
  include 'includes/html/head.php';
  include './login.php';
  
  if(isset($_SESSION['is_logged_in'])) {
    switch($_SESSION['type']) {
      case 'student':
        header("Location: dashboard.php");
        break;
      case 'teacher':
        header("Location: dashboard.php");
        break;
      case 'coordinator':
        header("Location: /coordinator/account/account.php?page=student&type=student&grade_level=1");
        break;
    }
  }
?>
  <div id="LoginWrapper" class="wrapper">
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