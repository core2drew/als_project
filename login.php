<?php
  //Check if request is POST
  if($_SERVER["REQUEST_METHOD"] == "POST") {
    //DB Connection
    require 'config/db_connect.php';
    $error_fields = [];
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $query = "SELECT id, profile_image_url, type, CONCAT(lastname, ', ' , firstname) as fullname, grade_level, is_admin from users where email='$email' and password='$password' and deleted_at IS NULL";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);

    $type = $row['type'];
    $fullname = $row['fullname'];
    $user_id = $row['id'];
    $grade_level = $row['grade_level'];
    $profile_image_url = $row['profile_image_url'];
    $is_admin = $row['is_admin'];
    $count = mysqli_num_rows($result);

    if($count == 1) {
      //Attendance
      $timezone = "Asia/Hong_Kong";
      date_default_timezone_set($timezone);
      $log_at = date("Y-m-d H:i:s");

      $query = "INSERT INTO user_logs (user_id, log_at) VALUES ($user_id, '$log_at')";
      $result = mysqli_query($conn, $query);
      echo $query ;

      $_SESSION['is_logged_in'] = true;
      $_SESSION['type'] = $type;
      $_SESSION['fullname'] = $fullname;
      $_SESSION['user_id'] = $user_id;
      $_SESSION['grade_level'] = $grade_level;
      $_SESSION['profile_image_url'] = $profile_image_url;
      $_SESSION['is_admin'] = $is_admin;
      
    }else {
      $error_fields['login'] = 'Incorrect username or Password';
      //echo "Error " . mysqli_error($conn);
    }
  }
