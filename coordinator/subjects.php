<?php
  require '../config/db_connect.php';
  include '../includes/html/head.php';
  include '../check_session.php';
  include '../includes/header.php';
  $grade_level = isset($_GET['grade_level']) ? $_GET['grade_level'] : null;

  $query = "SELECT
  subjects.id,
  subjects.title
  FROM subjects WHERE subjects.grade_level = $grade_level";
  $result = mysqli_query($conn, $query);
  $count = mysqli_num_rows($result);
?>

<div id="Coordinator" class="wrapper">
  <?php include '../includes/sidebar.php'; ?>
  <div id="ManageSubjects" class="page">
    <div class="tabs">
      <a class="tab <?php echo $grade_level == 1 ? 'active' : null ?>" href="/coordinator/subjects.php?page=subjects&grade_level=1">Elementary Subjects</a>
      <a class="tab <?php echo $grade_level == 2 ? 'active' : null ?>" href="/coordinator/subjects.php?page=subjects&grade_level=2">High School Subjects</a>
    </div>
    <div class="table-actions">
      <?php
        $create_link = "/coordinator/create-subject.php?page=subjects&grade_level=$grade_level";
        echo "<a class='button' href=$create_link>Create Subject</a>";
      ?>
    </div>
    <?php
      if($count <= 0):
    ?>
      <table class="table">
        <thead>
          <th>Title</th>
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
        <th></th>
      </thead>
      <tbody>
        <?php
          while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            $id = $row['id'];
            $title = $row['title'];
            $update_btn = "<a class='button' href='/coordinator/update-subject.php?page=subjects&id=$id'>Update</a>";
            $delete_btn = "<a class='button' href='/coordinator/delete-subject.php?page=subjects&id=$id'>Delete</a>";

            $table_row =
            "<tr>
              <td>$title</td>
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
  include '../includes/html/footer.php';
?>