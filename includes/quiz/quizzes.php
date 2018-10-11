<?php
  if($_SESSION['type'] !== 'student') {
    $query = "SELECT id, title, questions_id, minutes FROM quizzes WHERE subject_id = $subject_id AND user_id = $user_id AND deleted_at IS NULL";
  } else {
    $query = "SELECT a.id, a.title, a.minutes, a.questions_id, b.taken_at IS NOT NULL as is_taken,
    (select title from subjects where id = a.subject_id) as subject
    from quizzes as a inner join users_has_quiz as b on a.id = b.quiz_id where b.user_id = $user_id and a.deleted_at is null and b.deleted_at is null";
  }
  $result = mysqli_query($conn, $query);
  $count = mysqli_num_rows($result);
?>

<?php if($user_type == 'teacher'): ?>
  <div class="title">
    <h2>Quizzes</h2>
    <a class="button" href="<?php echo $_SERVER['PHP_SELF'] ?>">Back</a>
  </div>
<?php endif ?>

<?php if($user_type == 'teacher'): ?>
  <div class="table-actions">
    <span id='CreateQuiz' class='button'>Create Quiz</span>
  </div>
<?php endif ?>

<?php
  if($count <= 0):
?>
  <div class="no-records">
    <p class="message">No Records</p>
  </div>
<?php else: ?>
  <table class="table quiz">
    <?php if($user_type == 'teacher'): ?>
      <thead>
        <th>Title</th>
        <th>Question Count</th>
        <th>Minutes</th>
        <th class="options">Options</th>
      </thead>
    <?php elseif($user_type == 'student'): ?>
      <thead>
        <th>Subject</th>
        <th>Title</th>
        <th>Items</th>
        <th>Minutes</th>
        <th class="options">Options</th>
      </thead>
    <?php endif ?>
    <tbody>
      <?php
        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
          $id = $row['id'];
          $title = $row['title'];
          $minutes = $row['minutes'];
          $subject = isset($row['subject']) ? $row['subject'] : null;
          $questions_count = empty($row['questions_id']) ? 0 : count(explode(',', $row['questions_id']));
          $is_taken = isset($row['is_taken']) ? $row['is_taken'] : null;
          if($user_type == 'teacher'){
            $questions = "<a class='button view-quiz' href=/teacher/questions.php?subject_id=$subject_id&quiz_id=$id>Questions</a>";
            $assign_quiz = "<span class='button assign' data-quiz-id=$id>Assign</span>";
            $update_quiz = "<span class='button update' data-quiz-id=$id>Update</span>";
            $remove_quiz = "<span class='button delete' data-quiz-id=$id>Remove</span>";
            $table_row =
            "<tr>
              <td>$title</td>
              <td>$questions_count</td>
              <td>$minutes</td>
              <td class='option'>$questions $assign_quiz $update_quiz $remove_quiz</td>
            </tr>";
          } else if ($user_type == 'student') {
            $view_result = "<span class='button view-result' data-quiz-id=$id>View Result</span>";
            $take_quiz = "<span class='button take-quiz' data-quiz-id=$id>Take Quiz</span>";
            $table_action = $is_taken ? $view_result : $take_quiz;
            $table_row =
            "<tr>
              <td>$subject</td>
              <td>$title</td>
              <td>$questions_count</td>
              <td>$minutes</td>
              <td class='option student'>$table_action</td>
            </tr>";
          }
          echo $table_row;
        }
      ?>
    </tbody>
  </table>
<?php endif; ?>