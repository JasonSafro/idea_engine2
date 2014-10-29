<?php

/**
 * @file
 * PeSlider type editing UI.
 */

/**
 * UI controller.
 */
class PeSliderTypeUIController extends EntityDefaultUIController {

	/**
	 * Overrides hook_menu() defaults.
	 */
	public function hook_menu() {
		$items = parent::hook_menu();
		$items[$this->path]['title'] = 'BigWig Slider';
		$items[$this->path]['description'] = 'Manage BigWig Slider entity types, including adding
		and removing fields and the display of fields.';
		
		unset($items[$this->path . '/import']);
		
		return $items;
	}
	
}

/**
 * Generates the pe_slider type editing form.
 */
function pe_slider_type_form($form, &$form_state, $pe_slider_type, $op = 'edit') {

	$human_readable = strtolower($pe_slider_type->label);

	$machine_readable = preg_replace('@[^a-z0-9_]+@','_',$human_readable);
	$query = new EntityFieldQuery();

	$query->entityCondition('entity_type', 'pe_slider');

	$result = $query->execute();

	if (isset($result['pe_slider'])) {

		$news_items_nids = array_keys($result['pe_slider']);

		$news_items = entity_load('pe_slider', $news_items_nids);

	}

	if ($op == 'clone') {
		$hideops = '.views-field-operations, ul.action-links, p.no-slides { display: none; }';
		$pe_slider_type->label .= ' (cloned)';
		$pe_slider_type->type = '';
		drupal_add_css($hideops, 'inline', array('preprocess' => TRUE));
	}
	
	if($pe_slider_type->label == NULL) {
		$add = '';
	} else {
		$add = '<ul class="action-links"><li><a href="'.$GLOBALS['base_url'].'/admin/content/pe_slider/add/'.$pe_slider_type->type.'">Add new slide</a></li></ul>';
	}
	
	if(views_embed_view('pe_slider', $display_id = 'pe_slider_admin_block') == '') {
		($pe_slider_type->label == NULL) ? $slides = '' : $slides = '<p class="no-slides">No Slides have been created.</p>';
	} else {
		$slides = views_embed_view('pe_slider', $display_id = 'pe_slider_admin_block');
	}
	
	$form['label'] = array(
		'#title' => t('Slider Name'),
		'#suffix' => $add.$slides,
		'#type' => 'textfield',
		'#default_value' => $pe_slider_type->label,
		'#description' => t('The human-readable name of this BigWig Slider.'),
		'#required' => TRUE,
		'#size' => 30,
	);

	// Machine-readable type name.
	$form['type'] = array(
		'#type' => 'machine_name',
		'#default_value' => isset($pe_slider_type->type) ? $pe_slider_type->type : '',
		'#maxlength' => 32,
		//    '#disabled' => $pe_slider_type->isLocked() && $op != 'clone',
		'#machine_name' => array(
			'exists' => 'pe_slider_get_types',
			'source' => array('label'),
		),
		'#description' => t('A unique machine-readable name for this pe_slider type. It must only contain lowercase letters, numbers, and underscores.'),
	);

	$form['data']['#tree'] = TRUE;
	$form['data']['sample_data'] = array(
		'#type' => 'textfield',
		'#attributes' => array('class' => array('element-invisible')),
		'#default_value' => $machine_readable
	);

	// BigWig Slider: parameters Settings
	$form['data']['parameters'] = array(
		'#type' => 'fieldset',
		'#title' => t('Parameters')
	);
	
	$form['data']['parameters']['autopause'] = array(
		'#type' => 'checkbox',
		'#title' => t('Enable Autopause'),
		'#default_value' => isset($pe_slider_type->data['autopause']) ? $pe_slider_type->data['autopause'] : 0
	);
	
	$form['data']['parameters']['plugin'] = array(
		'#type' => 'select',
		'#title' => t('data-plugin'),
		'#options' => array(
			'"peVario"' => t('peVario'),
			'"peVolo"' => t('peVolo')
		),
		'#default_value' => isset($pe_slider_type->data['parameters']['plugin']) ? $pe_slider_type->data['parameters']['plugin'] : 'peVario'
	);
	
	$form['data']['parameters']['fullwidth'] = array(
		'#type' =>'checkbox', 
		'#title' => t('Enable Fullwidth'),
		'#default_value' => isset($pe_slider_type->data['parameters']['fullwidth']) ? $pe_slider_type->data['parameters']['fullwidth'] : 0
	);
	
	$form['data']['parameters']['orig-width'] = array(
			'#type' => 'textfield',
			'#title' => t('Original Width'),
			'#description' => t('Original width of the caption area, if slider size is reduced because of a smaller viewport (for example on tablets/phones), the caption area will be scaled down accordingly.'),
			'#default_value' => isset($pe_slider_type->data['parameters']['orig-width']) ? $pe_slider_type->data['parameters']['orig-width'] : '940'
	);
	
	$form['data']['parameters']['orig-height'] = array(
		'#type' => 'textfield',
		'#title' => t('Original Height'),
		'#description' => t('Original height of the caption area, if slider size is reduced because of a smaller viewport (for example on tablets/phones), the caption area will be scaled down accordingly.'),
		'#default_value' => isset($pe_slider_type->data['parameters']['orig-height']) ? $pe_slider_type->data['parameters']['orig-height'] : '400'
	);
	
	$form['data']['parameters']['height'] = array(
		'#type' => 'textfield',
		'#title' => t('Maximum Height'),
		'#description' => t('This parameter controls max height of the slider.'),
		'#default_value' => isset($pe_slider_type->data['parameters']['height']) ? $pe_slider_type->data['parameters']['height'] : '500'
	);
	
	$form['data']['parameters']['aspect-ratio'] = array(
		'#type' => 'textfield',
		'#title' => t('Aspect Ratio'),
		'#description' => t('Enter an aspect ratio for the slider (recommended values are "container" or "2.35"). If container is entered, the slider will inherit the width/height of the containing block element. <strong>"container" must be used for "fullscreen" sliders.</strong>'),
		'#default_value' => isset($pe_slider_type->data['parameters']['aspect-ratio']) ? $pe_slider_type->data['parameters']['aspect-ratio'] : '2.35'
	);
	
	$form['data']['parameters']['video'] = array(
		'#type' =>'checkbox',
		'#title' => t('Enable Video'),
		'#description' => t('If selected, the slider background will be a video instead of images. This video will be present on all slides.'),
		'#default_value' => isset($pe_slider_type->data['parameters']['video']) ? $pe_slider_type->data['parameters']['video'] : 0
	);
	
	$form['data']['parameters']['video-path'] = array(
		'#type' =>'managed_file',
		'#title' => t('Primary Video'),
		'#description' => t('Upload a video file. Valid file formats are mp4, webM, ogv. If a fallback video is being used (highly recommended), ogv or webM must be used as the primary video.'),
		'#default_value' => isset($pe_slider_type->data['parameters']['video-path']) ? $pe_slider_type->data['parameters']['video-path'] : NULL,
		'#upload_validators' => array(
			'file_validate_extensions' => array(0 => 'mp4 ogv webm'),
		),
		'#upload_location' => 'public://bigwig/video/',
		'#states' => array(
				// Hide the settings when the cancel notify checkbox is disabled.
				'invisible' => array(
						':input[name="data[parameters][video]"]' => array('checked' => FALSE),
				)
			),			
	);
	
	$form['data']['parameters']['video-backup'] = array(
			'#type' =>'managed_file',
			'#title' => t('Fallback Video'),
			'#description' => t('Upload a backup video file <strong>(must be mp4 format)</strong>. This will be used in browsers where ogv and webM videos are not supported. <strong>The the file name must follow exact same naming as the "primary video" filename.</strong> For example, if the primrary video is named "video.ogv", the fallback video must be named "video.mp4".'),
			'#default_value' => isset($pe_slider_type->data['parameters']['video-backup']) ? $pe_slider_type->data['parameters']['video-backup'] : NULL,
			'#upload_validators' => array(
				'file_validate_extensions' => array(0 => 'mp4'),
			),
			'#upload_location' => 'public://bigwig/video/',
			'#states' => array(
					// Hide the settings when the cancel notify checkbox is disabled.
					'invisible' => array(
							':input[name="data[parameters][video]"]' => array('checked' => FALSE),
					)
			),
	);
	
	$form['data']['parameters']['video-fallback'] = array(
		'#type' =>'managed_file',
		'#title' => t('Video Fallback Image'),
		'#description' => t('Upload a fallback image for browsers that do not support HTML5 video (IE8, IE9).'),
		'#default_value' => isset($pe_slider_type->data['parameters']['video-fallback']) ? $pe_slider_type->data['parameters']['video-fallback'] : NULL,
		'#upload_validators' => array(
			'file_validate_extensions' => array(0 => 'jpg gif png'),
		),
		'#upload_location' => 'public://bigwig/video/',
		'#states' => array(
			// Hide the settings when the cancel notify checkbox is disabled.
			'invisible' => array(
				':input[name="data[parameters][video]"]' => array('checked' => FALSE),
			),
		),
	);
	
	
	$form['actions'] = array('#type' => 'actions');
	$form['actions']['submit'] = array(
			'#type' => 'submit',
			'#value' => t('Save BigWig Slider'),
			'#weight' => 40,
	);

	return $form;
}

