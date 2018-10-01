jQuery(document).ready(function($) {
  var homeModule = (function(){
    
    function init(){
      $(".owl-carousel").owlCarousel();
    }

    return {
      init: init
    }
  })()

  homeModule.init()
})