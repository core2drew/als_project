<?php
  $is_coordinator = $_SESSION['type'] === 'coordinator' ? true : false;
  $back_to_subjects = "$_SERVER[PHP_SELF]?page=lessonandvideos&sub_page=educationalvideos&grade_level=$grade_level";

  $query = "SELECT id, title, url, type FROM videos WHERE subject_id=$subject_id AND deleted_at IS NULL";
  $result = mysqli_query($conn, $query);
  $count = mysqli_num_rows($result);
?>

<!-- Display only when user type is coordinator -->
<?php if($is_coordinator): ?>
  <div class="title">
    <h2>Subject Lessons</h2>
    <a class="button" href="<?php echo $back_to_subjects ?>">Back</a>
  </div>
  <div class="table-actions">
    <span id='UploadVideo' class='button'>Upload Video</span>
  </div>
<?php endif; ?>

<?php
  if($count <= 0):
?>
  <div class="no-records">
    <p class="message">No Records</p>
  </div>
  <?php else: ?>
  <table class="table educationalvideo">
    <thead>
      <th>Title</th>
      <th class="options">Options</th>
    </thead>
    <tbody>
      <?php
        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
          if($row['type'] === 'upload') {
            $view = "<span class='button view' data-video-id=$row[id]>Watch</span>";
          } elseif ($row['type'] === 'link') {
            $view = "<a class='button' href=$row[url] target=_blank>Watch</a>";
          }
          if($is_coordinator) {
            $update = "<span class='button update' data-video-id=$row[id]>Update</span>";
            $remove = "<span class='button delete' data-video-id=$row[id]>Remove</span>";
            $table_row =
            "<tr>
              <td>$row[title]</td>
              <td class='option coordinator'>$view $update $remove</td>
            </tr>";
          } else {
            $table_row =
            "<tr>
              <td>$row[title]</td>
              <td class='option teacher-student'>$view</td>
            </tr>";
          }
          echo $table_row;
        }
      ?>
    </tbody>
  </table>
<?php endif; ?>