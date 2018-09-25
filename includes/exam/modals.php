<div class="modal-container">
  <div id="DeleteModal" class="modal">
    <div class="title">Confirmation</div>
    <div class="content">Are you sure you want to delete?</div>
    <div class="actions">
      <span class="action button yes">Yes</span>
      <span class="action button close">No</span>
    </div>
  </div>

  <div id="CreateModal" class="modal exams">
    <div class="title">Create Exam</div>
    <div class="content">
      <form id="CreateForm" class="form" method="POST">
        <input type="hidden" name="subject_id" value="<?php echo $subject_id ?>" />
        <div class="input">
          <input type="text" name="title" placeholder="Title"/>
        </div>
        <div class="input instruction">
          <textarea name="instruction" placeholder="Instruction"></textarea>
        </div>
        <div class="input">
          <input type="text" name="minutes" placeholder="Minutes" />
        </div>
      </form>
    </div>
    <div class="actions">
      <span class="action button create">Create</span>
      <span class="action button close">Cancel</span>
    </div>
  </div>

  <div id="UpdateModal" class="modal exams">
    <div class="title">Update Exam</div>
    <div class="content">
      <form id="UpdateForm" class="form" method="POST">
        <div class="input">
          <input type="text" name="title" placeholder="Title"/>
        </div>
        <div class="input instruction">
          <textarea name="instruction" placeholder="Instruction"></textarea>
        </div>
        <div class="input">
          <input type="text" name="minutes" placeholder="Minutes" />
        </div>
      </form>
    </div>
    <div class="actions">
      <span class="action button update">Update</span>
      <span class="action button close">Cancel</span>
    </div>
  </div>

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
      <span class="action button close">Cancel</span>
    </div>
  </div>

  <div id="ExamViewQuestionModal" class="modal">
    <div class="title">View Question</div>
    <div class="content">
      <div class="question">This is test question</div>
      <div class="choices">
        <span class="choice answer">Choice 1</span>
        <span class="choice">Choice 1</span>
        <span class="choice">Choice 1</span>
        <span class="choice">Choice 1</span>
      </div>
      <div class="explanation">This is a test explanation</div>
    </div>
    <div class="actions">
      <span class="action button close">Close</span>
    </div>
  </div>
</div>