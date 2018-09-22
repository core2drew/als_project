jQuery(document).ready(function($){
  var examModule = (function() {
    var includedQuestions = [];
    var examId = 0;
    var question_url = '/resources/exam/questions.php'
    var modalContainer = $(".modal-container");
    var $tableActions = $(".table-actions");
    var $table = $('.table');
    var $modal = modalContainer.find('.modal')

    //Table Actions
    var $createExamBtn = $tableActions.find('#CreateExam')
    
    //Create
    var $createModal = modalContainer.find('#CreateModal');
    var $createModalForm = $createModal.find(".form");
    var $saveButton = $createModal.find('.create');

    //Update
    var $updateModal = modalContainer.find('#UpdateModal');
    var $updateModalForm = $updateModal.find(".form");
    var $updateButton = $updateModal.find('.update');
    var $updateRecordButton = $table.find('.update');

    //Delete
    var $deleteModal = modalContainer.find('#DeleteModal');
    var $yesDeleteButton = $deleteModal.find('.yes')
    var $deleteRecordButton = $table.find('.delete');

    var addExamQuestionModal = $("#AddExamQuestionModal");
    var addExamQuestionModalClose = addExamQuestionModal.find('.close');
    var addExamQuestionModalTable = addExamQuestionModal.find('.table');
    var saveExamQuestionsButton = addExamQuestionModal.find('.save-question');

    var manageExams = $("#ManageExams");
    var examQuestionTable = manageExams.find('.exam-questions');
    var removeExamQuestionButton = examQuestionTable.find('.remove-question');

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

    function saveExam(e){
      var url = '/resources/exam/add.php';
      var data = $createModalForm.serialize(); // Convert form data to URL params

      //Validate form field
      $createModalForm.validate({
        errorClass: "error-field",
        rules:{
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
      
      //Is form valid
      if($createModalForm.valid()) {
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

    function updateExam(e) {
      var data = $updateModalForm.serializeArray(); // Convert form data to URL params
      data.push({name: 'id', value: examId})
      
      //Validate form field
      $updateModalForm.validate({
        errorClass: "error-field",
        rules:{
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
      
      //If form valid update exam
      if($updateModalForm.valid()) {
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

    function showCreateModal(){
      modalContainer.addClass('active')
      $createModal.show();
    }

    function showUpdateModal() {
      var url = '/resources/exam/exam.php';
      var $title = $updateModal.find('input[name=title]');
      var $instruction = $updateModal.find('textarea[name=instruction]');
      var $minutes = $updateModal.find('input[name=minutes]');

      examId = $(this).data('examId'); //get id of selected exam
      modalContainer.addClass('active')
      
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

    function showDeleteModal(e){
      examId = $(this).data('examId'); //get id of selected exam
      modalContainer.addClass('active')
      $deleteModal.show();
    }

    function actionsInit(){
      $createExamBtn.on('click', showCreateModal)
      $yesDeleteButton.on('click', deleteExam)

      //Show Modal
      $updateRecordButton.on('click', showUpdateModal)
      $deleteRecordButton.on('click', showDeleteModal)

      //Close all modals
      $modal.find('.no').on('click', closeModals)

      $saveButton.on('click', saveExam)
      $updateButton.on('click', updateExam)
    }

    function closeModals(){
      modalContainer.removeClass('active');
      $deleteModal.hide();
      $createModal.hide();
    }

    function init() {
      actionsInit()

      $("#AddExamQuestionBtn").on("click", function(){
        modalContainer.addClass('active');
        addExamQuestionModal.show();
        var subjectId = addExamQuestionModal.data('subjectId');
        var examId = addExamQuestionModal.data('examId');
        loadExamQuestion(subjectId, examId);
      })
  
      addExamQuestionModalClose.on('click', function(){
        closeModals()
        addExamQuestionModal.hide();
        includedQuestions = []; //reset included
      })
  
      saveExamQuestionsButton.on('click', function(){
        var examId = addExamQuestionModal.data('examId');
        saveExamQuestions(includedQuestions, examId);
      })
  
      removeExamQuestionButton.on('click', function(){
        var $this = $(this)
        var questionId = $this.data('questionId');
        var examId = addExamQuestionModal.data('examId');
        removeExamQuestion(questionId, examId)
        $this.closest('tr').remove();
      })
    }

    return {
      init: init
    }
  })()

  examModule.init();
})