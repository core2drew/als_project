jQuery(document).ready(function($){
  // Lesson Module
  var lessonModule = (function(){
    var lessonEditor;
    var Lessons = $("#Lessons");
    var LessonForm = Lessons.find('.form');
    var formSubmitButton = LessonForm.find('.submit');

    function createLesson(data){
      $.ajax({
        type: "POST",
        url: '/resources/lesson/add.php',
        data: data,
        success: function(res){
          if(res.success) {
            //show modal created success
            //modal go to lesson table
            alert("Lesson created!")
          }
        },
        error: function(err) {
          console.error("Something went wrong");
        }
      });
    }

    function saveLesson(data) {
      $.ajax({
        type: "POST",
        url: `/resources/lesson/update.php`,
        data: data,
        success: function(res){
          if(res.success) {
            //show modal created success
            //modal go to lesson table
            alert("Lesson update!")
            console.log(res)
          }
        },
        error: function(err) {
          console.error("Something went wrong");
        }
      });
    }

    var init = function(){
      //Create CKEditor
      DecoupledEditor.create( document.querySelector( '.document-editor__editable' ), {
        cloudServices: {
          tokenUrl: '/resources/ckeditor/token.php',
          uploadUrl: '/public/images'
        }
      })
      .then( editor => {
          const toolbarContainer = document.querySelector( '.document-editor__toolbar' );
          toolbarContainer.appendChild( editor.ui.view.toolbar.element );
          lessonEditor = editor;
      } )
      .catch( err => {
          console.error( err );
      });

      //Handle Form Submission Saving/Update Lesson
      formSubmitButton.on('click', function(e) {
        e.preventDefault();
        var data = LessonForm.serializeArray()
        data.push({name: 'editor_data', value: lessonEditor.getData()})
        // update request has id
        if(helperModule.$_GET('id')) {
          data.push({name: 'id', value: helperModule.$_GET('id')})
          saveLesson(data)
        } else {
          createLesson(data)
        }
      })
    }
    return {
      init: init
    }
  })();

  lessonModule.init();
})