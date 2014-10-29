<?php 

/**
 * @file
 * Create compound field using the Field Types API.
 *
 * @see field_types
 * @see field
 */

/***************************************************************
 * Add Slide Builder Javascript/CSS
***************************************************************/
function pe_slider_preprocess_html(&$vars) {
	if (path_is_admin(current_path())) {
		drupal_add_library('system', 'ui.draggable');
		drupal_add_js(drupal_get_path('module', 'pe_slider') . '/js/admin.js');
		drupal_add_js(drupal_get_path('theme', 'bigwig') . '/js/admin/admin.js');
		drupal_add_css($theme_path = drupal_get_path('theme', variable_get('theme_default', NULL)) . '/css/slider.css');
	}
}

/**
 * Implements hook_css_alter().
 */
function pe_slider_css_alter(&$css) {
	if (path_is_admin(current_path())) {
		drupal_add_css(drupal_get_path('module', 'pe_slider') . '/css/admin.css');
	}
}

/***************************************************************
 * Field Type API hooks
***************************************************************/

/**
 * Implements hook_field_info().
 *
 * Provides the description of the field.
 */

function pe_slider_field_info() {
	return array(
			'pe_slider_layer' => array(
					'label' => t('Layer Settings'),
					'description' => t("This field stores PC layer values"),
					'default_widget' => 'pe_slider_layer',
					'default_formatter' => 'pe_slider_layer',
			),

	);
}

/**
 * Implements hook_field_validate().
 *
 * This hook gives us a chance to validate content that's in our
 * field.
 *
 * @see pe_slider_field_widget_error()
 */
function pe_slider_field_validate($entity_type, $entity, $field, $instance, $langcode, $items, &$errors) {
	foreach ($items as $delta => $item) {
		// ...
	}
}


/**
 * Implements hook_field_is_empty().
 *
 * hook_field_is_emtpy() is where Drupal asks us if this field is empty.
 * Return TRUE if it does not contain data, FALSE if it does. This lets
 * the form API flag an error when required fields are empty.
 */
function pe_slider_field_is_empty($item, $field) {
	$temp = array_keys($field['columns']);
	$key = array_shift($temp);
	return empty($item[$key]);
}

/**
 * Implements hook_field_formatter_info().
 *
 * We need to tell Drupal that we have two different types of formatters
 * for this field. One will change the text color, and the other will
 * change the background color.
 *
 * @see pe_slider_field_formatter_view()
 */
function pe_slider_field_formatter_info() {
	return array(
			'pe_slider_layer' => array(
					'label' => t('layer fields'),
					'field types' => array('pe_slider_layer'),
			),
	);
}

function pe_slider_field_presave($entity_type, $entity, $field, $instance, $langcode, &$items) {
	// Make sure that each file which will be saved with this object has a
	// permanent status, so that it will not be removed when temporary files are
	// cleaned up.

	switch ($instance['widget']['type']) {
		case 'pe_slider_layer':

			foreach ($items as $delta => $item) {
				if ($item['img'] != 0) {
					$file = file_load($item['img']);
					if (!$file->status) {
						$file->status = FILE_STATUS_PERMANENT;
						file_save($file);
						file_usage_add($file, 'pe_slider', 'pe_slider', $item['img']);
					}
				}
			}
			break;

	}
}

/**
 * Implements hook_field_formatter_view().
 *
 * Two formatters are implemented.
 * - pe_slider_simple_text just outputs markup indicating the color that
 *   was entered and uses an inline style to set the text color to that value.
 * - pe_slider_color_background does the same but also changes the
 *   background color of div.region-content.
 *
 * @see pe_slider_field_formatter_info()
 */
function pe_slider_field_formatter_view($entity_type, $entity, $field, $instance, $langcode, $items, $display) {
	$element = array();

	switch ($display['type']) {
		case 'pe_slider_layer':

			foreach ($items as $delta => $item) {

				$layer_value = '';
				$tag = '';
				$image = '';
				$max_delta = count($items) - 1;
				$max_format = ($delta == $max_delta) ? '</li>' : '';
					
				if (!empty($item['img'])) {
					$img_path = '<img src="'.file_create_url(file_load($item['img'])->uri).'" />';
				} else {
					$img_path = '&nbsp;';
				}

				switch ($item['layer']) {
					case "img": $layer_value = $img_path; break;
					case "div": $layer_value = $item['markup']; break;
					default: $layer_value = ""; break;
				}
					
				if ($item['layer'] == 'img') {
					$tag = 'div';
				} else { $tag = $item['layer'];
				}
					
				$element[$delta] = array('#markup' => '<'.$tag.' class="caption '
						.$item['layer'].' '
						.$item['css'].'" data-transition="'
						.$item['transition'].'" data-delay="'
						.$item['delay'].'" data-duration="'
						.$item['duration'].'" data-x="'
						.$item['x'].'" data-y="'
						.$item['y'].'">'.$layer_value.'</'.$tag.'>'.$max_format);
			}
			break;
	}
	return $element;
}

