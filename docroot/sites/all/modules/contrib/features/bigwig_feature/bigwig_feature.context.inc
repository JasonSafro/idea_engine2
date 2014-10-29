<?php
/**
 * @file
 * bigwig_feature.context.inc
 */

/**
 * Implements hook_context_default_contexts().
 */
function bigwig_feature_context_default_contexts() {
  $export = array();

  $context = new stdClass();
  $context->disabled = FALSE; /* Edit this to true to make a default context disabled initially */
  $context->api_version = 3;
  $context->name = 'blog';
  $context->description = '';
  $context->tag = 'bigwig - templates';
  $context->conditions = array(
    'node' => array(
      'values' => array(
        'blog_post' => 'blog_post',
      ),
      'options' => array(
        'node_form' => '0',
      ),
    ),
    'path' => array(
      'values' => array(
        'blog' => 'blog',
      ),
    ),
  );
  $context->reactions = array(
    'block' => array(
      'blocks' => array(
        'search-form' => array(
          'module' => 'search',
          'delta' => 'form',
          'region' => 'sidebar_right',
          'weight' => '-10',
        ),
        'block-1' => array(
          'module' => 'block',
          'delta' => '1',
          'region' => 'sidebar_right',
          'weight' => '-9',
        ),
        'block-9' => array(
          'module' => 'block',
          'delta' => '9',
          'region' => 'sidebar_right',
          'weight' => '-8',
        ),
        'views-bigwig_taxonomy-categories' => array(
          'module' => 'views',
          'delta' => 'bigwig_taxonomy-categories',
          'region' => 'sidebar_right',
          'weight' => '-7',
        ),
        'views-bigwig_taxonomy-tagcloud' => array(
          'module' => 'views',
          'delta' => 'bigwig_taxonomy-tagcloud',
          'region' => 'sidebar_right',
          'weight' => '-6',
        ),
        'block-10' => array(
          'module' => 'block',
          'delta' => '10',
          'region' => 'sidebar_right',
          'weight' => '-5',
        ),
        'block-6' => array(
          'module' => 'block',
          'delta' => '6',
          'region' => 'sidebar_right',
          'weight' => '-4',
        ),
      ),
    ),
  );
  $context->condition_mode = 0;

  // Translatables
  // Included for use with string extractors like potx.
  t('bigwig - templates');
  $export['blog'] = $context;

  $context = new stdClass();
  $context->disabled = FALSE; /* Edit this to true to make a default context disabled initially */
  $context->api_version = 3;
  $context->name = 'boxed_grid';
  $context->description = '';
  $context->tag = 'bigwig - homepages';
  $context->conditions = array(
    'path' => array(
      'values' => array(
        'node/47' => 'node/47',
      ),
    ),
  );
  $context->reactions = array(
    'block' => array(
      'blocks' => array(
        'views-bigwig_homepage-boxed_grid' => array(
          'module' => 'views',
          'delta' => 'bigwig_homepage-boxed_grid',
          'region' => 'prescript',
          'weight' => '-10',
        ),
        'block-8' => array(
          'module' => 'block',
          'delta' => '8',
          'region' => 'prescript',
          'weight' => '-9',
        ),
        'views-bigwig_homepage-services2col' => array(
          'module' => 'views',
          'delta' => 'bigwig_homepage-services2col',
          'region' => 'content',
          'weight' => '-9',
        ),
        'views-bigwig_homepage-staff' => array(
          'module' => 'views',
          'delta' => 'bigwig_homepage-staff',
          'region' => 'content',
          'weight' => '-7',
        ),
        'block-13' => array(
          'module' => 'block',
          'delta' => '13',
          'region' => 'postscript',
          'weight' => '-10',
        ),
        'block-14' => array(
          'module' => 'block',
          'delta' => '14',
          'region' => 'postscript',
          'weight' => '-9',
        ),
      ),
    ),
    'theme_html' => array(
      'class' => 'front',
    ),
  );
  $context->condition_mode = 0;

  // Translatables
  // Included for use with string extractors like potx.
  t('bigwig - homepages');
  $export['boxed_grid'] = $context;

  $context = new stdClass();
  $context->disabled = FALSE; /* Edit this to true to make a default context disabled initially */
  $context->api_version = 3;
  $context->name = 'contact';
  $context->description = '';
  $context->tag = 'bigwig - templates';
  $context->conditions = array(
    'path' => array(
      'values' => array(
        'contact' => 'contact',
      ),
    ),
  );
  $context->reactions = array(
    'block' => array(
      'blocks' => array(
        'block-6' => array(
          'module' => 'block',
          'delta' => '6',
          'region' => 'sidebar_right',
          'weight' => '-10',
        ),
      ),
    ),
  );
  $context->condition_mode = 0;

  // Translatables
  // Included for use with string extractors like potx.
  t('bigwig - templates');
  $export['contact'] = $context;

  $context = new stdClass();
  $context->disabled = FALSE; /* Edit this to true to make a default context disabled initially */
  $context->api_version = 3;
  $context->name = 'fullscreen_slider';
  $context->description = '';
  $context->tag = 'bigwig - homepages';
  $context->conditions = array(
    'path' => array(
      'values' => array(
        'node/42' => 'node/42',
      ),
    ),
  );
  $context->reactions = array(
    'block' => array(
      'blocks' => array(
        'pe_slider-pe_slider_1' => array(
          'module' => 'pe_slider',
          'delta' => 'pe_slider_1',
          'region' => 'content',
          'weight' => '-10',
        ),
      ),
    ),
    'region' => array(
      'bartik' => array(
        'disable' => array(
          'header' => 0,
          'help' => 0,
          'page_top' => 0,
          'page_bottom' => 0,
          'highlighted' => 0,
          'featured' => 0,
          'content' => 0,
          'sidebar_first' => 0,
          'sidebar_second' => 0,
          'triptych_first' => 0,
          'triptych_middle' => 0,
          'triptych_last' => 0,
          'footer_firstcolumn' => 0,
          'footer_secondcolumn' => 0,
          'footer_thirdcolumn' => 0,
          'footer_fourthcolumn' => 0,
          'footer' => 0,
          'dashboard_main' => 0,
          'dashboard_sidebar' => 0,
          'dashboard_inactive' => 0,
        ),
      ),
      'bigwig' => array(
        'disable' => array(
          'footer_first' => 'footer_first',
          'footer_second' => 'footer_second',
          'footer_third' => 'footer_third',
          'footer_fourth' => 'footer_fourth',
          'header_left' => 0,
          'header_right' => 0,
          'prescript' => 0,
          'sidebar_left' => 0,
          'content' => 0,
          'sidebar_right' => 0,
          'postscript' => 0,
          'footer_fifth' => 0,
          'footer_sixth' => 0,
          'dashboard_main' => 0,
          'dashboard_sidebar' => 0,
          'dashboard_inactive' => 0,
        ),
      ),
      'seven' => array(
        'disable' => array(
          'content' => 0,
          'help' => 0,
          'page_top' => 0,
          'page_bottom' => 0,
          'sidebar_first' => 0,
          'dashboard_main' => 0,
          'dashboard_sidebar' => 0,
          'dashboard_inactive' => 0,
        ),
      ),
    ),
    'theme_html' => array(
      'class' => 'fullscreen front',
    ),
  );
  $context->condition_mode = 0;

  // Translatables
  // Included for use with string extractors like potx.
  t('bigwig - homepages');
  $export['fullscreen_slider'] = $context;

  $context = new stdClass();
  $context->disabled = FALSE; /* Edit this to true to make a default context disabled initially */
  $context->api_version = 3;
  $context->name = 'fullscreen_video';
  $context->description = '';
  $context->tag = 'bigwig - homepages';
  $context->conditions = array(
    'path' => array(
      'values' => array(
        'node/44' => 'node/44',
      ),
    ),
  );
  $context->reactions = array(
    'block' => array(
      'blocks' => array(
        'pe_slider-pe_slider_5' => array(
          'module' => 'pe_slider',
          'delta' => 'pe_slider_5',
          'region' => 'content',
          'weight' => '-10',
        ),
      ),
    ),
    'region' => array(
      'bartik' => array(
        'disable' => array(
          'header' => 0,
          'help' => 0,
          'page_top' => 0,
          'page_bottom' => 0,
          'highlighted' => 0,
          'featured' => 0,
          'content' => 0,
          'sidebar_first' => 0,
          'sidebar_second' => 0,
          'triptych_first' => 0,
          'triptych_middle' => 0,
          'triptych_last' => 0,
          'footer_firstcolumn' => 0,
          'footer_secondcolumn' => 0,
          'footer_thirdcolumn' => 0,
          'footer_fourthcolumn' => 0,
          'footer' => 0,
          'dashboard_main' => 0,
          'dashboard_sidebar' => 0,
          'dashboard_inactive' => 0,
        ),
      ),
      'bigwig' => array(
        'disable' => array(
          'footer_first' => 'footer_first',
          'footer_second' => 'footer_second',
          'footer_third' => 'footer_third',
          'footer_fourth' => 'footer_fourth',
          'header_left' => 0,
          'header_right' => 0,
          'prescript' => 0,
          'sidebar_left' => 0,
          'content' => 0,
          'sidebar_right' => 0,
          'postscript' => 0,
          'footer_fifth' => 0,
          'footer_sixth' => 0,
          'dashboard_main' => 0,
          'dashboard_sidebar' => 0,
          'dashboard_inactive' => 0,
        ),
      ),
      'seven' => array(
        'disable' => array(
          'content' => 0,
          'help' => 0,
          'page_top' => 0,
          'page_bottom' => 0,
          'sidebar_first' => 0,
          'dashboard_main' => 0,
          'dashboard_sidebar' => 0,
          'dashboard_inactive' => 0,
        ),
      ),
    ),
    'theme_html' => array(
      'class' => 'fullscreen front',
    ),
  );
  $context->condition_mode = 0;

  // Translatables
  // Included for use with string extractors like potx.
  t('bigwig - homepages');
  $export['fullscreen_video'] = $context;

  $context = new stdClass();
  $context->disabled = FALSE; /* Edit this to true to make a default context disabled initially */
  $context->api_version = 3;
  $context->name = 'fullwidth_slider';
  $context->description = '';
  $context->tag = 'bigwig - homepages';
  $context->conditions = array(
    'path' => array(
      'values' => array(
        'node/43' => 'node/43',
      ),
    ),
  );
  $context->reactions = array(
    'block' => array(
      'blocks' => array(
        'pe_slider-pe_slider_2' => array(
          'module' => 'pe_slider',
          'delta' => 'pe_slider_2',
          'region' => 'prescript',
          'weight' => '-10',
        ),
        'block-7' => array(
          'module' => 'block',
          'delta' => '7',
          'region' => 'prescript',
          'weight' => '-9',
        ),
        'views-bigwig_homepage-block' => array(
          'module' => 'views',
          'delta' => 'bigwig_homepage-block',
          'region' => 'content',
          'weight' => '-10',
        ),
        'views-bigwig_homepage-latest_projects' => array(
          'module' => 'views',
          'delta' => 'bigwig_homepage-latest_projects',
          'region' => 'content',
          'weight' => '-9',
        ),
      ),
    ),
    'theme_html' => array(
      'class' => 'front',
    ),
  );
  $context->condition_mode = 0;

  // Translatables
  // Included for use with string extractors like potx.
  t('bigwig - homepages');
  $export['fullwidth_slider'] = $context;

  $context = new stdClass();
  $context->disabled = FALSE; /* Edit this to true to make a default context disabled initially */
  $context->api_version = 3;
  $context->name = 'fullwidth_video';
  $context->description = '';
  $context->tag = 'bigwig - homepages';
  $context->conditions = array(
    'path' => array(
      'values' => array(
        'node/45' => 'node/45',
      ),
    ),
  );
  $context->reactions = array(
    'block' => array(
      'blocks' => array(
        'pe_slider-pe_slider_3' => array(
          'module' => 'pe_slider',
          'delta' => 'pe_slider_3',
          'region' => 'prescript',
          'weight' => '-10',
        ),
        'block-7' => array(
          'module' => 'block',
          'delta' => '7',
          'region' => 'prescript',
          'weight' => '-9',
        ),
        'views-bigwig_homepage-block' => array(
          'module' => 'views',
          'delta' => 'bigwig_homepage-block',
          'region' => 'content',
          'weight' => '-10',
        ),
        'views-bigwig_homepage-latest_projects' => array(
          'module' => 'views',
          'delta' => 'bigwig_homepage-latest_projects',
          'region' => 'content',
          'weight' => '-9',
        ),
      ),
    ),
    'theme_html' => array(
      'class' => 'front',
    ),
  );
  $context->condition_mode = 0;

  // Translatables
  // Included for use with string extractors like potx.
  t('bigwig - homepages');
  $export['fullwidth_video'] = $context;

  $context = new stdClass();
  $context->disabled = FALSE; /* Edit this to true to make a default context disabled initially */
  $context->api_version = 3;
  $context->name = 'global';
  $context->description = '';
  $context->tag = 'bigwig - templates';
  $context->conditions = array(
    'sitewide' => array(
      'values' => array(
        1 => 1,
      ),
    ),
  );
  $context->reactions = array(
    'block' => array(
      'blocks' => array(
        'block-2' => array(
          'module' => 'block',
          'delta' => '2',
          'region' => 'header_left',
          'weight' => '-10',
        ),
        'block-3' => array(
          'module' => 'block',
          'delta' => '3',
          'region' => 'header_right',
          'weight' => '-10',
        ),
        'block-5' => array(
          'module' => 'block',
          'delta' => '5',
          'region' => 'footer_first',
          'weight' => '-10',
        ),
        'views-bigwig_taxonomy-tagcloud' => array(
          'module' => 'views',
          'delta' => 'bigwig_taxonomy-tagcloud',
          'region' => 'footer_second',
          'weight' => '-10',
        ),
        'views-bigwig_blog-latest_news' => array(
          'module' => 'views',
          'delta' => 'bigwig_blog-latest_news',
          'region' => 'footer_third',
          'weight' => '-10',
        ),
        'simplenews-15' => array(
          'module' => 'simplenews',
          'delta' => '15',
          'region' => 'footer_fourth',
          'weight' => '-10',
        ),
        'block-4' => array(
          'module' => 'block',
          'delta' => '4',
          'region' => 'footer_fifth',
          'weight' => '-10',
        ),
        'system-powered-by' => array(
          'module' => 'system',
          'delta' => 'powered-by',
          'region' => 'footer_sixth',
          'weight' => '-10',
        ),
      ),
    ),
  );
  $context->condition_mode = 1;

  // Translatables
  // Included for use with string extractors like potx.
  t('bigwig - templates');
  $export['global'] = $context;

  $context = new stdClass();
  $context->disabled = FALSE; /* Edit this to true to make a default context disabled initially */
  $context->api_version = 3;
  $context->name = 'portfolio-fullscreen';
  $context->description = '';
  $context->tag = 'bigwig - templates';
  $context->conditions = array(
    'path' => array(
      'values' => array(
        'portfolio-fullscreen' => 'portfolio-fullscreen',
        'gallery-fullscreen' => 'gallery-fullscreen',
        'portfolio-featured' => 'portfolio-featured',
      ),
    ),
  );
  $context->reactions = array(
    'theme_html' => array(
      'class' => 'fullscreen',
    ),
  );
  $context->condition_mode = 0;

  // Translatables
  // Included for use with string extractors like potx.
  t('bigwig - templates');
  $export['portfolio-fullscreen'] = $context;

  $context = new stdClass();
  $context->disabled = FALSE; /* Edit this to true to make a default context disabled initially */
  $context->api_version = 3;
  $context->name = 'portfolio-nodes';
  $context->description = '';
  $context->tag = 'bigwig - templates';
  $context->conditions = array(
    'node' => array(
      'values' => array(
        'portfolio' => 'portfolio',
      ),
      'options' => array(
        'node_form' => '0',
      ),
    ),
  );
  $context->reactions = array(
    'block' => array(
      'blocks' => array(
        'views-9021f0c00e7edd35cb40bffd8f0a8f5a' => array(
          'module' => 'views',
          'delta' => '9021f0c00e7edd35cb40bffd8f0a8f5a',
          'region' => 'content',
          'weight' => '10',
        ),
      ),
    ),
  );
  $context->condition_mode = 0;

  // Translatables
  // Included for use with string extractors like potx.
  t('bigwig - templates');
  $export['portfolio-nodes'] = $context;

  $context = new stdClass();
  $context->disabled = FALSE; /* Edit this to true to make a default context disabled initially */
  $context->api_version = 3;
  $context->name = 'services';
  $context->description = '';
  $context->tag = 'bigwig - templates';
  $context->conditions = array(
    'node' => array(
      'values' => array(
        'services' => 'services',
      ),
      'options' => array(
        'node_form' => '0',
      ),
    ),
  );
  $context->reactions = array(
    'block' => array(
      'blocks' => array(
        'views-bigwig_misc-block_1' => array(
          'module' => 'views',
          'delta' => 'bigwig_misc-block_1',
          'region' => 'content',
          'weight' => '-10',
        ),
        'search-form' => array(
          'module' => 'search',
          'delta' => 'form',
          'region' => 'sidebar_right',
          'weight' => '-26',
        ),
        'block-6' => array(
          'module' => 'block',
          'delta' => '6',
          'region' => 'sidebar_right',
          'weight' => '-25',
        ),
        'block-1' => array(
          'module' => 'block',
          'delta' => '1',
          'region' => 'sidebar_right',
          'weight' => '-10',
        ),
      ),
    ),
  );
  $context->condition_mode = 0;

  // Translatables
  // Included for use with string extractors like potx.
  t('bigwig - templates');
  $export['services'] = $context;

  $context = new stdClass();
  $context->disabled = FALSE; /* Edit this to true to make a default context disabled initially */
  $context->api_version = 3;
  $context->name = 'small_slider';
  $context->description = '';
  $context->tag = 'bigwig - homepages';
  $context->conditions = array(
    'path' => array(
      'values' => array(
        'node/49' => 'node/49',
      ),
    ),
  );
  $context->reactions = array(
    'block' => array(
      'blocks' => array(
        'pe_slider-pe_slider_6' => array(
          'module' => 'pe_slider',
          'delta' => 'pe_slider_6',
          'region' => 'prescript',
          'weight' => '-10',
        ),
        'block-8' => array(
          'module' => 'block',
          'delta' => '8',
          'region' => 'prescript',
          'weight' => '-9',
        ),
        'views-bigwig_homepage-block' => array(
          'module' => 'views',
          'delta' => 'bigwig_homepage-block',
          'region' => 'content',
          'weight' => '-10',
        ),
        'views-bigwig_homepage-latest_projects' => array(
          'module' => 'views',
          'delta' => 'bigwig_homepage-latest_projects',
          'region' => 'content',
          'weight' => '-9',
        ),
      ),
    ),
    'theme_html' => array(
      'class' => 'front',
    ),
  );
  $context->condition_mode = 0;

  // Translatables
  // Included for use with string extractors like potx.
  t('bigwig - homepages');
  $export['small_slider'] = $context;

  $context = new stdClass();
  $context->disabled = FALSE; /* Edit this to true to make a default context disabled initially */
  $context->api_version = 3;
  $context->name = 'staff';
  $context->description = '';
  $context->tag = 'bigwig - templates';
  $context->conditions = array(
    'node' => array(
      'values' => array(
        'team_member' => 'team_member',
      ),
      'options' => array(
        'node_form' => '0',
      ),
    ),
  );
  $context->reactions = array(
    'block' => array(
      'blocks' => array(
        'views-bigwig_misc-active_staff' => array(
          'module' => 'views',
          'delta' => 'bigwig_misc-active_staff',
          'region' => 'content',
          'weight' => '-10',
        ),
        'search-form' => array(
          'module' => 'search',
          'delta' => 'form',
          'region' => 'sidebar_right',
          'weight' => '-10',
        ),
        'block-6' => array(
          'module' => 'block',
          'delta' => '6',
          'region' => 'sidebar_right',
          'weight' => '-9',
        ),
        'block-1' => array(
          'module' => 'block',
          'delta' => '1',
          'region' => 'sidebar_right',
          'weight' => '-8',
        ),
      ),
    ),
  );
  $context->condition_mode = 0;

  // Translatables
  // Included for use with string extractors like potx.
  t('bigwig - templates');
  $export['staff'] = $context;

  $context = new stdClass();
  $context->disabled = FALSE; /* Edit this to true to make a default context disabled initially */
  $context->api_version = 3;
  $context->name = 'video';
  $context->description = '';
  $context->tag = 'bigwig - homepages';
  $context->conditions = array(
    'path' => array(
      'values' => array(
        'node/48' => 'node/48',
      ),
    ),
  );
  $context->reactions = array(
    'block' => array(
      'blocks' => array(
        'views-bigwig_homepage-homepage_video' => array(
          'module' => 'views',
          'delta' => 'bigwig_homepage-homepage_video',
          'region' => 'prescript',
          'weight' => '-10',
        ),
        'block-7' => array(
          'module' => 'block',
          'delta' => '7',
          'region' => 'prescript',
          'weight' => '-9',
        ),
        'views-bigwig_homepage-block' => array(
          'module' => 'views',
          'delta' => 'bigwig_homepage-block',
          'region' => 'content',
          'weight' => '-10',
        ),
      ),
    ),
    'theme_html' => array(
      'class' => 'front',
    ),
  );
  $context->condition_mode = 0;

  // Translatables
  // Included for use with string extractors like potx.
  t('bigwig - homepages');
  $export['video'] = $context;

  $context = new stdClass();
  $context->disabled = FALSE; /* Edit this to true to make a default context disabled initially */
  $context->api_version = 3;
  $context->name = 'wide_grid';
  $context->description = '';
  $context->tag = 'bigwig - homepages';
  $context->conditions = array(
    'path' => array(
      'values' => array(
        'node/46' => 'node/46',
      ),
    ),
  );
  $context->reactions = array(
    'block' => array(
      'blocks' => array(
        'views-bigwig_homepage-wide_grid' => array(
          'module' => 'views',
          'delta' => 'bigwig_homepage-wide_grid',
          'region' => 'prescript',
          'weight' => '-10',
        ),
        'block-7' => array(
          'module' => 'block',
          'delta' => '7',
          'region' => 'prescript',
          'weight' => '-9',
        ),
        'views-bigwig_homepage-block' => array(
          'module' => 'views',
          'delta' => 'bigwig_homepage-block',
          'region' => 'content',
          'weight' => '-10',
        ),
        'block-13' => array(
          'module' => 'block',
          'delta' => '13',
          'region' => 'postscript',
          'weight' => '-10',
        ),
        'block-12' => array(
          'module' => 'block',
          'delta' => '12',
          'region' => 'postscript',
          'weight' => '-9',
        ),
      ),
    ),
    'theme_html' => array(
      'class' => 'front',
    ),
  );
  $context->condition_mode = 0;

  // Translatables
  // Included for use with string extractors like potx.
  t('bigwig - homepages');
  $export['wide_grid'] = $context;

  return $export;
}
