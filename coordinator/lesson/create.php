<?php 
  require '../../config/db_connect.php';
  include '../../includes/html/head.php';
  include '../../check_session.php';
  include '../../includes/header.php';
  include '../../resources/lesson/add.php';

  $grade_level = isset($_GET['grade_level']) ? $_GET['grade_level'] : null;

   //Query all Subjects
   $subjects_query = "SELECT subjects.id, subjects.title
   FROM subjects WHERE subjects.grade_level=$grade_level AND deleted_at IS NULL";

  $form_action = htmlspecialchars($_SERVER["PHP_SELF"])."?page=lessons&grade_level=$grade_level";
  $back_link = "/coordinator/lesson/lessons.php?page=lessons&grade_level=$grade_level";
?>

<div id="Coordinator" class="wrapper">
  <?php include '../../includes/sidebar.php'; ?>
  <div id="LessonForm" class="page">
    <?php if(isset($is_success) && $is_success): ?>
      <div class="message">
        <h1>Lesson Created Successfully</h1>
        <a href=<?php echo $back_link ?> >Back</a>
      </div>
    <?php else: ?>
      <h1 class='title'>Create Lesson</h1>
      <form class="form" method="POST" action="<?php echo $form_action ?>">
        <div class="input">
          <label class="label">Subjects</label>
          <select name="subject_id">
            <?php 
              $subjects_result = mysqli_query($conn, $subjects_query);
              $subjects_count = mysqli_num_rows($subjects_result);

              while($subject_row = mysqli_fetch_array($subjects_result, MYSQLI_ASSOC)) {
                if($row['id'] == $subject_row['id'] ) {
                  echo "<option value='$subject_row[id]' selected>$subject_row[title]</option>";
                }else {
                  echo "<option value='$subject_row[id]'>$subject_row[title]</option>";
                }
              }
            ?>
          </select>
        </div>
        <div class="input">
          <label class="label">Title</label>
          <input type="text" name="title" value="<?php echo isset($_POST['title']) ? $_POST['title'] : '' ?>"/>
          <?php echo isset($error_fields['title']) ? "<label class='error'>$error_fields[title]</label>" : null ?>
        </div>
        <button class='button' type="submit">Create</button>
      </form>
    <?php endif; ?>
  </div>
</div>

<?php
  include '../../includes/html/footer.php';
?>