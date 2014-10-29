(function($) {
	$(document).ready(function() {

		var $container = $('#isotope-container');

		$container.isotope({
			itemSelector: '.isotope-element',
			animationOptions: {
				duration: 500,
				easing: 'linear',
				queue: false
			}
		//filter: '.nothing'
		});

		jQuery(window).resize(function() {
			setTimeout(function() {jQuery('.portfolio').isotope('reLayout');},550);
		});

		var $optionSets = $('#isotope-options .option-set'),
		$optionLinks = $optionSets.find('a');

		$optionLinks.click(function(){

			$container.isotope({
				animationOptions: {
					duration: 500,
					easing: 'linear',
					queue: false
				}
			});

			var $this = $(this);
			// don't proceed if already selected
			if ( $this.hasClass('selected') ) {
				return false;
			}
			var $optionSet = $this.parents('.option-set');
			$optionSet.find('.selected').removeClass('selected');
			$this.addClass('selected');

			var options = {},
			key = $optionSet.attr('data-option-key'),
			value = $this.attr('data-option-value');
			// parse 'false' as false boolean
			value = value === 'false' ? false : value;
			options[ key ] = value;
			if ( key === 'layoutMode' && typeof changeLayoutMode === 'function' ) {
				// changes in layout modes need extra logic
				changeLayoutMode( $this, options )
			} else {
				// otherwise, apply new options
				$container.isotope( options );
			}

			return false;
		});
	});
})(jQuery);