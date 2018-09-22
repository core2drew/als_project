jQuery(document).ready(function($){
   //Questions Module
  var questionModule = (function(){
    var questionId = 0;
    var choicesCount = 2

    var $manageQuestions = $("#ManageQuestions");
    var $modalContainer = $(".modal-container");

    //All Modals
    var $modal = $modalContainer.find('.modal');

    var $tableActions = $manageQuestions.find('.table-actions');
    var $questionTable = $manageQuestions.find('.table.questions');

    //Question Table Actions
    var $createQuestionButton = $tableActions.find('#CreateQuestion');
    var $viewQuestionButton = $questionTable.find('.view');
    var $removeQuestionButton = $questionTable.find('.remove');

    //Create Question
    var $createModal = $modalContainer.find('#CreateModal');
    var $createModalForm = $createModal.find(".form");
    var $saveButton = $createModal.find('.create');

    //Delete Question Modal / Actions
    var $deleteModal = $modalContainer.find('#DeleteModal');
    var $yesDeleteButton = $deleteModal.find('.yes');
    
    //View Question modal
    var $viewModal = $modalContainer.find('#ViewQuestionModal');
    
    var addChoiceButton = $modalContainer.find('.add')
    var removeChoiceButton = $modalContainer.find('.remove')

    function showCreateModal(){
      $modalContainer.addClass('active')
      $createModal.show();
    }

    function showViewModal(){
      $modalContainer.addClass('active')
      $viewModal.show();
    }

    function showDeleteModal(){
      questionId = $(this).data('questionId'); //get id of selected exam
      $modalContainer.addClass('active')
      $deleteModal.show();
    }
    
    function saveQuestion() {
      var url = '/resources/question/add.php';
      var data = $createModalForm.serialize(); // Convert form data to URL params

      //Validate form field
      $createModalForm.validate({
        errorClass: "error-field",
        rules:{
          question: {
            required: true
          },
          choice_1: {
            required: true
          },
          choice_2: {
            required: true
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

    function deleteQuestion(){
      var url = '/resources/question/delete.php';
      $.ajax({
        type: "POST",
        url: url,
        data: $.param({'id': questionId}),
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

    function addChoice(){
      var $choices = $modalContainer.find('.choices');
      var $choice = $('<div/>').addClass('input choice')
      var $remove = $('<span/>').addClass('basic button remove')
      var $label = $('<label/>').addClass('label')
      var $input = $('<input type=text />')

      $remove.append('Remove');
      $label.append('Choice ' + (++choicesCount))
      $choice.append($label).append($input).append($remove)
      $choices.append($choice)

      if(choicesCount >= 4) {
        addChoiceButton.hide();
      }
    }

    function removeChoice(){
      console.log($(this).closest('.input'))
      $(this).closest('.input').remove();

      if($choices.children().length < 4) {
        addChoiceButton.show();
      }
    }

    function closeModals(){
      $modalContainer.removeClass('active');
      $deleteModal.hide();
      $createModal.hide();
      $viewModal.hide();
    }

    function init() {
      //Table Actions
      $createQuestionButton.on('click', showCreateModal)
      $viewQuestionButton.on('click', showViewModal)
      $removeQuestionButton.on('click', showDeleteModal)
  
      //Modal Actions
      $modal.find('.close').on('click', closeModals)

      //Create Question Modal Action
      $saveButton.on('click', saveQuestion)

      //Confirmation Delete Modal Action
      $yesDeleteButton.on('click', deleteQuestion)

      addChoiceButton.on('click', addChoice)
      removeChoiceButton.on('click', removeChoice)
    }

    return {
      init: init
    }
  })();

  questionModule.init();
})