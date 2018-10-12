jQuery(document).ready(function($){
  //Account Module
  var activityModule = (function(){
    var validateCreate, validateUpdate, activityId, currentSliderImage;

    var $manageAccounts = $('#ManageHome')
    var $modalContainer = $(".modal-container.activity").not('.profile');

    var $tableActions = $manageAccounts.find('.table-actions')
    var $activityTable = $manageAccounts.find('.table.activities');
    var $modal = $modalContainer.find('.modal');

    var $createRecordButton = $tableActions.find('#CreateActivity')

    var $updateRecordButton = $activityTable.find('.update')
    var $deleteRecordButton = $activityTable.find('.delete')

    //Create
    var $createModal = $modalContainer.find('#CreateModal');
    var $createForm = $createModal.find("#CreateForm");
    var $saveButton = $createModal.find('.create');

    //Update
    var $updateModal = $modalContainer.find('#UpdateModal');
    var $updateForm = $updateModal.find(".form");
    var $updateButton = $updateModal.find('.update');

    //Delete
    var $deleteModal = $modalContainer.find('#DeleteModal');
    var $yesDeleteButton = $deleteModal.find('.yes');

    var $activityImage = $modal.find('#ActivityImage');
    var $chooseImageButton = $activityImage.find('.choose-image');
    var $uploadImageInput = $activityImage.find('input[type=file]');
    var $imageViewContainer = $activityImage.find('.image-viewer');
    var $imageContainer = $activityImage.find('.image');

    function chooseImage() {
      $(this).siblings('input[type=file]').trigger('click');
    }

    function imageSelected(){
      var reader = new FileReader();
      if(this.files[0].size>3538500){
        alert("Image Size should not be greater than 3MB");
        helperModule.clearInputFile($uploadImageInput)
        return false;
      }
  
      if(this.files[0].type.indexOf("image") == -1 ){
        alert("Invalid Type");
        helperModule.clearInputFile($uploadImageInput)       
        return false;
      }
  
      reader.onload = function (e) {
        $imageContainer.attr('src', e.target.result)
        $imageViewContainer.attr('style', `background-image:url(${e.target.result})`)
      };
  
      reader.readAsDataURL(this.files[0]);
    }

    function showCreateModal(){
      $modalContainer.addClass('active')
      $createModal.show();
    }

    function showUpdateModal() {
      var $this = $(this)
      activityId = $this.data('activityId');
      
      var $title = $updateModal.find('.title');
      var $sliderImage = $updateModal.find('.image');
      var $sliderViewerImage = $updateModal.find('.image-viewer');
      var $description = $updateModal.find('.description');
      
      $.ajax({
        type: "GET",
        url: '/resources/activity/activity.php',
        data: $.param({
          'id': activityId
        }),
        success: function(res){
          if(res.success) {
            $title.val(res.data.title)
            $sliderImage.attr('src', res.data.image_url)
            $sliderViewerImage.attr('style', `background-image:url(${res.data.image_url})`)
            $description.val(res.data.description)
            //Show Modal
            currentSliderImage = res.data.image_url
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
      activityId = $(this).data('activityId'); //get id of selected exam
      $modalContainer.addClass('active')
      $deleteModal.show();
    }

    function closeModals(){
      $modalContainer.removeClass('active');
      $updateModal.hide();
      $createModal.hide();
      $deleteModal.hide();
      validateCreate.resetForm();
      validateUpdate.resetForm();
    }

    function createRecord(){
      if($createForm.valid()) {
        var formData = new FormData($createForm[0]);
        $.ajax({
          type: "POST",
          url: '/resources/activity/add.php',
          data: formData,
          contentType: false, // NEEDED, DON'T OMIT THIS (requires jQuery 1.6+)
          processData: false, // NEEDED, DON'T OMIT THIS
          success: function(res){
            if(res.success) {
              //show modal created success
              //modal go to lesson table
              location.reload();
            }
            else {
              alert(res.message)
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
        formData.append('id', activityId)
        formData.append('slider_image_url', currentSliderImage)
        $.ajax({
          type: "POST",
          url: '/resources/activity/update.php',
          data: formData,
          contentType: false, // NEEDED, DON'T OMIT THIS (requires jQuery 1.6+)
          processData: false, // NEEDED, DON'T OMIT THIS
          success: function(res){
            if(res.success) {
              //show modal created success
              //modal go to lesson table
              location.reload();
            }
            else {
              alert(res.message)
            }
          },
          error: function(err) {
            console.error("Something went wrong");
          }
        });
      }
    }

    function deleteRecord() {
      var url = '/resources/activity/delete.php';
      $.ajax({
        type: "POST",
        url: url,
        data: $.param({'id': activityId}),
        success: function(res){
          if(res.success) {
            location.reload();
          }
        },
        error: function(err) {
          console.error("Something went wrong");
        }
      });
    }

    function init() {
      validateCreate = $createForm.validate({ errorClass: "error-field" })
      validateUpdate = $updateForm.validate({ errorClass: "error-field" })

      $createRecordButton.on('click', showCreateModal)
      $saveButton.on('click', createRecord)

      $updateRecordButton.on('click', showUpdateModal)

      $deleteRecordButton.on('click', showDeleteModal)
      $yesDeleteButton.on('click', deleteRecord)

      $updateButton.on('click', updateRecord)

      //Close all modals
      $modal.find('.close').on('click', closeModals)

      $chooseImageButton.on('click', chooseImage)
      $uploadImageInput.on('change', imageSelected)
    }

    return {
      init: init
    }
  })()

  activityModule.init()
})