jQuery(document).ready(function($){

  var studentModule = (function() {

    var $manageExams = $("#ManageExams");
    var $examQuestions = $manageExams.find('#ExamQuestions')

    var $title = $manageExams.children('.title')

    function startCountDown() {
      var timer = new Timer();
      var $countDown = $('#CountDown');
      var $minutes = $countDown.find('.minutes');
      var examMinutes = $countDown.data('examMinutes')

      timer.start({countdown: true, startValues: {minutes: examMinutes}});
      $minutes.html(timer.getTimeValues().toString());
      timer.addEventListener('secondsUpdated', function (e) {
        $minutes.html(timer.getTimeValues().toString());
      });
      timer.addEventListener('targetAchieved', function (e) {
        //$('#CountDownMinutes').html('KABOOM!!');
      });
    }

    function init(){
      startCountDown();
      if($examQuestions.length) {
        $.ajax({
          type: "GET",
          url: '/resources/student/exam-questions.php',
          data: $.param({
            exam_id: $examQuestions.data('examId'),
            questions_id: $examQuestions.data('questionsId')
          }),
          success: function(res){
            if(res.success) {
              $title.find('h2').html(res.data.title)
              res.data.map(function(data, i) {
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
                  var $radioButton = $(`<input type='radio' name='answer_${data.id}'>`)
                  var $choicesItem = $('<div/>').addClass('choice')
                  // if(ans.is_answer) {
                  //   $choicesItem.addClass('is-answer')
                  // }
                  $choicesItem.append($radioButton).append(ans.answer)
                  $choices.append($choicesItem)
                  $questionItem.append($choices)
                })
                $examQuestions.append($questionItem)
              })
            }
          },
          error: function(err) {
            console.error("Something went wrong");
          }
        });
      }
    }

    return {
      init: init
    }
  })()
  
  studentModule.init()
})

