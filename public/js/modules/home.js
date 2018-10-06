jQuery(document).ready(function($) {
  var homeModule = (function(){

    var $manageHome = $('#ManageHome')

    var $ActivityContainer = $manageHome.find('#ActivityContainer')
    var $ActivitySlider = $ActivityContainer.find('#ActivitySlider')
    var $NoActivity = $manageHome.find('#NoActivity')

    function generateActivities(data, container) {
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
      }else {
        $NoActivity.show();
        $ActivitySlider.hide();
      }
    }

    function getActivities(){
      $.ajax({
        type: 'GET',
        url: '/resources/activity/activity.php',
        success: function(res) {
          //Generate activities
          generateActivities(res.data, $ActivitySlider)

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
        },
        error: function(err) {
          console.error("Something went wrong");
        }
      })
    }
    
    function init(){
      getActivities();
      
    }
    return {
      init: init
    }
  })()

  homeModule.init()
})