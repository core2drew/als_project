<?php 
  $profile_image_url = !empty($_SESSION['profile_image_url']) ? $_SESSION['profile_image_url'] : '/public/images/profile-placeholder-image.png';
  $id = $_SESSION['user_id'];
?>

<div id="Header">
  <div class="als-logo">
    <img class="img" src="/public/images/als-logo.png"/>
  </div>
  <?php if($_SESSION['type'] === 'coordinator'): ?>
    <div class="menu">
      <a class="item <?php echo $_GET['page'] == 'home' ? 'active' : null ?>" href="/home.php?page=home&sub_page=home">Home</a>
      <?php if($_SESSION['is_admin']): ?>
        <a class="item <?php echo $_GET['page'] == 'accounts' ? 'active' : null ?>" href="/coordinator/account.php?page=accounts&sub_page=coordinator&type=coordinator">Accounts</a>
      <?php else: ?>
        <a class="item <?php echo $_GET['page'] == 'accounts' ? 'active' : null ?>" href="/coordinator/account.php?page=accounts&sub_page=teacher&type=teacher&grade_level=1">Accounts</a>
      <?php endif ?>
      <a class="item <?php echo $_GET['page'] == 'subjects' ? 'active' : null ?>" href="/coordinator/subjects.php?page=subjects&grade_level=1">Subjects</a>
      <a class="item <?php echo $_GET['page'] == 'lessonandvideos' ? 'active' : null ?>" href="/coordinator/lessons.php?page=lessonandvideos&sub_page=lessons&grade_level=1">Lessons & Videos</a>
      <a class="item <?php echo $_GET['page'] == 'examandquestions' ? 'active' : null ?>" href="/coordinator/questions.php?page=examandquestions&sub_page=questions&grade_level=1">Exam & Questions</a>
      <a class="item <?php echo $_GET['page'] == 'reports' ? 'active' : null ?>" href="/coordinator/reports.php?page=reports&grade_level=1">Reports</a>
    </div>
  <?php endif; ?>
  <div class="profile">
    <img class="img" src="<?php echo $profile_image_url ?>"/>
    <div class="button dropdown">
      <p class="name">
        <?php echo $_SESSION['fullname']; ?>
        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" class="icon dropdown-arrow" x="0px" y="0px" viewBox="0 0 292.362 292.362" style="enable-background:new 0 0 292.362 292.362;" xml:space="preserve">
          <g>
            <path d="M286.935,69.377c-3.614-3.617-7.898-5.424-12.848-5.424H18.274c-4.952,0-9.233,1.807-12.85,5.424   C1.807,72.998,0,77.279,0,82.228c0,4.948,1.807,9.229,5.424,12.847l127.907,127.907c3.621,3.617,7.902,5.428,12.85,5.428   s9.233-1.811,12.847-5.428L286.935,95.074c3.613-3.617,5.427-7.898,5.427-12.847C292.362,77.279,290.548,72.998,286.935,69.377z" fill="#FFFFFF"/>
          </g>
        </svg>
      </p>
      <div class="menu">
        <a class="item" href="/profile.php?page=profile&id=<?php echo $id ?>">Profile</a>
        <a class="item" href="#">About</a>
        <a class="item" href="/logout.php">Logout</a>
      </div>
    </div>
  </div>
</div>