<?php
  session_start();
  //Check if request is POST
  if($_SERVER["REQUEST_METHOD"] == "POST") {
    //DB Connection
    require 'config/db_connect.php';
    //Allow to send json to client
    header('Content-Type: application/json');

    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $query = "SELECT id, type from users where username='$username' and password='$password'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);

    $user_type = $row['type'];
    
    $count = mysqli_num_rows($result);
    mysqli_close($conn);

    if($count == 1) {
      $_SESSION['login_user'] = $username;
      $_SESSION['user_type'] = $user_type;
      $json = ['success' => true];
      echo json_encode($json);
    }else {
      //echo "Error " . mysqli_error($conn);
      $json = ['success' => false, 'message' => 'Incorrect username or Password'];
      echo json_encode($json);
    }
  }
