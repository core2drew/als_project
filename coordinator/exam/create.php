<?php
  require '../../config/db_connect.php';
  include '../../includes/html/head.php';
  include '../../check_session.php';
  include '../../includes/header.php';

  $grade_level = isset($_GET['grade_level']) ? $_GET['grade_level'] : null;
  $subject = isset($_GET['subject']) ? $_GET['subject'] : null;

  $subject_query = "SELECT title FROM subjects WHERE grade_level = $grade_level AND deleted_at IS NULL";
  
  $subject_result = mysqli_query($conn, $subject_query);
  $subject_count = mysqli_num_rows($subject_result);
  $count = 0;
?>

<div id="Coordinator" class="wrapper">
  <?php include '../../includes/sidebar.php'; ?>
  <div id="ManageExams" class="page">
    <?php
      if($subject_count > 0):
    ?>
      <div class="tabs">
        <?php
         while($subject_row = mysqli_fetch_array($subject_result, MYSQLI_ASSOC)) {
            $href = "/coordinator/exam/create.php?page=exams&subject=$subject_row[title]&grade_level=$grade_level";
            $active_class = $subject_row == $subject ? " active'" : "'";
            $link = "<a class='tab". $active_class ." href='$href'>$subject_row[title]</a>";
            echo $link;
         }
        ?>
      </div>
    <?php endif; ?>
    <div class="table-actions">
      <?php
        $create_link = "/coordinator/exam/create.php?page=exams&grade_level=$grade_level";
        echo "<a class='button' href=$create_link>Create Exam</a>";
      ?>
    </div>
    <?php
      if($count <= 0):
    ?>
      <table class="table">
        <thead>
          <th>Title</th>
          <th>Subject</th>
          <th>View Questions</th>
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
        <th>Subject</th>
        <th>View Questions</th>
        <th class="options">Options</th>
      </thead>
      <tbody>
        <?php
          while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $id = $row['id'];
            $title = $row['title'];
            $url = $row['url'];
            $upload_option = $row['type'];
            $update_btn = "<a class='button' href='/coordinator/learningvideo/update.php?page=learningvideos&grade_level=$grade_level&upload_option=$upload_option&id=$id'>Update</a>";
            $delete_btn = "<a class='button' href='/coordinator/learningvideo/delete.php?page=learningvideos&grade_level=$grade_level&upload_option=$upload_option&id=$id'>Delete</a>";

            $table_row =
            "<tr>
              <td>$title</td>
              <td><a href=$url target='_blank'>Watch</a></td>
              <td class='option'>$update_btn $delete_btn</td>
            </tr>";
            echo $table_row;
          }
        ?>
      </tbody>
    <?php endif; ?>
    </table>
  </div>
</div>
<?php
  include '../../includes/html/footer.php';
?>