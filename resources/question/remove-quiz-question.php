<?php 
  require '../../config/db_connect.php';
  header('Content-Type: application/json');

  $json_data['success'] = false;

  if(isset($_POST['question_id'])) {
    $quiz_id = isset($_POST['quiz_id']) ? mysqli_real_escape_string($conn, $_POST['quiz_id']) : null;
    $question_id = mysqli_real_escape_string($conn, $_POST['question_id']);
    $exam_query = "SELECT questions_id FROM quizzes WHERE id=$quiz_id";
    $exam_result = mysqli_query($conn, $exam_query);
    $exam_row = mysqli_fetch_array($exam_result, MYSQLI_ASSOC);
    $questions_id_array = explode(',', $exam_row['questions_id']);

    $index = array_search($question_id, $questions_id_array);
    
    if( $index !== FALSE) {

      unset($questions_id_array[$index]);

      if(count($questions_id_array)) {
        $exam_query = "UPDATE quizzes SET questions_id='". implode(",", $questions_id_array) ."' WHERE id=$quiz_id";
      } else {
        $exam_query = "UPDATE quizzes SET questions_id=NULL WHERE id=$quiz_id";
      }

      $exam_result = mysqli_query($conn, $exam_query);
      if($exam_result) {
        $json_data['success'] = true;
      } else {
        $json_data['message'] = 'Oops, something went wrong.';
      }
    }
  }

  echo json_encode($json_data);