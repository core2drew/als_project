jQuery(document).ready(function($){
  var quizModule = (function() {
    var validateCreateQuiz, 
    validateUpdateQuiz;

    var quizId = 0;

    var $manageQuiz = $("#ManageQuiz");
    var $modalContainer = $(".modal-container");

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
    var $createModal = $modalContainer.find('#CreateModal.quiz');
    var $createModalForm = $createModal.find(".form");
    var $saveButton = $createModal.find('.create');

    //Update Quiz
    var $updateModal = $modalContainer.find('#UpdateModal.quiz');
    var $updateModalForm = $updateModal.find(".form");
    var $updateButton = $updateModal.find('.update');
    var $updateRecordButton = $quizTable.find('.update');

    //Delete Quiz
    var $deleteModal = $modalContainer.find('#DeleteModal.quiz');
    var $yesDeleteButton = $deleteModal.find('.yes');
    var $deleteRecordButton = $quizTable.find('.delete');

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

    function saveRecord(e){
      var url = '/resources/quiz/add.php';
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

    function updateRecord(e) {
      var data = $updateModalForm.serializeArray(); // Convert form data to URL params
      data.push({name: 'id', value: quizId})
      
      //Validate form field
      $updateModalForm.validate({
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
      
      //If form valid update exam
      if($updateModalForm.valid()) {
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
    }

    function showUpdateModal() {
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
      validateCreateQuiz.resetForm();
      validateUpdateQuiz.resetForm();
    }

    function init() {
      validateCreateQuiz = $createModalForm.validate({ errorClass: "error-field" })
      validateUpdateQuiz = $updateModalForm.validate({ errorClass: "error-field" })

      $createQuizButton.on('click', showCreateModal)
      $yesDeleteButton.on('click', deleteRecord)
  
      //Show Modal
      $updateRecordButton.on('click', showUpdateModal)
      $deleteRecordButton.on('click', showDeleteModal)
  
      //Close all modals
      $modal.find('.close').on('click', closeModals)
  
      $saveButton.on('click', saveRecord)
      $updateButton.on('click', updateRecord)
    }

    return {
      init: init
    }
  })()

  quizModule.init();
})