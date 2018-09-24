<div class="modal-container">
  <div id="DeleteModal" class="modal">
    <div class="title">Confirmation</div>
    <div class="content">Are you sure you want to delete this video?</div>
    <div class="actions">
      <span class="action button yes">Yes</span>
      <span class="action button close">No</span>
    </div>
  </div>

  <div id="CreateModal" class="modal">
    <div class="title">Upload Video</div>
    <div class="content">
      <div class="tabs">
        <span class="tab active" data-tab-action="upload">Upload</span>
        <span class="tab" data-tab-action="link">Link</span>
      </div>
      <form id="CreateForm" autocomplete="off" class="form" method="POST">
        <div class="input">
          <label class="label">Title</label>
          <input type="text" name="title" value="" required/>
        </div>
        <div class="input" id="UploadVideo">
          <label class="label">Upload Video</label>
          <input type="text" name="filename" readonly required/>
          <input type="file" name="video_file" accept="video/mp4"/>
          <span class="button browse-video">Upload</span>
        </div>
        <div class="input" id="SaveLink">
          <label class="label">Video Link</label>
          <input type="hidden" name="filename" value="" />
          <input type="text" name="video_link"/>
        </div>
        <input type="hidden" name="subject_id" value="<?php echo $subject_id ?>" />
      </form>
    </div>
    <div class="actions">
      <span class="action button create">Create</span>
      <span class="action button close">Cancel</span>
    </div>
  </div>

  <div id="UpdateModal" class="modal">
    <div class="title">Update Video</div>
    <div class="content">
      <div class="tabs">
        <span class="tab" data-tab-action="upload">Upload</span>
        <span class="tab" data-tab-action="link">Link</span>
      </div>
      <form id="UpdateForm" autocomplete="off" class="form" method="POST">
        <div class="input">
          <label class="label">Title</label>
          <input type="text" name="title" value="" required/>
        </div>
        <div class="input" id="UploadVideo">
          <label class="label">Upload Video</label>
          <input type="text" name="filename" readonly required/>
          <input type="file" name="video_file" accept="video/mp4"/>
          <span class="button browse-video">Upload</span>
        </div>
        <div class="input" id="SaveLink">
          <label class="label">Video Link</label>
          <input type="hidden" name="filename" value=""/>
          <input type="text" name="video_link"/>
        </div>
        <input type="hidden" name="video_id" value="<?php echo $video_id ?>" />
      </form>
    </div>
    <div class="actions">
      <span class="action button update">Update</span>
      <span class="action button close">Cancel</span>
    </div>
  </div>

  <div id="ViewModal" class="modal">
    <!-- <div class="title">Watch Educational Video</div> -->
    <div class="content">
      <video width="100%" height="100%" controls>
        <source src="" type="video/mp4">
        Your browser does not support the video tag.
      </video>
    </div>
    <div class="actions">
      <span class="action button close">Close</span>
    </div>
  </div>
</div>