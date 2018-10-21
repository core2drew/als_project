<?php 
  $query = "SELECT title, lesson, reviewer_filename FROM lessons WHERE id = $lesson_id";
  $result = mysqli_query($conn, $query);
  $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
?>

<form id="UpdateForm" class="form" method="POST">
  <div class="input">
    <input type="text" name="title" placeholder="Title" value="<?php echo $row['title'] ?>" required/>
  </div>
  <div id="LessonEditorContainer">
    <!-- <div class="document-editor">
      <div class="document-editor__toolbar"></div>
      <div class="document-editor__editable-container">
          <div class="document-editor__editable">
            <?php echo $row['lesson'] ?>
          </div>
      </div>
    </div> -->
  </div>
  <div class="input" id="LessonReviewer">
    <input type="text" name="filename" readonly placeholder="Upload Reviewer" value="<?php echo $row['reviewer_filename'] ?>"/>
    <input type="file" name="reviewer_file" accept="application/pdf"/>
    <span class="button upload">Upload</span>
  </div>
  <input type="hidden" name="subject_id" value="<?php echo $subject_id ?>" />
  <input type="hidden" name="lesson_id" value="<?php echo $lesson_id ?>" />
  <span class='button update'>Update</span>
</form>