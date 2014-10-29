<?php

/**
 * @file
 * PeSlider editing UI.
 *
 * We make very little use of the EntityAPI interface for this - preferring instead to use
 * views. That offers more flexibility to change a UI that will, more often than not,
 * be end-user facing.
 */

/**
 * UI controller.
 */
class PeSliderUIController extends EntityDefaultUIController {

  /**
   * Overrides hook_menu() defaults. Main reason for doing this is that
   * parent class hook_menu() is optimized for entity type administration.
   */
  public function hook_menu() {
    
    $items = array();
    $id_count = count(explode('/', $this->path));
    $wildcard = isset($this->entityInfo['admin ui']['menu wildcard']) ? $this->entityInfo['admin ui']['menu wildcard'] : '%' . $this->entityType;

    // Change the overview menu type for the list of pe_slider.
    $items[$this->path]['type'] = MENU_LOCAL_TASK;
    
    // Change the add page menu to multiple types of entities
    $items[$this->path . '/add'] = array(
      'title' => 'Add a slide',
      'description' => 'Add a new BigWig Slider slide',
      'page callback'  => 'pe_slider_add_page',
      'access callback'  => 'pe_slider_access',
      'access arguments' => array('edit'),
      'type' => MENU_NORMAL_ITEM,
      'weight' => 20,
      'file' => 'pe_slider.admin.inc',
      'file path' => drupal_get_path('module', $this->entityInfo['module'])

    );
    
    if (!empty($this->entityInfo['exportable'])) {
    	$items[$this->path . '/import']['title'] = entity_ui_get_action_title('import', $this->entityType);
    	unset($items[$this->path . '/import']['title callback']);
    	unset($items[$this->path . '/import']['title arguments']);
    }
    
    // Add menu items to add each different type of entity.
    foreach (pe_slider_get_types() as $type) {
      $items[$this->path . '/add/' . $type->type] = array(
        'title' => 'Add ' . $type->label,
        'page callback' => 'pe_slider_form_wrapper',
        'page arguments' => array(pe_slider_create(array('type' => $type->type))),
        'access callback' => 'pe_slider_access',
        'access arguments' => array('edit', 'edit ' . $type->type),
        'file' => 'pe_slider.admin.inc',
        'file path' => drupal_get_path('module', $this->entityInfo['module'])
      );
    }

    // Loading and editing pe_slider entities
    $items[$this->path . '/slide/' . $wildcard] = array(
      'page callback' => 'pe_slider_form_wrapper',
      'page arguments' => array($id_count + 1),
      'access callback' => 'pe_slider_access',
      'access arguments' => array('edit', $id_count + 1),
      'weight' => 0,
      'context' => MENU_CONTEXT_PAGE | MENU_CONTEXT_INLINE,
      'file' => 'pe_slider.admin.inc',
      'file path' => drupal_get_path('module', $this->entityInfo['module'])
    );
    $items[$this->path . '/slide/' . $wildcard . '/edit'] = array(
      'title' => 'Edit',
      'type' => MENU_DEFAULT_LOCAL_TASK,
      'weight' => -10,
      'context' => MENU_CONTEXT_PAGE | MENU_CONTEXT_INLINE,
    );
    
    $items[$this->path . '/slide/' . $wildcard . '/delete'] = array(
      'title' => 'Delete',
      'page callback' => 'pe_slider_delete_form_wrapper',
      'page arguments' => array($id_count + 1),
      'access callback' => 'pe_slider_access',
      'access arguments' => array('edit', $id_count + 1),
      'type' => MENU_LOCAL_TASK,
      'context' => MENU_CONTEXT_INLINE,
      'weight' => 10,
      'file' => 'pe_slider.admin.inc',
      'file path' => drupal_get_path('module', $this->entityInfo['module'])
    );
    
    // Menu item for viewing pe_slider
    $items['slide/' . $wildcard] = array(
      //'title' => 'Title',
      'title callback' => 'pe_slider_page_title',
      'title arguments' => array(1),
      'page callback' => 'pe_slider_page_view',
      'page arguments' => array(1),
      'access callback' => 'pe_slider_access',
      'access arguments' => array('view', 1),
      'type' => MENU_CALLBACK,
    );

    return $items;
  }
  
  
  /**
   * Create the markup for the add PeSlider Entities page within the class
   * so it can easily be extended/overriden.
   */ 
  public function addPage() {
    $item = menu_get_item();
    $content = system_admin_menu_block($item);

    if (count($content) == 1) {
      $item = array_shift($content);
      drupal_goto($item['href']);
    }    
        
    return theme('pe_slider_add_list', array('content' => $content));
  }
  
}


