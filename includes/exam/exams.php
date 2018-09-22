<?php
  $query = "SELECT id, title, minutes FROM exams WHERE subject_id = $subject_id AND deleted_at IS NULL";
  $result = mysqli_query($conn, $query);
  $count = mysqli_num_rows($result);
?>

<div class="title">
  <h2>Exams</h2>
  <a class="button" href="/coordinator/exam/exams.php?page=examandquestions&sub_page=exams&grade_level=1">Go Back</a>
</div>

<div class="table-actions">
  <span id='CreateExam' class='button'>Create Exam</span>
</div>
<?php
  if($count <= 0):
?>
  <table class="table">
    <thead>
      <th>Title</th>
      <th>Minutes</th>
      <th class="options">Options</th>
    </thead>
  </table>
  <div class="no-records">
    <h3>No Records</h3>
  </div>
<?php else: ?>
  <table class="table">
    <thead>
      <th>Title</th>
      <th>Minutes</th>
      <th class="options">Options</th>
    </thead>
    <tbody>
      <?php
        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
          $id = $row['id'];
          $title = $row['title'];
          $minutes = $row['minutes'];
          $questions = "<a class='button' href=/coordinator/exam/exams.php?page=examandquestions&sub_page=exams&subject_id=$subject_id&id=$id>Questions</a>";
          $update = "<span class='button update' data-exam-id=$id>Update</span>";
          $remove = "<span class='button delete' data-exam-id=$id>Remove</span>";
          $table_row =
          "<tr>
            <td>$title</td>
            <td>$minutes</td>
            <td class='option'>$questions $update $remove</td>
          </tr>";
          echo $table_row;
        }
      ?>
    </tbody>
  </table>
<?php endif; ?>