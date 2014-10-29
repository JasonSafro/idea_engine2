<?php

function flare_lightbox_field_schema($field) {

switch($field['type']) {
    case 'flare_lightbox':
      $columns = array(
        'img' => array(
        	'type' => 'int',
        	'not null' => FALSE,
        	'unsigned' => TRUE,
        ),
        'toggle_attributes' => array(
        		'type' => 'varchar',
        		'length' => '128',
        		'not null' => FALSE,
        ),
        'alt' => array(
          'type' => 'text',
          'not null' => FALSE,
        ),
        'title' => array(
          'type' => 'text',
          'not null' => FALSE,
        ),
        'toggle_caption' => array(
          'type' => 'varchar',
	      'length' => '128',
	      'not null' => FALSE,
        ),
        'caption' => array(
          'type' => 'text',
          'not null' => FALSE,
        ),
        'toggle_masonry' => array(
          'type' => 'varchar',
	      'length' => '128',
	      'not null' => FALSE,
        ),
        'masonry_thumbnail_width' => array(
          'type' => 'text',
	      'not null' => FALSE,
        ),
        'masonry_thumbnail_height' => array(
          'type' => 'text',
	      'not null' => FALSE,
        ),
      );
      $indexes = array(
      
      );
      break;
}
	  
  return array(
    'columns' => $columns,
    'indexes' => $indexes,
  );
	  
}

?>