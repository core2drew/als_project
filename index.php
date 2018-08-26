<?php
  include 'includes/html/head.php';
  if(isset($_SESSION['login_user'])) {
    header("Location: dashboard.php");
  }
?>
  <div id="LoginWrapper" class="wrapper">
    <div id="LoginFormContainer">
      <h2 class="title">Login</h2>
      <form id="LoginForm" method="POST">
        <div class="field">
          <label class="label">Username</label>
          <input class="input" type="text" name="username"/>
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