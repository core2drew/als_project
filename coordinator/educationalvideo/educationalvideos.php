<?php
  require '../../config/db_connect.php';
  include '../../includes/html/head.php';
  include '../../check_session.php';
  include '../../includes/header.php';

  $grade_level = isset($_GET['grade_level']) ? $_GET['grade_level'] : null;

  $query = "SELECT
  vid.id,
  vid.title,
  vid.url,
  vid.type
  FROM videos vid LEFT JOIN subjects sub
  ON vid.subject_id = sub.id
  WHERE sub.grade_level = $grade_level AND vid.deleted_at IS NULL AND sub.deleted_at IS NULL";
  $result = mysqli_query($conn, $query);
  $count = mysqli_num_rows($result);
?>

<div id="Coordinator" class="wrapper">
  <?php include '../../includes/sidebar.php'; ?>
  <div id="ManageLearningVideos" class="page">
    <div class="tabs">
      <?php 
        for($i = 1; $i <= 2; $i++) {
          $href = "/coordinator/educationalvideo/educationalvideos.php?page=lessonandvideos&sub_page=educationalvideos&grade_level=$i";
          $label = $i <= 1 ? 'Elementary' : 'High School';
          $active_class = $grade_level == $i ? " active'" : "'";
          $link = "<a class='tab". $active_class ." href='$href'>$label</a>";
          echo $link;
        }
      ?>
    </div>
    <div class="table-actions">
      <?php
        $create_link = "/coordinator/educationalvideo/create.php?page=lessonandvideos&sub_page=educationalvideos&grade_level=$grade_level&upload_option=upload";
        echo "<a class='button' href=$create_link>Create Learning Videos</a>";
      ?>
    </div>
    <?php
      if($count <= 0):
    ?>
      <table class="table">
        <thead>
          <th>Title</th>
          <th class="watch">Watch</th>
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
        <th class="watch">Watch</th>
        <th class="options">Options</th>
      </thead>
      <tbody>
        <?php
          while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $id = $row['id'];
            $title = $row['title'];
            $url = $row['url'];
            $upload_option = $row['type'];
            $update_btn = "<a class='button' href='/coordinator/educationalvideo/update.php?page=lessonandvideos&sub_page=educationalvideos&grade_level=$grade_level&upload_option=$upload_option&id=$id'>Update</a>";
            $delete_btn = "<a class='button' href='/coordinator/educationalvideo/delete.php?page=lessonandvideos&sub_page=educationalvideos&grade_level=$grade_level&upload_option=$upload_option&id=$id'>Delete</a>";

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