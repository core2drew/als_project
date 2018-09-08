<?php 
  require '../../config/db_connect.php';
  include '../../includes/html/head.php';
  include '../../check_session.php';
  include '../../includes/header.php';
  include '../../resources/subject/add.php';

  $grade_level = isset($_GET['grade_level']) ? $_GET['grade_level'] : null;
  $form_action = htmlspecialchars($_SERVER["PHP_SELF"])."?page=subjects&grade_level=$grade_level";
  $back_link = "/coordinator/subject/subjects.php?page=subject&grade_level=$grade_level";
?>

<div id="Coordinator" class="wrapper">
  <?php include '../../includes/sidebar.php'; ?>
  <div id="SubjectForm" class="page">
    <?php if(isset($is_success) && $is_success): ?>
      <div class="message">
        <h1>Subject Created Successfully</h1>
        <a href=<?php echo $back_link ?> >Back</a>
      </div>
    <?php else: ?>
      <h1 class='title'>Create Subject</h1>
      <form class="form" method="POST" action="<?php echo $form_action ?>">
        <div class="input">
          <label class="label">Title</label>
          <input type="text" name="title" value="<?php echo isset($_POST['title']) ? $_POST['title'] : '' ?>"/>
          <?php echo isset($error_fields['title']) ? "<label class='error'>$error_fields[title]</label>" : null ?>
        </div>
        <input type="hidden" name="grade_level" value=<?php echo $grade_level ?> />
        <button class='button' type="submit">Create</button>
      </form>
    <?php endif; ?>
  </div>
</div>

<?php
  include '../../includes/html/footer.php';
?>