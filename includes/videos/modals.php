<div class="modal-container educational">
  <div class="loading">
    <div class="lds-ripple">
      <div class="ripple"></div>
      <div class="ripple"></div>
    </div>
  </div>
  
  <div id="DeleteModal" class="modal">
    <div class="title">Confirmation</div>
    <div class="content">Are you sure you want to delete this video?</div>
    <div class="actions">
      <span class="action button yes">Yes</span>
      <span class="action button close">No</span>
    </div>
  </div>

  <div id="CreateModal" class="modal educationalvideo">
    <div class="title">Upload Video</div>
    <div class="content">
      <!-- <div class="tabs">
        <span class="tab active" data-tab-action="upload">Upload</span>
        <span class="tab" data-tab-action="link">Link</span>
      </div> -->
      <form id="CreateForm" autocomplete="off" class="form" method="POST">
        <div class="input">
          <input type="text" name="title" placeholder="Title" required/>
        </div>
        <!-- <div class="input" id="UploadVideo">
          <span class="button choose-video">Choose Video</span>
          <input type="text" name="filename" placeholder="Upload Video" readonly required/>
          <input type="file" name="video_file" accept="video/mp4"/>
        </div> -->
        <div class="input" id="SaveLink">
          <input type="hidden" name="filename" value = ""/>
          <input type="text" name="video_link" placeholder="Video Link"/>
        </div>
        <input type="hidden" name="subject_id" value="<?php echo $subject_id ?>" />
      </form>
    </div>
    <div class="actions">
      <span class="action button create">Create</span>
      <span class="action button close">Cancel</span>
    </div>
  </div>

  <div id="UpdateModal" class="modal educationalvideo">
    <div class="title">Update Video</div>
    <div class="content">
      <!-- <div class="tabs">
        <span class="tab" data-tab-action="upload">Upload</span>
        <span class="tab" data-tab-action="link">Link</span>
      </div> -->
      <form id="UpdateForm" autocomplete="off" class="form" method="POST">
        <div class="input">
          <input type="text" name="title" placeholder="Title" required/>
        </div>
        <!-- <div class="input" id="UploadVideo">
          <span class="button choose-video">Choose Video</span>
          <input type="text" name="filename" placeholder="Upload Video" readonly required/>
          <input type="file" name="video_file" accept="video/mp4"/>
        </div> -->
        <div class="input" id="SaveLink">
          <input type="hidden" name="filename" value=""/>
          <input type="text" name="video_link" placeholder="Video Link"/>
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