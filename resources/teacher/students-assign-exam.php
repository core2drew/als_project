<?php
    require '../../config/db_connect.php';
    header('Content-Type: application/json');

    $json_data['success'] = false;

    $teacher_id = mysqli_real_escape_string($conn, $_GET['teacher_id']);
    $exam_id = mysqli_real_escape_string($conn, $_GET['exam_id']);
    
    //Get all students
    $query = "SELECT id FROM users WHERE teacher_id = $teacher_id AND deleted_at IS NULL";
    $result = mysqli_query($conn, $query);
    $count = mysqli_num_rows($result);

    if($result) {
      if($count > 0) {
        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
          $created_at = date("Y-m-d H:i:s");
          $insert_query = "INSERT INTO users_has_exam (user_id, exam_id, created_at) VALUES ('$row[id]', '$exam_id', '$created_at')";
          $insert_result = mysqli_query($conn, $insert_query);
        }
        $json_data['success'] = true;
        $json_data['message'] = 'Successful exam assigning';
      }else {
        $json_data['message'] = 'No Students assign to you';
      }
    } else {
      $json_data['message'] = 'Oops, something went wrong.';
    }
  
    echo json_encode($json_data);