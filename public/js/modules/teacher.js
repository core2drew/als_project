jQuery(document).ready(function($){

  var teacherModule = (function() {
    var examId;
    var subjectId;

    var $manageExams = $("#ManageExams");
    var $modalContainer = $(".modal-container.teacher").not('.profile');

    //All Modals
    var $modal = $modalContainer.find('.modal');

    var $examsTable = $manageExams.find('.table.exam');

    //var $assignExamButton = $examsTable.find('.assign-exam')
    var $assignExamToAllButton = $examsTable.find('.assign-exam-to-all')
    var $viewExamButton = $examsTable.find('.view-exam')

    var $examQuestions = $manageExams.find('#ExamQuestions')
    var $assignExamModal = $modalContainer.find('#AssignExamModal')
    var $examDetailsModal = $modalContainer.find('#ExamDetailsModal')

    var $saveAssignExamButton = $assignExamModal.find('.save')
    var $assignExamModalTable = $assignExamModal.find('.table')

    var $viewExam = $examDetailsModal.find('.view')

    var $title = $manageExams.children('.title')

    function makeStudentTable(container, data){
      var tableBody = container.find('tbody')
      tableBody.empty();
      container.siblings('.no-records').show();
      if(data.length > 0) {
        container.siblings('.no-records').hide();// hide no record
        $.each(data, function(index, data) {
          var row = $("<tr/>").addClass('row');
          var name = $('<td/>').addClass('td');
          var view = $('<td/>').addClass('td');

          name.text(data.name);
          row.append(name);
  
          if(data.is_taken == "0" || data.is_taken == null) {
            view.append(
              `<span class='button assign' data-student-id=${data.id}>Assign</span>`
            )
            view.append(
              `<span class='button remove' data-student-id=${data.id}>Unassign</span>`
            )
            var assign = view.find('.assign')
            var remove = view.find('.remove')
            row.append(view);

            if(data.has_exam && data.is_taken != null) {
              assign.hide()
              remove.css('display','block')
            }

            assign.on('click', function(){
              var $this = $(this)
              var studentId = $this.data('studentId')
              $this.hide();
              remove.css('display','block')
              assignExam(studentId, examId)
            })
  
            remove.on('click', function(){
              var $this = $(this)
              var studentId = $this.data('studentId')
              $(this).hide();
              assign.css('display','block')
              removeAssignExam(studentId, examId)
            })

          } else if (data.is_taken == "1"){
            view.append(
              "<span class='button basic taken'>Taken</span>"
            )
            row.append(view);
          }

          tableBody.append(row);
        });
      }
      return container.append(tableBody);
    }

    function showAssignExamModal(){
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
            makeStudentTable($assignExamModalTable, res.data)
            $modalContainer.addClass('active')
            $assignExamModal.show();
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
      $examDetailsModal.hide();
      $assignExamModal.hide();
    }

    function assignExamToAll(e) {
      var $this = $(this)
      var teacherId = $this.data('teacherId')
      var examId = $this.data('examId')
      $.ajax({
        type: "POST",
        url: '/resources/teacher/assign-exam-to-all.php',
        data: $.param({
          teacher_id: teacherId,
          exam_id: examId
        }),
        success: function(res){
          alert(res.message)
        },
        error: function(err) {
          console.error("Something went wrong");
        }
      });
    }

    function assignExam(studentId, examId) {
      $.ajax({
        type: "POST",
        url: '/resources/teacher/assign-exam.php',
        data: $.param({
          student_id: studentId,
          exam_id: examId
        }),
        success: function(res){
          if(res.success) {
            //alert(res.message)
          }
        },
        error: function(err) {
          console.error("Something went wrong");
        }
      });
    }

    function removeAssignExam(studentId, examId){
      $.ajax({
        type: "POST",
        url: '/resources/teacher/assign-exam.php',
        data: $.param({
          student_id: studentId,
          exam_id: examId,
          action: 'remove'
        }),
        success: function(res){
          if(res.success) {
            //alert(res.message)
          }
        },
        error: function(err) {
          console.error("Something went wrong");
        }
      });
    }

    function showInstruction(){
      var $this = $(this)
      examId = $this.data('examId')
      subjectId = $this.data('subjectId')
      var $title = $examDetailsModal.find('.content > .title')
      var $minutes = $examDetailsModal.find('.minutes')
      var $items = $examDetailsModal.find('.items')
      var $instruction = $examDetailsModal.find('.instruction')

      $title.empty()
      $minutes.empty()
      $items.empty()
      $instruction.empty()
      
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
          if(res.data.instruction) {
            $instruction.html(`
              <p class="title"><b>Instruction:</b></p>
              ${res.data.instruction}
              `
            )
          }
          $modalContainer.addClass('active');
          $examDetailsModal.show();
        },
        error: function(err) {
          console.error("Something went wrong");
        }
      })
    }

    function startView(){
      var hostname = window.location.hostname
      window.location.href = `/teacher/exams.php?subject_id=${subjectId}&exam_id=${examId}`
    }
    
    function init(){

      //Close all modals
      $modal.find('.close').on('click', closeModals)

      //$assignExamButton.on('click', showAssignExamModal)
      $assignExamToAllButton.on('click', assignExamToAll)
      $viewExamButton.on('click', showInstruction)
      $viewExam.on('click', startView)

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