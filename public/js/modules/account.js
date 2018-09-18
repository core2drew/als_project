jQuery(document).ready(function($){
  //Account Module
  var accountModule = (function(){
    var profileImage = $('#ProfileImage');
    var uploadProfileImageButton = profileImage.find('.upload-btn');
    var uploadProfileImageInput = profileImage.find('input[type=file]');
    var profileImageContainer = profileImage.find('.image');
    var showPassword = $('.show-password');

    function init() {
      uploadProfileImageButton.on('click', function(e){
        e.preventDefault();
        var fileInput = $(this).siblings('input[type=file]').trigger('click');
      })

      uploadProfileImageInput.on('change', function(){
        var reader = new FileReader();
        if(this.files[0].size>528385){
          alert("Image Size should not be greater than 500Kb");
          helperModule.clearInputFile(uploadProfileImageInput)
          return false;
        }
    
        if(this.files[0].type.indexOf("image")==-1){
            alert("Invalid Type");
            helperModule.clearInputFile(uploadProfileImageInput)       
            return false;
        } 
    
        reader.onload = function (e) {
          // get loaded data and render thumbnail.
          profileImageContainer.attr('src', e.target.result)
        };
    
        reader.readAsDataURL(this.files[0]);
      })
      
      showPassword.mousedown(function(e) {
        e.preventDefault();
        $(this).siblings("input[name='password']").attr('type','text')
      });

      showPassword.mouseup(function(e) {
        e.preventDefault();
        $(this).siblings("input[name='password']").attr('type','password')
      });
    }

    return {
      init: init
    }
  })();

  accountModule.init();
})