/**
 * Form callback wrapper: create or edit a pe_slider.
 *
 * @param $pe_slider
 *   The pe_slider object being edited by this form.
 *
 * @see pe_slider_edit_form()
 */
function pe_slider_form_wrapper($pe_slider) {
  // Add the breadcrumb for the form's location.
  pe_slider_set_breadcrumb();
  return drupal_get_form('pe_slider_edit_form', $pe_slider);
}


/**
 * Form callback wrapper: delete a pe_slider.
 *
 * @param $pe_slider
 *   The pe_slider object being edited by this form.
 *
 * @see pe_slider_edit_form()
 */
function pe_slider_delete_form_wrapper($pe_slider) {
  // Add the breadcrumb for the form's location.
  //pe_slider_set_breadcrumb();
  return drupal_get_form('pe_slider_delete_form', $pe_slider);
}


/**
 * Form callback: create or edit a pe_slider.
 *
 * @param $pe_slider
 *   The pe_slider object to edit or for a create form an empty pe_slider object
 *     with only a pe_slider type defined.
 */
function pe_slider_edit_form($form, &$form_state, $pe_slider) {
  $data = db_query("SELECT data from pe_slider_type where type = '".$pe_slider->type."'")->fetchAssoc();
  $groups = unserialize($data['data']);

  // Add the default field elements.
  $form['name'] = array(
    '#type' => 'textfield',
    '#title' => t('Slide Name'),
  	'#prefix' => '<div class="dimensions" data-video="'.(($groups['parameters']['video-fallback'] == 0) ? '0' : file_create_url(file_load($groups['parameters']['video-fallback'])->uri)).'" data-max-height="'.$groups['parameters']['height'].'" data-width="'.$groups['parameters']['orig-width'].'" data-height="'.$groups['parameters']['orig-height'].'">',
  	'#suffix' => '</div>',
    '#default_value' => isset($pe_slider->name) ? $pe_slider->name : '',
    '#maxlength' => 255,
    '#required' => TRUE,
    '#weight' => -5,
  );
  
  $form['data']['#tree'] = TRUE;
  
  $form['data']['weight'] = array(
    '#type' => 'textfield',
    '#title' => t('Weight'),
    '#default_value' => isset($pe_slider->data['weight']) ? $pe_slider->data['weight'] : '',
    '#maxlength' => 4,
  	'#size' => 4,
    '#required' => FALSE,
    '#weight' => -3,
  );
  
  $form['data']['delay'] = array(
    '#type' => 'textfield',
    '#title' => t('Delay'),
    '#default_value' => isset($pe_slider->data['delay']) ? $pe_slider->data['delay'] : '7',
    '#maxlength' => 4,
  	'#size' => 4,
    '#required' => TRUE,
    '#weight' => -4,
  );
  
  $form['data']['transition'] = array(
	'#type' => 'select',
	'#title' => t('data-transition'),
	'#options' => array(
		'"random"' => t('random'),
		'"fade"' => t('fade'),
		'"blockfade"' => t('fbackfade'),
		'"fall"' => t('fall'),
		'"domino"' => t('domino'),
		'"flip"' => t('flip'),
		'"revealL"' => t('revealL'),
		'"revealR"' => t('revealR'),
		'"revealT"' => t('revealT'),
		'"revealB"' => t('revealB'),
		'"saw"' => t('saw'),
		'"scale"' => t('scale'),
		'"bars"' => t('bars'),
		'"zoom"' => t('zoom'),
		'"drop"' => t('drop')
	),
	'#default_value' => isset($pe_slider->data['transition']) ? $pe_slider->data['transition'] : '"random"'
  );

  // Add the field related form elements.
  $form_state['pe_slider'] = $pe_slider;
  field_attach_form('pe_slider', $pe_slider, $form, $form_state);

  $form['actions'] = array(
    '#type' => 'container',
    '#attributes' => array('class' => array('form-actions')),
    '#weight' => 400,
  );

  // We add the form's #submit array to this button along with the actual submit
  // handler to preserve any submit handlers added by a form callback_wrapper.
  $submit = array();

  if (!empty($form['#submit'])) {
    $submit += $form['#submit'];
  }

  $form['actions']['submit'] = array(
    '#type' => 'submit',
    '#value' => t('Save Slide'),
    '#submit' => $submit + array('pe_slider_edit_form_submit'),
  );
  
  if (!empty($pe_slider->name)) {
    $form['actions']['delete'] = array(
      '#type' => 'submit',
      '#value' => t('Delete slide'),
      '#suffix' => l(t('Cancel'), 'admin/content/pe_slider'),
      '#submit' => $submit + array('pe_slider_form_submit_delete'),
      '#weight' => 45,
    );
  }

  // We append the validate handler to #validate in case a form callback_wrapper
  // is used to add validate handlers earlier.
  $form['#validate'][] = 'pe_slider_edit_form_validate';
  return $form;
}


