<?php
  $query = "SELECT id, title FROM exams WHERE subject_id = $subject_id AND deleted_at IS NULL";
  $result = mysqli_query($conn, $query);
  $count = mysqli_num_rows($result);
?>
<div class="table-actions">
  <?php
    $link = "/coordinator/exam/exams.php?page=examandquestions&sub_page=exams&subject_id=$subject_id&action=create";
    echo "<a class='button' href=$link>Create Exam</a>";
  ?>
</div>
<?php
  if($count <= 0):
?>
  <table class="table">
    <thead>
      <th>Title</th>
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
      <th class="options">Options</th>
    </thead>
    <tbody>
      <?php
        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
          $id = $row['id'];
          $title = $row['title'];
          $questions = "<a href=/coordinator/exam/exams.php?page=examandquestions&sub_page=exams&subject_id=$subject_id&id=$id>Questions</a>";
          $remove_exam = "<a href=/coordinator/exam/delete.php?page=examandquestions&sub_page=exams&subject_id=$subject_id&id=$id>Remove</a>";
          $table_row =
          "<tr>
            <td>$title</td>
            <td class='option'>$questions $remove_exam</td>
          </tr>";
          echo $table_row;
        }
      ?>
    </tbody>
  </table>
<?php endif; ?>