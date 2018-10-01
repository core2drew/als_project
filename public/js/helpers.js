//Helper Module
var helperModule = (function(){
  var clearInputFile = function(elem) {
    elem.wrap('<form>').closest('form').get(0).reset();
    elem.unwrap();
    elem.val('');
  }

  var $_GET = function(param) {
    var vars = {};
    window.location.href.replace( location.hash, '' ).replace( 
      /[?&]+([^=&]+)=?([^&]*)?/gi, // regexp
      function( m, key, value ) { // callback
        vars[key] = value !== undefined ? value : '';
      }
    );
    if ( param ) {
      return vars[param] ? vars[param] : null;	
    }
    return vars;
  }

  return {
    clearInputFile: clearInputFile,
    $_GET: $_GET
  }
})()