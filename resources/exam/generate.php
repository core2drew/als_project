<?php
  require '../../config/db_connect.php';
  header('Content-Type: application/json');
  
  $json_data['success'] = false;

  if($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = isset($_POST['title']) ? mysqli_real_escape_string($conn, $_POST['title']) : NULL;
    $instruction = isset($_POST['instruction']) ? mysqli_real_escape_string($conn, $_POST['instruction']) : NULL;
    $subject_id = isset($_POST['subject_id']) ? mysqli_real_escape_string($conn, $_POST['subject_id']) : NULL;
    $minutes = isset($_POST['minutes']) ? mysqli_real_escape_string($conn, $_POST['minutes']) : NULL;
    $generate_count = isset($_POST['generate_count']) ? mysqli_real_escape_string($conn, $_POST['generate_count']) : NULL;
    $created_at = date("Y-m-d H:i:s");
    $questions_id = [];

    //Randomize
    $generate_query = "SELECT id FROM questions WHERE subject_id = $subject_id AND deleted_at IS NULL ORDER BY RAND() LIMIT $generate_count";
    $generate_result = mysqli_query($conn, $generate_query);
    
    while($generate_row = mysqli_fetch_array($generate_result, MYSQLI_ASSOC)) {
      $questions_id[] = $generate_row['id'];
    }

    // format array to string 1','2','3','4
    $questions_id = implode(",", $questions_id);
    $query = "INSERT INTO exams (title, subject_id, instruction, minutes, questions_id, created_at) VALUES ('$title', '$subject_id', '$instruction', $minutes, '$questions_id', '$created_at')";
    $result = mysqli_query($conn, $query);
    if($result) {
      $json_data['success'] = true;
    } else {
      $json_data['message'] = 'Oops, something went wrong.';
    }
  }

  echo json_encode($json_data);