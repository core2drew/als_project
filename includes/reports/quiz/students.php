<?php
  if(isset($teacher_id)) {
    $go_back_to_subjects = "$_SERVER[PHP_SELF]?subject_id=$subject_id";
  } else {
    $go_back_to_subjects = "$_SERVER[PHP_SELF]?page=reports&sub_page=quiz&grade_level=$grade_level";
  }


  if(isset($teacher_id)) {
    $query = "SELECT
    student.id,
    CONCAT(student.lastname, ', ' ,student.firstname) as name,
    (SELECT title FROM quizzes WHERE id = uq.quiz_id) as title,
    uq.created_at as date,
    (
      SELECT COUNT(*) FROM quiz_records as qr
      LEFT JOIN answers as ans
      ON qr.answer_id = ans.id
      WHERE qr.user_id = uq.user_id AND ans.is_answer = 1 AND qr.quiz_id = $quiz_id
    ) as score,
    uq.questions_id as items
    FROM users student RIGHT JOIN users_has_quiz as uq
    ON student.id = uq.user_id
    WHERE student.type='student' AND student.grade_level=$grade_level AND teacher_id = $teacher_id AND uq.quiz_id = $quiz_id AND student.deleted_at IS NULL AND uq.taken_at IS NOT NULL";
  } else {
    //Display all student account
    $query = "SELECT
    student.id,
    CONCAT(student.lastname, ', ' ,student.firstname) as name,
    (SELECT title FROM quizzes WHERE id = uq.quiz_id) as title,
    uq.created_at as date,
    (
      SELECT COUNT(*) FROM quiz_records as qr
      LEFT JOIN answers as ans
      ON qr.answer_id = ans.id
      WHERE qr.user_id = uq.user_id AND ans.is_answer = 1 AND qr.quiz_id = $quiz_id
    ) as score,
    uq.questions_id as items
    FROM users student RIGHT JOIN users_has_quiz as uq
    ON student.id = uq.user_id
    WHERE student.type='student' AND student.grade_level=$grade_level AND uq.quiz_id = $quiz_id AND student.deleted_at IS NULL AND uq.taken_at IS NOT NULL";
  }
  $result = mysqli_query($conn, $query);
  $count = mysqli_num_rows($result);
?>

<div class="title">
  <h2>Quiz Report</h2>
  <a class="button" href="<?php echo $go_back_to_subjects ?>">Back</a>
</div>

<?php
  if($count <= 0):
?>
  <div class="no-records">
    <p class="message">No Records</p>
  </div>
<?php
  else:
?>
  <table class="table accounts">
    <thead>
      <th>Name</th>
      <th>Quiz Title</th>
      <th>Date</th>
      <th>Score</th>
      <th>Percentage</th>
    </thead>
    <tbody>
      <?php
        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
          $id = $row['id'];
          $name = $row['name'];
          $title = $row['title'];
          $date = $row['date'];
          $items = count(explode(',', $row['items']));
          $score = $row['score'].'/'.$items;
          $percentage = ($row['score'] / $items) * 100;
          $percentage = number_format($percentage, 2);
          $table_row =
          "<tr>
            <td>$name</td>
            <td>$title</td>
            <td>$date</td>
            <td>$score</td>
            <td>$percentage %</td>
          </tr>";
          echo $table_row;
        }
      ?>
    </tbody>
  </table>
<?php
  endif;
?>