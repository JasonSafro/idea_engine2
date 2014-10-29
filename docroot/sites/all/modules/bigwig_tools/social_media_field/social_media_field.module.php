<?php

function social_media_field_field_info() {
	return array(
			'social_icons' => array(
					'label' => t('Social Icons'),
					'description' => t("Add social media icons through the Field Type API."),
					'default_widget' => 'social_icons',
					'default_formatter' => 'social_icons', // This doesn't *have* to be the same name as default_widget's value, this is only coincidence
			),
	);
}

function social_media_field_field_validate($entity_type, $entity, $field, $instance, $langcode, $items, $errors) {
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
function social_media_field_field_is_empty($item, $field) {
	$temp = array_keys($field['columns']);
	$key = array_shift($temp);
	return empty($item[$key]);
}

function social_media_field_field_presave($entity_type, $entity, $field, $instance, $langcode, &$items) {
	// Make sure that each file which will be saved with this object has a
	// permanent status, so that it will not be removed when temporary files are
	// cleaned up.

	switch ($instance['widget']['type']) {
		case 'social_icons':

			foreach ($items as $delta => $item) {
				if ($item['img'] != 0) {
					$file = file_load($item['img']);
					if (!$file->status) {
						$file->status = FILE_STATUS_PERMANENT;
						file_save($file);
						file_usage_add($file, 'social_icons', 'social_icons', $item['img']);
					}
				}
			}
			break;

	}
}

function social_media_field_field_widget_info() {
	return array(
			'social_icons' => array(
					'label' => t('Social Icons'),
					'field types' => array('social_icons'),
			),
	);
}

function social_media_field_field_formatter_info() {
	return array(
			'social_icons' => array(
					'label' => t('Social Icons'),
					'field types' => array('social_icons'),
			),
	);
}

function social_media_field_field_formatter_view($entity_type, $entity, $field, $instance, $langcode, $items, $display) {
	$element = array();
	
	foreach ($items as $delta => $item) {
		
		switch($item['icon']) {
			case 'twitter': $tooltip = "Twitter"; break;
			case 'facebook': $tooltip = "Facebook"; break;
			case 'dribbble': $tooltip = "Dribbble"; break;
			case 'linkedin': $tooltip = "LinkedIn"; break;
			case 'vimeo': $tooltip = "Vimeo"; break;
			case 'gplus': $tooltip = "Google Plus"; break;
			case 'pinterest': $tooltip = "Pinterest"; break;
			case 'tumblr': $tooltip = "Tumblr"; break;
			case 'flickr': $tooltip = "Flickr"; break;
			case 'skype': $tooltip = "Skype"; break;
			case 'instagram': $tooltip = "Instagram"; break;
		}
		
		if (!empty($item['link'])) {
			$link = $item['link'];
		} else {
			$link = '#';
		}
		
		if (!empty($item['icon'])) {
			$icon = '<a href="'.$link.'" data-rel="tooltip" data-position="top" data-original-title="'.$tooltip.'"><i class="icon-'.$item['icon'].'-circled"/></i></a>';
		} else {
			$icon = '<a href="'.$link.'">'.$tooltip.'</a>';
		}
		
		switch ($display['type']) {
			case 'social_icons':
				$element[$delta] = array('#markup' => $icon);
			break;
		}
		
	}

	return $element;
}

function social_media_field_field_widget_form(&$form, &$form_state, $field, $instance, $langcode, $items, $delta, $element) {
	switch ($instance['widget']['type']) {
		case 'social_icons':
			
			$settings = $form_state['field'][$instance['field_name']][$langcode]['field']['settings'];
			$field_name = $instance['field_name'];

			$element['icon'] = array(
					'#attributes' => array('class' => array('edit-social-icon-'.$delta), 'title' => t('')),
					'#type' => 'select',
					'#title' => t('Icon'),
					'#description' => t('Select a social network.'),
					'#options'       => array(
							'0' => t('Select icon:'),
							'facebook' => t('Facebook'),
							'twitter' => t('Twitter'),
							'linkedin' => t('LinkedIn'),
							'gplus' => t('Google+'),
							'dribbble' => t('Dribbble'),
							'pinterest' => t('Pinterest'),
							'tumblr' => t('Tumblr'),
							'flickr' => t('Flickr'),
							'vimeo' => t('Vimeo'),
							'skype' => t('Skype'),
							'instagram' => t('Instagram'),
					),
			);

			$element['link'] = array(
					'#attributes' => array('class' => array('edit-social-link-'.$delta), 'title' => t('')),
					'#type' => 'textfield',
					'#title' => t('Link:'),
					'#description' => t("Enter the URL to this profile."),
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