<?php
  $query = "SELECT id, title, (SELECT COUNT(*) FROM questions WHERE subject_id = subjects.id AND type='$type' AND deleted_at IS NULL) as count
  FROM subjects 
  WHERE grade_level = $grade_level AND deleted_at IS NULL";
  $result = mysqli_query($conn, $query);
  $count = mysqli_num_rows($result);
?>

<div class="tabs">
  <?php
    for($i = 1; $i <= 2; $i++) {
      $href = "$_SERVER[PHP_SELF]?page=examandquestions&sub_page=questions&grade_level=$i";
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
  <div class="no-records">
    <p class="message">No Records</p>
  </div>
<?php else: ?>
  <table class="table subjects">
    <thead>
      <th>Subject</th>
      <th>Question Count</th>
      <th class="options">Options</th>
    </thead>
    <tbody>
      <?php
        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
          $id = $row['id'];
          $title = $row['title'];
          $count = $row['count'];
          $question = "<a class='button' href=$_SERVER[PHP_SELF]?page=examandquestions&sub_page=questions&grade_level=$grade_level&subject_id=$id>Questions</a>";
          //$remove_exam = "<a href=/coordinator/exam/delete.php?page=examandquestions&sub_page=exams&grade_level=$grade_level&subject_id=$id>Remove</a>";
          $table_row =
          "<tr>
            <td>$title</td>
            <td>$count</td>
            <td class='option'>$question</td>
          </tr>";
          echo $table_row;
        }
      ?>
    </tbody>
  </table>
<?php endif; ?>