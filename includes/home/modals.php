<div class="modal-container">
  <div id="DeleteModal" class="modal">
    <div class="title">Confirmation</div>
    <div class="content">Are you sure you want to delete this activity?</div>
    <div class="actions">
      <span class="action button yes">Yes</span>
      <span class="action button close">No</span>
    </div>
  </div>

  <div id="CreateModal" class="modal account">
    <div class="title">Create Activity</div>
    <div class="content">
      <form id="CreateForm" autocomplete="off" class="form" method="POST">
        <div class="input">
          <input name="title" class='title' placeholder="Title" required />
        </div>
        <div class="input" id="ActivityImage">
          <div class="image-viewer" style="background-image:url(/public/images/slider-placeholder-image.jpg)"></div>
          <img class="image" src="/public/images/slider-placeholder-image.jpg" />
          <input type="file" name="activity_image" accept="image/*" />
          <span class="button choose-image">Choose Image</span>
        </div>
        <div class="input">
          <textarea name="description" placeholder="Description" required></textarea>
        </div>
      </form>
    </div>
    <div class="actions">
      <span class="action button create">Create</span>
      <span class="action button close">Cancel</span>
    </div>
  </div>

  <div id="UpdateModal" class="modal account">
    <div class="title">Update Activity</div>
    <div class="content">
      <form id="UpdateForm" autocomplete="off" class="form" method="POST">
        <div class="input">
          <input name="title" class='title' placeholder="Title" required />
        </div>
        <div class="input" id="ActivityImage">
          <div class="image-viewer" style="background-image:url(/public/images/slider-placeholder-image.jpg)"></div>
          <img class="image" src="/public/images/slider-placeholder-image.jpg" />
          <input type="file" name="activity_image" accept="image/*" />
          <span class="button choose-image">Choose Image</span>
        </div>
        <div class="input">
          <textarea class="description" name="description" placeholder="Description" required></textarea>
        </div>
      </form>
    </div>
    <div class="actions">
      <span class="action button update">Update</span>
      <span class="action button close">Cancel</span>
    </div>
  </div>
</div>