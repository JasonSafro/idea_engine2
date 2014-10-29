<?php

/**
 * @file
 * Contains a Views field handler to take care of displaying edit links
 * as fields
 */


class pe_slider_handler_edit_link_field extends pe_slider_handler_link_field {
  function construct() {
    parent::construct();
    $this->additional_fields['type'] = 'type';
  }


  function render($values) {
    $type = $values->{$this->aliases['type']};
    
    //Creating a dummy pe_slider to check access against
    $dummy_pe_slider = (object) array('type' => $type);
    if (!pe_slider_access('edit', $dummy_pe_slider)) {
      return;
    }
    
    $text = !empty($this->options['text']) ? $this->options['text'] : t('edit');
    $pe_slider_id = $values->{$this->aliases['pe_slider_id']};
    
    return l($text, 'admin/content/pe_slider/slide/' . $pe_slider_id . '/edit');
  }
}
