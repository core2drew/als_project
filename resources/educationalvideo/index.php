<?php
  require '../../config/db_connect.php';
  header('Content-Type: application/json');

  $json_data['success'] = false;

  $id = mysqli_real_escape_string($conn, $_GET['id']);
  $query = "SELECT id, title, filename, url, type FROM videos WHERE id = $id AND deleted_at IS NULL";
  $result = mysqli_query($conn, $query);
  $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

  if($result) {
    $json_data['success'] = true;
    $json_data['data']['title'] = $row['title'];
    $json_data['data']['filename'] = $row['filename'];
    $json_data['data']['video_link'] = $row['url'];
    $json_data['data']['type'] = $row['type'];
  } else {
    $json_data['message'] = 'Oops, something went wrong.';
  }

  echo json_encode($json_data);