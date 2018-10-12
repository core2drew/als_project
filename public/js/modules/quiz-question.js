jQuery(document).ready(function($){
  //Questions Module
 var questionModule = (function(){
	var questionId;
	var quizId;
	var choicesCount;
	var validateCreateQuiz;
	var validationRules = {
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

   var $manageQuiz = $("#ManageQuiz");
   var $modalContainer = $(".modal-container.questions");

   //All Modals
   var $modal = $modalContainer.find('.modal');

   var $tableActions = $manageQuiz.find('.table-actions');
   var $questionTable = $manageQuiz.find('.table.questions');

   //Question Table Actions
   var $createQuestionButton = $tableActions.find('#CreateQuestion');
   var $viewRecord = $questionTable.find('.view');
   var $removeQuestionButton = $questionTable.find('.delete');

   //Create Question
   var $createModal = $modalContainer.find('#CreateModal');
   var $createModalForm = $createModal.find(".form");
   var $saveButton = $createModal.find('.create');
   var $choices = $createModal.find('.choices');
   var $questionType = $createModal.find('#QuestionType')

   //Choices Type
   var $multipleChoice = $createModal.find('#MultipleChoice')
   var $trueOrFalse = $createModal.find('#TrueOrFalse')
   var $fillInTheBlank = $createModal.find('#FillInTheBlank')

   //Delete Question Modal / Actions
   var $deleteModal = $modalContainer.find('#DeleteModal');
   var $yesDeleteButton = $deleteModal.find('.yes');
   
   //View Question modal
   var $viewModal = $modalContainer.find('#ViewQuestionModal');
   
   var $addChoiceButton = $modalContainer.find('.add')

   function showCreateModal(){
     $modalContainer.addClass('active')
	  $createModal.show();
	  helperModule.clearInputFile($createModalForm)
   }

   function showViewModal(){
     var questionId = $(this).data('questionId');

     var $question = $viewModal.find('.question')
     var $choices = $viewModal.find('.choices')
     var $explanation = $viewModal.find('.explanation')

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

           $modalContainer.addClass('active')
           $viewModal.show();
         }
       },
       error: function(err) {
         console.error("Something went wrong");
       }
     })
   }

   function showDeleteModal(){
     var $this = $(this)
     quizId = $this.data('quizId')
     questionId = $this.data('questionId'); //get id of selected exam
     $modalContainer.addClass('active')
     $deleteModal.show();
   }
   
   function saveQuestion() {
		var url = '/resources/question/add-quiz-question.php';
		var data = $createModalForm.serializeArray(); // Convert form data to URL params
		var hasAnswer = false;
		var questionType = 'multiple';

		console.log(data)

		data.map(function(d, i){
			if(d.name == 'is_answer') {
				hasAnswer = true
			}
			if(d.name == 'question-type') {
				questionType = d.value
			}
		})

     //Is form valid
     if(validateCreateQuiz.form()) {
			if(
				!hasAnswer && 
				(questionType === 'multiple' || questionType === 'true-false')
			) {
				alert('Select answer to proceed')
				return
			}

       $.ajax({
         type: "POST",
         url: url,
         data: data,
         success: function(res){
           console.log(res)
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
     var url = '/resources/question/remove-quiz-question.php';
     $.ajax({
       type: "POST",
       url: url,
       data: $.param({
         'quiz_id': quizId,
         'question_id': questionId
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

   function addChoice(){
     choicesCount = $choices.children().length + 1;
     currentName = `choice_${choicesCount}`

     //Add new field to validation
     validationRules[currentName] = {
       required: true
     }

     var $choice = $('<div/>').addClass('input choice')
     var $remove = $('<span/>').addClass('button remove')
     var $label = $('<label/>').addClass('label')

     var $isAnswer = $(`<input type=radio name=is_answer value=${currentName}/>`)
     var $input = $(`<input type=text name=${currentName} placeholder='Choice ${choicesCount}' required/>`)
     var $answer = $('<div/>').addClass('answer')
     
     $remove.append('Remove');
     $answer.append($isAnswer).append($input)

     $choice.append($remove).append($answer)
     $choices.append($choice)

     if($choices.children().length >= 4) {
       $addChoiceButton.hide();
     }
   }

   function removeChoice() {
     var $input = $(this).closest('.input');
     var index = $input.index();
     choicesCount = $choices.children().length;

     //Remove item 4 if you remove item 3
     if(index == 2 && choicesCount >= 4) {
       $input.next('.input').remove();
     } else {
       $input.remove();
     }

     if($choices.children().length < 4) {
       $addChoiceButton.show();
     }
   }

   function closeModals(){
     $modalContainer.removeClass('active');
     $deleteModal.hide();
     $createModal.hide();
	  $viewModal.hide();
	  validateCreateQuiz.resetForm();
	  resetQuestionType()
   }

   function changeQuestionType(e) {
		helperModule.clearInputFile($multipleChoice)
		helperModule.clearInputFile($trueOrFalse)
		validateCreateQuiz.resetForm();
		var value = e.target.value
		switch(value) {
			case 'multiple':
			$multipleChoice.siblings().hide();
			$multipleChoice.show();
			break;
			case 'true-false':
			$trueOrFalse.siblings().hide();
			$trueOrFalse.show();
			break;
			case 'fill-in':
			$fillInTheBlank.siblings().hide();
			$fillInTheBlank.show();
			break;
			default:
			$multipleChoice.siblings().hide();
			$multipleChoice.show();
		}
	}
	
	function resetQuestionType(){
		$multipleChoice.siblings().hide();
      $multipleChoice.show();
	}

   function init() {
		validateCreateQuiz = $createModalForm.validate({
			errorClass: "error-field",
			rules: {
				question: {
					required: true
				},
				choice_1: {
					required: true
				},
				choice_2: {
					required: true
				},
				choice_3: {
					required: true
				},
				choice_4: {
					required: true
				},
				fillanswer: {
					required: true
				}
			}
		})
		//Table Actions
		$createQuestionButton.on('click', showCreateModal)
		$viewRecord.on('click', showViewModal)
		$removeQuestionButton.on('click', showDeleteModal)
	
		//Modal Actions
		$modal.find('.close').on('click', closeModals)

		//Create Question Modal Action
		$saveButton.on('click', saveQuestion)

		//Confirmation Delete Modal Action
		$yesDeleteButton.on('click', deleteQuestion)

		$addChoiceButton.on('click', addChoice)
		$choices.on('click', '.remove', removeChoice)
		
		//Change choices
		$questionType.on('change', changeQuestionType)
   }

   return {
     init: init
   }
 })();

 questionModule.init();
})