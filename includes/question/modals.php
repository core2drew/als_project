<div class="modal-container">
  <div id="DeleteModal" class="modal">
    <div class="title">Confirmation</div>
    <div class="content">Are you sure you want to delete this question?</div>
    <div class="actions">
      <span class="action button yes">Yes</span>
      <span class="action button close">No</span>
    </div>
  </div>

  <div id="CreateModal" class="modal">
    <div class="title">Create Question</div>
    <div class="content">
      <form id="CreateForm" autocomplete="off" class="form" method="POST">
        <input type="hidden" name="subject_id" value="<?php echo $subject_id ?>" />
        <div class="input question">
          <label class="label">Question</label>
          <textarea name="question" required></textarea>
        </div>
        <div class="choices">
          <div class="input choice">
            <label class="label">Choice 1</label>
            <input type="text" name="choice_1" required/>
          </div>
          <div class="input choice">
            <label class="label">Choice 2</label>
            <input type="text" name="choice_2" required/>
          </div>
        </div>
        <span class="add button">Add Choice</span>
      </form>
    </div>
    <div class="actions">
      <span class="action button create">Create</span>
      <span class="action button close">Cancel</span>
    </div>
  </div>

  <div id="ViewQuestionModal" class="modal">
    <div class="title">View Question</div>
    <div class="content">
      <div class="question"></div>
      <div class="choices"></div>
      <div class="explanation"></div>
    </div>
    <div class="actions">
      <span class="action button close">Close</span>
    </div>
  </div>
</div>