/**
 * Form API submit callback for the type form.
 */
function pe_slider_type_form_submit(&$form, &$form_state) {
	$videoState = $form['data']['parameters']['video-path']['#default_value'];
	$backupState = $form['data']['parameters']['video-backup']['#default_value'];

	/* Build Slider Entity*/
	$pe_slider_type = entity_ui_form_submit_build_entity($form, $form_state);

	$deleteVideo = (($videoState != 0) && ($pe_slider_type->data['parameters']['video-path'] != $videoState)) ? 1 : 0;
	$deleteBackup = (($backupState != 0) && ($pe_slider_type->data['parameters']['video-backup'] != $backupState)) ? 1 : 0;
	$human_readable = strtolower($pe_slider_type->label);
	$machine_readable = preg_replace('@[^a-z0-9_]+@','_',$human_readable);
	$video = (!empty($pe_slider_type->data['parameters']['video-path'])) ? $pe_slider_type->data['parameters']['video-path'] : NULL;
	$videoFallback = (!empty($pe_slider_type->data['parameters']['video-fallback'])) ? $pe_slider_type->data['parameters']['video-fallback'] : NULL;
	$backupVideo = (!empty($pe_slider_type->data['parameters']['video-backup'])) ? $pe_slider_type->data['parameters']['video-backup'] : NULL;
	
	if($pe_slider_type->data['sample_data'] == '') {
		$new = 'true';
	} else {
		$new = 'false';
	}
	
	if(!$video == NULL) {
		/* Permanently Save Managed Files */
		$fid = $video;
		$file = file_load($video);
		$file->status = FILE_STATUS_PERMANENT;
		file_save($file);
		file_usage_add($file, 'pe_slider', 'pe_slider', $video);
	}
	
	if(!$backupVideo == NULL) {
		/* Permanently Save Managed Files */
		$fid = $backupVideo;
		$file = file_load($backupVideo);
		$file->status = FILE_STATUS_PERMANENT;
		file_save($file);
		file_usage_add($file, 'pe_slider', 'pe_slider', $backupVideo);
	}
	
	if(!$videoFallback == NULL) {
		/* Permanently Save Managed Files */
		$fid = $videoFallback;
		$file = file_load($videoFallback);
		$file->status = FILE_STATUS_PERMANENT;
		file_save($file);
		file_usage_add($file, 'pe_slider', 'pe_slider', $videoFallback);
	}
	
	if(!$deleteVideo == 0) {
		$fid = $videoState;
		$file = file_load($videoState);
		file_delete($file, TRUE);
	}
    
	if(!$deleteBackup == 0) {
		$fid = $backupState;
		$file = file_load($backupState);
		file_delete($file, TRUE);
	}
	
	if(($new == 'true') && ($form_state['op'] != 'clone')) {
		field_create_instance(array(
				'field_name' => 'field_image',
				'label' => 'Image',
				'entity_type' => 'pe_slider',
				'bundle' => $machine_readable,
		));
		
		field_create_instance(array(
				'field_name' => 'field_layer_settings',
				'label' => 'Layer Settings',
				'entity_type' => 'pe_slider',
				'bundle' => $machine_readable,
		));
	}
	
	$pe_slider_type->save();

	if($form_state['op'] == 'clone') {
		$query = new EntityFieldQuery();
		$query->entityCondition('entity_type', 'pe_slider')
		->entityCondition('bundle', $pe_slider_type->data['sample_data']);
		$result = $query->execute();

		if (isset($result['pe_slider'])) {
			$news_items_nids = array_keys($result['pe_slider']);
			$news_items = entity_load('pe_slider', $news_items_nids);

		foreach($news_items as $item) {
			$clone = replicate_clone_entity('pe_slider', $item);
			$clone->pe_slider_id = '';
			$clone->type = $machine_readable;
			entity_save('pe_slider', $clone);
		}
		
		}
	}

	$form_state['redirect'] = 'admin/structure/pe_slider';
}

/**
 * Form API submit callback for the delete button.
 */
function pe_slider_type_form_submit_delete(&$form, &$form_state) {
	$form_state['redirect'] = $globals['base_url'].'/admin/structure/pe_slider/manage/' . $form_state['pe_slider_type']->type . '/delete';
}