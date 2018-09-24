<?php 
  $query = "SELECT title, lesson, reviewer_filename, reviewer_link FROM lessons WHERE id = $lesson_id";
  $result = mysqli_query($conn, $query);
  $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
?>

<div id="UpdateForm" class="form" method="POST">
  <div class="input">
    <h3><?php echo $row['title'] ?></h3>
  </div>
  <div id="LessonEditorContainer">
    <div class="document-editor">
      <!-- <div class="document-editor__toolbar"></div> -->
      <div class="document-editor__editable-container">
          <div class="document-editor__editable">
            <?php echo $row['lesson'] ?>
          </div>
      </div>
    </div>
  </div>
  <?php if(isset($row['reviewer_link'])): ?>
    <a href="<?php echo $row['reviewer_link'] ?>"><?php echo $row['reviewer_filename'] ?></a>
  <?php endif ?>
</div>