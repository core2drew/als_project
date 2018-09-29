jQuery(document).ready(function($){

  var studentModule = (function() {
    var examId;
    var $manageExams = $("#ManageExams");
    var $modalContainer = $(".modal-container");
    var $examQuestions = $manageExams.find('#ExamQuestions')

    //All Modals
    var $modal = $modalContainer.find('.modal');
    var $examDetailsModal = $modalContainer.find('#ExamDetailsModal')
    var $examStart = $examDetailsModal.find('.start')

    var $tableExams = $("#ManageExams").find('.table.exam')
    var $takeExam = $tableExams.find('.take-exam')

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

    function closeModals(){
      $modalContainer.removeClass('active');
      $examDetailsModal.hide();
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

    function startExam(){
      var hostname = window.location.hostname
      window.location.replace(`/exams.php?exam_id=${examId}`)
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
      //Close all modals
      $modal.find('.close').on('click', closeModals)

      $takeExam.on('click', showInstruction)
      $examStart.on('click', startExam)
    }

    return {
      init: init
    }
  })()
  
  studentModule.init()
})