/**
 * Implements hook_field_widget_info().
 *
 * These widget types will eventually show up in hook_field_widget_form,
 * where we will have to flesh them out.
 *
 * @see pe_slider_field_widget_form()
 */
function pe_slider_field_widget_info() {
	return array(
			'pe_slider_layer' => array(
					'label' => t('Layer values'),
					'field types' => array('pe_slider_layer'),
			),
	);
}

/**
 * Implements hook_field_widget_form().
 *
 * hook_widget_form() is where Drupal tells us to create form elements for
 * our field's widget.
 */
function pe_slider_field_widget_form(&$form, &$form_state, $field, $instance, $langcode, $items, $delta, $element) {
	switch ($instance['widget']['type']) {

		case 'pe_slider_layer':

			$settings = $form_state['field'][$instance['field_name']][$langcode]['field']['settings'];

			$field_name = $instance['field_name'];

			$element['#attached']['css'] = array(drupal_get_path('module', 'pe_slider') . '/css/admin.css');
			
			$element['#attributes']['autocomplete'] = 'off';
			$element['layer'] = array(
					'#attributes' => array('class' => array('edit-pe_slider-fields-layer-'.$delta), 'title' => t('')),
					'#type' => 'select',
					'#title' => t('Layer Type:'),
					'#description' => t('HTML Wrapper'),
					'#options'       => array(
							'0' => t('Select type:'),
							'img' => t('Image'),
							'div' => t('Text'),
					),
			);

			$element['transition'] = array(
					'#attributes' => array('class' => array('edit-pe_slider-fields-transition'), 'title' => t('')),
					'#type' => 'select',
					'#title' => t('data-transition'),
					'#description' => t('Transition effect'),
					'#options'       => array(
							'bounce' => t('bounce'),
							'bounceIn' => t('bounceIn'),
							'bounceInDown' => t('bounceInDown'),
							'bounceInLeft' => t('bounceInLeft'),
							'bounceInRight' => t('bounceInRight'),
							'bounceInUp' => t('bounceInUp'),
							'bounceOut' => t('bounceOut'),
							'bounceOutDown' => t('bounceOutDown'),
							'bounceOutLeft' => t('bounceOutLeft'),
							'bounceOutRight' => t('bounceOutRight'),
							'bounceOutUp' => t('bounceOutUp'),
							'fadeIn' => t('fadeIn'),
							'fadeInDownBig' => t('fadeInDownBig'),
							'fadeInDown' => t('fadeInDown'),
							'fadeInLeftBig' => t('fadeInLeftBig'),
							'fadeInLeft' => t('fadeInLeft'),
							'fadeInRightBig' => t('fadeInRightBig'),
							'fadeInRight' => t('fadeInRight'),
							'fadeInUpBig' => t('fadeInUpBig'),
							'fadeInUp' => t('fadeInUp'),
							'fadeOut' => t('fadeOut'),
							'fadeOutDownBig' => t('fadeOutDownBig'),
							'fadeOutDown' => t('fadeOutDown'),
							'fadeOutLeftBig' => t('fadeOutLeftBig'),
							'fadeOutLeft' => t('fadeOutLeft'),
							'fadeOutRightBig' => t('fadeOutRightBig'),
							'fadeOutRight' => t('fadeOutRight'),
							'fadeOutUpBig' => t('fadeOutUpBig'),
							'fadeOutUp' => t('fadeOutUp'),
							'flash' => t('flash'),
							'flip' => t('flip'),
							'flipInX' => t('flipInX'),
							'flipInY' => t('fadeInY'),
							'flipOutX' => t('flipOutX'),
							'flipOutY' => t('fadeOutY'),
							'hinge' => t('hinge'),
							'lightSpeedIn' => t('lightSpeedIn'),
							'lightSpeedOut' => t('lightSpeedOut'),
							'pulse' => t('pulse'),
							'rollIn' => t('rollIn'),
							'rollOut' => t('rollOut'),
							'rotateIn' => t('rotateIn'),
							'rotateInDownLeft' => t('rotateInDownLeft'),
							'rotateInDownRight' => t('rotateInDownRight'),
							'rotateInUpLeft' => t('rotateInUpLeft'),
							'rotateInUpRight' => t('rotateInUpRight'),
							'rotateOut' => t('rotateOut'),
							'rotateOutDownLeft' => t('rotateOutDownLeft'),
							'rotateOutDownRight' => t('rotateOutDownRight'),
							'rotateOutUpLeft' => t('rotateOutUpLeft'),
							'rotateOutUpRight' => t('rotateOutUpRight'),
							'shake' => t('shake'),
							'swing' => t('swing'),
							'tada' => t('tada'),
							'wiggle' => t('wiggle'),
							'wobble' => t('wobble'),
					),

					'#states' => array(
							'invisible' => array(      // Action to take: check the checkbox.
									':input[name="'.$field_name.'[und]['.$delta.'][layer]"]' => array('value' => 0),
							),
							'disabled' => array(      // Action to take: check the checkbox.
									':input[name="'.$field_name.'[und]['.$delta.'][layer]"]' => array('value' => 0),
							),
					),
			);


			$element['x'] = array(
					'#attributes' => array('class' => array('edit-pe_slider-fields-data-x'), 'title' => t('')),
					'#type' => 'textfield',
					'#maxlength' => 4,
					'#size' => 4,
					'#title' => t('data-x'),
					'#description' => t('x-axis'),
					'#states' => array(
							'invisible' => array(      // Action to take: check the checkbox.
									':input[name="'.$field_name.'[und]['.$delta.'][layer]"]' => array('value' => 0),
							),
							'disabled' => array(
									':input[name="'.$field_name.'[und]['.$delta.'][layer]"]' => array('value' => 0),
							),
					),
			);
				

			$element['y'] = array(
					'#attributes' => array('class' => array('edit-pe_slider-fields-data-y'), 'title' => t('')),
					'#type' => 'textfield',
					'#maxlength' => 4,
					'#size' => 4,
					'#title' => t('data-y'),
					'#description' => t('y-axis'),
					'#states' => array(
							'invisible' => array(      // Action to take: check the checkbox.
									':input[name="'.$field_name.'[und]['.$delta.'][layer]"]' => array('value' => 0),
							),
							'disabled' => array(
									':input[name="'.$field_name.'[und]['.$delta.'][layer]"]' => array('value' => 0),
							),
					),
			);

			$element['duration'] = array(
					'#attributes' => array('class' => array('edit-pe_slider-fields-data-duration'), 'title' => t('')),
					'#type' => 'textfield',
					'#maxlength' => 4,
					'#size' => 4,
					'#field_suffix' => 'ms',
					'#title' => t('data-duration:'),
					'#description' => t('Animation duration'),
					'#states' => array(
							'invisible' => array(      // Action to take: check the checkbox.
									':input[name="'.$field_name.'[und]['.$delta.'][layer]"]' => array('value' => 0),
							),
					),
			);

			$element['delay'] = array(
					'#attributes' => array('class' => array('edit-pe_slider-fields-data-delay'), 'title' => t('')),
					'#type' => 'textfield',
					'#maxlength' => 4,
					'#size' => 4,
					'#field_suffix' => 'ms',
					'#title' => t('data-delay:'),
					'#description' => t('delay animation'),
					'#states' => array(
							'invisible' => array(      // Action to take: check the checkbox.
									':input[name="'.$field_name.'[und]['.$delta.'][layer]"]' => array('value' => 0),
							),
					),
			);

			

			$element['css'] = array(
					'#attributes' => array('class' => array('add-css edit-pe_slider-fields-css-'.$delta), 'title' => t('')),
					'#type' => 'textfield',
					'#size' => 10,
					'#title' => t('CSS Classes'),
					'#description' => t("Add additional CSS classes to this layer."),
					'#states' => array(
							'invisible' => array(      // Action to take: check the checkbox.
									':input[name="'.$field_name.'[und]['.$delta.'][layer]"]' => array('value' => 0),
							),
					),
			);
			
			$element['img'] = array(
					'#attributes' => array('class' => array('edit-pe_slider-fields-image-'.$delta), 'title' => t('')),
					'#type' => 'managed_file',
					'#title' => t('Image upload'),
					'#upload_validators' => array(
							'file_validate_extensions' => array(0 => 'png jpg jpeg gif'),
					),
					'#upload_location' => 'public://default_images/',
					'#description' => t("Upload an image."),
					'#states' => array(
							'visible' => array(      // Action to take: check the checkbox.
									':input[name="'.$field_name.'[und]['.$delta.'][layer]"]' => array('value' => 'img'),
							),
					),
			);
			
			$element['markup'] = array(
					'#attributes' => array('class' => array('edit-pe_slider-fields-markup-'.$delta), 'title' => t('')),
					'#type' => 'textarea',
					'#title' => t('Markup:'),
					'#description' => t("Paste markup in the textarea above."),
					'#states' => array(
							'visible' => array(      // Action to take: check the checkbox.
									':input[name="'.$field_name.'[und]['.$delta.'][layer]"]' => array('value' => 'div'),
							),
					),
			);
				
			$element['delete'] = array(
					'#attributes' => array('class' => array('edit-pe_slider-fields-css-'.$delta), 'title' => t('')),
					'#type' => 'fieldset',
					'#title' => t("Select a layer type:"),
					'#description' => t("If a layer type is not selected, this layer will be deleted on save."),
					'#states' => array(
							'visible' => array(      // Action to take: check the checkbox.
									':input[name="'.$field_name.'[und]['.$delta.'][layer]"]' => array('value' => 0),
							),
					),
			);


			// Loop through all the element children and set a default value if we have one. Then set HTML wrappers.
			foreach (element_children($element) as $element_key) {
				$value = isset($items[$delta][$element_key]) ? $items[$delta][$element_key] : '';
				$element[$element_key]['#default_value'] = $value;
			}
			break;

	}



	return $element;
}

function pe_slider_form_alter(&$form, &$form_state, $form_id) {
	$form['#attributes']['autocomplete'] = 'off';	
}