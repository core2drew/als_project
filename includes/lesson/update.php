<?php 
  $query = "SELECT lessons.title, lessons.lesson FROM lessons WHERE lessons.id = $lesson_id";
  $result = mysqli_query($conn, $query);
  $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
?>

<form id="UpdateForm" class="form" method="POST">
  <div class="input">
    <label class="label">Title</label>
    <input type="text" name="title" value="<?php echo $row['title'] ?>"/>
  </div>
  <div id="LessonEditorContainer">
    <div class="document-editor">
      <div class="document-editor__toolbar"></div>
      <div class="document-editor__editable-container">
          <div class="document-editor__editable">
            <?php echo $row['lesson'] ?>
          </div>
      </div>
    </div>
  </div>
  <input type="hidden" name="subject_id" value="<?php echo $subject_id ?>" />
  <input type="hidden" name="lesson_id" value="<?php echo $lesson_id ?>" />
  <span class='button update'>Update</span>
</form>