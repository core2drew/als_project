jQuery(document).ready(function($){
  //Account Module
  var accountModule = (function(){
    var validateCreate, 
        validateUpdate, 
        userType,
        userId,
        currentEmail,
        currentUserId,
        currentProfileImage;

    var $manageAccounts = $('#ManageAccounts')
    var $modalContainer = $(".modal-container.account").not('.profile');
    var $loading = $modalContainer.find('.loading');
    
    //All Modals
    var $modal = $modalContainer.find('.modal');

    var $tableActions = $manageAccounts.find('.table-actions')
    var $accountTable = $manageAccounts.find('.table.accounts');

    var $updateRecordButton = $accountTable.find('.update')
    var $deleteRecordButton = $accountTable.find('.delete')

    var $createRecordButton = $tableActions.find('#CreateAccount')

    //Create
    var $createModal = $modalContainer.find('#CreateModal');
    var $createForm = $createModal.find("#CreateForm");
    var $saveButton = $createModal.find('.create');

    //Update
    var $updateModal = $modalContainer.find('#UpdateModal.account');
    var $updateForm = $updateModal.find(".form");
    var $updateButton = $updateModal.find('.update');

    //Delete
    var $deleteModal = $modalContainer.find('#DeleteModal');
    var $yesDeleteButton = $deleteModal.find('.yes');

    var $profileImage = $modal.find('#ProfileImage');
    var $chooseProfileImageButton = $profileImage.find('.choose-image');
    var $uploadProfileImageInput = $profileImage.find('input[type=file]');
    var $profileImageContainer = $profileImage.find('.image');
    var $showPasswordButton = $modal.find('.show-password');
    
    function showCreateModal(){
      $modalContainer.addClass('active')
      $createModal.show();
    }

    function showUpdateModal() {
      //$loading.addClass('active')
      
      var $this = $(this)
      userId = $this.data('userId');
      userType = $this.data('userType');
      
      var $profileImage = $updateModal.find('.image');
      var $lastName = $updateModal.find('input[name=lastname]');
      var $firstName = $updateModal.find('input[name=firstname]');
      var $address = $updateModal.find('input[name=address]');
      var $contactNo = $updateModal.find('input[name=contactno]');
      var $teacher = $updateModal.find('select[name=teacher_id]');
      var $email = $updateModal.find('input[name=email]');
      var $password = $updateModal.find('input[name=password]');
      
      $.ajax({
        type: "GET",
        url: '/resources/account/account.php',
        data: $.param({
          'id': userId,
          'type': userType
        }),
        success: function(res){
          $loading.removeClass('active')
          if(res.success) {
            $profileImage.attr('src', res.data.profile_image_url)
            $lastName.val(res.data.lastname)
            $firstName.val(res.data.firstname)
            $address.val(res.data.address)
            $contactNo.val(res.data.contactno)
            $teacher.val(res.data.teacher_id)
            $email.val(res.data.email)
            $password.val(res.data.password)

            currentEmail = res.data.email
            currentProfileImage = res.data.profile_image_url
            //Show Modal
            $modalContainer.addClass('active')
            $updateModal.show();
          }
        },
        error: function(err) {
          $loading.removeClass('active')
          console.error("Something went wrong");
        }
      });
    }

    function showDeleteModal(){
      userId = $(this).data('userId'); //get id of selected exam
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

    function hidePassword(){
      $(this).siblings("input[name='password']").attr('type','password')
    }
    
    function showPassword(){
      $(this).siblings("input[name='password']").attr('type','text')
    }

    function chooseImage() {
      $(this).siblings('input[type=file]').trigger('click');
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

    function createRecord(){
      if($createForm.valid()) {
        //$loading.addClass('active')
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

    function updateRecord(){
      currentUserId = $manageAccounts.data('currentUserId')
      if($updateForm.valid()) {
        //$loading.addClass('active')
        var formData = new FormData($updateForm[0]);
        formData.append('id', userId)
        formData.append('current_user_id', currentUserId)
        formData.append('current_email', currentEmail)
        formData.append('profile_image_url', currentProfileImage)
        $.ajax({
          type: "POST",
          url: '/resources/account/update.php',
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
      //$loading.addClass('active')
      var url = '/resources/account/delete.php';
      $.ajax({
        type: "POST",
        url: url,
        data: $.param({'id': userId}),
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

    function init(){
      validateCreate = $createForm.validate({ errorClass: "error-field" })
      validateUpdate = $updateForm.validate({ errorClass: "error-field" })
      
      $createRecordButton.on('click', showCreateModal)
      $updateRecordButton.on('click', showUpdateModal)
      $deleteRecordButton.on('click', showDeleteModal)

      $yesDeleteButton.on('click', deleteRecord)

      $saveButton.on('click', createRecord)
      $updateButton.on('click', updateRecord)

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