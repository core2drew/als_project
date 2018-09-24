<?php
  require '../config/db_connect.php';
  include '../includes/html/head.php';
  include '../check_session.php';
  include '../includes/header.php';
  
  $user_id = $_SESSION['user_id'];

  $grade_level = isset($_GET['grade_level']) ? $_GET['grade_level'] : null;
  $subject_id = isset($_GET['subject_id']) ? $_GET['subject_id'] : null;
  $exam_id = isset($_GET['exam_id']) ? $_GET['exam_id'] : null;

  $query = "SELECT
    lastname,
    firstname,
    address,
    contactno,
    email
    FROM users
    WHERE teacher_id = $user_id AND deleted_at IS NULL";

  $result = mysqli_query($conn, $query);
  $count = mysqli_num_rows($result);
?>

<div id="Teacher" class="wrapper">
  <?php include '../includes/sidebar.php' ?>
  <div id="ManageStudent" class="page">
    <h2>Students</h2>
    <?php
      if($count <= 0):
    ?>
     <div class="no-records">
      <p class="message">No Records</p>
    </div>
    <?php
      else:
    ?>
      <table class="table">
        <thead>
          <th>Name</th>
          <th>Address</th>
          <th>Contact No.</th>
          <th>Email</th>
        </thead>
        <tbody>
          <?php
            while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
              $last_name = $row['lastname'];
              $first_name = $row['firstname'];
              $address = $row['address'];
              $contactno = $row['contactno'];
              $email = $row['email'];
              $teacher_name = isset($row['teacher_name']) ? $row['teacher_name'] : '';
              $table_row =
                "<tr>
                  <td>$last_name, $first_name</td>
                  <td>$address</td>
                  <td>$contactno</td>
                  <td>$email</td>
                </tr>";
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