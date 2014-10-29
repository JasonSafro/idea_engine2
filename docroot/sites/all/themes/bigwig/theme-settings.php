<?php

/**
 * @file
 * General theme settings elements.
 */

function bigwig_form_system_theme_settings_alter(&$form, &$form_state) {
	
	$form['bigwig_settings'] = array(
			'#type' => 'vertical_tabs',
			'#weight' => -10,
			'#prefix' => t('<h3>BigWig Settings</h3>'),
			'#attached' => array(
					'css' => array(drupal_get_path('theme', 'bigwig') . '/css/admin.css'),
					'js' => array(
							drupal_get_path('theme', 'bigwig') . '/js/admin/colorpicker.js',
							drupal_get_path('theme', 'bigwig') . '/js/admin/admin.js',
					),
			),
	);
  
	$form['bigwig_settings']['regions'] = array(
  		'#type' => 'fieldset',
  		'#title' => t('Regions'),
  		'#description' => t('Configure the region settings.'),
		'#weight' => 3,
	);
	
	bigwig_settings_global_tab($form);
  
	foreach (system_region_list('bigwig') as $region => $title) {
		if (($region !== 'dashboard_main') && ($region !== 'dashboard_sidebar') && ($region !== 'dashboard_inactive')) {
			$form['bigwig_settings']['regions'][$region] = array(
					'#type' => 'fieldset',
					'#title' => $title,
					'#description' => t('Configure the ' . $title . ' region settings.'),
					'#collapsible' => TRUE,
					'#collapsed' => TRUE,
	
			);
			
			$form['bigwig_settings']['regions'][$region][$region . '_grid'] = array(
				'#type'          => 'select',
		  		'#title'         => t('Grid Width'),
		  		'#default_value' => theme_get_setting($region . '_grid'),
		  		'#options'       => array(
					'none' => t('Default'),
					'1' => t('span1'),
					'2' => t('span2'),
					'3' => t('span3'),
					'4' => t('span4'),
					'5' => t('span5'),
					'6' => t('span6'),
					'7' => t('span7'),
					'8' => t('span8'),
					'9' => t('span9'),
					'10' => t('span10'),
					'11' => t('span11'),
					'12' => t('span12'),
				),
			);
			
			$form['bigwig_settings']['regions'][$region][$region . '_css'] = array(
					'#type'          => 'textfield',
					'#title'         => t('CSS Classes'),
					'#default_value' => theme_get_setting($region . '_css'),
			);
		}
	}
	
	/* BACKGROUND SETTINGS */
	
	$form['bigwig_settings']['background'] = array(
			'#type' => 'fieldset',
			'#title' => t('Background'),
			'#description' => t('Set the background image and background color. If an alternate image is needed, <a href="http://www.subtlepatterns.com/" target="_blank">Subtle Patterns</a> offers
					hundreds of options. Custom background images can be uploaded by selecting the "Upload Image" button. <br/><br/>'),
			'#collapsible' => TRUE,
			'#collapsed' => TRUE,
			'#weight' => 2
	);
	
	$form['bigwig_settings']['background']['backgroundColor'] = array(
			'#type' => 'textfield',
			'#field_prefix' => '#',
			'#title' => t('Background color:'),
			'#maxlength' => 7,
			'#description' => t('Select a background color.'),
			'#default_value' => theme_get_setting('backgroundColor'),
	);
	
	$form['bigwig_settings']['background']['backgroundImage'] = array(
			'#title' => t('Background Image:'),
			'#type'          => 'radios',
			'#default_value' => theme_get_setting('backgroundImage'),
			'#options'       => array(
					'no-background' => t('No Background Image'),
					'wood' => t('Wood Dark'),
					'retina_wood' => t('Wood Light'),
					'agsquare' => t('Diamond'),
					'noisy_grid' => t('Noisy Grid'),
					'tiny_grid' => t('Grid'),
					'custom' => t('Upload Image'),
			),
	);
	
	
	$form['bigwig_settings']['background']['backgroundCustom'] = array(
			'#title' => 'Upload Custom Background',
			'#type' => 'managed_file',
			'#upload_location' => 'public://bigwig/',
			'#upload_validators' => array(
					'file_validate_extensions' => array(0 => 'png jpg jpeg gif'),
			),
			'#description' => t("Upload an image."),
			'#default_value' => theme_get_setting('backgroundCustom'),
			'#states' => array(
					'visible' => array(      // Action to take: check the checkbox.
							':input[name="backgroundImage"]' =>  array('value' => 'custom'),
					),
			),
	);
		
	$form['bigwig_settings']['layout'] = array(
			'#type' => 'fieldset',
			'#title' => t('Layout'),
			'#weight' => 2
	);
	
	$form['bigwig_settings']['layout']['layoutWidth'] = array(
			'#type' => 'radios',
			'#field_prefix' => t('Select the layout width. If a background color and/or image is being used, the "boxed" width is recommended.<br/><br/>'),
			'#title' => t('Layout Width'),
			'#options' => array(
					'fullwidthlayout' => t('Full Width'),
					'boxedlayout' => t('Boxed')
			),
			'#default_value' => theme_get_setting('layoutWidth')
	);
	
	$form['bigwig_settings']['layout']['layoutColor'] = array(
			'#title' => t('Color Scheme'),
			'#field_prefix' => t('Select a color scheme. Stylesheets for each color scheme can be found in the theme CSS folder.<br/><br/>'),
			'#type'          => 'radios',
			'#default_value' => theme_get_setting('layoutColor'),
			'#options'       => array(
					'84bd32' => t('84bd32'),
					'fed108' => t('fed108'),
					'f15a23' => t('f15a23'),
					'd73300' => t('d73300'),
					'00a6d5' => t('00a6d5'),
					'f15a23' => t('f15a23'),
					'cccccc' => t('cccccc'),
					'01f0f0' => t('01f0f0'),
					'ff0066' => t('ff0066'),
					'c69c6d' => t('c69c6d'),
					'9aae4c' => t('9aae4c'),
					'8781bd' => t('8781bd'),
					'e1e1e1' => t('e1e1e1'),
          '074085' => t('074085'),
			),
	);
	
	$form['bigwig_settings']['layout']['responsive'] = array(
			'#type'          => 'checkbox',
			'#prefix'		 => '<label class="custom-label">Responsive Layout</label>',
			'#title'         => t('Enable Responsive Layout?'),
			'#description'         => t('Checking this option will enable a responsive layout on tablet/mobile devices.'),
			'#default_value' => theme_get_setting('responsive'),
	);
	
	$form['bigwig_settings']['layout']['sticky-header'] = array(
			'#type'          => 'checkbox',
			'#prefix'		 => '<label class="custom-label">Sticky Header</label>',
			'#title'         => t('Enable Sticky Header?'),
			'#description'         => t('Checking this option will enable a sticky header on desktop/widescreen devices.'),
			'#default_value' => theme_get_setting('sticky-header'),
	);
	
	$form['bigwig_settings']['misc'] = array(
			'#type' => 'fieldset',
			'#title' => t('Miscellaneous'),
			'#weight' => 10,
	);
	
	$form['bigwig_settings']['misc']['google-maps']= array(
			'#type' => 'fieldset',
			'#title' => t('Google Maps'),
			'#description' => t('Enter the latitude/longitude coordinates of your address. To lookup a set of coordinates, visit
					<a href="http://itouchmap.com/latlong.html" target="_blank">iTouchMap.com</a> and enter the street address. These coordinates 
					will be used for the map on the "Contact" page.'),
			'#collapsible' => TRUE,
			'#collapsed' => TRUE,
	);
	
	$form['bigwig_settings']['misc']['google-maps']['latitude'] = array(
			'#type' => 'textfield',
			'#title' => t('Latitude'),
			'#default_value' => theme_get_setting('latitude'),
	);
	
	$form['bigwig_settings']['misc']['google-maps']['longitude'] = array(
			'#type' => 'textfield',
			'#title' => t('Longitude'),
			'#default_value' => theme_get_setting('longitude'),
	);
	
	$form['bigwig_settings']['misc']['simplenews']= array(
			'#type' => 'fieldset',
			'#title' => t('Privacy Policy'),
			'#description' => t('Enter a message and/or link to attach to the bottom of all "Simplenews" blocks for the newsletter. HTML markup is allowed.'),
			'#collapsible' => TRUE,
			'#collapsed' => TRUE,
	);
	
	$form['bigwig_settings']['misc']['simplenews']['privacy-policy'] = array(
			'#type'          => 'textarea',
			'#rows'			 => 3,
			'#default_value' => theme_get_setting('privacy-policy'),
	);
	
	$form['bigwig_settings']['misc']['iphone-regular']= array(
			'#type' => 'fieldset',
			'#title' => t('iPhone Icon (Regular screens)'),
			'#description' => t('Upload a 57x57 pixel icon to be used on iPhones and iPads (non-retina screens).'),
			'#collapsible' => TRUE,
			'#collapsed' => TRUE,
	);
	
	$form['bigwig_settings']['misc']['iphone-regular']['iphoneRegularIcon'] = array(
			'#type' => 'managed_file',
			'#upload_validators' => array(
					'file_validate_extensions' => array(0 => 'png jpg jpeg gif'),
			),
			'#upload_location' => 'public://bigwig/',
			'#description' => t("Upload an image."),
			'#default_value' => theme_get_setting('iphoneRegularIcon'),
	);
	
	$form['bigwig_settings']['misc']['ipad-regular']= array(
			'#type' => 'fieldset',
			'#title' => t('iPad Icon (Regular screens)'),
			'#description' => t('Upload a 72x72 pixel icon to be used on iPads (regular screens).'),
			'#collapsible' => TRUE,
			'#collapsed' => TRUE,
	);
	
	$form['bigwig_settings']['misc']['ipad-regular']['ipadRegularIcon'] = array(
			'#type' => 'managed_file',
			'#upload_validators' => array(
					'file_validate_extensions' => array(0 => 'png jpg jpeg gif'),
			),
			'#upload_location' => 'public://bigwig/',
			'#description' => t("Upload an image."),
			'#default_value' => theme_get_setting('ipadRegularIcon'),
	);
	
	$form['bigwig_settings']['misc']['apple-retina']= array(
			'#type' => 'fieldset',
			'#title' => t('iPad/iPhone Icon (Retina screens)'),
			'#description' => t('Upload a 114x114 pixel icon to be used on iPads (retina screens).'),
			'#collapsible' => TRUE,
			'#collapsed' => TRUE,
	);
	
	$form['bigwig_settings']['misc']['apple-retina']['appleRetinaIcon'] = array(
			'#type' => 'managed_file',
			'#upload_validators' => array(
					'file_validate_extensions' => array(0 => 'png jpg jpeg gif'),
			),
			'#upload_location' => 'public://bigwig/',
			'#description' => t("Upload an image."),
			'#default_value' => theme_get_setting('appleRetinaIcon'),
	);
		
	if ($form['var']['#value'] != 'theme_settings') {
		$key = preg_replace(array('/^theme_/', '/_settings$/'), '', $form['var']['#value']);
		$themes = list_themes();
		if (isset($themes[$key]->base_themes)) {
			$theme_keys = array_keys($themes[$key]->base_themes);
			$theme_keys[] = $key;
		}
		else {
			$theme_keys = array($key);
		}
		foreach ($theme_keys as $theme) {
			$theme_path = drupal_get_path('theme', $theme);
			if (file_exists($theme_path . '/theme-settings.php')) {
				$form_state['build_info']['files'][] = $theme_path . '/theme-settings.php';
			}
		}
	}
	
	$form['#submit'][] = 'bigwig_settings_form_submit';
		
}

function bigwig_settings_form_submit($form, &$form_state) {
		$images = array($form_state['values']['backgroundCustom'], $form_state['values']['iphoneIconRegular'], $form_state['values']['ipadRegularIcon'], $form_state['values']['appleRetinaIcon']);

		foreach ($images as $item) {
			if (!empty($item)) {
				/* Permanently Save Managed Files */
				$fid = $item;
				$file = file_load($fid);
				$file->status = FILE_STATUS_PERMANENT;
				file_save($file);
				file_usage_add($file, 'bigwig', 'bigwig', $item);
			}
		}
}

function bigwig_settings_global_tab(&$form) {
	// Toggles
	$form['theme_settings']['toggle_logo']['#default_value'] = theme_get_setting('toggle_logo');
	$form['theme_settings']['toggle_name']['#default_value'] = theme_get_setting('toggle_name');
	$form['theme_settings']['toggle_slogan']['#default_value'] = theme_get_setting('toggle_slogan');
	$form['theme_settings']['toggle_node_user_picture']['#default_value'] = theme_get_setting('toggle_node_user_picture');
	$form['theme_settings']['toggle_comment_user_picture']['#default_value'] = theme_get_setting('toggle_comment_user_picture');
	$form['theme_settings']['toggle_comment_user_verification']['#default_value'] = theme_get_setting('toggle_comment_user_verification');
	$form['theme_settings']['toggle_favicon']['#default_value'] = theme_get_setting('toggle_favicon');
	$form['theme_settings']['toggle_secondary_menu']['#default_value'] = theme_get_setting('toggle_secondary_menu');

	$form['logo']['default_logo']['#default_value'] = theme_get_setting('default_logo');
	$form['logo']['settings']['logo_path']['#default_value'] = theme_get_setting('logo_path');
	$form['favicon']['default_favicon']['#default_value'] = theme_get_setting('default_favicon');
	$form['favicon']['settings']['favicon_path']['#default_value'] = theme_get_setting('favicon_path');

	$form['bigwig_settings']['global_settings'] = array(
			'#type' => 'fieldset',
			'#title' => t('Global'),
			'#weight' => 1,
	);
	$form['theme_settings']['#collapsible'] = TRUE;
	$form['theme_settings']['#collapsed'] = FALSE;
	$form['logo']['#collapsible'] = TRUE;
	$form['logo']['#collapsed'] = TRUE;
	$form['favicon']['#collapsible'] = TRUE;
	$form['favicon']['#collapsed'] = TRUE;
	$form['bigwig_settings']['global_settings']['logo'] = $form['logo'];
	$form['bigwig_settings']['global_settings']['favicon'] = $form['favicon'];
	$form['bigwig_settings']['global_settings']['theme_settings'] = $form['theme_settings'];

	unset($form['theme_settings']);
	unset($form['logo']);
	unset($form['favicon']);

	$form['bigwig_settings']['bigwig_use_default_settings'] = array(
			'#type' => 'hidden',
			'#default_value' => 0,
	);

	global $theme_key;
	$form['bigwig_settings']['bigwig_current_theme'] = array(
			'#type' => 'hidden',
			'#default_value' => $theme_key,
	);
}