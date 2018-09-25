<?php 
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
    //DIsplay all coordinators account
    else if($type == 'coordinator') {
      $query = "SELECT
        id,
        lastname,
        firstname,
        address,
        contactno,
        email
        FROM users WHERE type = 'coordinator' AND is_admin = 0 AND deleted_at IS NULL";
        $create_link = "/coordinator/account/create.php?page=accounts&sub_page=$type&type=$type";
    }
  
    $result = mysqli_query($conn, $query);
    $count = mysqli_num_rows($result);
?>

<?php if($sub_page !== 'coordinator'): ?>
  <div class="tabs">
    <?php 
      for($i = 1; $i <= 2; $i++) {
        $href = "$_SERVER[PHP_SELF]?page=accounts&sub_page=$type&type=$type&grade_level=$i";
        $label = $i <= 1 ? 'Elementary' : 'High School';
        $active_class = $grade_level == $i ? " active'" : "'";
        $link = "<a class='tab". $active_class ." href='$href'>$label</a>";
        echo $link;
      }
    ?>
  </div>
<?php endif ?>
<div class="table-actions">
  <span id="CreateAccount" class='button'>Create Account</span>
</div>
<?php
  if($count <= 0):
?>
  <div class="no-records">
    <p class="message">No Records</p>
  </div>
<?php
  else:
?>
  <table class="table accounts">
    <thead>
      <?php if($type == 'student'): ?>
        <th>Name</th>
        <th>Address</th>
        <th>Contact No.</th>
        <th>Email</th>
        <th>Teacher</th>
        <th class="options">Options</th>

      <?php elseif($type == 'teacher' || 'coordinator'): ?>
        <th>Name</th>
        <th>Address</th>
        <th>Contact No.</th>
        <th>Email</th>
        <th class="options">Options</th>
      <?php endif ?>
    </thead>
    <tbody>
      <?php
        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
          $id = $row['id'];
          $last_name = $row['lastname'];
          $first_name = $row['firstname'];
          $address = $row['address'];
          $contactno = $row['contactno'];
          $email = $row['email'];
          $teacher_name = isset($row['teacher_name']) ? $row['teacher_name'] : '';
          if($type == 'coordinator') {
            $update_btn = "<a class='button update' href='/coordinator/account/update.php?page=accounts&sub_page=$type&type=$type&id=$id'>Update</a>";
            $delete_btn = "<a class='button delete' href='/coordinator/account/delete.php?page=accounts&sub_page=$type&type=$type&id=$id'>Delete</a>";
          } else {
            $update_btn = "<a class='button update' href='/coordinator/account/update.php?page=accounts&sub_page=$type&type=$type&grade_level=$grade_level&id=$id'>Update</a>";
            $delete_btn = "<a class='button delete' href='/coordinator/account/delete.php?page=accounts&sub_page=$type&type=$type&grade_level=$grade_level&id=$id'>Delete</a>";
          }

          if($type == 'student') {
            $table_row =
            "<tr>
              <td>$last_name, $first_name</td>
              <td>$address</td>
              <td>$contactno</td>
              <td>$email</td>
              <td>$teacher_name</td>
              <td class='option'>$update_btn $delete_btn</td>
            </tr>";
          }else if($type == 'teacher' || $type == 'coordinator') {
            $table_row =
            "<tr>
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