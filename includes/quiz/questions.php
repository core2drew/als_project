<?php
  //Get Id of quiz
  $quiz_id = isset($_GET['quiz_id']) ? $_GET['quiz_id'] : null; 

  //Get question ids of quiz
  $query = "SELECT questions_id FROM quizzes WHERE id=$quiz_id";
  $result = mysqli_query($conn, $query);
  $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

  // convert string to array example "1,2,3" to [1,2,3]
  $questions_id = explode(',', $row['questions_id']);
  
  // format array to string 1','2','3','4
  $questions_id = implode("','", $questions_id);

  //Get current questions of quiz
  $query = "SELECT DISTINCT quest.id, quest.question,
  (SELECT answer FROM answers WHERE question_id = quest.id AND is_answer = 1 LIMIT 0,1) as answer
  FROM quizzes quiz LEFT JOIN questions quest ON quiz.subject_id = quest.subject_id 
  WHERE quest.id IN ('". $questions_id ."') AND quest.deleted_at IS NULL";
  
  //Results of query
  $result = mysqli_query($conn, $query);
  //Record count of query
  $count = mysqli_num_rows($result);

  $go_back_to_subjects = "/teacher/quiz.php?subject_id=$subject_id";
?>

<div class="title">
  <h2>Quiz Questions</h2>
  <a class="button" href="<?php echo $go_back_to_subjects ?>">Back</a>
</div>

<div class="table-actions">
  <span id="CreateQuestion" class='button'>Add Question</span>
</div>
<?php
  if($count <= 0):
?>
  <div class="no-records">
    <p class="message">No Records</p>
  </div>
<?php else: ?>
  <table class="table quiz questions">
    <thead>
      <th>Question</th>
      <th>Answer</th>
      <th>Option</th>
    </thead>
    <tbody>
      <?php
        //Loop question result
        while($qr = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
          $id = $qr['id'];
          $question = $qr['question'];
          $answer = $qr['answer'];
          $view = "<span class='button view' data-question-id=$id>View</span>";
          $remove = "<span class='button delete' data-question-id=$id data-quiz-id=$quiz_id>Remove</span>";
          $table_row =
          "<tr>
            <td>$question</td>
            <td>$answer</td>
            <td>$view $remove</td>
          </tr>";
          echo $table_row;
        }
      ?>
    </tbody>
  </table>
<?php endif; ?>

