<?php
  $action = isset($_GET['action']) ? $_GET['action'] : null;
  $is_coordinator = $_SESSION['type'] === 'coordinator' ? true : false;

  $back_to_subjects = "$_SERVER[PHP_SELF]?page=lessonandvideos&sub_page=lessons&grade_level=$grade_level";
  $back_link_lessons = $back_to_subjects."&subject_id=$subject_id";

  $query = "SELECT id, title FROM lessons WHERE subject_id=$subject_id AND deleted_at IS NULL";
  $result = mysqli_query($conn, $query);
  $count = mysqli_num_rows($result);
?>

<!-- Display only when action is set-->
<?php if($action): ?>
  <?php if($action == 'create'): ?>
    <div class="title">
      <h2>Create Lesson</h2>
      <a class="button" href="<?php echo $back_link_lessons ?>">Back</a>
    </div>
    <?php include '../includes/lesson/create.php' ?>
  <?php elseif($action == 'update'): ?>
    <div class="title">
      <h2>Update Lesson</h2>
      <a class="button" href="<?php echo $back_link_lessons ?>">Back</a>
    </div>
    <?php include '../includes/lesson/update.php' ?>
  <?php endif ?>
<?php else: ?>

<!-- Display only when user type is coordinator -->
<?php if($is_coordinator): ?>
  <div class="title">
    <h2>Subject Lessons</h2>
    <a class="button" href="<?php echo $back_to_subjects ?>">Back</a>
  </div>
  <div class="table-actions">
    <a id='CreateLesson' href="<?php echo $back_link_lessons."&action=create" ?>" class='button'>Create Lesson</a>
  </div>
<?php endif; ?>

<?php
  if($count <= 0):
?>
  <div class="no-records">
    <p class="message">No Records</p>
  </div>
  <?php else: ?>
    <table class="table lessons">
      <thead>
        <th>Title</th>
        <th>Options</th>
      </thead>
      <tbody>
        <?php
          while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            if($is_coordinator) {
              $update = "<a class='button update' href=$back_link_lessons&action=update&lesson_id=$row[id]>Update</a>";
              $remove_exam = "<span class='button delete' data-lesson-id=$row[id]>Remove</span>";
              $table_row =
              "<tr>
                <td>$row[title]</td>
                <td class='option'>$update $remove_exam</td>
              </tr>";
            } else {
              $view = "<a class='button view' href=/lessons.php?grade_level=$grade_level&subject_id=$subject_id&lesson_id=$row[id]>View</a>";
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
<?php endif; ?>