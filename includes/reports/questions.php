<?php
  $go_back_to_subjects = "$_SERVER[PHP_SELF]?page=reports&sub_page=reports&grade_level=$grade_level";

  $query = "SELECT question,
  (SELECT COUNT(*) FROM exam_records, answers 
  WHERE answers.id = exam_records.answer_id AND exam_records.question_id = questions.id) as answered,
  (SELECT COUNT(*) FROM exam_records, answers 
  WHERE answers.id = exam_records.answer_id AND answers.is_answer = 1 AND exam_records.question_id = questions.id) as answer_correctly_count
  FROM questions WHERE subject_id = $subject_id AND deleted_at IS NULL";
  $result = mysqli_query($conn, $query);
  $count = mysqli_num_rows($result);
?>

<div class="title">
  <h2>Subject Questions Report</h2>
  <a class="button" href="<?php echo $go_back_to_subjects ?>">Back</a>
</div>

<?php
  if($count <= 0):
?>
  <div class="no-records">
    <p class="message">No Records</p>
  </div>
<?php else: ?>
  <table class="table exam questions">
    <thead>
      <th>Question</th>
      <th>Answered Count</th>
      <th>Correct Answers</th>
      <th>Percentage</th>
    </thead>
    <tbody>
      <?php
        //Loop result
        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
          $question = $row['question'];
          $answered = $row['answered'];
          $answer_correctly_count = $row['answer_correctly_count'];
          $percentage = ($answer_correctly_count / $answered) * 100;
          $table_row =
          "<tr>
            <td>$question</td>
            <td>$answered</td>
            <td>$answer_correctly_count</td>
            <td>$percentage</td>
          </tr>";
          echo $table_row;
        }
      ?>
    </tbody>
  </table>
<?php endif; ?>

