jQuery(document).ready(function($){
   //Questions Module
   var questionModule = (function(){
    var manageQuestions = $("#ManageQuestions");
    var filterDropdown = manageQuestions.find('.filter-dropdown');

    function init () {
      filterDropdown.on('change', function(e) {
        var filter = e.target.value
        if(filter === 'all') {
          location.assign('/coordinator/question/questions.php?page=questions&grade_level=1')
        } else {
          location.assign('/coordinator/question/questions.php?page=questions&grade_level=1&subject_id='+filter)
        }
      })
    }

    return {
      init: init
    }
  })();

  questionModule.init();
})