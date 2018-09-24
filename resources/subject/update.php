<?php
  require '../../config/db_connect.php';
  header('Content-Type: application/json');

  $json_data['success'] = false;

  if($_SERVER["REQUEST_METHOD"] == "POST") {

    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $title = mysqli_real_escape_string($conn, $_POST['title']);;

    $query = "UPDATE subjects SET title='$title' WHERE id=$id";
    $result = mysqli_query($conn, $query);

    if($result) {
      $json_data['success'] = true;
    } else {
      $json_data['message'] = 'Oops, something went wrong.';;
    }
  }

  echo json_encode($json_data);