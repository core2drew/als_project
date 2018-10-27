<?php 
  if(isset($teacher_id)) {
    $go_back = "$_SERVER[PHP_SELF]?subject_id=$subject_id";
  } else {
    $go_back = "$_SERVER[PHP_SELF]?page=reports&sub_page=exam&grade_level=$grade_level&subject_id=$subject_id";
  }


  if(isset($teacher_id)) {
    $query = "SELECT
    student.id,
    CONCAT(student.lastname, ', ' ,student.firstname) as name,
    (SELECT title FROM exams WHERE id = ue.exam_id) as title,
    ue.created_at as date,
    (
      SELECT COUNT(*) FROM exam_records as er
      LEFT JOIN answers as ans
      ON er.answer_id = ans.id
      WHERE er.user_id = ue.user_id AND ans.is_answer = 1
    ) as score,
    ( SELECT questions_id FROM exams WHERE id = ue.exam_id) as items 
    FROM users student RIGHT JOIN users_has_exam as ue
    ON student.id = ue.user_id
    WHERE student.type='student' AND teacher_id = $teacher_id AND ue.exam_id = $exam_id AND student.grade_level=$grade_level AND student.deleted_at IS NULL AND ue.taken_at IS NOT NULL";
  
  } else {
    //Display all student account
    $query = "SELECT
      student.id,
      CONCAT(student.lastname, ', ' ,student.firstname) as name,
      (SELECT title FROM exams WHERE id = ue.exam_id) as title,
      ue.created_at as date,
      (
        SELECT COUNT(*) FROM exam_records as er
        LEFT JOIN answers as ans
        ON er.answer_id = ans.id
        WHERE er.user_id = ue.user_id AND ans.is_answer = 1
      ) as score,
      ( SELECT questions_id FROM exams WHERE id = ue.exam_id) as items 
      FROM users student RIGHT JOIN users_has_exam as ue
      ON student.id = ue.user_id
      WHERE student.type='student' AND ue.exam_id = $exam_id AND student.grade_level=$grade_level AND student.deleted_at IS NULL AND ue.taken_at IS NOT NULL";
  }
  $result = mysqli_query($conn, $query);
  $count = mysqli_num_rows($result);
?>
<div class="title">
  <h2>Exam Report</h2>
  <a class="button" href="<?php echo $go_back ?>">Back</a>
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
      <th>Exam Title</th>
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