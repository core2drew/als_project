jQuery(document).ready(function($){

  var subjectModule = (function(){
    var subjectId;
    var validation;

    var $manageSubjects = $("#ManageSubjects");
    var $modalContainer = $(".modal-container.subject").not('.profile');
    var $loading = $modalContainer.find('.loading');
    //All Modals
    var $modal = $modalContainer.find('.modal');

    var $table = $manageSubjects.find('.table.subjects');
    var $tableActions = $manageSubjects.find('.table-actions');

    //Table Actions
    var $createButton = $tableActions.find('#CreateSubject');
    var $updateRecordButton = $table.find('.update');
    var $deleteRecordButton = $table.find('.delete');

    //Create Modal / Actions
    var $createModal = $modalContainer.find('#CreateModal')
    var $createForm = $createModal.find('#CreateForm');
    var $createModalButton = $createModal.find('.create');
    
    //Update Modal / Actions
    var $updateModal = $modalContainer.find('#UpdateModal')
    var $updateForm = $updateModal.find('#UpdateForm');
    var $updateModalButton = $updateModal.find('.update');

    //Delete Modal / Actions
    var $deleteModal = $modalContainer.find('#DeleteModal');
    var $yesDeleteButton = $deleteModal.find('.yes');

    function createRecord(){
      if($createForm.valid()) {
        //$loading.addClass('active')
        var formData = new FormData($createForm[0]);
        $.ajax({
          type: "POST",
          url: '/resources/subject/add.php',
          data: formData,
          contentType: false,
          processData: false,
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
    }

    function updateRecord() {
      if($updateForm.valid()) {
        //$loading.addClass('active')
        var formData = new FormData($updateForm[0]);
        formData.append('id', subjectId)

        $.ajax({
          type: "POST",
          url: `/resources/subject/update.php`,
          data: formData,
          contentType: false, // NEEDED, DON'T OMIT THIS (requires jQuery 1.6+)
          processData: false, // NEEDED, DON'T OMIT THIS
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

    function deleteRecord() {
      //$loading.addClass('active')
      var url = '/resources/subject/delete.php';
      $.ajax({
        type: "POST",
        url: url,
        data: $.param({'id': subjectId}),
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

    function showCreateModal(){
      $modalContainer.addClass('active')
      $createModal.show();
    }

    function showUpdateModal(){
      subjectId = $(this).data('subjectId'); //get id of selected exam
      $modalContainer.addClass('active')
      $updateModal.show();
      
      $.ajax({
        type: "GET",
        url: `/resources/subject/subject.php`,
        data: $.param({id: subjectId}),
        success: function(res){
          if(res.success) {
            $updateForm.find('input[name=title]').val(res.data.title)
          }
        },
        error: function(err) {
          console.error("Something went wrong");
        }
      });
    }

    function showDeleteModal(){
      subjectId = $(this).data('subjectId'); //get id of selected exam
      $modalContainer.addClass('active')
      $deleteModal.show();
    }

    function closeModals(){
      validation.resetForm();
      $modalContainer.removeClass('active');
      $createModal.hide();
      $updateModal.hide();
      $deleteModal.hide();
    }

    var init = function(){
      validation = $createForm.validate({errorClass: "error-field"})

      $createButton.on('click', showCreateModal)
      $updateRecordButton.on('click', showUpdateModal)
      $deleteRecordButton.on('click', showDeleteModal)

      $createModalButton.on('click', createRecord)
      $updateModalButton.on('click', updateRecord)

      //Modal Actions
      $modal.find('.close').on('click', closeModals)

      //Confirmation Delete Modal Action
      $yesDeleteButton.on('click', deleteRecord)
    }
    return {
      init: init
    }
  })();

  subjectModule.init();
})