<?php
  require '../../config/db_connect.php';
  header('Content-Type: application/json');

  $json_data['success'] = false;

  function getQuestionsWithAnswer($questions_id, $user_id, $conn){
    // convert string to array example "1,2,3" to [1,2,3]
    $questions_id = explode(',', $questions_id);
    // format array to string 1','2','3','4
    $questions_id = implode("','", $questions_id);

    //Get current questions of exam
    $question_query = "SELECT DISTINCT quest.id, quest.question, quest.explanation, quest.question_type FROM quizzes quiz 
    LEFT JOIN questions quest ON quiz.subject_id = quest.subject_id
    WHERE quest.id IN ('". $questions_id ."') AND quest.deleted_at IS NULL";

    //Results of query
    $question_result = mysqli_query($conn, $question_query);

    if($question_result) {
      $json_data['success'] = true;
      $json_data['data'] = [];

      while($question_row = mysqli_fetch_array($question_result, MYSQLI_ASSOC)) {
        $data = [];
        $data['id'] = $question_row['id'];
        $data['question'] = $question_row['question'];
        $data['question_type'] = $question_row['question_type'];
        
        if(isset($question_row['explanation']) && !empty($question_row['explanation'])) {
          $data['explanation'] = $question_row['explanation'];
        }

        $data['answers'] = [];
        $answer_query = "SELECT ans.id, ans.answer, ans.is_answer, qr.user_id, qr.fill_in_answer FROM answers as ans LEFT JOIN quiz_records as qr  ON qr.answer_id = ans.id AND qr.user_id = $user_id WHERE ans.question_id = $question_row[id] ORDER BY id ASC";
        $answer_result = mysqli_query($conn, $answer_query);
        while($answer_row = mysqli_fetch_array($answer_result, MYSQLI_ASSOC)) {
          $answer_data = [
            'id' => $answer_row['id'],
            'answer' => $answer_row['answer'],
            'user_answer' => isset($answer_row['user_id']) ? true : false,
            'is_answer' => (int)$answer_row['is_answer'] === 1 ? true : false,
            'fill_in_answer' => isset($answer_row['fill_in_answer']) ? $answer_row['fill_in_answer'] : NULL
          ];
          array_push($data['answers'], $answer_data);
        }
        
        array_push($json_data['data'], $data);
      }
      return $json_data;
    } else {
      $json_data['message'] = 'Oops, something went wrong.';
    }
  }

  if($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = isset($_POST['user_id']) ? mysqli_real_escape_string($conn, $_POST['user_id']) : null;
    $quiz_id = isset($_POST['quiz_id']) ? mysqli_real_escape_string($conn, $_POST['quiz_id']) : null;
    $questions_id = isset($_POST['questions_id']) ? mysqli_real_escape_string($conn, $_POST['questions_id']) : null; 
    $answers = isset($_POST['answers']) ? $_POST['answers'] : [];
    $answers = json_decode($answers);

    foreach($answers as $answer) {
      if(isset($answer)) {
        $question_id = $answer->question_id;
        $answer_id = $answer->answer_id;
        $fill_in_answer = isset($answer->fill_in_answer) ? $answer->fill_in_answer : NULL;
        if($fill_in_answer) {
          $query = "INSERT INTO quiz_records (user_id, quiz_id, question_id, answer_id, fill_in_answer) VALUES ('$user_id', '$quiz_id', '$question_id', '$answer_id', '$fill_in_answer')";
        } else {
          $query = "INSERT INTO quiz_records (user_id, quiz_id, question_id, answer_id) VALUES ('$user_id', '$quiz_id', '$question_id', '$answer_id')";
        }
        
        $result = mysqli_query($conn, $query);
      }
    }

    $json_data = getQuestionsWithAnswer($questions_id, $user_id, $conn);
  }

  echo json_encode($json_data);