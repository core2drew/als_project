<?php
  //Check if request is POST
  if($_SERVER["REQUEST_METHOD"] == "POST") {
    //DB Connection
    require 'config/db_connect.php';

    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $query = "SELECT id, type, CONCAT(firstname, ' ', lastname) as fullname from users where email='$email' and password='$password'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);

    $type = $row['type'];
    $fullname = $row['fullname'];
    
    $count = mysqli_num_rows($result);
    mysqli_close($conn);

    if($count == 1) {
      $_SESSION['is_logged_in'] = true;
      $_SESSION['type'] = $type;
      $_SESSION['fullname'] = $fullname;
    }else {
      echo 'Incorrect username or Password';
      //echo "Error " . mysqli_error($conn);
    }
  }
