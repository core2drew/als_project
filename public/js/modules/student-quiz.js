jQuery(document).ready(function(){
  var studentQuizModule = (function() {
    var quizId, answers = [], userId;
    var timer;

    var $manageQuiz = $("#ManageQuiz");
    var $modalContainer = $(".modal-container");

    //All Modals
    var $modal = $modalContainer.find('.modal');

    var $quizQuestions = $manageQuiz.find('#QuizQuestions')
    var $quizQuestionsAnswer = $manageQuiz.find('#QuizQuestionsAnswers')
    var $countDown =  $manageQuiz.find('#CountDown');

    var $tableQuiz = $manageQuiz.find('.table.quiz')
    var $takeQuiz = $tableQuiz.find('.take-quiz')
    var $viewQuizResult = $tableQuiz.find('.view-result')

    var $quizDetailsModal = $modalContainer.find('#QuizDetailsModal')
    var $quizStart = $quizDetailsModal.find('.start')

    var $confirmationModal = $modalContainer.find('#Confirmation')
    var $confirmationMessage = $confirmationModal.find('.content')
    var $confirmYesButton = $confirmationModal.find('.yes')

    var $attentionModal = $modalContainer.find('#Attention')
    var $attentionMessage = $attentionModal.find('.content')
    var $attentionOkButton = $attentionModal.find('.yes')

    var $submitQuiz = $manageQuiz.find('#SubmitQuiz')

    function startCountDown(minutes) {
      timer = new Timer();
      var $minutes = $countDown.find('.minutes');

      timer.start({countdown: true, startValues: {minutes: minutes}});
      $minutes.html(timer.getTimeValues().toString());
      timer.addEventListener('secondsUpdated', function (e) {
        $minutes.html(timer.getTimeValues().toString());
      });
      timer.addEventListener('targetAchieved', function (e) {
        $attentionMessage.html(`Time is up, this quiz will submit automatically`)
        $modalContainer.addClass('active');
        $attentionModal.show();
        $attentionOkButton.on('click', submitQuiz)
      });
    }

    function closeModals(){
      $modalContainer.removeClass('active');
      $quizDetailsModal.hide();
      $confirmationModal.hide();
      $attentionModal.hide();
    }

    function showInstruction(){
      quizId = $(this).data('quizId')
      var $title = $quizDetailsModal.find('.content > .title')
      var $minutes = $quizDetailsModal.find('.minutes')
      var $items = $quizDetailsModal.find('.items')
      var $instruction = $quizDetailsModal.find('.instruction')

      $.ajax({
        type: "GET",
        url: '/resources/student/quiz-details.php',
        data: $.param({
          quiz_id: quizId
        }),
        success: function(res){
          var items = res.data.questions_id.split(',')
          $title.html(`<b>Title:</b> ${res.data.title}`)
          $minutes.html(`<b>Minutes:</b> ${res.data.minutes}`)
          $items.html(`<b>Items:</b> ${items.length}`)
          $instruction.html(`
            <p class="title"><b>Instruction:</b></p>
            ${res.data.instruction}
            `
          )

          $modalContainer.addClass('active');
          $quizDetailsModal.show();
        },
        error: function(err) {
          console.error("Something went wrong");
        }
      })
    }

    function generateQuestions(data){
      var quizMinutes = $countDown.data('quizMinutes')

      $(window).on("beforeunload", function() {
        return "If you leave now you can't retake this quiz"
      })
      
      data.map(function(data, i) {
        var $question = $('<div/>').addClass('question')
        var $questionItem = $('<div/>').addClass('question-item')
        var $number = $('<span/>').addClass('numbering')

        var numbering = `${i + 1}).`;
        $number.html(numbering)
        $question.append($number)
        $question.append(data.question)

        $questionItem.append($question)

        var $choices = $('<div/>').addClass('choices')
        data.answers.map(function(ans){
          if(data.question_type == 'multiple' || data.question_type == 'true-false') {
            var $radioButton = $(`<input type='radio' name='question_${data.id}' value=${ans.id}>`)
            var $choicesItem = $('<div/>').addClass('choice')

            $radioButton.on('click', function(e) {
              answers[i] = {
                'question_id': data.id,
                'question_type': data.question_type,
                'answer_id': ans.id
              }
            })

            $choicesItem.append($radioButton).append(ans.answer)
            $choices.append($choicesItem)
            $questionItem.append($choices)
          }
          else if (data.question_type == 'fill-in') {
            $fillIn = $('<input/>').addClass('fill-input');
            $fillIn.on('change', function(e) {
              answers[i] = {
                'question_id': data.id,
                'question_type': data.question_type,
                'answer_id': ans.id,
                'fill_in_answer': e.target.value
              }
            })
  
            $questionItem.append($fillIn)
          }
        })
        $quizQuestions.append($questionItem)
      })
      startCountDown(quizMinutes);
      $submitQuiz.show();
    }

    function generateAnswers(data, $container) {
      data.map(function(data, i) {
        var $question = $('<div/>').addClass('question')
        var $questionItem = $('<div/>').addClass('question-item')
        var $number = $('<span/>').addClass('numbering')
        var $choices = $('<div/>').addClass('choices')
        var $explanation = $('<div/>').addClass('explanation')
        var $noAnswer = $('<div/>').addClass('noanswer')

        $noAnswer.html('No Answer')

        var numbering = `${i + 1}).`;
        $number.html(numbering)
        $question.append($number)
        //Display no answer
        $questionItem.append($noAnswer)

        $question.append(data.question)
        $questionItem.append($question)

        data.answers.map(function(ans){
          var $choicesItem = $('<div/>').addClass('choice')
          
          if(ans.user_answer) {
            $choicesItem.addClass('user-answer')
            //Remove no answer if user has an answer
            $noAnswer.remove()
          }

          if(ans.is_answer) {
            $choicesItem.addClass('correct-answer')
          }

          $choicesItem.append(ans.answer)
          $choices.append($choicesItem)
          $questionItem.append($choices)
        })
        if(data.explanation) {
          $explanation.html(`<label class='label'>Explanation:</label>`)
          $explanation.append(`${data.explanation}`)
          $questionItem.append($explanation)
        }

        $container.append($questionItem)
      })
    }

    function showAnswers(data){
      $quizQuestions.empty();
      $submitQuiz.remove()
      timer.stop();
      $countDown.remove();
      generateAnswers(data, $quizQuestions)
    }

    function startQuiz(){
      window.location.replace(`/quiz.php?quiz_id=${quizId}`)
    }

    function viewResult() {
      quizId = $(this).data('quizId')
      window.location.replace(`/quiz.php?quiz_id=${quizId}`)
    }

    function submitQuiz() {
      $(window).off('beforeunload');
      quizId = $quizQuestions.data('quizId')
      userId = $quizQuestions.data('userId')
      questionsId = $quizQuestions.data('questionsId')

      closeModals();

      $.ajax({
        type: 'POST',
        url: '/resources/student/submit-quiz.php',
        data: {
          user_id: userId,
          quiz_id: quizId,
          questions_id: questionsId,
          answers: JSON.stringify(answers)
        },
        success: function(res) {
          showAnswers(res.data)
        },
        error: function(err) {
          console.error("Something went wrong");
        }
      })
    }

    function confirmSubmitQuiz(){
      $confirmationMessage.html(`Are you sure you want to submit this quiz?`)
      if(answers.length == 0) {
        $confirmationMessage.html(`Looks like you don't have any answers. Are you sure you want to submit this quiz?`)
      }
      $modalContainer.addClass('active');
      $confirmationModal.show();
      $confirmYesButton.off('click')
      $confirmYesButton.on('click', submitQuiz)
    }

    function getQuestions(){
      $.ajax({
        type: "GET",
        url: '/resources/student/quiz-questions.php',
        data: $.param({
          quiz_id: $quizQuestions.data('quizId'),
          questions_id: $quizQuestions.data('questionsId')
        }),
        success: function(res){
          if(res.success) {
            generateQuestions(res.data)
          }
        },
        error: function(err) {
          console.error("Something went wrong");
        }
      });
    }

    function getAnswers(){
      $.ajax({
        type: "GET",
        url: '/resources/student/quiz-review.php',
        data: $.param({
          quiz_id: $quizQuestionsAnswer.data('quizId'),
          questions_id: $quizQuestionsAnswer.data('questionsId'),
          user_id: $quizQuestionsAnswer.data('userId')
        }),
        success: function(res){
          if(res.success) {
            generateAnswers(res.data, $quizQuestionsAnswer)
          }
        },
        error: function(err) {
          console.error("Something went wrong");
        }
      });
    }

    function init() {
      if($quizQuestionsAnswer.length) {
        getAnswers()
      }
      if($quizQuestions.length) {
        getQuestions()
      }

      //Close all modals
      $modal.find('.close').on('click', closeModals)

      $takeQuiz.on('click', showInstruction)

      $viewQuizResult.on('click', viewResult)
      $quizStart.on('click', startQuiz)

      //Submit Exam
      $submitQuiz.on('click', confirmSubmitQuiz)
    }

    return {
      init: init
    }
  })()

  studentQuizModule.init()
})