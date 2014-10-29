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
$isotope = ($view->style_plugin->plugin_name == 'isotope') ? 'true' : 'false';
?>

<?php if($isotope == 'true'): ?>

<?php foreach ($fields as $id => $field): ?>
	<?php if(($id == 'field_flare_image') && !empty($row->field_field_flare_image[0])): ?>

	  	<?php $img = file_load($row->field_field_flare_image[0]['raw']['img'])->uri; ?>
	  	<?php $caption = $row->field_field_flare_image[0]['raw']['toggle_caption']; ?>
		<?php $video = (!empty($row->field_field_template[0]['raw']['value'])) ? 'true' : 'false'; ?>
		
  	  	<span class="cell-title">
  	  		<a href="<?php print url('node/' . $row->nid, array('absolute' => TRUE)); ?>"><?php print $row->node_title?></a>
  	  	</span>
  		<div class="scalable">
  			<a <?php if($caption == 1) :?>
  			    data-title="<?php print $row->node_title; ?>"
	  		    data-description="<?php print $row->field_field_flare_image[0]['raw']['caption']; ?>"
	  		   <?php endif; ?>
			   class="peOver"
			   data-flare-gallery="projectGallery"
			   data-flare-thumb="<?php print image_style_url('bigwig_320x240', $img); ?>"
			   data-target="flare"
			   <?php if(($video == 'true') && !empty($row->field_field_video[0]['rendered']['#markup'])): ?>
			   data-flare-videoposter="<?php image_style_url('bigwig_940x460', $img); ?>"
			   href="<?php print $row->field_field_video[0]['rendered']['#markup']; ?>">
			   <?php else: ?>
			   href="<?php print image_style_url('bigwig_940x460', $img); ?>">
			   <?php endif; ?>
  				<img src="<?php print image_style_url('bigwig_320x240', $img); ?>" />
  			</a>
  		</div>

	<?php endif; ?>
<?php endforeach; ?>

<?php else: ?>

<?php foreach ($fields as $id => $field): ?>
  <?php if (!empty($field->separator)): ?>
    <?php print $field->separator; ?>
  <?php endif; ?>

  <?php print $field->wrapper_prefix; ?>
    <?php print $field->label_html; ?>
    <?php print $field->content; ?>
  <?php print $field->wrapper_suffix; ?>
<?php endforeach; ?>

<?php endif; ?>