/**
 * Form API validate callback for the pe_slider form
 */
function pe_slider_edit_form_validate(&$form, &$form_state) {
  $pe_slider = $form_state['pe_slider'];
  
  // Notify field widgets to validate their data.
  field_attach_form_validate('pe_slider', $pe_slider, $form, $form_state);
}


/**
 * Form API submit callback for the pe_slider form.
 * 
 * @todo remove hard-coded link
 */
function pe_slider_edit_form_submit(&$form, &$form_state) {
  
  $pe_slider = entity_ui_controller('pe_slider')->entityFormSubmitBuildEntity($form, $form_state);
  // Save the pe_slider and go back to the list of pe_slider
  
  // Add in created and changed times.
  if ($pe_slider->is_new = isset($pe_slider->is_new) ? $pe_slider->is_new : 0){
    $pe_slider->created = time();
  }

  $pe_slider->changed = time();
  
  $pe_slider->save();
  $form_state['redirect'] = 'admin/structure/pe_slider/manage/'.$pe_slider->type;
}

/**
 * Form API submit callback for the delete button.
 * 
 * @todo Remove hard-coded path
 */
function pe_slider_form_submit_delete(&$form, &$form_state) {
  $form_state['redirect'] = 'admin/content/pe_slider/slide/' . $form_state['pe_slider']->pe_slider_id . '/delete';
}


/**
 * Form callback: confirmation form for deleting a pe_slider.
 *
 * @param $pe_slider
 *   The pe_slider to delete
 *
 * @see confirm_form()
 */
function pe_slider_delete_form($form, &$form_state, $pe_slider) {
  $form_state['pe_slider'] = $pe_slider;

  $form['#submit'][] = 'pe_slider_delete_form_submit';

  $form = confirm_form($form,
    t('Are you sure you want to delete slide %name?', array('%name' => $pe_slider->name)),
    'admin/content/pe_slider/slide',
    '<p>' . t('This action cannot be undone.') . '</p>',
    t('Delete'),
    t('Cancel'),
    'confirm'
  );
  
  return $form;
}

/**
 * Submit callback for pe_slider_delete_form
 */
function pe_slider_delete_form_submit($form, &$form_state) {
  $pe_slider = $form_state['pe_slider'];

  pe_slider_delete($pe_slider);

  drupal_set_message(t('The slide %name has been deleted.', array('%name' => $pe_slider->name)));
  watchdog('pe_slider', 'Deleted slide %name.', array('%name' => $pe_slider->name));

  $form_state['redirect'] = 'admin/structure/pe_slider/';
}



/**
 * Page to add PeSlider Entities.
 *
 * @todo Pass this through a proper theme function
 */
function pe_slider_add_page() {
  $controller = entity_ui_controller('pe_slider');
  return $controller->addPage();
}


/**
 * Displays the list of available pe_slider types for pe_slider creation.
 *
 * @ingroup themeable
 */
function theme_pe_slider_add_list($variables) {
  $content = $variables['content'];
  $output = '';
  if ($content) {
    $output = '<dl class="pe_slider-type-list">';
    foreach ($content as $item) {
      $output .= '<dt>' . l($item['title'], $item['href']) . '</dt>';
      $output .= '<dd>' . filter_xss_admin($item['description']) . '</dd>';
    }
    $output .= '</dl>';
  }
  else {
    if (user_access('administer pe_slider types')) {
      $output = '<p>' . t('PeSlider Entities cannot be added because you have not created any pe_slider types yet. Go to the <a href="@create-pe_slider-type">pe_slider type creation page</a> to add a new pe_slider type.', array('@create-pe_slider-type' => url('admin/structure/pe_slider/add'))) . '</p>';
    }
    else {
      $output = '<p>' . t('No pe_slider types have been created yet for you to use.') . '</p>';
    }
  }

  return $output;
}





/**
 * Sets the breadcrumb for administrative pe_slider pages.
 */
function pe_slider_set_breadcrumb() {
  $breadcrumb = array(
    l(t('Home'), '<front>'),
    l(t('Administration'), 'admin'),
    l(t('Content'), 'admin/content'),
    l(t('BigWig Slider'), 'admin/content/pe_slider'),
  );

  drupal_set_breadcrumb($breadcrumb);
}
