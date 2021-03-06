<form id="CreateForm" class="form" method="POST" autocomplete="off">
  <div class="input">
    <input type="text" name="title" placeholder="Title" required/>
  </div>
  <div id="LessonEditorContainer">
    <!-- <div class="document-editor">
      <div class="document-editor__toolbar"></div>
      <div class="document-editor__editable-container">
          <div class="document-editor__editable"></div>
      </div>
    </div> -->
  </div>
  <div class="input" id="LessonReviewer">
    <input type="text" name="filename" placeholder="Upload Reviewer" readonly />
    <input type="file" name="reviewer_file" accept="application/pdf"/>
    <span class="button upload">Upload</span>
  </div>
  <input type="hidden" name="subject_id" value="<?php echo $subject_id ?>" />
  <span class='button create'>Create</span>
</form>