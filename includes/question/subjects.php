<?php
  $query = "SELECT id, title FROM subjects WHERE grade_level = $grade_level AND deleted_at IS NULL";
  $result = mysqli_query($conn, $query);
  $count = mysqli_num_rows($result);
?>

<div class="title">
  <h2>Subjects</h2>
</div>

<div class="tabs">
  <?php
    for($i = 1; $i <= 2; $i++) {
      $href = "/coordinator/question/questions.php?page=examandquestions&sub_page=questions&grade_level=$i";
      $label = $i <= 1 ? 'Elementary' : 'High School';
      $active_class = $grade_level == $i ? " active'" : "'";
      $link = "<a class='tab". $active_class ." href='$href'>$label</a>";
      echo $link;
    }
  ?>
</div>
<?php
  if($count <= 0):
?>
  <table class="table subjects">
    <thead>
      <th>Subject</th>
      <th class="options">Options</th>
    </thead>
  </table>
  <div class="no-records">
    <h3>No Records</h3>
  </div>
<?php else: ?>
  <table class="table subjects">
    <thead>
      <th>Subject</th>
      <th class="options">Options</th>
    </thead>
    <tbody>
      <?php
        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
          $id = $row['id'];
          $title = $row['title'];
          $question = "<a href=/coordinator/question/questions.php?page=examandquestions&sub_page=questions&grade_level=$grade_level&subject_id=$id>Questions</a>";
          //$remove_exam = "<a href=/coordinator/exam/delete.php?page=examandquestions&sub_page=exams&grade_level=$grade_level&subject_id=$id>Remove</a>";
          $table_row =
          "<tr>
            <td>$title</td>
            <td class='option'>$question</td>
          </tr>";
          echo $table_row;
        }
      ?>
    </tbody>
  </table>
<?php endif; ?>