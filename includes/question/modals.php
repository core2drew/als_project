<div class="modal-container">
  <div id="DeleteModal" class="modal">
    <div class="title">Confirmation</div>
    <div class="content">Are you sure you want to delete this question?</div>
    <div class="actions">
      <span class="action button yes">Yes</span>
      <span class="action button close">No</span>
    </div>
  </div>

  <div id="CreateModal" class="modal questions">
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
        <span class="add button">
          <svg version="1.1" class="icon" x="0px" y="0px" viewBox="0 0 31.059 31.059" style="enable-background:new 0 0 31.059 31.059;" xml:space="preserve">
            <g>
              <g>
                <path d="M15.529,31.059C6.966,31.059,0,24.092,0,15.529C0,6.966,6.966,0,15.529,0
                  c8.563,0,15.529,6.966,15.529,15.529C31.059,24.092,24.092,31.059,15.529,31.059z M15.529,1.774
                  c-7.585,0-13.755,6.171-13.755,13.755s6.17,13.754,13.755,13.754c7.584,0,13.754-6.17,13.754-13.754S23.113,1.774,15.529,1.774z"
                  />
              </g>
              <g>
                <path d="M21.652,16.416H9.406c-0.49,0-0.888-0.396-0.888-0.887c0-0.49,0.397-0.888,0.888-0.888h12.246
                  c0.49,0,0.887,0.398,0.887,0.888C22.539,16.02,22.143,16.416,21.652,16.416z"/>
              </g>
              <g>
                <path d="M15.529,22.539c-0.49,0-0.888-0.397-0.888-0.887V9.406c0-0.49,0.398-0.888,0.888-0.888
                  c0.49,0,0.887,0.398,0.887,0.888v12.246C16.416,22.143,16.02,22.539,15.529,22.539z"/>
              </g>
            </g>
          </svg>
          Add Choice
        </span>
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