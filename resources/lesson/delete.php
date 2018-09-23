<?php
  require '../../config/db_connect.php';
  header('Content-Type: application/json');
  
  $json_data['success'] = false;

  if($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = isset($_POST['id']) ? $_POST['id'] : null;
    $deleted_at = date("Y-m-d H:i:s");
    
    if(isset($id)) {
      $query = "UPDATE lessons SET deleted_at='$deleted_at' WHERE id=$id";
      $result = mysqli_query($conn, $query);
      
      if($result) {
        $json_data['success'] = true;
      } else {
        $json_data['message'] = 'Oops, something went wrong.';
      }
    }
  }

  echo json_encode($json_data);