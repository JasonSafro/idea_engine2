<?php

/**
 * Implements hook_image_default_styles().
 */
 function flare_lightbox_image_default_styles() {
 	$styles = array();
	
 	/* Masonry Thumbnail Dimensions (Width => Height) */
 	$thumbnails = array(
 		'320' => '240',
 		'420' => '372',
 		'620' => '350',	
 		'940' => '460'	
 	);
	
 	// Default image presets for Flare Lightbox
 	foreach($thumbnails as $width => $height) {
 		$styles['bigwig_'.$width.'x'.$height] = array(
 				'label' => 'BigWig Portfolio ('.$width.'x'.$height.')',
 				'effects' => array(
 						array(
 								'name' => 'image_scale_and_crop',
 								'data' => array('width' => $width, 'height' => $height),
 								'weight' => 0,
 						),
 				),
 		);
 	}

 	return $styles;
}

function flare_lightbox_field_info() {
	return array(
			'flare_lightbox' => array(
					'label' => t('Flare Lightbox'),
					'description' => t("Add social media icons through the Field Type API."),
					'default_widget' => 'flare_lightbox',
					'default_formatter' => 'flare_lightbox', // This doesn't *have* to be the same name as default_widget's value, this is only coincidence
			),
	);
}

function flare_lightbox_field_validate($entity_type, $entity, $field, $instance, $langcode, $items, $errors) {
	foreach ($items as $delta => $item) {

	}
}

/**
 * Implements hook_field_is_empty().
 *
 * hook_field_is_emtpy() is where Drupal asks us if this field is empty.
 * Return TRUE if it does not contain data, FALSE if it does. This lets
 * the form API flag an error when required fields are empty.
 */
function flare_lightbox_field_is_empty($item, $field) {
	$temp = array_keys($field['columns']);
	$key = array_shift($temp);
	return empty($item[$key]);
}

function flare_lightbox_field_presave($entity_type, $entity, $field, $instance, $langcode, &$items) {
	// Make sure that each file which will be saved with this object has a
	// permanent status, so that it will not be removed when temporary files are
	// cleaned up.

	foreach ($items as $delta => $item) {
		if ($item['img'] != 0) {
			$file = file_load($item['img']);
			
			if (!$file->status) {
				$file->status = FILE_STATUS_PERMANENT;
				file_save($file);
				file_usage_add($file, 'flare_lightbox', 'flare_lightbox', $item['img']);
			}
			
			if ($item['toggle_masonry'] == 1) {
				$width = $item['masonry_thumbnail_width'];
				$height = $item['masonry_thumbnail_height'];
				
				$directory = file_build_uri('bigwig/masonry_thumbnails');
				if (!file_prepare_directory($directory, FILE_CREATE_DIRECTORY)) {
					$directory = NULL;
				}

				$thumb = system_retrieve_file(file_create_url($file->uri), $directory, TRUE, $replace = FILE_EXISTS_REPLACE);
				$image = image_load($thumb->uri);
				$scaled = image_scale_and_crop($image, $width, $height); // it returns TRUE
				image_save($image);
			}
		}
	}
}

function flare_lightbox_field_widget_info() {
	$arr['flare_lightbox'] = array(
			'label' => t('Default'),
			'field types' => array('flare_lightbox'),
	);
	
	foreach(image_styles() as $item) {
		$arr[$item['name']] = array(
				'label' => t($item['label']),
				'field types' => array('flare_lightbox'),
		);
	}
	
	return $arr;
}

function flare_lightbox_field_formatter_info() {
	
	$arr['flare_lightbox'] = array(
			'label' => t('Default'),
			'field types' => array('flare_lightbox'),
	);
	
	foreach(image_styles() as $item) {
		$arr[$item['name']] = array(
				'label' => t($item['label']),
				'field types' => array('flare_lightbox'),
		);
	}
	
	return $arr;
	
}

function flare_lightbox_field_formatter_view($entity_type, $entity, $field, $instance, $langcode, $items, $display) {
	$element = array();
	
	foreach ($items as $delta => $item) {
		
		if (!empty($item['img'])) {
			$img = file_create_url(file_load($item['img'])->uri);
			
			if($display['type'] == 'flare_lightbox') {
				$element[$delta] = array('#markup' => '<img src="'.$img.'" />');
			} else {
				$style = image_style_url($display['type'], file_load($item['img'])->uri);
				$element[$delta] = array('#markup' => '<img src="'.$style.'" />');
			}
			
		} else {
			$img = '&nbsp;';
		}
		
	}

	return $element;
}

function flare_lightbox_field_widget_form(&$form, &$form_state, $field, $instance, $langcode, $items, $delta, $element) {
	switch ($instance['widget']['type']) {
		case 'flare_lightbox':
			
			$settings = $form_state['field'][$instance['field_name']][$langcode]['field']['settings'];
			$field_name = $instance['field_name'];
			
			$element['img'] = array(
					'#attributes' => array('class' => array('edit-revolution_slider-fields-image-'.$delta), 'title' => t('')),
					'#type' => 'managed_file',
					'#title' => t('Image upload'),
					'#upload_validators' => array(
							'file_validate_extensions' => array(0 => 'png jpg jpeg gif'),
					),
					'#attached' => array(
							'css' => array(drupal_get_path('module', 'flare_lightbox') . '/admin.css'),
							'js' => array(drupal_get_path('module', 'flare_lightbox') . '/admin.js')
							),
					'#upload_location' => 'public://bigwig/'
			);
			
			
			$element['alt'] = array(
					'#type' => 'textfield',
					'#title' => t('Alt'),
					'#description' => t('Add an alt attribute to this image.')
			);
			
			$element['title'] = array(
					'#type' => 'textfield',
					'#title' => t('Title'),
					'#description' => t('Add a title attribute to this image.')
			);
			
			$element['toggle_caption'] = array(
					'#type' => 'checkbox',
					'#title' => t('Add Caption'),
					'#prefix' => t('<label>Options</label>')
			);
			
			$element['toggle_masonry'] = array(
					'#type' => 'checkbox',
					'#title' => t('Add Masonry Thumbnail')
			);
				
			$element['caption'] = array(
					'#type' => 'textarea',
					'#title' => t('Caption Text:'),
					'#rows' => 2,
					'#states' => array(
							'visible' => array(
									':input[name="'.$field_name.'[und]['.$delta.'][toggle_caption]"]' => array('checked' => TRUE),
							),
					),
			);
			
			$element['masonry_thumbnail_width'] = array(
					'#prefix' => t('<div class="field-thumbnail">'),
					'#field_suffix' => t('px'),
					'#type' => 'textfield',
					'#title' => t('Thumbnail Width:'),
					'#states' => array(
							'visible' => array(
									':input[name="'.$field_name.'[und]['.$delta.'][toggle_masonry]"]' => array('checked' => TRUE),
							),
					),
			);
			
			$element['masonry_thumbnail_height'] = array(
					'#type' => 'textfield',
					'#title' => t('Thumbnail Height:'),
					'#suffix' => t('<div class="description">The suggested width for masonry thumbnails is 256px.</div></div>'),
					'#field_suffix' => t('px'),
					'#states' => array(
							'visible' => array(
									':input[name="'.$field_name.'[und]['.$delta.'][toggle_masonry]"]' => array('checked' => TRUE),
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



?>