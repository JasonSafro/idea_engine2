<?php

/**
 * @file
 * Providing extra functionality for the PeSlider UI via views.
 */


	/**
	 * Implements hook_views_data()
	 */
	
	function pe_slider_views_data_alter(&$data) {
		
		// allow for intergration with all entity types
		$types = entity_get_info();
		foreach ($types as $key => $type) {
			// create a structured link in the view to replicate entity
			$data['views_entity_' . $key]['replicate_ui_link'] = array(
					'field' => array(
							'title' => t('replicate link'),
							'help' => t('Provide a simple link to replicate the entity'),
							'handler' => 'views_handler_field_replicate_ui_link',
					),
			);
		}
	
		$data['pe_slider']['link_pe_slider'] = array(
				'field' => array(
						'title' => t('Link'),
						'help' => t('Provide a link to the pe_slider.'),
						'handler' => 'pe_slider_handler_link_field',
				),
		);
		$data['pe_slider']['edit_pe_slider'] = array(
				'field' => array(
						'title' => t('Edit Link'),
						'help' => t('Provide a link to the edit form for the pe_slider.'),
						'handler' => 'pe_slider_handler_edit_link_field',
				),
		);
		$data['pe_slider']['delete_pe_slider'] = array(
				'field' => array(
						'title' => t('Delete Link'),
						'help' => t('Provide a link to delete the pe_slider.'),
						'handler' => 'pe_slider_handler_delete_link_field',
				),
		);
		// This content of this field are decided based on the menu structure that
		// follows pe_slider/pe_slider/%pe_slider_id/op
		$data['pe_slider']['operations'] = array(
				'field' => array(
						'title' => t('Operations links'),
						'help' => t('Display all operations available for this pe_slider.'),
						'handler' => 'pe_slider_handler_pe_slider_operations_field',
				),
		);
	}
	
	
	/**
	 * Implements hook_views_default_views().
	 */
	function pe_slider_views_default_views() {
		$views = array();
	
		$view = new view();
		$view->name = 'pe_slider';
		$view->description = 'A list of all BigWig Slider slides. This view is used for administration purposes only (do not edit this).';
		$view->tag = 'bigwig';
		$view->base_table = 'pe_slider';
		$view->human_name = 'BigWig Slider';
		$view->core = 7;
		$view->api_version = '3.0';
		$view->disabled = FALSE; /* Edit this to true to make a default view disabled initially */
		
		/* Display: Master */
		$handler = $view->new_display('default', 'Master', 'default');
		$handler->display->display_options['title'] = 'BigWig Slider';
		$handler->display->display_options['use_more_always'] = FALSE;
		$handler->display->display_options['access']['type'] = 'perm';
		$handler->display->display_options['access']['perm'] = 'create any pe_slider type';
		$handler->display->display_options['cache']['type'] = 'none';
		$handler->display->display_options['query']['type'] = 'views_query';
		$handler->display->display_options['exposed_form']['type'] = 'basic';
		$handler->display->display_options['pager']['type'] = 'full';
		$handler->display->display_options['pager']['options']['items_per_page'] = '10';
		$handler->display->display_options['style_plugin'] = 'table';
		$handler->display->display_options['style_options']['columns'] = array(
		  'name' => 'name',
		  'pe_slider_id' => 'pe_slider_id',
		);
		$handler->display->display_options['style_options']['default'] = '-1';
		$handler->display->display_options['style_options']['info'] = array(
		  'name' => array(
		    'sortable' => 0,
		    'default_sort_order' => 'asc',
		    'align' => '',
		    'separator' => '',
		  ),
		  'pe_slider_id' => array(
		    'sortable' => 0,
		    'default_sort_order' => 'asc',
		    'align' => '',
		    'separator' => '',
		  ),
		);
		/* No results behavior: Global: Text area */
		$handler->display->display_options['empty']['area']['id'] = 'area';
		$handler->display->display_options['empty']['area']['table'] = 'views';
		$handler->display->display_options['empty']['area']['field'] = 'area';
		$handler->display->display_options['empty']['area']['label'] = 'Empty ';
		$handler->display->display_options['empty']['area']['empty'] = TRUE;
		$handler->display->display_options['empty']['area']['content'] = 'No slides have been created.';
		$handler->display->display_options['empty']['area']['format'] = 'filtered_html';
		/* Field: Slide: Slide ID */
		$handler->display->display_options['fields']['pe_slider_id']['id'] = 'pe_slider_id';
		$handler->display->display_options['fields']['pe_slider_id']['table'] = 'pe_slider';
		$handler->display->display_options['fields']['pe_slider_id']['field'] = 'pe_slider_id';
		/* Field: Field: Image */
		$handler->display->display_options['fields']['field_image']['id'] = 'field_image';
		$handler->display->display_options['fields']['field_image']['table'] = 'field_data_field_image';
		$handler->display->display_options['fields']['field_image']['field'] = 'field_image';
		$handler->display->display_options['fields']['field_image']['click_sort_column'] = 'fid';
		$handler->display->display_options['fields']['field_image']['settings'] = array(
		  'image_style' => 'thumbnail',
		  'image_link' => '',
		);
		$handler->display->display_options['fields']['field_image']['delta_offset'] = '0';
		/* Field: Slide: Name */
		$handler->display->display_options['fields']['name']['id'] = 'name';
		$handler->display->display_options['fields']['name']['table'] = 'pe_slider';
		$handler->display->display_options['fields']['name']['field'] = 'name';
		/* Field: Slide: replicate link */
		$handler->display->display_options['fields']['replicate_ui_link']['id'] = 'replicate_ui_link';
		$handler->display->display_options['fields']['replicate_ui_link']['table'] = 'views_entity_pe_slider';
		$handler->display->display_options['fields']['replicate_ui_link']['field'] = 'replicate_ui_link';
		$handler->display->display_options['fields']['replicate_ui_link']['label'] = '';
		$handler->display->display_options['fields']['replicate_ui_link']['exclude'] = TRUE;
		$handler->display->display_options['fields']['replicate_ui_link']['alter']['alter_text'] = TRUE;
		$handler->display->display_options['fields']['replicate_ui_link']['alter']['text'] = 'Clone';
		$handler->display->display_options['fields']['replicate_ui_link']['element_label_colon'] = FALSE;
		/* Field: Slide: Operations links */
		$handler->display->display_options['fields']['operations']['id'] = 'operations';
		$handler->display->display_options['fields']['operations']['table'] = 'pe_slider';
		$handler->display->display_options['fields']['operations']['field'] = 'operations';
		$handler->display->display_options['fields']['operations']['alter']['alter_text'] = TRUE;
		$handler->display->display_options['fields']['operations']['alter']['text'] = '[operations] [replicate_ui_link]';
		/* Contextual filter: Slide: Type */
		$handler->display->display_options['arguments']['type']['id'] = 'type';
		$handler->display->display_options['arguments']['type']['table'] = 'pe_slider';
		$handler->display->display_options['arguments']['type']['field'] = 'type';
		$handler->display->display_options['arguments']['type']['default_action'] = 'default';
		$handler->display->display_options['arguments']['type']['default_argument_type'] = 'raw';
		$handler->display->display_options['arguments']['type']['default_argument_options']['index'] = '4';
		$handler->display->display_options['arguments']['type']['summary']['number_of_records'] = '0';
		$handler->display->display_options['arguments']['type']['summary']['format'] = 'default_summary';
		$handler->display->display_options['arguments']['type']['summary_options']['items_per_page'] = '25';
		$handler->display->display_options['arguments']['type']['limit'] = '0';
		
		/* Display: Page */
		$handler = $view->new_display('page', 'Page', 'pe_slider_admin_block');
		$handler->display->display_options['path'] = 'admin/content/pe_slider/list';
		
	$translatables['pe_slider'] = array(
			t('Master'),
			t('PeSliders'),
			t('more'),
			t('Apply'),
			t('Reset'),
			t('Sort by'),
			t('Asc'),
			t('Desc'),
			t('Items per page'),
			t('- All -'),
			t('Offset'),
			t('Empty '),
			t('No pe_slider have been created yet'),
			t('PeSlider ID'),
			t('.'),
			t(','),
			t('Name'),
			t('View'),
			t('Operations links'),
			t('Page'),
	);
	$views[] = $view;
	return $views;

}