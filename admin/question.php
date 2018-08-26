<?php
  include '../includes/html/head.php';
  include '../check_session.php';
  if(!isset($_SESSION['user_type']) || $_SESSION['user_type'] == 'student') {
    echo 'Students are not allowed to enter this page.';
    die();
  }
?>
  <div id="QuestionWrapper" class="wrapper">
    <h1>Question</h1>
    <h3>Add Question</h3>

    <div class="message"></div>
    <form method="POST" id="AddQuestionForm">
      <p>
        <textarea name="question"><?php echo isset($_POST['question']) ? $_POST['question'] : '' ?></textarea>
      </p>
      <p>
        <input type="text" name="choice_1" value="<?php echo isset($_POST['choice_1']) ? $_POST['choice_1'] : '' ?>" />
      </p>
      <p>
        <input type="text" name="choice_2" value="<?php echo isset($_POST['choice_2']) ? $_POST['choice_2'] : '' ?>" />
      </p>
      <p>
        <input type="text" name="choice_3" value="<?php echo isset($_POST['choice_3']) ? $_POST['choice_3'] : '' ?>" />
      </p>
      <p>
        <input type="text" name="choice_4" value="<?php echo isset($_POST['choice_4']) ? $_POST['choice_4'] : '' ?>" />
      </p>
      <button type="submit">Add</button>
    </form>
    <?php
      include '../includes/question/questions.php'
    ?>
  </div>
<?php
  include '../includes/html/footer.php';
?>