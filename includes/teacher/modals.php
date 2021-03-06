<div class="modal-container teacher">
  <div id="AssignExamModal" class="modal" data-user-id="<?php echo $_SESSION['user_id'] ?>">
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

  <div id="ExamDetailsModal" class="modal">
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