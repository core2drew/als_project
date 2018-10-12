jQuery(document).ready(function($){
  var examModule = (function() {
    var includedQuestions = [];
    var examId = 0;
    var question_url = '/resources/exam/questions.php'
    var validateCreateExam, validateUpdateExam, validateGenerateExam;

    var $manageExams = $("#ManageExams");
    var $modalContainer = $(".modal-container.exams").not('.profile');

    //All Modals
    var $modal = $modalContainer.find('.modal');

    var $tableActions = $manageExams.find('.table-actions');
    var $examTable = $manageExams.find('.table.exam').not('.questions');
    var $examQuestionTable = $manageExams.find('.table.exam.questions');

    //Exam Table Actions
    var $createExamButton = $tableActions.find('#CreateExam');
    var $addExamQuestionButton = $tableActions.find("#AddExamQuestion");
    var $generateExamButton = $tableActions.find('#GenerateExam');

    //Exam Question Table Actions
    var $removeExamQuestionButton = $examQuestionTable.find('.delete');
    var $viewExamQuestionButton = $examQuestionTable.find('.view');

    //Create Exam
    var $createModal = $modalContainer.find('#CreateModal');
    var $createModalForm = $createModal.find(".form");
    var $saveButton = $createModal.find('.create');

    //Update Exam
    var $updateModal = $modalContainer.find('#UpdateModal');
    var $updateModalForm = $updateModal.find(".form");
    var $updateButton = $updateModal.find('.update');
    var $updateRecordButton = $examTable.find('.update');

    //Delete Exam
    var $deleteModal = $modalContainer.find('#DeleteModal');
    var $yesDeleteButton = $deleteModal.find('.yes');
    var $deleteRecordButton = $examTable.find('.delete');

    //Add Exam Question Modal
    var $examQuestionModal = $modalContainer.find("#ExamQuestionModal");
    var $examQuestionModalTable = $examQuestionModal.find('.table');
    var $saveExamQuestionsButton = $examQuestionModal.find('.save');
    
    //Generate Exam Question Modal
    var $generateModal = $modalContainer.find('#GenerateModal')
    var $generateModalForm = $generateModal.find(".form");
    var $generateButton = $generateModal.find('.create');

    //View Exam Question modal
    var $examViewQuestionModal = $modalContainer.find('#ExamViewQuestionModal');

    function makeQuestionTable(container, data) {
      var tableBody = container.find('tbody')
      tableBody.empty();
      container.siblings('.no-records').show();// hide no record
      
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

    function saveExam(){
      var url = '/resources/exam/add.php';
      var data = $createModalForm.serialize(); // Convert form data to URL params

      //Is form valid
      if(validateCreateExam.form()) {
        $.ajax({
          type: "POST",
          url: url,
          data: data,
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
    }

    function generateExam() {
      var url = '/resources/exam/generate.php';
      var data = $generateModalForm.serialize(); // Convert form data to URL params

       //Is form valid
       if(validateGenerateExam.form()) {
        $.ajax({
          type: "POST",
          url: url,
          data: data,
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
    }

    function updateExam() {
      var data = $updateModalForm.serializeArray(); // Convert form data to URL params
      data.push({name: 'id', value: examId})
      
      //If form valid update exam
      if(validateUpdateExam.form()) {
        $.ajax({
          type: "POST",
          url: '/resources/exam/update.php',
          data: $.param(data),
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
    }

    function deleteExam() {
      var url = '/resources/exam/delete.php';
      $.ajax({
        type: "POST",
        url: url,
        data: $.param({'id': examId}),
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

    function saveExamQuestions() {
      examId = $examQuestionModal.data('examId');
      $.ajax({
        type: "POST",
        url: question_url,
        data: $.param({
          questions_id: includedQuestions.join(","), 
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

    function viewExamQuestion(){
      var questionId = $(this).data('questionId');

      $modalContainer.addClass('active');
      $examViewQuestionModal.show();

      $question = $examViewQuestionModal.find('.question')
      $choices = $examViewQuestionModal.find('.choices')
      $explanation = $examViewQuestionModal.find('.explanation')

      $choices.empty()
      $explanation.hide()
      
      $.ajax({
        type: "GET",
        url: '/resources/question/question.php',
        data: $.param({
          id: questionId
        }),
        success: function(res){
          if(res.success) {
            $question.html(res.data.question)
            if(res.data.explanation) {
              $explanation.show()
              $explanation.html(res.data.explanation)
            }
            
            res.data.answers.map(function(data, index){
              var $choice = $('<span/>').addClass('choice')
              if(data.is_answer) {
                $choice.addClass('answer')
              }
              $choice.html(data.answer)
              $choices.append($choice)
            })
          }
        },
        error: function(err) {
          console.error("Something went wrong");
        }
      });
    }

    function removeExamQuestion() {
      var questionId = $(this).data('questionId');
      examId = $examQuestionModal.data('examId');
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

    function showCreateModal(){
      $modalContainer.addClass('active')
      $createModal.show();
      helperModule.clearInputFile($createModalForm)
    }

    function showUpdateModal() {
      helperModule.clearInputFile($updateModalForm)
      var url = '/resources/exam/exam.php';
      var $title = $updateModal.find('input[name=title]');
      var $instruction = $updateModal.find('textarea[name=instruction]');
      var $minutes = $updateModal.find('input[name=minutes]');

      examId = $(this).data('examId'); //get id of selected exam
      $modalContainer.addClass('active')
      
      //Display selected record details
      $.ajax({
        type: "GET",
        url: url,
        data: $.param({'id': examId}),
        success: function(res){
          if(res.success) {
            $title.val(res.data.title)
            $instruction.val(res.data.instruction)
            $minutes.val(res.data.minutes)
            $updateModal.show();
          }
        },
        error: function(err) {
          console.error("Something went wrong");
        }
      });
    }

    function showDeleteModal(){
      examId = $(this).data('examId'); //get id of selected exam
      $modalContainer.addClass('active')
      $deleteModal.show();
    }

    function showGenerateModal(){
      $modalContainer.addClass('active')
      $generateModal.show();
      helperModule.clearInputFile($generateModalForm)
    }

    function showExamQuestionsModal() {
      $modalContainer.addClass('active');
      var subjectId = $examQuestionModal.data('subjectId');
      var examId = $examQuestionModal.data('examId');
      $examQuestionModal.show();

      $.ajax({
        type: "GET",
        url: question_url,
        data: $.param({
          subject_id: subjectId, 
          exam_id: examId
        }),
        success: function(res){
          makeQuestionTable($examQuestionModalTable, res.data);
          $examQuestionModal.show();
        },
        error: function(err) {
          console.error("Something went wrong");
        }
      });
    }

    function closeModals(){
      $modalContainer.removeClass('active');
      $deleteModal.hide();
      $updateModal.hide();
      $createModal.hide();
      $generateModal.hide();
      $examQuestionModal.hide();
      $examViewQuestionModal.hide();
      includedQuestions = []; //reset included
      validateCreateExam.resetForm()
      validateUpdateExam.resetForm()
      validateGenerateExam.resetForm();
    }

    function init() {
      validateCreateExam = $createModalForm.validate({ 
        errorClass: "error-field",
        rules: {
          title: {
            required: true
          },
          instruction: {
            required: true
          },
          minutes: {
            required: true,
            digits: true
          }
        } 
      })

      validateUpdateExam = $updateModalForm.validate({ 
        errorClass: "error-field",
        rules: {
          title: {
            required: true
          },
          instruction: {
            required: true
          },
          minutes: {
            required: true,
            digits: true
          }
        } 
      })

      validateGenerateExam = $generateModalForm.validate({
        errorClass: "error-field",
        rules: {
          title: {
            required: true
          },
          instruction: {
            required: true
          },
          minutes: {
            required: true,
            digits: true
          },
          generate_count: {
            required: true,
            digits: true
          }
        } 
      })

      //Show Modal
      $createExamButton.on('click', showCreateModal)
      $generateExamButton.on('click', showGenerateModal)
      $addExamQuestionButton.on('click', showExamQuestionsModal)
      $yesDeleteButton.on('click', deleteExam)
      $updateRecordButton.on('click', showUpdateModal)
      $deleteRecordButton.on('click', showDeleteModal)

  
      //Close all modals
      $modal.find('.close').on('click', closeModals)
  
      $saveButton.on('click', saveExam)
      $updateButton.on('click', updateExam)
      $generateButton.on('click', generateExam)
  
      //save included question
      $saveExamQuestionsButton.on('click', saveExamQuestions)
      //remove question to exam
      $removeExamQuestionButton.on('click', removeExamQuestion)
      //view question
      $viewExamQuestionButton.on('click', viewExamQuestion)
    }

    return {
      init: init
    }
  })()

  examModule.init();
})