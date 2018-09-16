<?php
  require '../../config/db_connect.php';
  include '../../includes/html/head.php';
  include '../../check_session.php';
  include '../../includes/header.php';

  $grade_level = isset($_GET['grade_level']) ? $_GET['grade_level'] : null;

  //Query first subject
  $subject_query = "SELECT subjects.id FROM subjects WHERE subjects.grade_level=$grade_level AND deleted_at IS NULL LIMIT 1";
  $subject_result = mysqli_query($conn, $subject_query);
  $subject_row = mysqli_fetch_array($subject_result, MYSQLI_ASSOC);

  $query = "SELECT
  exam.id,
  exam.title,
  sub.title as subject_title
  FROM exams exam LEFT JOIN subjects sub
  ON exam.subject_id = sub.id
  WHERE sub.grade_level = $grade_level AND exam.deleted_at IS NULL AND sub.deleted_at IS NULL";
  $result = mysqli_query($conn, $query);
  $count = mysqli_num_rows($result);
?>

<div id="Coordinator" class="wrapper">
  <?php include '../../includes/sidebar.php'; ?>
  <div id="ManageExams" class="page">
    <div class="tabs">
      <?php
        for($i = 1; $i <= 2; $i++) {
          $href = "/coordinator/exam/exams.php?page=exams&grade_level=$i";
          $label = $i <= 1 ? 'Elementary' : 'High School';
          $active_class = $grade_level == $i ? " active'" : "'";
          $link = "<a class='tab". $active_class ." href='$href'>$label</a>";
          echo $link;
        }
      ?>
    </div>
    <div class="table-actions">
      <?php
        $create_link = "/coordinator/exam/create.php?page=exams&grade_level=$grade_level&subject_id=$subject_row[id]";
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
          <th class="options">Options</th>
        </thead>
        <tbody>
          <?php
            while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
              $id = $row['id'];
              $title = $row['title'];
              $subject = $row['subject_title'];
              $update_exam = "<a href=/coordinator/exam/update.php?page=exams&id=$id>Update</a>";
              $remove_exam = "<a href=/coordinator/exam/delete.php?page=exams&id=$id>Remove</a>";
              $table_row =
              "<tr>
                <td>$title</td>
                <td>$subject</td>
                <td class='option'>$update_exam $remove_exam</td>
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