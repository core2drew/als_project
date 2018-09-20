<?php 
  // include '../../resources/exam/add.php';

  $link = htmlspecialchars($_SERVER["PHP_SELF"])."?page=examandquestions&sub_page=exams&subject_id=$subject_id";
  $form_action = $link."&action=create";
  $back_link = $link;
?>

<?php if(isset($is_success) && $is_success): ?>
  <div class="message">
    <h1>Exam Created Successfully</h1>
    <a href=<?php echo $back_link ?> >Back</a>
  </div>
<?php else: ?>
  <h1 class='title'>Create Exam Question</h1>
  <form id="ExamForm" class="form" method="POST" action="<?php echo $form_action ?>">
    <input type="hidden" name="subject_id" value="<?php echo isset($_POST['subject_id']) ? $_POST['subject_id'] : $subject_id ?>"/>
    <div class="input">
      <label class="label">Title</label>
      <input type="text" name="title" value="<?php echo isset($_POST['title']) ? $_POST['title'] : '' ?>"/>
      <?php //handleErrorMessage('title', $error_fields) ?>
    </div>
    <div class="input">
      <label class="label">Instruction</label>
      <textarea name="instruction"><?php echo isset($_POST['instruction']) ? $_POST['instruction'] : '' ?></textarea>
      <?php //handleErrorMessage('instruction', $error_fields) ?>
    </div>
    <button id="SaveExam" class='button' type="submit">Create</button>
  </form>
<?php endif; ?>