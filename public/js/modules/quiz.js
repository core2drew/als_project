jQuery(document).ready(function($){
  var quizModule = (function() {
    var validateCreateQuiz, 
    validateUpdateQuiz;

    var quizId = 0;

    var $manageQuiz = $("#ManageQuiz");
    var $modalContainer = $(".modal-container").not('.profile');

    //All Modals
    var $modal = $modalContainer.find('.modal');

    var $tableActions = $manageQuiz.find('.table-actions');
    var $quizTable = $manageQuiz.find('.table.quiz');
    var $quizQuestionTable = $manageQuiz.find('.table.quiz.questions');

    //Table Actions
    var $createQuizButton = $tableActions.find('#CreateQuiz');
    var $addQuizQuestionButton = $tableActions.find("#AddQuizQuestion");
    
    //Quiz Table Actions
    var $removeQuestionButton = $quizQuestionTable.find('.delete');
    var $viewQuestionButton = $quizQuestionTable.find('.view');
    
    //Create Quiz
    var $createModal = $modalContainer.find('#CreateModal');
    var $createModalForm = $createModal.find(".form");
    var $saveButton = $createModal.find('.create');

    //Update Quiz
    var $updateModal = $modalContainer.find('#UpdateModal');
    var $updateModalForm = $updateModal.find(".form");
    var $updateButton = $updateModal.find('.update');
    var $updateRecordButton = $quizTable.find('.update');

    //Delete Quiz
    var $deleteModal = $modalContainer.find('#DeleteModal');
    var $yesDeleteButton = $deleteModal.find('.yes');
    var $deleteRecordButton = $quizTable.find('.delete');

    var $assignQuizModal = $modalContainer.find('#AssignQuizModal')
    var $assignQuizModalTable = $assignQuizModal.find('.table')
    var $assignQuizButton = $quizTable.find('.assign')
    var $assignQuizToAllButton = $quizTable.find('.assign-to-all')

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

    function makeStudentTable(container, data){
      var tableBody = container.find('tbody')
      tableBody.empty();
      container.siblings('.no-records').show();
      if(data.length > 0) {
        container.siblings('.no-records').hide();// hide no record
        $.each(data, function(index, data) {
          var row = $("<tr/>").addClass('row');
          var name = $('<td/>').addClass('td');
          var view = $('<td/>').addClass('td');

          name.text(data.name);
          row.append(name);
  
          if(data.is_taken == "0" || data.is_taken == null) {
            view.append(
              `<span class='button assign' data-student-id=${data.id}>Assign</span>`
            )
            view.append(
              `<span class='button remove' data-student-id=${data.id}>Unassign</span>`
            )
            var assign = view.find('.assign')
            var remove = view.find('.remove')
            row.append(view);

            if(data.has_quiz && data.is_taken != null) {
              assign.hide()
              remove.css('display','block')
            }

            assign.on('click', function(){
              var $this = $(this)
              var studentId = $this.data('studentId')
              $this.hide();
              remove.css('display','block')
              assignQuiz(studentId, quizId)
            })
  
            remove.on('click', function(){
              var $this = $(this)
              var studentId = $this.data('studentId')
              $(this).hide();
              assign.css('display','block')
              removeAssignQuiz(studentId, quizId)
            })

          } else if (data.is_taken == "1"){
            view.append(
              "<span class='button basic taken'>Taken</span>"
            )
            row.append(view);
          }

          tableBody.append(row);
        });
      }
      return container.append(tableBody);
    }

    function showAssignQuizModal(){
      quizId = $(this).data('quizId')
      $.ajax({
        type: "GET",
        url: '/resources/teacher/quiz-students.php',
        data: $.param({
          teacher_id: $assignQuizModal.data('userId'),
          quiz_id: quizId
        }),
        success: function(res){
          if(res.success) {
            makeStudentTable($assignQuizModalTable, res.data)
            $modalContainer.addClass('active')
            $assignQuizModal.show();
          } else {
            alert(res.message)
          }
        },
        error: function(err) {
          console.error("Something went wrong");
        }
      });
    }

    function assignQuiz(studentId, quizId) {
      $.ajax({
        type: "POST",
        url: '/resources/teacher/assign-quiz.php',
        data: $.param({
          student_id: studentId,
          quiz_id: quizId
        }),
        success: function(res){
          if(res.success) {
            //alert(res.message)
          }
        },
        error: function(err) {
          console.error("Something went wrong");
        }
      });
    }

    function assignQuizToAll() {
      var $this = $(this)
      var teacherId = $this.data('teacherId')
      var quizId = $this.data('quizId')
      $.ajax({
        type: "POST",
        url: '/resources/teacher/assign-quiz-to-all.php',
        data: $.param({
          teacher_id: teacherId,
          quiz_id: quizId
        }),
        success: function(res){
          alert(res.message)
        },
        error: function() {
          console.error("Something went wrong");
        }
      });
    }

    function removeAssignQuiz(studentId, quizId){
      $.ajax({
        type: "POST",
        url: '/resources/teacher/assign-quiz.php',
        data: $.param({
          student_id: studentId,
          quiz_id: quizId,
          action: 'remove'
        }),
        success: function(res){
          if(res.success) {
            //alert(res.message)
          }
        },
        error: function(err) {
          console.error("Something went wrong");
        }
      });
    }

    function saveRecord(e){
      var url = '/resources/quiz/add.php';
      var data = $createModalForm.serialize(); // Convert form data to URL params
      
      //Is form valid
      if(validateCreateQuiz.form()) {
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

    function updateRecord(e) {
      var data = $updateModalForm.serializeArray(); // Convert form data to URL params
      data.push({name: 'id', value: quizId})

      //If form valid update exam
      if(validateUpdateQuiz.form()) {
        $.ajax({
          type: "POST",
          url: '/resources/quiz/update.php',
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

    function deleteRecord() {
      var url = '/resources/quiz/delete.php';
      $.ajax({
        type: "POST",
        url: url,
        data: $.param({'id': quizId}),
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
      var url = '/resources/quiz/quiz.php';
      var $title = $updateModal.find('input[name=title]');
      var $instruction = $updateModal.find('textarea[name=instruction]');
      var $minutes = $updateModal.find('input[name=minutes]');

      quizId = $(this).data('quizId'); //get id of selected exam
      $modalContainer.addClass('active')
      
      //Display selected record details
      $.ajax({
        type: "GET",
        url: url,
        data: $.param({'id': quizId}),
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
      quizId = $(this).data('quizId'); //get id of selected exam
      $modalContainer.addClass('active')
      $deleteModal.show();
    }

    function closeModals(){
      $modalContainer.removeClass('active');
      $deleteModal.hide();
      $updateModal.hide();
      $createModal.hide();
      $assignQuizModal.hide();
      validateCreateQuiz.resetForm();
      validateUpdateQuiz.resetForm();
    }

    function init() {
      validateCreateQuiz = $createModalForm.validate({ 
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

      validateUpdateQuiz = $updateModalForm.validate({ 
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

      $createQuizButton.on('click', showCreateModal)
      $yesDeleteButton.on('click', deleteRecord)
  
      //Show Modal
      $updateRecordButton.on('click', showUpdateModal)
      $deleteRecordButton.on('click', showDeleteModal)
  
      //Close all modals
      $modal.find('.close').on('click', closeModals)
  
      $saveButton.on('click', saveRecord)
      $updateButton.on('click', updateRecord)

      $assignQuizButton.on('click', showAssignQuizModal)
      $assignQuizToAllButton.on('click', assignQuizToAll)
    }

    return {
      init: init
    }
  })()

  quizModule.init();
})