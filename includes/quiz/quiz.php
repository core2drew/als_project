<?php 
    $exam_query= "SELECT title, questions_id, minutes, instruction FROM quizzes WHERE id=$quiz_id AND deleted_at IS NULL";
    $exam_result = mysqli_query($conn, $exam_query);
    $exam_row = mysqli_fetch_array($exam_result, MYSQLI_ASSOC);
    
    $questions_id = isset($exam_row['questions_id']) ? $exam_row['questions_id'] : null; 
    
    $minutes = isset($exam_row['minutes']) ? $exam_row['minutes'] : null; 

    // convert string to array example "1,2,3" to [1,2,3]
    $questions_id = explode(',', $questions_id);
    $items_count = count($questions_id);

    // format array to string 1','2','3','4
    $questions_id = implode(",", $questions_id);
    
    $query = "SELECT * FROM users_has_quiz WHERE user_id=$user_id AND quiz_id=$quiz_id AND deleted_at IS NULL AND taken_at IS NOT NULL";
    $result = mysqli_query($conn, $query);
    $count = mysqli_num_rows($result);

    if($count <= 0) {
      //Update take exam
      if($user_type == 'student') {
        $taken_at = date("Y-m-d H:i:s");
        $take_exam_query= "UPDATE users_has_quiz SET taken_at = '$taken_at' WHERE user_id=$user_id AND quiz_id=$quiz_id AND deleted_at IS NULL";
        $take_exam_result = mysqli_query($conn, $take_exam_query);
      }
    }
?>

<?php if($user_type == 'teacher'): ?>
  <div class="title">
      <a class="button" href="<?php echo "$_SERVER[PHP_SELF]?subject_id=$subject_id" ?>">Back</a>
  </div>
<?php endif ?>

<?php if($user_type == 'student' && $count <= 0): ?>
  <div id="CountDown" data-quiz-minutes="<?php echo $minutes ?>">
    <h3 class="minutes"><?php echo '00:'.$minutes.':00' ?></h3>
  </div>
  <div id="QuizQuestions" data-quiz-id="<?php echo $quiz_id ?>" data-questions-id="<?php echo $questions_id ?>" data-user-id=<?php echo $user_id ?>></div>
  <div id="SubmitQuiz" class="button">Submit</div>
<?php else: ?>
  <div id="QuizQuestionsAnswers" data-quiz-id="<?php echo $quiz_id ?>" data-questions-id="<?php echo $questions_id ?>" data-user-id=<?php echo $user_id ?>></div>
<?php endif ?>

<?php if($user_type == 'teacher'): ?>
  <div id="QuizQuestions" data-quiz-id="<?php echo $quiz_id ?>" data-questions-id="<?php echo $questions_id ?>" data-user-id=<?php echo $user_id ?>></div>
<?php endif ?>