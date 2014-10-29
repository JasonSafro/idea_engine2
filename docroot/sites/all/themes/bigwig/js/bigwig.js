jQuery(document).ready(function($) {
	jQuery.fn.exists = function(){ return this.length>0; }

	
	if (jQuery('.sticky-header').exists()) {
	    $(window).resize(function() {
	    	var $top = $('.info-bar').height();   
	        if ($(this).scrollTop() >= $top) {
				$('.menu-bar').addClass('fixed');
			} else {
				$('.menu-bar').removeClass('fixed');
			}
	    });
	    
	    $(document).scroll( function() {
	    	var $top = $('.info-bar').height();   
	    	
	        if ($(this).scrollTop() >= $top) {
				$('.menu-bar').addClass('fixed');
			} else {
				$('.menu-bar').removeClass('fixed');
			}
	    });
	}


	
});