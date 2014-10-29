<?php

/**
 * This field handler aggregates operations that can be done on a pe_slider
 * under a single field providing a more flexible way to present them in a view
 */
class pe_slider_handler_pe_slider_operations_field extends views_handler_field {
  function construct() {
    parent::construct();

    $this->additional_fields['pe_slider_id'] = 'pe_slider_id';
  }

  function query() {
    $this->ensure_my_table();
    $this->add_additional_fields();
  }

  function render($values) {

    $links = menu_contextual_links('pe_slider', 'admin/content/pe_slider/slide', array($this->get_value($values, 'pe_slider_id')));
    
    if (!empty($links)) {
      return theme('links', array('links' => $links, 'attributes' => array('class' => array('links', 'inline', 'operations'))));
    }
  }
}
