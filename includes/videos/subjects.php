<?php
  $is_coordinator = $_SESSION['type'] === 'coordinator' ? true : false;
  $query = "SELECT id, title FROM subjects WHERE grade_level = $grade_level AND deleted_at IS NULL";
  $result = mysqli_query($conn, $query);
  $count = mysqli_num_rows($result);
?>

<?php if($_SESSION['type'] === 'coordinator'):?>
  <div class="tabs">
    <?php
      for($i = 1; $i <= 2; $i++) {
        $href = "$_SERVER[PHP_SELF]?page=lessonandvideos&sub_page=educationalvideos&grade_level=$i";
        $label = $i <= 1 ? 'Elementary' : 'High School';
        $active_class = $grade_level == $i ? " active'" : "'";
        $link = "<a class='tab". $active_class ." href='$href'>$label</a>";
        echo $link;
      }
    ?>
  </div>
<?php endif; ?>

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
          if($_SESSION['type'] === 'coordinator') {
            $videos = "<a class='button' href=$_SERVER[PHP_SELF]?page=lessonandvideos&sub_page=educationalvideos&grade_level=$grade_level&subject_id=$id>Videos</a>";
          } else {
            $videos = "<a class='button' href=$_SERVER[PHP_SELF]?grade_level=$grade_level&subject_id=$id>Videos</a>";
          }
          $table_row =
          "<tr>
            <td>$title</td>
            <td class='option'>$videos</td>
          </tr>";
          echo $table_row;
        }
      ?>
    </tbody>
  </table>
<?php endif; ?>