<?php

/**
 * @file
 * Default simple view template to all the fields as a row.
 *
 * - $view: The view in use.
 * - $fields: an array of $field objects. Each one contains:
 *   - $field->content: The output of the field.
 *   - $field->raw: The raw data for the field, if it exists. This is NOT output safe.
 *   - $field->class: The safe class id to use.
 *   - $field->handler: The Views field handler object controlling this field. Do not use
 *     var_export to dump this object, as it can't handle the recursion.
 *   - $field->inline: Whether or not the field should be inline.
 *   - $field->inline_html: either div or span based on the above flag.
 *   - $field->wrapper_prefix: A complete wrapper containing the inline_html to use.
 *   - $field->wrapper_suffix: The closing tag for the wrapper.
 *   - $field->separator: an optional separator that may appear before a field.
 *   - $field->label: The wrap label text to use.
 *   - $field->label_html: The full HTML of the label to use including
 *     configured element type.
 * - $row: The raw result object from the query, with all data it fetched.
 *
 * @ingroup views_templates
 */

?>

<?php foreach ($fields as $id => $field): ?>
	<?php switch($fields['field_template']->content): case 'image': ?>
	  
	  <?php if($id == 'field_image'): ?>
	  <div class="post-media">
	  	<?php print $fields['field_image']->content; ?>
	  </div>
	  <?php endif; ?>
	  
	  <?php break; case 'slider': ?>
	  
	  <?php if($id == 'field_image_1'): ?>
	  <div class="post-media">
	   <div class="peSlider peVolo peNeedResize" data-plugin="peVolo" data-controls-arrows="edges-buttons" data-controls-bullets="disabled" data-icon-font="enabled">
	   	<div data-delay="7" class="visible">
	   		<?php print $fields['field_image_1']->content; ?>
	  	</div>
	  </div>
	  </div>
	  <?php endif; ?>
	  
	  <?php break; case 'video': ?>
	  
	  <?php if($id == 'field_video'): ?>
	  <div class="post-media">
	  	<a href="<?php print $fields['field_video']->content; ?>" class="peVideo"></a>
	  </div>
	  <?php endif; ?>
	  
	  <?php break; endswitch; ?>
	

	<?php if(($id != 'field_template') && ($id != 'field_video') && ($id != 'field_image') && ($id != 'field_image_1')): ?>
	  <?php if (!empty($field->separator)): ?>
	    <?php print $field->separator; ?>
	  <?php endif; ?>
	
	  <?php print $field->wrapper_prefix; ?>
	    <?php print $field->label_html; ?>
	    <?php print $field->content; ?>
	  <?php print $field->wrapper_suffix; ?>
	<?php endif; ?>
<?php endforeach; ?>