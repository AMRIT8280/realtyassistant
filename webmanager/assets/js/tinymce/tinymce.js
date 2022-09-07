"use strict";
// Class definition

var KTTinymce = function () {    
    // Private functions
    var demos = function () {
      
		tinymce.init({
		forced_root_block : "",
		branding: false,
		//statusbar: false,
		selector: '#myTextarea',
		
		width: 800,
		height: 300,
		plugins: [
		  'advlist link image lists charmap print preview hr anchor pagebreak',
		  'searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking',
		  'table emoticons template paste'
		],
		toolbar: 'undo redo| code | styleselect | bold italic link | alignleft aligncenter alignright alignjustify | ' +
		  'bullist numlist outdent indent |',
		menu: {
		  //favs: {title: 'My Favorites', items: 'code visualaid | searchreplace | emoticons print preview media fullpage |'}
		},
		menubar: 'favs  view format table',
		content_css: 'css/content.css'
	  });       
    }

    return {
        // public functions
        init: function() {
            demos(); 
        }
    };
}();

// Initialization
jQuery(document).ready(function() {
    KTTinymce.init();
});