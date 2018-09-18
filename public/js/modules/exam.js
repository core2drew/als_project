jQuery(document).ready(function($){
  var examModule = (function() {
    var includedQuestions = [];
    var question_url = '/resources/exam/questions.php'
    var modalContainer = $(".modal-container");
    var addExamQuestionModal = $("#AddExamQuestionModal");
    var addExamQuestionModalClose = addExamQuestionModal.find('.close');
    var addExamQuestionModalTable = addExamQuestionModal.find('.table');
    var saveExamQuestionsButton = addExamQuestionModal.find('.save-question');
    var manageExams = $("#ManageExams");
    var examQuestionTable = manageExams.find('.exam-questions');
    var removeExamQuestionButton = examQuestionTable.find('.remove-question');
  

    function saveExamQuestions(includedQuestions, examId) {
      $.ajax({
        type: "POST",
        url: question_url,
        data: $.param({
          questions_id: includedQuestions.join(), 
          exam_id: examId
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

    function makeQuestionTable(container, data) {
      var tableBody = $("<tbody />").addClass('body');
      container.find('.body').empty();
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
  
    function loadExamQuestion(subjectId, examId) {
      $.ajax({
        type: "GET",
        url: question_url,
        data: $.param({
          subject_id: subjectId, 
          exam_id: examId
        }),
        success: function(res){
          makeQuestionTable(addExamQuestionModalTable, res.data);
        },
        error: function(err) {
          console.error("Something went wrong");
        }
      });
    }

    function removeExamQuestion(questionId, examId) {
      $.ajax({
        type: "POST",
        url: question_url,
        data: $.param({
          question_id: questionId, 
          exam_id: examId
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
    
    function init() {
      $("#AddExamQuestionBtn").on("click", function(){
        modalContainer.addClass('active');
        addExamQuestionModal.show();
        var subjectId = addExamQuestionModal.data('subjectId');
        var examId = addExamQuestionModal.data('examId');
        loadExamQuestion(subjectId, examId);
      })

      addExamQuestionModalClose.on('click', function(){
        modalContainer.removeClass('active');
        addExamQuestionModal.hide();
        includedQuestions = []; //reset included
      })

      saveExamQuestionsButton.on('click', function(){
        var examId = addExamQuestionModal.data('examId');
        saveExamQuestions(includedQuestions, examId);
      })

      removeExamQuestionButton.on('click', function(){
        var $this = $(this)
        var questionId = $this.data('questionId');
        var examId = addExamQuestionModal.data('examId');
        removeExamQuestion(questionId, examId)
        $this.closest('tr').remove();
      })
    }

    return {
      init: init
    }
  })()

  examModule.init();
})