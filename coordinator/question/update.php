<?php
  require '../../config/db_connect.php';
  include '../../includes/html/head.php';
  include '../../check_session.php';
  include '../../includes/header.php';
  include '../../resources/question/add.php';

  $grade_level = isset($_GET['grade_level']) ? $_GET['grade_level'] : null;
  $question_id = isset($_GET['id']) ? $_GET['id'] : null;

  //Query all subjects
  $subjects_query = "SELECT subjects.id, subjects.title
  FROM subjects WHERE subjects.grade_level=$grade_level AND deleted_at IS NULL";
  $subjects_result = mysqli_query($conn, $subjects_query);

  //Get selected question data
  $question_query = "SELECT id, question FROM questions WHERE id=$question_id AND deleted_at IS NULL";
  $question_result = mysqli_query($conn, $question_query);
  $question_row = mysqli_fetch_array($question_result, MYSQLI_ASSOC);

  //Get answers data
  $answer_query = "SELECT id, answer, is_answer FROM answers WHERE question_id=$question_id ORDER BY id";
  $answer_result = mysqli_query($conn, $answer_query);
  

  $form_action = htmlspecialchars($_SERVER["PHP_SELF"])."?page=questions&grade_level=$grade_level&id=$question_id";
  $back_link = "/coordinator/question/questions.php?page=questions&grade_level=$grade_level";

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
          <textarea name="question"><?php echo isset($_POST['question']) ? $_POST['question'] : $question_row['question'] ?></textarea>
          <?php handleErrorMessage('question', $error_fields) ?>
        </div>
        <?php
          $choice_count = 1;
          while($answer_row = mysqli_fetch_array($answer_result, MYSQLI_ASSOC)) {
            $choice = "choice_". $choice_count;
            echo "<div class='input'>";
              echo "<label class='label'>Choice $choice_count</label>";
              echo "<input type='text' name='$choice' value='". $answer_row['answer'] ."' />";
              echo handleErrorMessage('choice_1', $error_fields);
            echo "</div>";
            $choice_count++;
          }
        ?>
        <div class="input">
          <label class="label">Answer</label>
          <select name="is_answer">
            <?php 
              $choice_count = 1;
              mysqli_data_seek($answer_result, 0); //reset answer result
              while($answer_row = mysqli_fetch_array($answer_result, MYSQLI_ASSOC)) {
                $choice = "choice_". $choice_count;
                if($answer_row['is_answer']) {
                  echo "<option value='$choice' selected>Choice $choice_count</option>";
                } else {
                  echo "<option value='$choice'>Choice $choice_count</option>";
                }
                $choice_count++;
              }
            ?>
          </select>
        </div>
        <div class="input">
          <label class="label">Explanation</label>
          <textarea name="explanation"><?php echo isset($_POST['explanation']) ? $_POST['explanation'] : '' ?></textarea>
        </div>
        <button class='button' type="submit">Update</button>
      </form>
    <?php endif; ?>
  </div>
</div>
<?php include '../../includes/html/footer.php'; ?>