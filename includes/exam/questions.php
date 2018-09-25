<?php
  //Get Id of exam
  $exam_id = isset($_GET['exam_id']) ? $_GET['exam_id'] : null; 

  //Get question ids of exam
  $exam_query = "SELECT questions_id FROM exams WHERE id=$exam_id";
  $exam_result = mysqli_query($conn, $exam_query);
  $exam_row = mysqli_fetch_array($exam_result, MYSQLI_ASSOC);

  // convert string to array example "1,2,3" to [1,2,3]
  $questions_id = explode(',', $exam_row['questions_id']);
  
  // format array to string 1','2','3','4
  $questions_id = implode("','", $questions_id);

  //Get current questions of exam
  $question_query = "SELECT DISTINCT quest.id, quest.question,
  (SELECT answer FROM answers WHERE question_id = quest.id AND is_answer = 1 LIMIT 0,1) as answer
  FROM exams ex LEFT JOIN questions quest ON ex.subject_id = quest.subject_id 
  WHERE quest.id IN ('". $questions_id ."') AND quest.deleted_at IS NULL";
  
  //Results of query
  $question_result = mysqli_query($conn, $question_query);
  //Record count of query
  $question_count = mysqli_num_rows($question_result);

  $go_back_to_subjects = "$_SERVER[PHP_SELF]?page=examandquestions&sub_page=exams&grade_level=$grade_level&subject_id=$subject_id";
?>

<div class="title">
  <h2>Exam Questions</h2>
  <a class="button" href="<?php echo $go_back_to_subjects ?>">Back</a>
</div>

<div class="table-actions">
  <span id="AddExamQuestion" class='button'>Add Question</span>
</div>
<?php
  if($question_count <= 0):
?>
  <div class="no-records">
    <p class="message">No Records</p>
  </div>
<?php else: ?>
  <table class="table question">
    <thead>
      <th>Question</th>
      <th>Answer</th>
      <th>Option</th>
    </thead>
    <tbody>
      <?php
        //Loop question result
        while($qr = mysqli_fetch_array($question_result, MYSQLI_ASSOC)) {
          $id = $qr['id'];
          $question = $qr['question'];
          $answer = $qr['answer'];
          $view = "<button class='button view' data-question-id=$id>View</button>";
          $remove = "<button class='button remove' data-question-id=$id>Remove</button>";
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

