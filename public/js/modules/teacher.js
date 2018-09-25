jQuery(document).ready(function($){

  var teacherModule = (function() {
    var studentsHasExam = []
    var examId;

    var $manageExams = $("#ManageExams");
    var $modalContainer = $(".modal-container");

    //All Modals
    var $modal = $modalContainer.find('.modal');

    var $examsTable = $manageExams.find('.table.exam');

    var $assignExamButton = $examsTable.find('.assign-exam')

    var $examQuestions = $manageExams.find('#ExamQuestions')
    var $assignExamModal = $modalContainer.find('#AssignExamModal')
    var $saveAssignExamButton = $assignExamModal.find('.save')
    var $assignExamModalTable = $assignExamModal.find('.table')

    var $title = $manageExams.children('.title')

    function makeStudentTable(container, data){
      var tableBody = container.find('tbody')
      tableBody.empty();
      container.siblings('.no-records').show();
      if(data.length > 0) {
        container.siblings('.no-records').hide();// hide no record
        $.each(data, function(index, data) {
          var row = $("<tr/>").addClass('row');
          var studentName = $('<td/>').addClass('td');
          var view = $('<td/>').addClass('td');
          studentName.text(data.student_name);
          view.append(
            "<span class='button assign'>Assign</span>"
          )
          view.append(
            "<span class='button remove'>Unassign</span>"
          )
          row.append(studentName);
          row.append(view);
          var assign = view.find('.assign')
          var remove = view.find('.remove')

          assign.on('click', function(){
            studentsHasExam.push(data.id)
            $(this).hide();
            remove.css('display','block')
          })

          remove.on('click', function(){
            var index = studentsHasExam.indexOf(data.id);
            studentsHasExam.splice(index, 1);
            $(this).hide();
            assign.css('display','block')
          })
          tableBody.append(row);
        });
      }
      return container.append(tableBody);
    }

    function assignExam(){
      examId = $(this).data('examId')
      $.ajax({
        type: "GET",
        url: '/resources/teacher/students.php',
        data: $.param({
          teacher_id: $assignExamModal.data('userId'),
          exam_id: examId
        }),
        success: function(res){
          if(res.success) {
            // makeStudentTable($assignExamModalTable, res.data)
            // $modalContainer.addClass('active')
            // $assignExamModal.show();

            $.ajax({
              type: "GET",
              url: '/resources/teacher/students-assign-exam.php',
              data: $.param({
                teacher_id: $assignExamModal.data('userId'),
                exam_id: examId
              }),
              success: function(res){
                if(res.success) {
                  // makeStudentTable($assignExamModalTable, res.data)
                  // $modalContainer.addClass('active')
                  // $assignExamModal.show();
                  alert(res.message)
                }
              },
              error: function(err) {
                console.error("Something went wrong");
              }
            });
          } else {
            alert(res.message)
          }
        },
        error: function(err) {
          console.error("Something went wrong");
        }
      });
    }

    function closeModals(){
      $modalContainer.removeClass('active');
      $assignExamModal.hide();
    }

    function saveExamAssignment() {
      console.log(studentsHasExam)
    }
    
    function init(){

      //Close all modals
      $modal.find('.close').on('click', closeModals)

      $assignExamButton.on('click', assignExam)
      
      $saveAssignExamButton.on('click', saveExamAssignment)

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