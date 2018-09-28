<?php
  //DB Connection
  require '../../config/db_connect.php';
  header('Content-Type: application/json');

  $json_data['success'] = true;

  if($_SERVER["REQUEST_METHOD"] == "POST") {

    $exam_id = mysqli_real_escape_string($conn, $_POST['exam_id']);

    if(isset($_POST['question_id'])) {
      $question_id = mysqli_real_escape_string($conn, $_POST['question_id']);
      $exam_query = "SELECT questions_id FROM exams WHERE id=$exam_id";
      $exam_result = mysqli_query($conn, $exam_query);
      $exam_row = mysqli_fetch_array($exam_result, MYSQLI_ASSOC);
      $questions_id_array = explode(',', $exam_row['questions_id']);

      $index = array_search($question_id, $questions_id_array);
      if( $index !== FALSE) {
        unset($questions_id_array[$index]);
        if(count($questions_id_array)) {
          $exam_query = "UPDATE exams SET questions_id='". implode(",", $questions_id_array) ."' WHERE id=$exam_id";
        } else {
          $exam_query = "UPDATE exams SET questions_id=NULL WHERE id=$exam_id";
        }
        $exam_result = mysqli_query($conn, $exam_query);
        if($exam_result) {
          $json_data['success'] = true;
        } else {
          $json_data['message'] = 'Oops, something went wrong.';
        }
      }
    } else {
      $new_questions_id = mysqli_real_escape_string($conn, $_POST['questions_id']);
      //Get all questions id
      $exam_query = "SELECT questions_id FROM exams WHERE id=$exam_id";
      $exam_result = mysqli_query($conn, $exam_query);
      $exam_row = mysqli_fetch_array($exam_result, MYSQLI_ASSOC);
      $questions_id_array = !empty($exam_row['questions_id']) ? explode(',', $exam_row['questions_id']) : [];
  
      if(!empty($new_questions_id)) {
        array_push($questions_id_array, $new_questions_id);
      }
      if(count($questions_id_array)) {
        $exam_query = "UPDATE exams SET questions_id='". implode(',', $questions_id_array) ."' WHERE id=$exam_id";
      }else {
        $exam_query = "UPDATE exams SET questions_id=NULL WHERE id=$exam_id";
      }
      $exam_result = mysqli_query($conn, $exam_query);
      
      if($exam_result) {
        $json_data['success'] = true;
      } else {
        $json_data['message'] = 'Oops, something went wrong.';
      }
    }
  } 
  else {
    //$subject_id = mysqli_real_escape_string($conn, $_GET['subject_id']);
    $exam_id = mysqli_real_escape_string($conn, $_GET['exam_id']);
    $exam_query = "SELECT questions_id, subject_id FROM exams WHERE id=$exam_id";
    $exam_result = mysqli_query($conn, $exam_query);
    $exam_row = mysqli_fetch_array($exam_result, MYSQLI_ASSOC);
    $questions_id = $exam_row['questions_id'];
    $subject_id = $exam_row['subject_id'];
    $questions_id_array = explode(',', $questions_id);
    
    $question_query = "SELECT DISTINCT quest.id, quest.question
    FROM exams ex LEFT JOIN questions quest ON ex.subject_id = quest.subject_id
    WHERE quest.id NOT IN ('". implode("','",$questions_id_array) ."') AND quest.subject_id = $subject_id AND quest.deleted_at IS NULL";
    $question_result = mysqli_query($conn, $question_query);
    if($question_result) {
      $json_data['success'] = true;
      $json_data['data'] = [];
      while($question_row = mysqli_fetch_array($question_result, MYSQLI_ASSOC)) {
        array_push($json_data['data'], $question_row);
      }
    } else {
      $json_data['message'] = 'Oops, something went wrong.';
    }
  }
  echo json_encode($json_data);