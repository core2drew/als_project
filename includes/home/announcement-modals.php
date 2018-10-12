
<div class="modal-container announcement">
  <div class="loading">
    <div class="lds-ripple">
      <div class="ripple"></div>
      <div class="ripple"></div>
    </div>
  </div>
  <div id="DeleteModal" class="modal announcement">
    <div class="title">Confirmation</div>
    <div class="content">Are you sure you want to delete this announcement?</div>
    <div class="actions">
      <span class="action button yes">Yes</span>
      <span class="action button close">No</span>
    </div>
  </div>

  <div id="CreateModal" class="modal announcement">
    <div class="title">Create Announcement</div>
    <div class="content">
      <form id="CreateForm" autocomplete="off" class="form" method="POST">
        <div class="input">
          <input name="title" class='title' placeholder="Title" required />
        </div>
        <div class="input">
          <textarea name="announcement" placeholder="Announcement" required></textarea>
        </div>
        <input type="hidden" name="user_id" value=<?php echo $user_id ?> />
      </form>
    </div>
    <div class="actions">
      <span class="action button create">Create</span>
      <span class="action button close">Cancel</span>
    </div>
  </div>

  <div id="UpdateModal" class="modal announcement">
    <div class="title">Update Announcement</div>
    <div class="content">
      <form id="UpdateForm" autocomplete="off" class="form" method="POST">
        <div class="input">
          <input name="title" class='title' placeholder="Title" required />
        </div>
        <div class="input">
          <textarea class="announcement" name="announcement" placeholder="Announcement" required></textarea>
        </div>
      </form>
    </div>
    <div class="actions">
      <span class="action button update">Update</span>
      <span class="action button close">Cancel</span>
    </div>
  </div>
</div>