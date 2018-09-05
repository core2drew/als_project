<?php
  require '../../config/db_connect.php';
  include '../../includes/html/head.php';
  include '../../check_session.php';
  include '../../includes/header.php';
  
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
      WHERE student.type='student'";
  }
  // Display all teachers account
  else if($type == 'teacher') {
    $query = "SELECT
      users.id,
      users.lastname,
      users.firstname,
      users.address,
      users.contactno,
      users.email
      FROM users WHERE users.type = 'teacher'";
  }
  $result = mysqli_query($conn, $query);
  $count = mysqli_num_rows($result);
?>

<div id="Coordinator" class="wrapper">
  <?php include '../../includes/sidebar.php'; ?>
  <div id="Accounts" class="page">
    <?php
      // echo "<h1 class='title'>$type's Accounts</h1>";
    ?>
    <div class="table-actions">
      <?php
        $create_link = "/coordinator/account/create-account.php?page=$type&type=$type";
        echo "<a class='button' href=$create_link>Create Account</a>";
      ?>
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
            <th>Grade Level</th>
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
            <th>Grade Level</th>
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
              $grade_level = isset($row['grade_level']) ? $row['grade_level'] : '';
              $teacher_name = isset($row['teacher_name']) ? $row['teacher_name'] : '';
              $update_btn = "<a class='button' href='/coordinator/account/update-account.php?page=$type&type=$type&id=$id'>Update</a>";
              $delete_btn = "<a class='button' href='/coordinator/account/delete-account.php?page=$type&type=$type&id=$id'>Delete</a>";

              if($type == 'student') {
                $table_row =
                "<tr>
                  <td>$id</td>
                  <td>$last_name, $first_name</td>
                  <td>$address</td>
                  <td>$contactno</td>
                  <td>$email</td>
                  <td>$grade_level</td>
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
  include '../includes/html/footer.php';
?>