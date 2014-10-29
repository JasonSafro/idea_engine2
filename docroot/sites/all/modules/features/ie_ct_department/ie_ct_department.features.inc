<?php
/**
 * @file
 * ie_ct_department.features.inc
 */

/**
 * Implements hook_node_info().
 */
function ie_ct_department_node_info() {
  $items = array(
    'department' => array(
      'name' => t('Department'),
      'base' => 'node_content',
      'description' => t('Departments are business units within the Department of Education.'),
      'has_title' => '1',
      'title_label' => t('Department Title'),
      'help' => '',
    ),
  );
  drupal_alter('node_info', $items);
  return $items;
}
