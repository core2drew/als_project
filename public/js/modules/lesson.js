jQuery(document).ready(function($){
  // Lesson Module
  var lessonModule = (function(){
    var lessonEditor;
    var lessonId;

    var $manageLessons = $("#ManageLessons");
    var $modalContainer = $(".modal-container");

    //All Modals
    var $modal = $modalContainer.find('.modal');



    var $lessonTable = $manageLessons.find('.table.lessons');
    
    var $createForm = $manageLessons.find('#CreateForm');
    var $createButton = $createForm.find('.create');

    //All forms
    var $form = $manageLessons.find('.form');

    var $updateForm = $manageLessons.find('#UpdateForm');
    var $updateButton = $updateForm.find('.update');

    var $removeLessonButton = $lessonTable.find('.remove');

    //Delete Question Modal / Actions
    var $deleteModal = $modalContainer.find('#DeleteModal');
    var $yesDeleteButton = $deleteModal.find('.yes');

    var $uploadVideoButton = $form.find('.upload');
    var $uploadFileInput = $form.find('input[type=file]');
    var $uploadTextInput = $form.find('input[name=filename]');

    function createLesson(){
      //Validate form field
      $createForm.validate({
        errorClass: "error-field"
      })

      if($createForm.valid()) {
        var formData = new FormData($createForm[0]);
        formData.append('editor_data', lessonEditor.getData())
        $.ajax({
          type: "POST",
          url: '/resources/lesson/add.php',
          data: formData,
          contentType: false, // NEEDED, DON'T OMIT THIS (requires jQuery 1.6+)
          processData: false, // NEEDED, DON'T OMIT THIS
          success: function(res){
            if(res.success) {
              //show modal created success
              //modal go to lesson table
              //location.reload();
            }
          },
          error: function(err) {
            console.error("Something went wrong");
          }
        });
      }
    }

    function updateLesson() {
      //Validate form field
      $createForm.validate({
        errorClass: "error-field"
      })
      
      if($updateForm.valid()) {
        var data = $updateForm.serializeArray()
        data.push({name: 'editor_data', value: lessonEditor.getData()})
        $.ajax({
          type: "POST",
          url: `/resources/lesson/update.php`,
          data: data,
          success: function(res){
            if(res.success) {
              //show modal created success
              //modal go to lesson table
              location.reload();
            }
          },
          error: function(err) {
            console.error("Something went wrong");
          }
        });
      }
    }

    function deleteLesson() {
      var url = '/resources/lesson/delete.php';
      $.ajax({
        type: "POST",
        url: url,
        data: $.param({'id': lessonId}),
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

    function showDeleteModal(){
      lessonId = $(this).data('lessonId'); //get id of selected exam
      $modalContainer.addClass('active')
      $deleteModal.show();
    }

    function closeModals(){
      $modalContainer.removeClass('active');
      $deleteModal.hide();
    }

    function ckeditorInit(){
      //Create CKEditor
      if(document.querySelector( '.document-editor__editable' )) {
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
      }
    }

    var init = function(){
      ckeditorInit()

      $createButton.on('click', createLesson)
      $updateButton.on('click', updateLesson)
      $removeLessonButton.on('click', showDeleteModal)

      //Modal Actions
      $modal.find('.close').on('click', closeModals)

      //Confirmation Delete Modal Action
      $yesDeleteButton.on('click', deleteLesson)


      $uploadVideoButton.on('click', function(){
        $(this).siblings('input[type=file]').trigger('click');
      })
  
      $uploadFileInput.on('change', function(){
        var $this = $(this)
        $filename = $this[0].files[0].name;
        $uploadTextInput.val($filename);
      })
    }
    return {
      init: init
    }
  })();

  lessonModule.init();
})