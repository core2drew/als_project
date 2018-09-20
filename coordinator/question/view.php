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
  $question_query = "SELECT id, question, explanation FROM questions WHERE id=$question_id AND deleted_at IS NULL";
  $question_result = mysqli_query($conn, $question_query);
  $question_row = mysqli_fetch_array($question_result, MYSQLI_ASSOC);

  //Get answers data
  $answer_query = "SELECT id, answer, is_answer FROM answers WHERE question_id=$question_id ORDER BY id";
  $answer_result = mysqli_query($conn, $answer_query);
  

  $form_action = htmlspecialchars($_SERVER["PHP_SELF"])."?page=examandquestions&sub_page=questions&grade_level=$grade_level&id=$question_id";
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
    <h1 class='title'>View Exam Question</h1>
    <a href=<?php echo $back_link ?>>Back</a>

    <div id="ViewQuestion" class="segment">
      <label class="label">Question:</label>
      <p class="question"><?php echo $question_row['question'] ?></p>

      <label class="label">Choices:</label>
      <?php
        $choice_count = 1;
        while($answer_row = mysqli_fetch_array($answer_result, MYSQLI_ASSOC)) {
          $choice = "choice_". $choice_count;
            echo "<div class='choice-container'>";
              if($answer_row['is_answer']) {
                echo "<p class='answer'>$answer_row[answer]</p>";
                echo "<svg class='check icon' viewBox='0 0 352.62 352.62' xml:space='preserve'>
                        <g>
                          <path d='M337.222,22.952c-15.912-8.568-33.66,7.956-44.064,17.748c-23.867,23.256-44.063,50.184-66.708,74.664
                            c-25.092,26.928-48.348,53.856-74.052,80.173c-14.688,14.688-30.6,30.6-40.392,48.96c-22.032-21.421-41.004-44.677-65.484-63.648
                            c-17.748-13.464-47.124-23.256-46.512,9.18c1.224,42.229,38.556,87.517,66.096,116.28c11.628,12.24,26.928,25.092,44.676,25.704
                            c21.42,1.224,43.452-24.48,56.304-38.556c22.645-24.48,41.005-52.021,61.812-77.112c26.928-33.048,54.468-65.485,80.784-99.145
                            C326.206,96.392,378.226,44.983,337.222,22.952z M26.937,187.581c-0.612,0-1.224,0-2.448,0.611
                            c-2.448-0.611-4.284-1.224-6.732-2.448l0,0C19.593,184.52,22.653,185.132,26.937,187.581z'/>
                        </g>
                      </svg>";
              } else {
                echo "<p class='choice'>$answer_row[answer]</p>";
              }
            echo "</div>";
          $choice_count++;
        }
      ?>
      <?php 
        if(!empty($question_row['explanation'])):
      ?>
        <label class="label">Explanation:</label>
        <p class="explanation"><?php echo $question_row['explanation'] ?></p>
      <?php endif; ?>
    </div>
  </div>
</div>
<?php
  include '../../includes/html/footer.php';
?>