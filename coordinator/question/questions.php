<?php
  require '../../config/db_connect.php';
  include '../../includes/html/head.php';
  include '../../check_session.php';
  include '../../includes/header.php';

  $grade_level = isset($_GET['grade_level']) ? $_GET['grade_level'] : null;

  $query = "SELECT
  quest.id,
  quest.question,
  sub.title as subject
  FROM questions quest LEFT JOIN subjects sub
  ON quest.subject_id = sub.id
  WHERE sub.grade_level = $grade_level AND quest.deleted_at IS NULL AND sub.deleted_at IS NULL";
  $result = mysqli_query($conn, $query);
  $count = mysqli_num_rows($result);
?>

<div id="Coordinator" class="wrapper">
  <?php include '../../includes/sidebar.php'; ?>
  <div id="ManageQuestions" class="page">
    <div class="tabs">
      <?php 
        for($i = 1; $i <= 2; $i++) {
          $href = "/coordinator/question/questions.php?page=questions&grade_level=$i";
          $label = $i <= 1 ? 'Elementary' : 'High School';
          $active_class = $grade_level == $i ? " active'" : "'";
          $link = "<a class='tab". $active_class ." href='$href'>$label</a>";
          echo $link;
        }
      ?>
    </div>
    <div class="table-actions">
      <?php
        $create_link = "/coordinator/question/create.php?page=questions&grade_level=$grade_level";
        echo "<a class='button' href=$create_link>Create Question</a>";
      ?>
    </div>
    <?php
      if($count <= 0):
    ?>
      <table class="table">
        <thead>
          <th>Question</th>
          <th>Subject</th>
          <th class="options">Options</th>
        </thead>
      </table>
      <div class="no-records">
        <h3>No Records</h3>
      </div>
    <?php else: ?>
      <table class="table">
        <thead>
          <th>Question</th>
          <th>Subject</th>
          <th class="options">Options</th>
        </thead>
        <tbody>
          <?php
            while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
              $id = $row['id'];
              $title = $row['question'];
              $subject = $row['subject'];
              $view_btn = "<a class='button' href='/coordinator/question/update.php?page=questions&grade_level=$grade_level&id=$id'>View</a>";
              $update_btn = "<a class='button' href='/coordinator/question/update.php?page=questions&grade_level=$grade_level&id=$id'>Update</a>";
              $delete_btn = "<a class='button' href='/coordinator/question/delete.php?page=questions&grade_level=$grade_level&id=$id'>Delete</a>";
              $table_row =
              "<tr>
                <td>$title</td>
                <td>$subject</td>
                <td class='option'>$view_btn $update_btn $delete_btn</td>
              </tr>";
              echo $table_row;
            }
          ?>
        </tbody>
      </table>
    <?php endif; ?>
  </div>
</div>
<?php
  include '../../includes/html/footer.php';
?>