jQuery(document).ready(function($){
	
    jQuery.fn.exists = function () { return this.length > 0 };
    
    if($('body.page-admin-appearance').exists()) {
		$('.vertical-tabs').before('<div class="branding">Boutique Framework 1.1</div>');
		$(".vertical-tab-button:last").addClass('misc');
		$(".vertical-tab-button:eq(3)").addClass('regions');
		$(".vertical-tab-button:eq(2)").addClass('layout');
		$(".vertical-tab-button:eq(1)").addClass('background');
		
		if($('#edit-custom div.form-wrapper').exists() == false) {
			$('#edit-custom').remove();
		};
		
		/* THEME SETTINGS: BACKGROUND IMAGE */
		
		$('input:checked').parent().addClass('form-item-active');
	
		$('input:radio').click(function() {
			$('input:radio[name='+$(this).attr('name')+']').parent().removeClass('form-item-active');
	        $(this).parent().addClass('form-item-active');
		});
		
		/* THEME SETTINGS: COLOR PICKER */
		$('#edit-backgroundcolor').ColorPicker({
				onSubmit: function(hsb, hex, rgb, el) {
					$(el).val(hex);
					$(el).ColorPickerHide();
				},
				onBeforeShow: function () {
					$(this).ColorPickerSetColor(this.value);
				}
			}).bind('keyup', function(){
				$(this).ColorPickerSetColor(this.value);
			});
	
		$('.colorpicker_submit').text('Submit');
    }
	
    if($('#edit-field-template-und').exists()) {
		$template = $('select#edit-field-template-und');
		
		switch($template.val()) {
			case 'image':
				$('.field-name-field-video').hide();
			break;
			case 'slider':
				$('.field-name-field-video').hide();
			break;
		}
		
		$template.change(function () {
			switch($(this).val()) {
				case 'video':
					$('.field-name-field-video').show();
				break;
				case 'image':
					$('.field-name-field-video').hide();
				break;
				case 'slider':
					$('.field-name-field-video').hide();
				break;
			}
		});
    }
    
    if($('body.page-admin-structure-block').exists()) {
    	$bigwig = $('#block-system-help a:contains("Demonstrate block regions")');
    	$bigwig.after('<div style="margin-top: 20px;" class="messages status"><strong>Notice:</strong> The default BigWig block templates are managed using the Context module. To manage the blocks contained within the prepackaged templates, navigate to Structure > Context.</div>');
    }

});
