<?php
  require '../../config/db_connect.php';
  include '../../includes/html/head.php';
  include '../../check_session.php';
  include '../../includes/header.php';
  include '../../resources/exam/add.php';

  $grade_level = isset($_GET['grade_level']) ? $_GET['grade_level'] : null;

  //Query all subjects
  $subjects_query = "SELECT subjects.id, subjects.title
  FROM subjects WHERE subjects.grade_level=$grade_level AND deleted_at IS NULL";
  $subjects_result = mysqli_query($conn, $subjects_query);

  $form_action = htmlspecialchars($_SERVER["PHP_SELF"])."?page=examandquestions&sub_page=exams&grade_level=$grade_level";
  $back_link = "/coordinator/exam/exams.php?page=examandquestions&sub_page=exams&grade_level=$grade_level";

  function handleErrorMessage($field, $error_fields = null){
    if(isset($error_fields)) {
      echo isset($error_fields[$field]) ? "<label class='error'>$error_fields[$field]</label>" : null;
    }
  }
?>

<div id="Coordinator" class="wrapper">
  <?php include '../../includes/sidebar.php'; ?>
  <div id="ManageQuestions" class="page">
    <?php if(isset($is_success) && $is_success): ?>
      <div class="message">
        <h1>Exam Created Successfully</h1>
        <a href=<?php echo $back_link ?> >Back</a>
      </div>
    <?php else: ?>
      <h1 class='title'>Create Exam Question</h1>
      
      <form class="form" method="POST" action="<?php echo $form_action ?>">
        <div class="input">
          <label class="label">Subject</label>
          <select name="subject_id">
            <?php 
              while($subject_row = mysqli_fetch_array($subjects_result, MYSQLI_ASSOC)) {
                if($row['subject_id'] == $subject_row['id'] ) {
                  echo "<option value='$subject_row[id]' selected>$subject_row[title]</option>";
                }else {
                  echo "<option value='$subject_row[id]'>$subject_row[title]</option>";
                }
              }
            ?>
          </select>
          <?php handleErrorMessage('subject_id', $error_fields) ?>
        </div>
        <div class="input">
          <label class="label">Title</label>
          <input type="text" name="title" value="<?php echo isset($_POST['title']) ? $_POST['title'] : '' ?>"/>
          <?php handleErrorMessage('title', $error_fields) ?>
        </div>
        <button class='button' type="submit">Create</button>
      </form>
    <?php endif; ?>
  </div>
</div>
<?php
  include '../../includes/html/footer.php';
?>