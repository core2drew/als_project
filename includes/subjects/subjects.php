<?php
  $query = "SELECT id, title FROM subjects WHERE grade_level = $grade_level AND deleted_at IS NULL";
  $result = mysqli_query($conn, $query);
  $count = mysqli_num_rows($result);
?>

<div class="tabs">
  <?php 
    for($i = 1; $i <= 2; $i++) {
      $href = "$_SERVER[PHP_SELF]?page=subjects&grade_level=$i";
      $label = $i <= 1 ? 'Elementary' : 'High School';
      $active_class = $grade_level == $i ? " active'" : "'";
      $link = "<a class='tab". $active_class ." href='$href'>$label</a>";
      echo $link;
    }
  ?>
</div>

<div class="table-actions">
  <span id='CreateSubject' class='button'>Create Subject</span>
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
      <th class="options">Options</th>
    </thead>
    <tbody>
      <?php
        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
          $id = $row['id'];
          $title = $row['title'];
          $update_btn = "<span class='button update' data-subject-id=$id>Update</span>";
          $delete_btn = "<span class='button delete' data-subject-id=$id>Delete</span>";

          $table_row =
          "<tr>
            <td>$title</td>
            <td class='option'>$update_btn $delete_btn</td>
          </tr>";
          echo $table_row;
        }
      ?>
    </tbody>
  </table>
<?php endif; ?>