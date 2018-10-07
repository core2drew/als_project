jQuery(document).ready(function($) {
  var homeModule = (function(){

    var $manageHome = $('#ManageHome')

    var $ActivitySlider = $manageHome.find('#ActivitySlider')
    var $Announcements = $manageHome.find('#Announcements')

    function generateActivities(data, $container) {
      if(data) {
        data.map(function(d) {
          var $item = $("<div/>").addClass('item')
          var $img = $('<div/>').css('backgroundImage', `url(${d.image_url})`).addClass('image')
          var $caption = $('<p/>').addClass('caption')
          $caption.html(d.description)
          $item.append($img)
          $item.append($caption)
          $ActivitySlider.append($item)
        })
        sliderInit()
      } else {
        var $noActivity = $('<div/>').attr('id', 'NoActivity')
        var $message = $('<h3/>').addClass('message').html('No Activities')
        $noActivity.append($message)
        $container.append($noActivity);
      }
    }

    function generateAnnouncements(data, $container){
      if(data) {
        data.map(function(d) {
          var $item = $("<div/>").addClass('item')
          var $announcer = $("<span/>").addClass('announcer')
          var $profileImage = $('<img/>').attr('src', d.profile_image_url).addClass('image')
          var $name = $('<span/>').addClass('name').append(d.announcer)

          $announcer.append($profileImage).append($name)

          var $announcement = $("<div/>").addClass('announcement')
          var $postDate = $('<p/>').addClass('post-date').append(d.created_at)
          var $message = $('<p/>').addClass('message').append(d.announcement)

          $announcement.append($postDate).append($message)

          $item.append($announcer).append($announcement)
          $container.append($item)
        })
      } else {
        var $noAnnouncements = $('<div/>').attr('id', 'NoAnnouncements')
        var $message = $('<h3/>').addClass('message').html('No Announcements')
        $noAnnouncements.append($message)
        $container.append($noAnnouncements);
      }
    }

    function sliderInit(){
      $('#ActivitySlider').slick({
        prevArrow:
        `<svg version="1.1" id="prevSlide" class="slidenav" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
              width="306px" height="306px" viewBox="0 0 306 306" style="enable-background:new 0 0 306 306;" xml:space="preserve">
          <g>
            <g id="keyboard-arrow-left">
              <polygon points="247.35,270.3 130.05,153 247.35,35.7 211.65,0 58.65,153 211.65,306 		"/>
            </g>
          </g>
        </svg>`,
        nextArrow: 
        `<svg version='1.1' id="nextSlide" class='slidenav' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' x='0px' y='0px' width='306px' height='306px' viewBox='0 0 306 306' xml:space='preserve'>
          <g>
            <g id='chevron-right'>
              <polygon points="94.35,0 58.65,35.7 175.95,153 58.65,270.3 94.35,306 247.35,153 "/>
            </g>
          </g>
        </svg>`
      });
    }

    function getActivities(){
      $.ajax({
        type: 'GET',
        url: '/resources/activity/activity.php',
        success: function(res) {
          //Generate activities
          generateActivities(res.data, $ActivitySlider)
        },
        error: function(err) {
          console.error("Something went wrong");
        }
      })
    }

    function getAnnouncements(){
      $.ajax({
        type: 'GET',
        url: '/resources/announcement/announcement.php',
        success: function(res) {
          //Generate activities
          generateAnnouncements(res.data, $Announcements)
        },
        error: function(err) {
          console.error("Something went wrong");
        }
      })
    }
    
    function init(){
      getActivities();
      getAnnouncements();
    }
    return {
      init: init
    }
  })()

  homeModule.init()
})