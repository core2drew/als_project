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
        header("Location: /coordinator/account.php?type=student");
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
        <button class="button" type="submit">Login</button>
      </form>
    </div>
  </div>
<?php
  include 'includes/html/footer.php';
?>