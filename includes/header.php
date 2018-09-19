<?php 
  $profile_image_url = !empty($_SESSION['profile_image_url']) ? $_SESSION['profile_image_url'] : '/public/images/profile-placeholder-image.png';
  $id = $_SESSION['user_id'];

?>

<div id="Header">
  <div class="als-logo">
    <img class="img" src="/public/images/als-logo.png"/>
  </div>
  <div class="menu">
    <a class="item" href="/coordinator/account/account.php?page=accounts&sub_page=student&type=student&grade_level=1">Accounts</a>
    <a class="item" href="/coordinator/subject/subjects.php?page=subjects&grade_level=1">Subjects</a>
    <a class="item" href="/coordinator/lesson/lessons.php?page=lessonandvideos&sub_page=lessons&grade_level=1">Lessons & Videos</a>
    <a class="item" href="/coordinator/question/questions.php?page=examandquestions&sub_page=questions&grade_level=1">Exam & Questions</a>
    <a class="item" href="/coordinator/reports.php?page=reports&grade_level=1">Reports</a>
  </div>
  <div class="profile">
    <img class="img" src="<?php echo $profile_image_url ?>"/>
    <div class="button dropdown">
      <p class="name"><?php echo $_SESSION['fullname']; ?></p>
        <div class="menu">
          <a class="item" href="/profile.php?id=<?php echo $id ?>">Profile</a>
          <a class="item" href="#">About</a>
          <a class="item" href="/logout.php">Logout</a>
        </div>
      </div>
  </div>
</div>