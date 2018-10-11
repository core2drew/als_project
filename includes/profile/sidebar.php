<?php if(isset($_GET['page']) && $_GET['page'] === 'profile'): ?>
  <a class="button <?php echo $_GET['page'] == 'profile' ? 'active' : null ?>" href="/profile.php?page=profile">Profile</a>
<?php endif ?>