jQuery(document).ready(function($){
    //Upload Video Module
    var learningVideoModule = (function(){
      var uploadVideo = $('#UploadVideo');
      var uploadVideoButton = uploadVideo.find('.upload-btn');
      var uploadFileInput = uploadVideo.find('input[type=file]');
      var uploadTextInput = uploadVideo.find('input[type=text]');
  
      function init(){
        uploadVideoButton.on('click', function(e) {
          e.preventDefault();
          var fileInput = $(this).siblings('input[type=file]').trigger('click');
        })
  
        uploadFileInput.on('change', function(){
          var $this = $(this)
          $filename = $this[0].files[0].name;
          uploadTextInput.val($filename);
        })
      }
  
      return {
        init: init
      }
    })()

    learningVideoModule.init()
})