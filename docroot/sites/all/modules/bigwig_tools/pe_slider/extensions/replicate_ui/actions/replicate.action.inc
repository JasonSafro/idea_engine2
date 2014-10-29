<?php

/**
 * @file
 * Implements a generic entity delete action. Uses Entity API if available.
 */

function replicate_ui_replicate_action_info() {
  return array(
    'replicate_ui_replicate_item' => array(
      'type' => 'entity',
      'label' => t('Replicate item'),
      'configurable' => FALSE,
      'behavior' => array('replicates_property'),
    ),
  );
}

function replicate_ui_replicate_item($entity, $context) {  
  // Duplicate the entity and save the replica.
  replicate_entity($context['entity_type'], $entity);
}