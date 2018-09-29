<?php
  require '../../config/db_connect.php';
  header('Content-Type: application/json');

  $json_data['success'] = false;
  $exam_id = isset($_GET['exam_id']) ? $_GET['exam_id'] : null; 
  
  $exam_query= "SELECT 
  title, questions_id, minutes, instruction
  FROM exams 
  WHERE id=$exam_id AND deleted_at IS NULL";
  $exam_result = mysqli_query($conn, $exam_query);
  $exam_row = mysqli_fetch_array($exam_result, MYSQLI_ASSOC);

  if($exam_result) {
    $json_data['success'] = true;
    $json_data['data'] = $exam_row;
  } else {
    $json_data['message'] = 'Oops, something went wrong.';
  }

  echo json_encode($json_data);