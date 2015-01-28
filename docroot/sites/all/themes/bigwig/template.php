<?php

	require_once dirname(__FILE__) . '/includes/bigwig.inc';
	
	/**
	 * Implements hook_css_alter().
	 */
	function bigwig_css_alter(&$css) {
		unset($css[drupal_get_path('module', 'system') . '/system.menus.css']);
		unset($css[drupal_get_path('module', 'system') . '/system.theme.css']);
		
		if (isset($css[drupal_get_path('module', 'views_isotope') . '/views_isotope.css'])) {
			unset($css[drupal_get_path('module', 'views_isotope') . '/views_isotope.css']);
		}
	}

	/**
	 * Implements hook_js_alter().
	 */
	function bigwig_js_alter(&$javascript) {
		$path = current_path();
		$find = 'imce';
		$pos = strpos($path, $find);

		/* Unset old version of jQuery on non-administration pages */
		if ((!path_is_admin(current_path())) && ($pos === false)) {
			unset($javascript['misc/jquery.js']);
		}
		
		if (isset($javascript[drupal_get_path('module', 'views_isotope') . '/jquery.isotope.min.js'])) {
			unset($javascript[drupal_get_path('module', 'views_isotope') . '/jquery.isotope.min.js']);
			unset($javascript[drupal_get_path('module', 'views_isotope') . '/views_isotope.js']);
		}
	}
	
	/**
	 * Implements hook_form_alter().
	 */
	function bigwig_form_alter(&$form, &$form_state, $form_id) {
		$form['actions']['submit']['#attributes']['class'][] = 'btn';
		$form['actions']['preview']['#attributes']['class'][] = 'btn';
		if ($form_id == 'search_block_form') {
			$form['actions']['#attributes']['class'][] = 'element-invisible';
		}
		if ($form_id == 'contact_site_form' || 'user_login' || 'comment_node_blog_post' ) {
			$form['actions']['submit']['#attributes']['class'][] = 'btn-success';
		}
	}
	
	/**
	 * Implements theme_menu_local_tasks().
	 */
	function bigwig_menu_local_tasks(&$vars) {
		$output = '';
	
		if (!empty($vars['primary'])) {
			$vars['primary']['#prefix'] = '<h2 class="element-invisible">' . t('Primary tabs') . '</h2>';
			$vars['primary']['#prefix'] .= '<ul class="nav nav-tabs primary">';
			$vars['primary']['#suffix'] = '</ul>';
			$output .= drupal_render($vars['primary']);
		}
	
		return $output;
	}
	
	function bigwig_menu_link(&$vars) {
	    $element = &$vars['element'];
	    $element['#href'] = drupal_get_path_alias($element['#href']);
	
	    if(strpos($element['#href'], "http://") !== false) {
            $href = $element['#href'];
	    } else {
            $base = $GLOBALS['base_url'];
            $href = ($element['#href'] == '<front>') ? $base : $base.'/'.$element['#href'];
	    }
	
	    if(!empty($element['#localized_options']['attributes']['title'])) {
            $subtitle = $element['#localized_options']['attributes']['title'];
	    }
	
	    $description = (!empty($subtitle)) ? ('<span class="subtitle">' . $subtitle . '</span>') : '';
	
	    /* Add custom classes to menu items */
	    $element['#attributes']['class'][] = 'menu-item';
	
	    /* Generate menu output */
	    $sub_menu = ($element['#below']) ? ($sub_menu = drupal_render($element['#below'])) : '';
	    $output = (strpos($element['#href'], '<nolink>')) ? $element['#title'].$description : '<a href="'.$href.'">'.$element['#title'].$description.'</a>';
		return '<li' . drupal_attributes($element['#attributes']) . '>' . $output . $sub_menu . "</li>";
	}
	
	function bigwig_menu_tree(&$variables) {
		return '<ul>' . $variables['tree'] . '</ul>';
	}
	
	/**
	 * Implements hook_preprocess_html().
	 */
	function bigwig_preprocess_html(&$vars) {
		$theme = bigwig_get_theme();
		
		$vars['jquery'] = $vars['jquery'] = '<script type="text/javascript" src="'.$GLOBALS['base_url'].'/'.path_to_theme().'/js/jquery-1.9.1.min.js"></script>';
		$skin = '<link href="'.$GLOBALS['base_url'].'/'.path_to_theme().'/css/colors/'.theme_get_setting('layoutColor').'.css" rel="stylesheet"/>';
		
		(theme_get_setting('layoutColor') !== '84bd32') ? $vars['skin'] = $skin : $vars['skin'] = '';
		(theme_get_setting('layoutWidth') == 'boxedlayout') ? $vars['classes_array'][] = 'boxed' : $vars['classes_array'][] = 'full-width';
		
		if(theme_get_setting('backgroundImage') == 'custom') {
			$image = 'body.custom {background-image: url('.file_create_url(file_load(theme_get_setting('backgroundCustom'))->uri).');}';
			drupal_add_css($image, 'inline', array('every_page' => TRUE, 'preprocess' => TRUE));
		}
		
		if(theme_get_setting('backgroundColor') != NULL) {
			$color = 'body { background-color: #'.theme_get_setting('backgroundColor').' !important; }';
			drupal_add_css($color, 'inline', array('every_page' => TRUE, 'preprocess' => TRUE));
		}
		
		if(theme_get_setting('backgroundImage') !== 'no-background') {
			$vars['classes_array'][] = theme_get_setting('backgroundImage');
		}
		
		if(theme_get_setting('sticky-header') == 1) {
			$vars['classes_array'][] = 'sticky-header';
		}
    
    // Add body classes based on select permissions
    if( user_access('use text format full_html') ) :
      $vars['classes_array'][] = 'user-can-choose-text-format';
    else :
      $vars['classes_array'][] = 'user-cannot-choose-text-format';
    endif;
    
    // Add body classes based on role
    if( isset($GLOBALS['user']->roles) && is_array($GLOBALS['user']->roles) && count($GLOBALS['user']->roles)>0 ) :
      $role_class_temp = array(
        'find' => array( ' ', '_' ),
        'replace' => array( '-', '-' ),
      );
      foreach( $GLOBALS['user']->roles as $one_role_id => $one_role ) :
        $vars['classes_array'][] = 'role-'.str_replace( $role_class_temp['find'], $role_class_temp['replace'], strtolower(trim($one_role)) );
      endforeach;
    endif;  
	}
	
	/**
	 * Implements hook_preprocess_page().
	 */
	function bigwig_preprocess_page(&$vars) {
		$theme = bigwig_get_theme();
		$theme->page = &$vars;
		$sidebar_left = 12 - theme_get_setting('sidebar_left_grid');
		$sidebar_right = 12 - theme_get_setting('sidebar_right_grid');
		$sidebar_both = 12 - (theme_get_setting('sidebar_left_grid') + theme_get_setting('sidebar_right_grid'));
		
		if (!empty($vars['page']['sidebar_left']) && !empty($vars['page']['sidebar_right'])) {
			$vars['content_settings'] = 'span' . $sidebar_both;
		}
		else if (!empty($vars['page']['sidebar_left']) && empty($vars['page']['sidebar_right'])) {
			$vars['content_settings'] = 'span' . $sidebar_left;
		}
		else if (empty($vars['page']['sidebar_left']) && !empty($vars['page']['sidebar_right'])) {
			$vars['content_settings'] = 'span' . $sidebar_right;
		} else {
			$vars['content_settings'] = (theme_get_setting('content_grid') !== 'none') ? 'span'. theme_get_setting('content_grid') : 'span12';
		}
		
 		if (drupal_is_front_page()) {
 			unset($vars['page']['content']['system_main']);
 		}
    
    // Custom updates for each content type
    if( isset($GLOBALS['nodes']['page_node']) ) :
      switch( $GLOBALS['nodes']['page_node']->type ) :
        case 'challenge':
          drupal_set_title( 'Challenge: '.$GLOBALS['nodes']['page_node']->title );
        break;
      
        case 'user_group':
          drupal_set_title( 'Welcome to the '.$GLOBALS['nodes']['page_node']->title.' group' );
        break;
      endswitch;
    endif;
	}


	function bigwig_preprocess_region(&$vars) {
		$theme = bigwig_get_theme();
		
		$span = theme_get_setting($vars['region'] . '_grid');
		$css = theme_get_setting($vars['region'] . '_css');
		$vars['classes_array'] = array('region');
		$vars['classes_array'][] = drupal_html_id($vars['region']);
		
		switch ($vars['region']) {
			case 'content': 
				$vars['classes_array'][] = $theme->page['content_settings'];
			break;
	 		default: if ($span != 'none') { $vars['classes_array'][] = 'span'.$span; } break;
		}
		
		if ($css != '') { $vars['classes_array'][] = $css; }
	}

	
	function bigwig_process_region(&$vars) {
		$theme = bigwig_get_theme();

		$vars['messages'] = $theme->page['messages'];
		$vars['breadcrumb'] = $theme->page['breadcrumb'];
		$vars['title_prefix'] = $theme->page['title_prefix'];
		$vars['title'] = $theme->page['title'];
		$vars['title_suffix'] = $theme->page['title_suffix'];
		$vars['tabs'] = $theme->page['tabs'];
		$vars['action_links'] = $theme->page['action_links'];
		$vars['feed_icons'] = $theme->page['feed_icons'];
	}
?>
