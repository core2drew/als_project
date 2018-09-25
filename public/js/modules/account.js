jQuery(document).ready(function($){
  //Account Module
  var accountModule = (function(){
    var validateCreate, validateUpdate;

    var $manageAccounts = $('#ManageAccounts')
    var $modalContainer = $(".modal-container");

    //All Modals
    var $modal = $modalContainer.find('.modal');

    var $tableActions = $manageAccounts.find('.table-actions')

    var $createRecord = $tableActions.find('#CreateAccount')

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

    var $profileImage = $('#ProfileImage');
    var $chooseProfileImageButton = $profileImage.find('.choose-image');
    var $uploadProfileImageInput = $profileImage.find('input[type=file]');
    var $profileImageContainer = $profileImage.find('.image');
    var $showPasswordButton = $('.show-password');
    
    function showCreateModal(){
      $modalContainer.addClass('active')
      $createModal.show();
    }

    function closeModals(){
      $modalContainer.removeClass('active');
      $updateModal.hide();
      $createModal.hide();
      $deleteModal.hide();
      validateCreate.resetForm();
      validateUpdate.resetForm();
    }

    function hidePassword(){
      $(this).siblings("input[name='password']").attr('type','password')
    }
    
    function showPassword(){
      $(this).siblings("input[name='password']").attr('type','text')
    }

    function chooseImage() {
      $(this).siblings('input[type=file]').trigger('click');
    }

    function createRecord(){
      if($createForm.valid()) {
        var formData = new FormData($createForm[0]);
        $.ajax({
          type: "POST",
          url: '/resources/account/add.php',
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

    function imageSelected(){
      var reader = new FileReader();
      if(this.files[0].size>3538500){
        alert("Image Size should not be greater than 3MB");
        helperModule.clearInputFile($uploadProfileImageInput)
        return false;
      }
  
      if(this.files[0].type.indexOf("image") == -1 ){
        alert("Invalid Type");
        helperModule.clearInputFile($uploadProfileImageInput)       
        return false;
      } 
  
      reader.onload = function (e) {
        // get loaded data and render thumbnail.
        $profileImageContainer.attr('src', e.target.result)
      };
  
      reader.readAsDataURL(this.files[0]);
    }

    function init(){
      validateCreate = $createForm.validate({ errorClass: "error-field" })
      validateUpdate = $updateForm.validate({ errorClass: "error-field" })
      
      $createRecord.on('click', showCreateModal)

      $saveButton.on('click', createRecord)

      //Close all modals
      $modal.find('.close').on('click', closeModals)

      $chooseProfileImageButton.on('click', chooseImage)
      $uploadProfileImageInput.on('change', imageSelected)

      $showPasswordButton.mousedown(showPassword);
      $showPasswordButton.mouseup(hidePassword);
    }

    return {
      init: init
    }
  })();

  accountModule.init()
})