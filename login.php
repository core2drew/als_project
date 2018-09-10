<?php
  //Check if request is POST
  if($_SERVER["REQUEST_METHOD"] == "POST") {
    //DB Connection
    require 'config/db_connect.php';
    $error_fields = [];
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $query = "SELECT id, profile_image_url, type, CONCAT(firstname, ' ', lastname) as fullname from users where email='$email' and password='$password' and deleted_at IS NULL";
    echo $query;
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);

    $type = $row['type'];
    $fullname = $row['fullname'];
    $user_id = $row['id'];
    $profile_image_url = $row['profile_image_url'];
    
    $count = mysqli_num_rows($result);
    mysqli_close($conn);

    if($count == 1) {
      $_SESSION['is_logged_in'] = true;
      $_SESSION['type'] = $type;
      $_SESSION['fullname'] = $fullname;
      $_SESSION['user_id'] = $user_id;
      $_SESSION['profile_image_url'] = $profile_image_url;
    }else {
      $error_fields['login'] = 'Incorrect username or Password';
      //echo "Error " . mysqli_error($conn);
    }
  }
