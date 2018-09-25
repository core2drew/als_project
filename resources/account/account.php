<?php
  require '../../config/db_connect.php';
  include "../../resources/_global.php";
  header('Content-Type: application/json');

  $json_data['success'] = false;

  $id = mysqli_real_escape_string($conn, $_GET['id']);
  $type = isset($_GET['type']) ? $_GET['type'] : null;
 
  $query = "SELECT id, lastname, firstname, address, contactno, email, grade_level, password, teacher_id, profile_image_url
  FROM users WHERE id = $id AND deleted_at IS NULL";
  
  $result = mysqli_query($conn, $query);
  $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
  $count = mysqli_num_rows($result);

  if($result) {
    $json_data['success'] = true;
    $json_data['data'] = $row;
  } else {
    $json_data['message'] = 'Oops, something went wrong.';
  }

  echo json_encode($json_data);