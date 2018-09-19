<?php
  require '../../config/db_connect.php';
  include '../../includes/html/head.php';
  include '../../check_session.php';
  include '../../includes/header.php';

  $grade_level = isset($_GET['grade_level']) ? $_GET['grade_level'] : null;
  $type = isset($_GET['type']) ? $_GET['type'] : null;

  //Display all student account
  if($type == 'student') {
    $query = "SELECT
      student.id,
      student.lastname,
      student.firstname,
      student.address,
      student.contactno,
      student.email,
      student.grade_level,
      CONCAT(teacher.lastname,', ' ,teacher.firstname) as teacher_name
      FROM users student LEFT JOIN users teacher
      ON student.teacher_id = teacher.id
      WHERE student.type='student' AND student.grade_level=$grade_level AND student.deleted_at IS NULL";
  }
  // Display all teachers account
  else if($type == 'teacher') {
    $query = "SELECT
      teacher.id,
      teacher.lastname,
      teacher.firstname,
      teacher.address,
      teacher.contactno,
      teacher.email
      FROM users teacher WHERE teacher.type = 'teacher' AND teacher.grade_level=$grade_level AND teacher.deleted_at IS NULL";
  }
  $result = mysqli_query($conn, $query);
  $count = mysqli_num_rows($result);

  $create_link = "/coordinator/account/create-account.php?page=accounts&sub_page=$type&type=$type&grade_level=$grade_level";
?>

<div id="Coordinator" class="wrapper">
  <?php include '../../includes/sidebar.php' ?>
  <div id="Accounts" class="page">
    <div class="tabs">
      <?php 
        for($i = 1; $i <= 2; $i++) {
          $href = "/coordinator/account/account.php?page=accounts&sub_page=$type&type=$type&grade_level=$i";
          $label = $i <= 1 ? 'Elementary' : 'High School';
          $active_class = $grade_level == $i ? " active'" : "'";
          $link = "<a class='tab". $active_class ." href='$href'>$label</a>";
          echo $link;
        }
      ?>
    </div>
    <div class="table-actions">
      <a class='button' href=<?php echo $create_link ?>>Create Account</a>
    </div>
    <?php
      if($count <= 0):
    ?>
      <table class="table">
        <thead>
          <?php if($type == 'student'): ?>
            <th>ID</th>
            <th>Name</th>
            <th>Address</th>
            <th>Contact No.</th>
            <th>Email</th>
            <th>Teacher</th>
            <th class="options">Options</th>
          <?php endif; ?>

          <?php if($type == 'teacher'): ?>
            <th>ID</th>
            <th>Name</th>
            <th>Address</th>
            <th>Contact No.</th>
            <th>Email</th>
            <th class="options">Options</th>
          <?php endif; ?>
        </thead>
      </table>
      <div class="no-records">
        <h3>No Records</h3>
      </div>
    <?php
      else:
    ?>
      <table class="table">
        <thead>
          <?php if($type == 'student'): ?>
            <th>ID</th>
            <th>Name</th>
            <th>Address</th>
            <th>Contact No.</th>
            <th>Email</th>
            <th>Teacher</th>
            <th class="options">Options</th>
          <?php endif; ?>

          <?php if($type == 'teacher'): ?>
            <th>ID</th>
            <th>Name</th>
            <th>Address</th>
            <th>Contact No.</th>
            <th>Email</th>
            <th class="options">Options</th>
          <?php endif ?>
        </thead>
        <tbody>
          <?php
            //Teacher Rows
            while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
              $id = $row['id'];
              $last_name = $row['lastname'];
              $first_name = $row['firstname'];
              $address = $row['address'];
              $contactno = $row['contactno'];
              $email = $row['email'];
              $teacher_name = isset($row['teacher_name']) ? $row['teacher_name'] : '';
              $update_btn = "<a class='button' href='/coordinator/account/update-account.php?page=$type&type=$type&id=$id&grade_level=$grade_level'>Update</a>";
              $delete_btn = "<a class='button' href='/coordinator/account/delete-account.php?page=$type&type=$type&id=$id&grade_level=$grade_level'>Delete</a>";

              if($type == 'student') {
                $table_row =
                "<tr>
                  <td>$id</td>
                  <td>$last_name, $first_name</td>
                  <td>$address</td>
                  <td>$contactno</td>
                  <td>$email</td>
                  <td>$teacher_name</td>
                  <td class='option'>$update_btn $delete_btn</td>
                </tr>";
              }else if($type == 'teacher') {
                $table_row =
                "<tr>
                  <td>$id</td>
                  <td>$last_name, $first_name</td>
                  <td>$address</td>
                  <td>$contactno</td>
                  <td>$email</td>
                  <td class='option'>$update_btn $delete_btn</td>
                </tr>";
              }
              echo $table_row;
            }
          ?>
        </tbody>
      </table>
    <?php
      endif;
    ?>
  </div>
</div>

<?php
  include '../../includes/html/footer.php';
?>