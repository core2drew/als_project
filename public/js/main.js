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

  var showPassword = $('.show-password');
  showPassword.mousedown(function(e) {
    e.preventDefault();
    $(this).siblings("input[name='password']").attr('type','text')
  });

  showPassword.mouseup(function(e) {
    e.preventDefault();
    $(this).siblings("input[name='password']").attr('type','password')
  });


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