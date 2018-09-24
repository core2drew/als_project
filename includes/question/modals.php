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
        <input type="hidden" name="user_type" value="<?php echo $_SESSION['type'] ?>" />
        <div class="input question">
          <textarea name="question" placeholder="Question" required></textarea>
        </div>
        <div class="choices">
          <div class="input choice">
            <div class="answer">
              <input type="radio" name="is_answer" value="choice_1" />
              <input type="text" name="choice_1" placeholder="Choice 1" required/>
            </div>
          </div>
          <div class="input choice">
            <div class="answer">
              <input type="radio" name="is_answer" value="choice_2" />
              <input type="text" name="choice_2" placeholder="Choice 2" required/>
            </div>
          </div>
        </div>
        <span class="add button">Add Choice</span>
        
        <div class="input explanation">
          <textarea name="explanation" placeholder="Explanation"></textarea>
        </div>
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