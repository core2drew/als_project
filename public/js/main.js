jQuery(document).ready(function($){
  jQuery(document).ready(function($){
    //Account Module
    var profileModule = (function(){
      var validateUpdate, 
          userType,
          userId,
          currentEmail,
          currentUserId,
          currentProfileImage,
          sessionId;
      
      var $updateProfileInfo = $('#UpdateProfileInfo')
      var $modalContainer = $(".modal-container.profile");
      var $loading = $modalContainer.find('.loading');
      
      //All Modals
      var $modal = $modalContainer.find('.modal');
  
      //Update
      var $updateModal = $modalContainer.find('#UpdateProfileModal.profile');
      var $updateForm = $updateModal.find(".form");
      var $updateButton = $updateModal.find('.update');
  
      var $profileImage = $modal.find('#UpdateProfileImage');
      var $chooseProfileImageButton = $profileImage.find('.choose-image');
      var $uploadProfileImageInput = $profileImage.find('input[type=file]');
      var $profileImageContainer = $profileImage.find('.image');
      var $showPasswordButton = $modal.find('.show-password');
      
      function showUpdateModal() {
        $loading.addClass('active')
        
        var $this = $(this)
        userId = $this.data('userId');
        userType = $this.data('userType');
        sessionId = $this.data('sessionId');
        
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
  
      function closeModals(){
        $modalContainer.removeClass('active');
        $updateModal.hide();
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
  
      function updateRecord(){
        if($updateForm.valid()) {
          $loading.addClass('active')
          var formData = new FormData($updateForm[0]);
          formData.append('id', userId)
          formData.append('current_user_id', userId)
          formData.append('current_email', currentEmail)
          formData.append('profile_image_url', currentProfileImage)
          formData.append('session_id', sessionId)
          $.ajax({
            type: "POST",
            url: '/resources/account/update-profile.php',
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
  
      function init(){
        validateUpdate = $updateForm.validate({ errorClass: "error-field" })
        
        $updateProfileInfo.on('click', showUpdateModal)
  
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
  
    profileModule.init()
  })
})