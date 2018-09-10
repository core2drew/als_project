<?php 
  $profile_image_url = !empty($_SESSION['profile_image_url']) ? $_SESSION['profile_image_url'] : '/public/images/profile-placeholder-image.png';
?>

<div id="Header">
  <div class="als-logo">
    <img class="img" src="/public/images/als-logo.png"/>
  </div>
  <div class="profile">
    <img class="img" src="<?php echo $profile_image_url ?>"/>
    <div class="button dropdown">
      <p class="name"><?php echo $_SESSION['fullname']; ?></p>
        <div class="menu">
          <a class="item" href="#">About</a>
          <a class="item" href="/logout.php">Logout</a>
        </div>
      </div>
  </div>
</div>