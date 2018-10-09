jQuery(document).ready(function($){
  //Account Module
  var announcementModule = (function(){
    var validateCreate, validateUpdate, announcementId, currentSliderImage;

    var $manageAccounts = $('#ManageHome')
    var $modalContainer = $(".modal-container.announcement");

    var $tableActions = $manageAccounts.find('.table-actions')
    var $announcementTable = $manageAccounts.find('.table.announcements');
    var $modal = $modalContainer.find('.modal');

    var $createRecordButton = $tableActions.find('#CreateAnnouncement')

    var $updateRecordButton = $announcementTable.find('.update')
    var $deleteRecordButton = $announcementTable.find('.delete')

    //Create
    var $createModal = $modalContainer.find('#CreateModal');
    var $createForm = $createModal.find("#CreateForm");
    var $saveButton = $createModal.find('.create');

    //Update
    var $updateModal = $modalContainer.find('#UpdateModal');
    var $updateForm = $updateModal.find(".form");
    var $updateButton = $updateModal.find('.update');

    //Delete
    var $deleteModal = $modalContainer.find('#DeleteModal');
    var $yesDeleteButton = $deleteModal.find('.yes');

    function showCreateModal(){
      $modalContainer.addClass('active')
      $createModal.show();
    }

    function showUpdateModal() {
      var $this = $(this)
      announcementId = $this.data('announcementId');
      
      var $title = $updateModal.find('.title');
      var $announcement = $updateModal.find('.announcement');
      
      $.ajax({
        type: "GET",
        url: '/resources/announcement/announcement.php',
        data: $.param({
          'id': announcementId
        }),
        success: function(res){
          
          if(res.success) {
            $title.val(res.data.title)
            $announcement.val(res.data.announcement)
            $modalContainer.addClass('active')
            $updateModal.show();
          }
        },
        error: function(err) {
          console.error("Something went wrong");
        }
      });
    }

    function showDeleteModal(){
      announcementId = $(this).data('announcementId'); //get id of selected exam
      $modalContainer.addClass('active')
      $deleteModal.show();
    }

    function closeModals(){
      $modalContainer.removeClass('active');
      $updateModal.hide();
      $createModal.hide();
      $deleteModal.hide();
      validateCreate.resetForm();
      validateUpdate.resetForm();
    }

    function createRecord(){
      if($createForm.valid()) {
        var formData = new FormData($createForm[0]);
        $.ajax({
          type: "POST",
          url: '/resources/announcement/add.php',
          data: formData,
          contentType: false, // NEEDED, DON'T OMIT THIS (requires jQuery 1.6+)
          processData: false, // NEEDED, DON'T OMIT THIS
          success: function(res){
            if(res.success) {
              location.reload();
            }
            else {
              alert(res.message)
            }
          },
          error: function(err) {
            console.error("Something went wrong");
          }
        });
      }
    }

    function updateRecord(){
      if($updateForm.valid()) {
        var formData = new FormData($updateForm[0]);
        formData.append('id', announcementId)
        $.ajax({
          type: "POST",
          url: '/resources/announcement/update.php',
          data: formData,
          contentType: false, // NEEDED, DON'T OMIT THIS (requires jQuery 1.6+)
          processData: false, // NEEDED, DON'T OMIT THIS
          success: function(res){
            if(res.success) {
              location.reload();
            }
            else {
              alert(res.message)
            }
          },
          error: function(err) {
            console.error("Something went wrong");
          }
        });
      }
    }

    function deleteRecord() {
      var url = '/resources/announcement/delete.php';
      $.ajax({
        type: "POST",
        url: url,
        data: $.param({'id': announcementId}),
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
      validateCreate = $createForm.validate({ errorClass: "error-field" })
      validateUpdate = $updateForm.validate({ errorClass: "error-field" })

      $createRecordButton.on('click', showCreateModal)
      $saveButton.on('click', createRecord)

      $updateRecordButton.on('click', showUpdateModal)

      $deleteRecordButton.on('click', showDeleteModal)
      $yesDeleteButton.on('click', deleteRecord)

      $updateButton.on('click', updateRecord)

      //Close all modals
      $modal.find('.close').on('click', closeModals)
    }

    return {
      init: init
    }
  })()

  announcementModule.init()
})