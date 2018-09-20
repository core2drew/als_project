<?php
  require '../../config/db_connect.php';
  include '../../includes/html/head.php';
  include '../../check_session.php';
  include '../../includes/header.php';
  include '../../resources/question/add.php';

  $grade_level = isset($_GET['grade_level']) ? $_GET['grade_level'] : null;

  //Query all subjects
  $subjects_query = "SELECT subjects.id, subjects.title
  FROM subjects WHERE subjects.grade_level=$grade_level AND deleted_at IS NULL";

  $form_action = htmlspecialchars($_SERVER["PHP_SELF"])."?page=examandquestions&sub_page=questions&grade_level=$grade_level";
  $back_link = "/coordinator/question/questions.php?page=examandquestions&sub_page=questions&grade_level=$grade_level";

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
        <h1>Question Created Successfully</h1>
        <a href=<?php echo $back_link ?> >Back</a>
      </div>
    <?php else: ?>
      <h1 class='title'>Create Exam Question</h1>
      <form class="form" method="POST" action="<?php echo $form_action ?>">
        <div class="input">
          <label class="label">Subject</label>
          <select name="subject_id">
            <?php 
              $subjects_result = mysqli_query($conn, $subjects_query);

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
          <label class="label">Question</label>
          <textarea name="question"><?php echo isset($_POST['question']) ? $_POST['question'] : '' ?></textarea>
          <?php handleErrorMessage('question', $error_fields) ?>
        </div>
        <div class="input">
          <label class="label">Choice 1</label>
          <input type="text" name="choice_1" value="<?php echo isset($_POST['choice_1']) ? $_POST['choice_1'] : '' ?>"/>
          <?php handleErrorMessage('choice_1', $error_fields) ?>
        </div>
        <div class="input">
          <label class="label">Choice 2</label>
          <input type="text" name="choice_2" value="<?php echo isset($_POST['choice_2']) ? $_POST['choice_2'] : '' ?>"/>
          <?php handleErrorMessage('choice_2', $error_fields) ?>
        </div>
        <div class="input">
          <label class="label">Choice 3</label>
          <input type="text" name="choice_3" value="<?php echo isset($_POST['choice_3']) ? $_POST['choice_3'] : '' ?>"/>
          <?php handleErrorMessage('choice_3', $error_fields) ?>
        </div>
        <div class="input">
          <label class="label">Choice 4</label>
          <input type="text" name="choice_4" value="<?php echo isset($_POST['choice_4']) ? $_POST['choice_4'] : '' ?>"/>
          <?php handleErrorMessage('choice_4', $error_fields) ?>
        </div>
        <div class="input">
          <label class="label">Answer</label>
          <select name="is_answer">
            <option value="choice_1">Choice 1</option>
            <option value="choice_2">Choice 2</option>
            <option value="choice_3">Choice 3</option>
            <option value="choice_4">Choice 4</option>
          </select>
        </div>
        <div class="input">
          <label class="label">Explanation</label>
          <textarea name="explanation"><?php echo isset($_POST['explanation']) ? $_POST['explanation'] : '' ?></textarea>
        </div>
        <button class='button' type="submit">Create</button>
      </form>
    <?php endif; ?>
  </div>
</div>
<?php include '../../includes/html/footer.php'; ?>