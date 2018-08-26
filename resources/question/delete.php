<?php
header('Content-Type: application/json');
require '../../config/db_connect.php';

if($_SERVER["REQUEST_METHOD"] == "POST") {

  $id = mysqli_real_escape_string($conn, $_POST['id']);
  
  $query = "DELETE FROM questions WHERE id='$id'";
  $result = mysqli_query($conn, $query);
  mysqli_close($conn);

  if($result) {
    $json = ['success' => true];
    echo json_encode($json);
  } else {
    //echo "Error " . mysqli_error($conn);
    $json = ['success' => false, 'message' => 'Something went wrong'];
    echo json_encode($json);
  }
}

