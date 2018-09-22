<?php
  require '../../config/db_connect.php';
  header('Content-Type: application/json');

  $json_data['success'] = false;

  $id = mysqli_real_escape_string($conn, $_GET['id']);

  //Get selected question data
  $question_query = "SELECT id, question, explanation FROM questions WHERE id=$id AND deleted_at IS NULL";
  $question_result = mysqli_query($conn, $question_query);
  $question_row = mysqli_fetch_array($question_result, MYSQLI_ASSOC);

  //Get answers data
  $answer_query = "SELECT id, answer, is_answer FROM answers WHERE question_id=$id ORDER BY id";
  $answer_result = mysqli_query($conn, $answer_query);

  if($question_result) {
    $json_data['success'] = true;
    $json_data['data']['question'] = $question_row['question'];
    $json_data['data']['explanation'] = $question_row['explanation'];

    while($answer_row = mysqli_fetch_array($answer_result, MYSQLI_ASSOC)) {
      $json_data['data']['answers'][] = array('answer' => $answer_row['answer'], 'is_answer' => $answer_row['is_answer'] ? true : false);
    }
  } else {
    $json_data['message'] = 'Oops, something went wrong.';
  }

echo json_encode($json_data);