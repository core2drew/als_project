jQuery(document).ready(function($){
    //Upload Video Module
    var learningVideoModule = (function(){
      var videoId,
          validateCreate,
          validateUpdate,
          currentFilename;
      var uploadOption = 'upload';

      var $manageEducationalVideos= $("#ManageEducationalVideos");
      var $modalContainer = $(".modal-container.educational").not('.profile');
      var $loading = $modalContainer.find('.loading');

      //All Modals
      var $modal = $modalContainer.find('.modal');

      var $tableActions = $manageEducationalVideos.find('.table-actions');
      var $videosTable = $manageEducationalVideos.find('.table.educationalvideo');

      //Table Actions
      var $uploadVideoButton = $tableActions.find('#UploadVideo');

      //Table Item Action
      var $updateRecordButton = $videosTable.find('.update');
      var $deleteRecordButton = $videosTable.find('.delete');
      var $viewRecordButton = $videosTable.find('.view');

      //Create
      var $createModal = $modalContainer.find('#CreateModal');
      var $createForm = $createModal.find("#CreateForm");
      var $saveButton = $createModal.find('.create');

      var $createUploadFileInput = $createForm.find('input[type=file]');
      var $createUploadFilename = $createForm.find('input[name=filename]');
      var $createUploadVideoLink = $createForm.find('input[name=video_link]');

      //Update
      var $updateModal = $modalContainer.find('#UpdateModal');
      var $updateForm = $updateModal.find(".form");
      var $updateButton = $updateModal.find('.update');

      //Modal Actions
      var $tab = $modal.find('.tab');
      var $chooseVideo = $modal.find('.choose-video');
      var $uploadFileInput = $modal.find('input[type=file]');
      var $uploadFilename = $modal.find('input[name=filename]');
      var $uploadVideoLink = $modal.find('input[name=video_link]');

      //View
      var $viewModal = $modalContainer.find('#ViewModal');
      var $viewModalVideo = $viewModal.find('video').get(0);
      var $viewModalVideoSource = $viewModal.find('source');

      //Delete Exam
      var $deleteModal = $modalContainer.find('#DeleteModal');
      var $yesDeleteButton = $deleteModal.find('.yes');

      function showCreateModal(){
        $modalContainer.addClass('active')
        $createModal.show();
      }

      function showUpdateModal() {
        $loading.addClass('active')
        var url = '/resources/educationalvideo';
        var $title = $updateModal.find('input[name=title]');
        var $filename = $updateModal.find('input[name=filename]');
        var $video_link = $updateModal.find('input[name=video_link]');
        var $uploadVideo = $updateModal.find('#UploadVideo');
        var $saveLink = $updateModal.find('#SaveLink');
        var $tab = $updateModal.find('.tab');
        
        videoId = $(this).data('videoId'); //get id of selected record
        
        //Display selected record details
        $.ajax({
          type: "GET",
          url: url,
          data: $.param({'id': videoId}),
          success: function(res){
            if(res.success) {
              $loading.removeClass('active')
              if(res.data.type === 'upload') {
                $tab.eq(0).addClass('active')
                $uploadVideo.show();
                $saveLink.hide();
                $uploadFilename.rules('add', { required: true })
                $uploadVideoLink.rules('add', { required: false })
              } else if (res.data.type === 'link') {
                $tab.eq(1).addClass('active')
                $uploadVideo.hide();
                $saveLink.css('display','flex');
                $uploadFilename.rules('add', { required: false })
                $uploadVideoLink.rules('add', { required: true })
              }
              currentFilename = res.data.filename;
              $title.val(res.data.title)
              $filename.val(res.data.filename)
              $video_link.val(res.data.video_link)
              uploadOption = res.data.type

              //Show Modal
              $modalContainer.addClass('active')
              $updateModal.show();
            }
          },
          error: function(err) {
            console.error("Something went wrong");
          }
        });
      }
  
      function showDeleteModal(){
        videoId = $(this).data('videoId'); //get id of selected exam
        $modalContainer.addClass('active')
        $deleteModal.show();
      }

      function createRecord(){
        if($createForm.valid()) {
          $loading.addClass('active')
          var formData = new FormData($createForm[0]);
          formData.append('upload_option', uploadOption)

          $.ajax({
            type: "POST",
            url: '/resources/educationalvideo/add.php',
            data: formData,
            contentType: false, // NEEDED, DON'T OMIT THIS (requires jQuery 1.6+)
            processData: false, // NEEDED, DON'T OMIT THIS
            success: function(res){
              $loading.removeClass('active')
              if(res.success) {
                //show modal created success
                //modal go to lesson table
                location.reload();
              }
            },
            error: function(err) {
              console.error("Something went wrong");
            }
          });
        }
      }

      function updateRecord(){
        if($updateForm.valid()) {
          var formData = new FormData($updateForm[0]);
          formData.append('upload_option', uploadOption)
          formData.append('id', videoId)
          formData.append('current_file_name', currentFilename)
          $.ajax({
            type: "POST",
            url: '/resources/educationalvideo/update.php',
            data: formData,
            contentType: false, // NEEDED, DON'T OMIT THIS (requires jQuery 1.6+)
            processData: false, // NEEDED, DON'T OMIT THIS
            success: function(res){
              if(res.success) {
                //show modal created success
                //modal go to lesson table
                location.reload();
              }
            },
            error: function(err) {
              console.error("Something went wrong");
            }
          });
        }
      }

      function deleteRecord() {
        $loading.addClass('active')
        var url = '/resources/educationalvideo/delete.php';
        $.ajax({
          type: "POST",
          url: url,
          data: $.param({'id': videoId}),
          success: function(res){
            if(res.success) {
              $loading.removeClass('active')
              location.reload();
            }
          },
          error: function(err) {
            console.error("Something went wrong");
          }
        });
      }

      function showViewModal() {
        var url = '/resources/educationalvideo';
        videoId = $(this).data('videoId'); //get id of selected record
        $.ajax({
          type: "GET",
          url: url,
          data: $.param({'id': videoId}),
          success: function(res){
            if(res.success) {
              $viewModalVideoSource.attr('src', res.data.video_link)
              $viewModalVideo.load()
              $viewModalVideo.play()
              //Show Modal
              $modalContainer.addClass('active')
              $viewModal.show();
            }
          },
          error: function(err) {
            console.error("Something went wrong");
          }
        });
      }

      function changeTab() {
        var $this = $(this)
        var $saveLink = $modal.find('#SaveLink')
        var $uploadVideo = $modal.find("#UploadVideo")
        var action = $this.data('tabAction')
        $this.siblings().removeClass('active')
        $this.addClass('active')
        
        if(action == 'upload') {
          $uploadVideo.show();
          $saveLink.hide();
          $uploadFilename.rules('add', { required: true })
          $uploadVideoLink.rules('add', { required: false })
         
        } else if (action == 'link') {
          $uploadVideo.hide();
          $saveLink.css('display','flex');
          $uploadFilename.rules('add', { required: false })
          $uploadVideoLink.rules('add', { required: true })
        }
        uploadOption = action
        resetForm()
      }

      function resetTab() {
        var $tab = $modal.find('.tab')
        var $saveLink = $modal.find('#SaveLink')
        var $uploadVideo = $modal.find("#UploadVideo")
        $tab.removeClass('active')
        $tab.eq(0).addClass('active')
        $uploadVideo.show();
        $saveLink.hide();
        uploadOption = 'upload'
        resetForm()
      }

      function resetForm() {
        helperModule.clearInputFile($createUploadFileInput)
        helperModule.clearInputFile($createUploadFilename)
        helperModule.clearInputFile($createUploadVideoLink)
        validateCreate.resetForm();
        validateUpdate.resetForm();
      }

      function closeModals(){
        $modalContainer.removeClass('active');
        $createModal.hide();
        $updateModal.hide();
        $deleteModal.hide();
        $viewModal.hide();
        $viewModalVideo.pause()
        //resetTab()
      }
      
      function init(){
        validateCreate = $createForm.validate({ errorClass: "error-field" })
        validateUpdate = $updateForm.validate({ errorClass: "error-field" })
        $tab.on('click', changeTab)

        //Close all modals
        $modal.find('.close').on('click', closeModals)

        //Show Modal
        $uploadVideoButton.on('click', showCreateModal)
        $updateRecordButton.on('click', showUpdateModal)
        $deleteRecordButton.on('click', showDeleteModal)
        $viewRecordButton.on('click', showViewModal)

        $saveButton.on('click', createRecord)
        $updateButton.on('click', updateRecord)
        $yesDeleteButton.on('click', deleteRecord)

        $chooseVideo.on('click', function(e) {
          e.preventDefault();
          var fileInput = $(this).siblings('input[type=file]').trigger('click');
        })
  
        $uploadFileInput.on('change', function(){
          var $this = $(this)
          $filename = $this[0].files[0].name;
          $uploadFilename.val($filename);
        })
      }
      
      return {
        init: init
      }
    })()

    learningVideoModule.init()
})