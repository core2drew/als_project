jQuery(document).ready(function($){

  var teacherModule = (function() {
    var $manageExams = $("#ManageExams");
    var $modalContainer = $(".modal-container");

    //All Modals
    var $modal = $modalContainer.find('.modal');

    var $examQuestions = $manageExams.find('#ExamQuestions')
    var $title = $manageExams.children('.title')
    
    function init(){

      if($examQuestions.length) {
        $.ajax({
          type: "GET",
          url: '/resources/exam/exam-questions.php',
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
                  var $choicesItem = $('<div/>').addClass('choice')

                  if(ans.is_answer) {
                    $choicesItem.addClass('is-answer')
                  }

                  $choicesItem.html(ans.answer)
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
  
  teacherModule.init()
})