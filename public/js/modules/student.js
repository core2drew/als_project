jQuery(document).ready(function($){

  var studentModule = (function() {
    var examId, answers = [], userId;
    var timer;

    var $manageExams = $("#ManageExams");
    var $modalContainer = $(".modal-container").not('.profile');

    //All Modals
    var $modal = $modalContainer.find('.modal');
    
    var $examQuestions = $manageExams.find('#ExamQuestions')
    var $examQuestionsAnswer = $manageExams.find('#ExamQuestionsAnswers')
    var $countDown =  $manageExams.find('#CountDown');

    var $examDetailsModal = $modalContainer.find('#ExamDetailsModal')
    var $examStart = $examDetailsModal.find('.start')

    var $confirmationModal = $modalContainer.find('#Confirmation')
    var $confirmationMessage = $confirmationModal.find('.content')
    var $confirmYesButton = $confirmationModal.find('.yes')

    var $attentionModal = $modalContainer.find('#Attention')
    var $attentionMessage = $attentionModal.find('.content')
    var $attentionOkButton = $attentionModal.find('.yes')

    var $tableExams = $manageExams.find('.table.exam')
    var $takeExam = $tableExams.find('.take-exam')
    var $viewResult = $tableExams.find('.view-result')

    var $submitExam = $manageExams.find('#SubmitExam')

    function startCountDown(minutes) {
      timer = new Timer();
      var $minutes = $countDown.find('.minutes');

      timer.start({countdown: true, startValues: {minutes: minutes}});
      $minutes.html(timer.getTimeValues().toString());
      timer.addEventListener('secondsUpdated', function (e) {
        $minutes.html(timer.getTimeValues().toString());
      });
      timer.addEventListener('targetAchieved', function (e) {
        $attentionMessage.html(`Time is up, this exam will submit automatically`)
        $modalContainer.addClass('active');
        $attentionModal.show();
        $attentionOkButton.on('click', submitExam)
      });
    }

    function closeModals(){
      $modalContainer.removeClass('active');
      $examDetailsModal.hide();
      $confirmationModal.hide();
      $attentionModal.hide();
    }

    function showInstruction(){
      examId = $(this).data('examId')
      var $title = $examDetailsModal.find('.content > .title')
      var $minutes = $examDetailsModal.find('.minutes')
      var $items = $examDetailsModal.find('.items')
      var $instruction = $examDetailsModal.find('.instruction')

      $.ajax({
        type: "GET",
        url: '/resources/student/exam-details.php',
        data: $.param({
          exam_id: examId
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
          $examDetailsModal.show();
        },
        error: function(err) {
          console.error("Something went wrong");
        }
      })
    }

    function generateQuestions(data){
      var examMinutes = $countDown.data('examMinutes')

      $(window).on("beforeunload", function() {
        return "If you leave now you can't retake this exam"
      })
      
      data.map(function(data, i) {
        var $question = $('<div/>').addClass('question')
        var $questionItem = $('<div/>').addClass('question-item')
        var $number = $('<span/>').addClass('numbering')
        var $choices = $('<div/>').addClass('choices')

        var numbering = `${i + 1}).`;
        $number.html(numbering)
        $question.append($number)
        $question.append(data.question)

        $questionItem.append($question)

        data.answers.map(function(ans){
          var $radioButton = $(`<input type='radio' name='question_${data.id}' value=${ans.id}>`)
          var $choicesItem = $('<div/>').addClass('choice')

          $radioButton.on('click', function(e) {
            answers[i] = {
              'question_id': data.id,
              'answer_id': ans.id
            }
          })

          $choicesItem.append($radioButton).append(ans.answer)
          $choices.append($choicesItem)
          $questionItem.append($choices)
        })
        $examQuestions.append($questionItem)
      })
      $submitExam.show();
      startCountDown(examMinutes);
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
          var $choicesItem = $('<div/>').addClass('choice result')
          
          if(ans.user_answer) {
            $choicesItem.addClass('user-answer')
            //Remove no answer if user has an answer
            $noAnswer.remove()
            $choicesItem.append("<span class='your-answer legend'>Your Answer</span>")
          }

          if(ans.is_answer) {
            $choicesItem.addClass('correct-answer')
            $choicesItem.append("<span class='correct-answer legend'>Corrent Answer</span>")
            $choicesItem.children('.your-answer').remove();
          }

          $choicesItem.prepend(ans.answer)
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
      $examQuestions.empty();
      $submitExam.remove()
      timer.stop();
      $countDown.remove();
      generateAnswers(data, $examQuestions)
    }

    function startExam(){
      window.location.replace(`/exams.php?exam_id=${examId}`)
    }

    function viewExamResult() {
      examId = $(this).data('examId')
      window.location.replace(`/exams.php?exam_id=${examId}`)
    }

    function submitExam() {
      $(window).off('beforeunload');
      examId = $examQuestions.data('examId')
      userId = $examQuestions.data('userId')
      questionsId = $examQuestions.data('questionsId')

      closeModals();

      $.ajax({
        type: 'POST',
        url: '/resources/student/submit-exam.php',
        data: {
          user_id: userId,
          exam_id: examId,
          questions_id: questionsId,
          answers: JSON.stringify(answers)
        },
        success: function(res) {
          console.log(res)
          showAnswers(res.data)
        },
        error: function(err) {
          console.error("Something went wrong");
        }
      })
    }

    function confirmSubmitExam(){
      $confirmationMessage.html(`Are you sure you want to submit this exam?`)
      if(answers.length == 0) {
        $confirmationMessage.html(`Looks like you don't have any answers. Are you sure you want to submit this exam?`)
      }
      $modalContainer.addClass('active');
      $confirmationModal.show();
      $confirmYesButton.off('click')
      $confirmYesButton.on('click', submitExam)
    }

    function getQuestions(){
      $.ajax({
        type: "GET",
        url: '/resources/student/exam-questions.php',
        data: $.param({
          exam_id: $examQuestions.data('examId'),
          questions_id: $examQuestions.data('questionsId')
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
        url: '/resources/student/exam-review.php',
        data: $.param({
          exam_id: $examQuestionsAnswer.data('examId'),
          questions_id: $examQuestionsAnswer.data('questionsId'),
          user_id: $examQuestionsAnswer.data('userId')
        }),
        success: function(res){
          if(res.success) {
            generateAnswers(res.data, $examQuestionsAnswer)
          }
        },
        error: function(err) {
          console.error("Something went wrong");
        }
      });
    }

    function init(){
      if($examQuestionsAnswer.length) {
        getAnswers()
      }
      if($examQuestions.length) {
        getQuestions()
      }

      //Close all modals
      $modal.find('.close').on('click', closeModals)

      //Modal Actions
      $takeExam.on('click', showInstruction)
      $viewResult.on('click', viewExamResult)
      $examStart.on('click', startExam)

      //Submit Exam
      $submitExam.on('click', confirmSubmitExam)
    }

    return {
      init: init
    }
  })()
  
  studentModule.init()
})

