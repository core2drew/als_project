<?php
  $query = "SELECT id, question FROM questions WHERE subject_id=$subject_id AND deleted_at IS NULL";
  $result = mysqli_query($conn, $query);
  $count = mysqli_num_rows($result);

  $go_back_to_subjects = "$_SERVER[PHP_SELF]?page=examandquestions&sub_page=questions&grade_level=$grade_level"
?>

<div class="title">
  <h2>Subject Questions</h2>
  <a class="button" href="<?php echo $go_back_to_subjects ?>">Back</a>
</div>

<div class="table-actions">
  <span id='CreateQuestion' class='button'>Create Question</span>
</div>

<?php
  if($count <= 0):
?>
  <div class="no-records">
    <p class="message">No Records</p>
  </div>
<?php else: ?>
  <table class="table questions">
    <thead>
      <th>Question</th>
      <th>Options</th>
    </thead>
    <tbody>
      <?php
        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
          $view = "<span class='button view' data-question-id=$row[id]>View</span>";
          $remove_exam = "<span class='button delete' data-question-id=$row[id]>Remove</span>";
          $table_row =
          "<tr>
            <td>$row[question]</td>
            <td class='option'>$view $remove_exam</td>
          </tr>";
          echo $table_row;
        }
      ?>
    </tbody>
  </table>
<?php endif; ?>