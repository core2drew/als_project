<div class="modal-container">
  <div id="DeleteModal" class="modal quiz">
    <div class="title">Confirmation</div>
    <div class="content">Are you sure you want to delete this quiz?</div>
    <div class="actions">
      <span class="action button yes">Yes</span>
      <span class="action button close">No</span>
    </div>
  </div>

  <div id="CreateModal" class="modal quiz">
    <div class="title">Create Quiz</div>
    <div class="content">
      <form id="CreateForm" class="form" method="POST">
        <input type="hidden" name="subject_id" value="<?php echo $subject_id ?>" />
        <input type="hidden" name="user_id" value="<?php echo $user_id ?>" />
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

  <div id="UpdateModal" class="modal quiz">
    <div class="title">Update Quiz</div>
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

  <div id="AssignExamModal" class="modal quiz" data-user-id="<?php echo $_SESSION['user_id'] ?>">
    <div class="title">Assign Exam</div>
    <div class="content">
      <table class="table">
        <thead class="header">
          <th>Student Name</th>
          <th>Give Exam</th>
        </thead>
        <tbody></tbody>
      </table>
      <div class="no-records">
        <h3>No Records</h3>
      </div>
    </div>
    <div class="actions">
      <span class="action button close">Close</span>
    </div>
  </div>

  <div id="ExamDetailsModal" class="modal quiz">
    <div class="title">Exam Instruction</div>
    <div class="content">
      <p class="title"></p>
      <p class="minutes"></p>
      <p class="items"></p>
      <p class="instruction"></p>
    </div>
    <div class="actions">
      <span class="action button view">View Exam</span>
      <span class="action button close">Close</span>
    </div>
  </div>
</div>