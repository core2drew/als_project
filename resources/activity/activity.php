<?php
  require '../../config/db_connect.php';
  include "../../resources/_global.php";
  header('Content-Type: application/json');

  $json_data['success'] = false;

  $id = isset($_GET['id']) ? mysqli_real_escape_string($conn, $_GET['id']) : null;
  $type = isset($_GET['type']) ? $_GET['type'] : null;



  if($id) {
    //Get activity by id
    $query = "SELECT id, title, description, image_url
    FROM activities WHERE id = $id AND deleted_at IS NULL";
    
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    $json_data['data'] = $row;

  } else {
    //Get all activities
    $query = "SELECT id, title, description, image_url
    FROM activities WHERE deleted_at IS NULL";

    $result = mysqli_query($conn, $query);
    while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
      $json_data['data'][] = $row;
    }
  }


  if($result) {
    $json_data['success'] = true;
  } else {
    $json_data['message'] = 'Oops, something went wrong.';
  }

  echo json_encode($json_data);