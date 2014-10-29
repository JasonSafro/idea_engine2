<?php
/**
 * @file
 * bigwig_feature.features.inc
 */

/**
 * Implements hook_ctools_plugin_api().
 */
function bigwig_feature_ctools_plugin_api($module = NULL, $api = NULL) {
  if ($module == "context" && $api == "context") {
    return array("version" => "3");
  }
}

/**
 * Implements hook_views_api().
 */
function bigwig_feature_views_api($module = NULL, $api = NULL) {
  return array("api" => "3.0");
}

/**
 * Implements hook_node_info().
 */
function bigwig_feature_node_info() {
  $items = array(
    'blog_post' => array(
      'name' => t('Blog Post'),
      'base' => 'node_content',
      'description' => t('Use the <i>Blog Post</i> content type to manage vlog nodes with the BigWig theme.'),
      'has_title' => '1',
      'title_label' => t('Title'),
      'help' => '',
    ),
    'portfolio' => array(
      'name' => t('Portfolio'),
      'base' => 'node_content',
      'description' => t('Use the <i>Portfolio</i> content type to manage portfolio nodes with the BigWig theme.'),
      'has_title' => '1',
      'title_label' => t('Title'),
      'help' => '',
    ),
    'services' => array(
      'name' => t('Services'),
      'base' => 'node_content',
      'description' => t('Use the <i>Services</i> content type to manage service nodes with the BigWig theme.'),
      'has_title' => '1',
      'title_label' => t('Title'),
      'help' => '',
    ),
    'team_member' => array(
      'name' => t('Team Member'),
      'base' => 'node_content',
      'description' => t('Use the <i>Team Member</i> content type to manage staff nodes with the BigWig theme.'),
      'has_title' => '1',
      'title_label' => t('Title'),
      'help' => '',
    ),
  );
  return $items;
}
