jQuery(document).ready(function($){
  function clearInputFile(elem) {
    elem.wrap('<form>').closest('form').get(0).reset();
    elem.unwrap();
    elem.val('');
  }

  //Lesson

   //Upload PDF
   var PDFLesson = $('#PDFLesson');
   var uploadPDFLessonButton = PDFLesson.find('.upload-btn');
   var uploadPDFLessonInput = PDFLesson.find('input[type=file]');
   var uploadPDFLessonTextInput = PDFLesson.find('input[type=text]');
 
   uploadPDFLessonButton.on('click', function(e) {
     e.preventDefault();
     console.log("test")
     var fileInput = $(this).siblings('input[type=file]').trigger('click');
   })
 
   uploadPDFLessonInput.on('change', function(){
     var $this = $(this)
     $filename = $this[0].files[0].name;
     uploadPDFLessonTextInput.val($filename);
   })

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
  // var questionTable = $('#QuestionsTable')
  // var addQuestionForm = $("#AddQuestionForm")
  // var removeQuestion = questionTable.find('.button.remove')
  // var questionWrapper = $("#QuestionWrapper")
  // addQuestionForm.submit(function(e){
  //   e.preventDefault()
  //   var form = $(this)
  //   var url = "/resources/question/add.php"
  //   $.ajax({
  //     type: "POST",
  //     url: url,
  //     data: form.serialize(),
  //     success: function(data){
  //       if(data.success) {
  //         window.location.href = 'question.php'
  //       } else {
  //         var message = questionWrapper.find('.message')
  //         message.empty(); // Remove children elements
  //         data.data.map(function(d){
  //           message.append(`<p>${d}</p>`)
  //         })
  //       }
  //     },
  //     error: function(err) {
  //       console.log(err)
  //     }
  //   });
  // })
  // removeQuestion.click(function(e){
  //   var url = "/resources/question/delete.php"
  //   $.ajax({
  //     type: "POST",
  //     url: url,
  //     data: {id: e.target.value},
  //     success: function(data){
  //       if(data.success) {
  //         window.location.href = 'question.php'
  //       } else {
  //         //alert(data.message); // show response from the php script
  //       }
  //     },
  //     error: function(err) {
  //       console.log(err.statusText)
  //     }
  //   });
  // })

  //Questions
  var manageQuestions = $("#ManageQuestions");
  var filterDropdown = manageQuestions.find('.filter-dropdown');
  
  filterDropdown.on('change', function(e) {
    var filter = e.target.value
    if(filter === 'all') {
      location.assign('/coordinator/question/questions.php?page=questions&grade_level=1')
    } else {
      location.assign('/coordinator/question/questions.php?page=questions&grade_level=1&subject_id='+filter)
    }
  })

  //Exam
  var includedQuestions = [];
  var question_url = '/resources/exam/questions.php'
  var modalContainer = $(".modal-container");
  var addExamQuestionModal = $("#AddExamQuestionModal");
  var addExamQuestionModalClose = addExamQuestionModal.find('.close');
  var addExamQuestionModalTable = addExamQuestionModal.find('.table');
  var saveExamQuestionsButton = addExamQuestionModal.find('.save-question');

  $("#AddExamQuestionBtn").on("click", function(){
    modalContainer.addClass('active');
    addExamQuestionModal.show();
    var subjectId = addExamQuestionModal.data('subjectId');
    var examId = addExamQuestionModal.data('examId');
    loadExamQuestion(subjectId, examId);
  })

  addExamQuestionModalClose.on('click', function(){
    modalContainer.removeClass('active');
    addExamQuestionModal.hide();
    includedQuestions = []; //reset included
  })

  saveExamQuestionsButton.on('click', function(){
    var examId = addExamQuestionModal.data('examId');
    saveExamQuestions(includedQuestions, examId);
  })

  function makeQuestionTable(container, data) {
    var tableBody = $("<tbody />").addClass('body');
    container.find('.body').empty();
    if(data.length > 0) {
      container.siblings('.no-records').hide();// hide no record

      $.each(data, function(index, data) {
          var row = $("<tr/>").addClass('row');
          var question = $('<td/>').addClass('td');
          var view = $('<td/>').addClass('td');
          question.text(data.question);
          view.append(
            "<button class='button include'>Include</button>"
          )
          view.append(
            "<button class='button remove'>Remove</button>"
          )
          row.append(question);
          row.append(view);
          var include = view.find('.include')
          var remove = view.find('.remove')
          include.on('click', function(){
            includedQuestions.push(data.id)
            $(this).hide();
            remove.show();
          })
          remove.on('click', function(){
            var index = includedQuestions.indexOf(data.id);
            includedQuestions.splice(index, 1);
            $(this).hide();
            include.show()
          })
          tableBody.append(row);
      });
    }
    return container.append(tableBody);
  }

  function loadExamQuestion(subjectId, examId) {
    $.ajax({
      type: "GET",
      url: question_url,
      data: $.param({
        subject_id: subjectId, 
        exam_id: examId
      }),
      success: function(res){
        makeQuestionTable(addExamQuestionModalTable, res.data);
      },
      error: function(err) {
        console.error("Something went wrong");
      }
    });
  }

  function saveExamQuestions(includedQuestions, examId) {
    $.ajax({
      type: "POST",
      url: question_url,
      data: $.param({
        questions_id: includedQuestions.join(), 
        exam_id: examId
      }),
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

  var manageExams = $("#ManageExams");
  var examQuestionTable = manageExams.find('.exam-questions');
  var removeExamQuestionButton = examQuestionTable.find('.remove-question');

  removeExamQuestionButton.on('click', function(){
    var $this = $(this)
    var questionId = $this.data('questionId');
    var examId = addExamQuestionModal.data('examId');
    removeExamQuestion(questionId, examId)
    $this.closest('tr').remove();
  })

  function removeExamQuestion(questionId, examId) {
    $.ajax({
      type: "POST",
      url: question_url,
      data: $.param({
        question_id: questionId, 
        exam_id: examId
      }),
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
})