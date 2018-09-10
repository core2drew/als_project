jQuery(document).ready(function($){
  // var loginForm = $('#LoginForm')
  // loginForm.submit(function(e){
  //   e.preventDefault()
  //   var form = $(this)
  //   var url = "login.php"
  //   $.ajax({
  //     type: "POST",
  //     url: url,
  //     data: form.serialize(), // serializes the form data.
  //     success: function(data){
  //       if(data.success) {
  //         window.location.href = 'dashboard.php'
  //       } else {
  //         alert(data.message); // show response from the php script
  //       }
  //     },
  //     error: function(err) {
  //       console.log(err.statusText)
  //     }
  //   });
  // })

  //Account
  var profileImage = $('#ProfileImage');
  var uploadProfileImageButton = profileImage.find('.upload-btn');
  var uploadProfileImageInput = profileImage.find('input[type=file]');
  var profileImageContainer = profileImage.find('.image');
  
  uploadProfileImageButton.on('click', function(e){
    e.preventDefault();
    var fileInput = $(this).siblings('input[type=file]').trigger('click');
  })

  uploadProfileImageInput.on('change', function(){
    var reader = new FileReader();
    if(this.files[0].size>528385){
      alert("Image Size should not be greater than 500Kb");
      clearInputFile(uploadProfileImageInput)
      return false;
    }

    if(this.files[0].type.indexOf("image")==-1){
        alert("Invalid Type");
        clearInputFile(uploadProfileImageInput)       
        return false;
    } 

    reader.onload = function (e) {
      // get loaded data and render thumbnail.
      profileImageContainer.attr('src', e.target.result)
    };

    reader.readAsDataURL(this.files[0]);
  })

  var showPassword = $('.show-password');
  showPassword.mousedown(function(e) {
    e.preventDefault();
    $(this).siblings("input[name='password']").attr('type','text')
  });

  showPassword.mouseup(function(e) {
    e.preventDefault();
    $(this).siblings("input[name='password']").attr('type','password')
  });

  //Upload Videos
  var uploadVideo = $('#UploadVideo');
  var uploadVideoButton = uploadVideo.find('.upload-btn');
  var uploadFileInput = uploadVideo.find('input[type=file]');
  var uploadTextInput = uploadVideo.find('input[type=text]');

  function clearInputFile(elem) {
    elem.wrap('<form>').closest('form').get(0).reset();
    elem.unwrap();
    elem.val('');
  }

  uploadVideoButton.on('click', function(e) {
    e.preventDefault();
    var fileInput = $(this).siblings('input[type=file]').trigger('click');
  })

  uploadFileInput.on('change', function(){
    var $this = $(this)
    $filename = $this[0].files[0].name;
    uploadTextInput.val($filename);
  })

  //Questions
  var questionTable = $('#QuestionsTable')
  var addQuestionForm = $("#AddQuestionForm")
  var removeQuestion = questionTable.find('.button.remove')
  var questionWrapper = $("#QuestionWrapper")
  addQuestionForm.submit(function(e){
    e.preventDefault()
    var form = $(this)
    var url = "/resources/question/add.php"
    $.ajax({
      type: "POST",
      url: url,
      data: form.serialize(),
      success: function(data){
        if(data.success) {
          window.location.href = 'question.php'
        } else {
          var message = questionWrapper.find('.message')
          message.empty(); // Remove children elements
          data.data.map(function(d){
            message.append(`<p>${d}</p>`)
          })
        }
      },
      error: function(err) {
        console.log(err)
      }
    });
  })
  
  removeQuestion.click(function(e){
    var url = "/resources/question/delete.php"
    $.ajax({
      type: "POST",
      url: url,
      data: {id: e.target.value},
      success: function(data){
        if(data.success) {
          window.location.href = 'question.php'
        } else {
          //alert(data.message); // show response from the php script
        }
      },
      error: function(err) {
        console.log(err.statusText)
      }
    });
  })
})