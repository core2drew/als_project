<div class="modal-container">
  <div id="DeleteModal" class="modal">
    <div class="title">Confirmation</div>
    <div class="content">Are you sure you want to delete?</div>
    <div class="actions">
      <span class="action button yes">Yes</span>
      <span class="action button no">No</span>
    </div>
  </div>

  <div id="CreateModal" class="modal">
    <div class="title">Create Exam</div>
    <div class="content">
      <form id="CreateForm" class="form" method="POST">
        <input type="hidden" name="subject_id" value="<?php echo $_GET['subject_id'] ?>" />
        <div class="input">
          <label class="label">Title</label>
          <input type="text" name="title" value=""/>
        </div>
        <div class="input">
          <label class="label">Instruction</label>
          <textarea name="instruction"></textarea>
        </div>
        <div class="input">
          <label class="label">Minutes</label>
          <input name="minutes" value=""/>
        </div>
      </form>
    </div>
    <div class="actions">
      <span class="action button create">Create</span>
      <span class="action button no">Cancel</span>
    </div>
  </div>

  <div id="UpdateModal" class="modal">
    <div class="title">Update Exam</div>
    <div class="content">
      <form id="UpdateForm" class="form" method="POST">
        <div class="input">
          <label class="label">Title</label>
          <input type="text" name="title" value=""/>
        </div>
        <div class="input">
          <label class="label">Instruction</label>
          <textarea name="instruction"></textarea>
        </div>
        <div class="input">
          <label class="label">Minutes</label>
          <input name="minutes" value=""/>
        </div>
      </form>
    </div>
    <div class="actions">
      <span class="action button update">Update</span>
      <span class="action button no">Cancel</span>
    </div>
  </div>
  <?php  ?>
  <div id="ExamQuestionModal" class="modal" data-subject-id="<?php echo $subject_id ?>" data-exam-id="<?php echo $_GET['exam_id'] ?>">
    <div class="loading">
      <div class="lds-ripple">
        <div class="ripple"></div>
        <div class="ripple"></div>
      </div>
    </div>
    <div class="title">Add Questions</div>
    <div class="content">
      <table class="table">
        <thead class="header">
          <th>Question</th>
          <th>Include</th>
        </thead>
        <tbody></tbody>
      </table>
      <div class="no-records">
        <h3>No Records</h3>
      </div>
    </div>
    <div class="actions">
      <span class='action button save'>Save</span>
      <span class="action button no">Cancel</span>
    </div>
  </div>
</div>