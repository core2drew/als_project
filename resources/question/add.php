<?php
require '../../config/db_connect.php';

if($_SERVER["REQUEST_METHOD"] == "POST") {
  header('Content-Type: application/json');
  $error_fields = [];

  if(empty($_POST['question'])) {
    array_push($error_fields, 'Question field is required');
  }

  if(empty($_POST['choice_1'])) {
    array_push($error_fields, 'Choice 1 field is required');
  }

  if(empty($_POST['choice_2'])) {
    array_push($error_fields, 'Choice 2 field is required');
  }

  if(empty($_POST['choice_3'])) {
    array_push($error_fields, 'Choice 3 field is required');
  }

  if(empty($_POST['choice_4'])) {
    array_push($error_fields, 'Choice 4 field is required');
  }

  if(count($error_fields) > 0) {
    $json = ['success' => false, 'data' => $error_fields];
    echo json_encode($json);
    die();
  }

  $question = mysqli_real_escape_string($conn, $_POST['question']);
  $choice_1 = mysqli_real_escape_string($conn, $_POST['choice_1']);
  $choice_2 = mysqli_real_escape_string($conn, $_POST['choice_2']);
  $choice_3 = mysqli_real_escape_string($conn, $_POST['choice_3']);
  $choice_4 = mysqli_real_escape_string($conn, $_POST['choice_4']);

  $query = "INSERT INTO questions (question, choice_1, choice_2, choice_3, choice_4) VALUES ('$question', '$choice_1', '$choice_2', '$choice_3', '$choice_4')";
  $result = mysqli_query($conn, $query);
  mysqli_close($conn);

  if($result) {
    $json = ['success' => true];
    echo json_encode($json);
  } else {
    //echo "Error " . mysqli_error($conn);
    $json = ['success' => false, 'message' => 'Something went wrong'];
  }
}