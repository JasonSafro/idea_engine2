<?php

function social_media_field_field_schema($field) {

switch($field['type']) {
    case 'social_icons':
      $columns = array(
        'icon' => array(
          'type' => 'varchar',
          'length' => '32',
          'not null' => FALSE,
        ),
        'link' => array(
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