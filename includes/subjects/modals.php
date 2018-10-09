<div class="modal-container subject">
  <div id="DeleteModal" class="modal">
    <div class="title">Confirmation</div>
    <div class="content">Are you sure you want to delete this subject?</div>
    <div class="actions">
      <span class="action button yes">Yes</span>
      <span class="action button close">No</span>
    </div>
  </div>

  <div id="CreateModal" class="modal">
    <div class="title">Create Subject</div>
    <div class="content">
      <form id="CreateForm" autocomplete="off" class="form" method="POST">
        <input type="hidden" name="grade_level" value="<?php echo $grade_level ?>" />
        <div class="input">
          <input type='text' name="title" placeholder="Subject Title" required/>
        </div>
      </form>
    </div>
    <div class="actions">
      <span class="action button create">Create</span>
      <span class="action button close">Cancel</span>
    </div>
  </div>

  <div id="UpdateModal" class="modal">
    <div class="title">Update Subject</div>
    <div class="content">
      <form id="UpdateForm" autocomplete="off" class="form" method="POST">
        <div class="input">
          <input type='text' name="title" placeholder="Subject Title" required/>
        </div>
      </form>
    </div>
    <div class="actions">
      <span class="action button update">Update</span>
      <span class="action button close">Cancel</span>
    </div>
  </div>
</div>