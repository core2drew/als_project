<?php 
  $go_back_to_subjects = "$_SERVER[PHP_SELF]?page=reports&sub_page=exam&grade_level=$grade_level";

  //Display all student account
  $query = "SELECT DISTINCT(exams.id), title FROM exams JOIN exam_records ON exams.id = exam_records.exam_id WHERE exams.subject_id = $subject_id AND exams.deleted_at IS NULL";
  $result = mysqli_query($conn, $query);
  $count = mysqli_num_rows($result);
?>
<div class="title">
  <h2>Exam Report</h2>
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
      <th>Title</th>
      <th>Report</th>
    </thead>
    <tbody>
      <?php
        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
          $id = $row['id'];
          $title = $row['title'];
          $students = "<a class='button' href=$_SERVER[PHP_SELF]?page=reports&sub_page=exam&grade_level=$grade_level&subject_id=$subject_id&exam_id=$id>View Report</a>";
          $table_row =
          "<tr>
            <td>$title</td>
            <td>$students</td>
          </tr>";
          echo $table_row;
        }
      ?>
    </tbody>
  </table>
<?php
  endif;
?>