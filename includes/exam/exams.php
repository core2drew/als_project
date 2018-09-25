<?php
  $query = "SELECT id, title, questions_id, minutes FROM exams WHERE subject_id = $subject_id AND deleted_at IS NULL";
  $result = mysqli_query($conn, $query);
  $count = mysqli_num_rows($result);

  $go_back_to_subjects = "$_SERVER[PHP_SELF]?page=examandquestions&sub_page=questions&grade_level=$grade_level";

  if(!$is_coordinator) {
    $go_back_link = $_SERVER['PHP_SELF'];
  }
?>

<div class="title">
  <h2>Exams</h2>
  <a class="button" href="<?php echo $go_back_to_subjects ?>">Back</a>
</div>

<?php if($is_coordinator): ?>
  <div class="table-actions">
    <span id='CreateExam' class='button'>Create Exam</span>
  </div>
<?php endif ?>

<?php
  if($count <= 0):
?>
  <div class="no-records">
    <p class="message">No Records</p>
  </div>
<?php else: ?>
  <table class="table exam">
    <thead>
      <th>Title</th>
      <th>Question Count</th>
      <th>Minutes</th>
      <th class="options">Options</th>
    </thead>
    <tbody>
      <?php
        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
          $id = $row['id'];
          $title = $row['title'];
          $minutes = $row['minutes'];
          $questions_count = empty($row['questions_id']) ? 0 : count(explode(',', $row['questions_id']));
          
          if($is_coordinator) {
            $questions = "<a class='button' href=$_SERVER[PHP_SELF]?page=examandquestions&sub_page=exams&grade_level=$grade_level&subject_id=$subject_id&exam_id=$id>Questions</a>";
            $update = "<span class='button update' data-exam-id=$id>Update</span>";
            $remove = "<span class='button delete' data-exam-id=$id>Remove</span>";
            $table_row =
            "<tr>
              <td>$title</td>
              <td>$questions_count</td>
              <td>$minutes</td>
              <td class='option'>$questions $update $remove</td>
            </tr>";
          } else {
            $questions = "<a class='button' href=$_SERVER[PHP_SELF]?subject_id=$subject_id&exam_id=$id>View</a>";
            $assign_exam = "<span class='button assign-exam' data-exam-id=$id>Assign Exam</span>";
            $table_row =
            "<tr>
              <td>$title</td>
              <td>$questions_count</td>
              <td>$minutes</td>
              <td class='option'>$questions $assign_exam</td>
            </tr>";
          }
          echo $table_row;
        }
      ?>
    </tbody>
  </table>
<?php endif; ?>