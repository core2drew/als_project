<?php
  require '../../config/db_connect.php';
  include "../../resources/_global.php";
  header('Content-Type: application/json');

  $json_data['success'] = false;
  $id = isset($_GET['id']) ? mysqli_real_escape_string($conn, $_GET['id']) : null;

  if($id) {
    $query = "SELECT a.id, a.title,
    CONCAT(u.lastname, ', ' , u.firstname) as announcer, u.profile_image_url, a.created_at, a.announcement FROM announcements as a INNER JOIN users as u ON a.user_id = u.id 
    WHERE a.id = $id AND a.deleted_at IS NULL";

    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    $json_data['data'] = $row;
    
  } else {
    //Get activity by id
    $query = "SELECT a.id, a.title,
    CONCAT(u.lastname, ', ' , u.firstname) as announcer, u.profile_image_url, a.created_at, a.announcement FROM announcements as a INNER JOIN users as u ON a.user_id = u.id 
    WHERE a.deleted_at IS NULL";

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