<?php print common_functionality_admin_comment( 'BEGIN '.__FILE__ ); ?>
<?php

/**
 * @file
 * Main view template.
 *
 * Variables available:
 * - $classes_array: An array of classes determined in
 *   template_preprocess_views_view(). Default classes are:
 *     .view
 *     .view-[css_name]
 *     .view-id-[view_name]
 *     .view-display-id-[display_name]
 *     .view-dom-id-[dom_id]
 * - $classes: A string version of $classes_array for use in the class attribute
 * - $css_name: A css-safe version of the view name.
 * - $css_class: The user-specified classes names, if any
 * - $header: The view header
 * - $footer: The view footer
 * - $rows: The results of the view query, if any
 * - $empty: The empty text to display if the view is empty
 * - $pager: The pager next/prev links to display, if any
 * - $exposed: Exposed widget form/info to display
 * - $feed_icon: Feed icon to display, if any
 * - $more: A link to view more, if any
 *
 * @ingroup views_templates
 */
$rows = $GLOBALS['view_data']['og_nodes_block_content_for_group'];
$accordion_data_parent = 'accordion-og_nodes_for_group';
?>
<div class="<?php print $classes; ?>">
  <?php print render($title_prefix); ?>
  <?php if ($title): ?>
    <?php print $title; ?>
  <?php endif; ?>
  <?php print render($title_suffix); ?>
  <?php if ($header): ?>
    <div class="view-header">
      <?php print $header; ?>
    </div>
  <?php endif; ?>

  <?php if ($exposed): ?>
    <div class="view-filters">
      <?php print $exposed; ?>
    </div>
  <?php endif; ?>

  <?php if ($attachment_before): ?>
    <div class="attachment attachment-before">
      <?php print $attachment_before; ?>
    </div>
  <?php endif; ?>

  <?php if ( is_array($rows) && count($rows)>0 ) : ?>
    <div class="view-content accordion" id="<?php print $accordion_data_parent; ?>">
<?php 
  $group_counter = 0;
  foreach( $rows as $one_group_title => $one_group ) :
    if( is_array($one_group) && count($one_group)>0 ) :
      ++$group_counter;
      $group_id = 'collapse_'.$group_counter;
?>
      <div class="accordion-group">
        <div class="accordion-heading">
          <a class="accordion-toggle <?php print $group_counter>1 ? 'collapsed' : ''; ?>" data-parent="<?php print $accordion_data_parent; ?>" data-toggle="collapse" href="#<?php print $group_id; ?>">
            <?php print $one_group_title.'S ('.count($one_group).')'; ?>
          </a>
        </div>
        
        <div id="<?php print $group_id; ?>" class="accordion-body <?php print $group_counter>1 ? '' : 'in'; ?> collapse" style="<?php print $group_counter>1 ? 'height: 0px;' : 'height: auto;'; ?>">
<?php
      foreach( $one_group as $one_node ) :
        print '<div class="accordion-inner">'.$one_node.'</div>'; 
      endforeach;
?>
        </div>
      </div>
<?php
    endif;
  endforeach;
?>
    </div>
  <?php elseif ($empty): ?>
    <div class="view-empty">
      <?php print $empty; ?>
    </div>
  <?php endif; ?>

  <?php if ($pager): ?>
    <?php print $pager; ?>
  <?php endif; ?>

  <?php if ($attachment_after): ?>
    <div class="attachment attachment-after">
      <?php print $attachment_after; ?>
    </div>
  <?php endif; ?>

  <?php if ($more): ?>
    <?php print $more; ?>
  <?php endif; ?>

  <?php if ($footer): ?>
    <div class="view-footer">
      <?php print $footer; ?>
    </div>
  <?php endif; ?>

  <?php if ($feed_icon): ?>
    <div class="feed-icon">
      <?php print $feed_icon; ?>
    </div>
  <?php endif; ?>

</div><?php /* class view */ ?>
<?php print common_functionality_admin_comment( 'END '.__FILE__ ); ?>