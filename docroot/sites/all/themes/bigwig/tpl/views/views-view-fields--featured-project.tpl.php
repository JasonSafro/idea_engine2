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
	<?php $i = 0; if (($id == 'field_flare_image') && !empty($row->field_field_flare_image[0])): ?>
		<?php $caption = $row->field_field_flare_image[$i]['raw']['toggle_caption']; ?>
	    <div class="span12 media">
	    <div class="peSlider peVolo peNeedResize" 
	    	data-plugin="peVolo" 
	    	data-controls-arrows="edges-buttons" 
	    	data-controls-bullets="disabled"
	    	data-icon-font="enabled">
			<?php foreach ($row->field_field_flare_image as $image): ?>
				<?php $file = file_load($row->field_field_flare_image[$i]['raw']['img']); ?>
				<div data-delay="7" class="visible">
					<img src="<?php print image_style_url('bigwig_940x460', $file->uri); ?>" />
						<?php if(($caption == 1) && !empty($row->field_field_flare_image[$i]['raw']['caption'])): ?>
						    <div class="peCaption">
						    <?php if(!empty($row->field_field_flare_image[$i]['raw']['title'])): ?>
							    <h3><?php print $row->field_field_flare_image[$i]['raw']['title']; ?></h3>
						    <?php endif; ?>
							    <p><?php print $row->field_field_flare_image[$i]['raw']['caption']; ?></p>
						    </div>
				    	<?php endif; $i++; ?>
				</div>
			<?php endforeach; ?>
		</div><!-- /.peSlider -->
		</div>
	<?php elseif(($id != 'flare_field_image') && ($id != 'field_template')) : ?>
	  <?php if (!empty($field->separator)): ?>
	    <?php print $field->separator; ?>
	  <?php endif; ?>
	
	  <?php print $field->wrapper_prefix; ?>
	    <?php print $field->label_html; ?>
	    <?php print $field->content; ?>
	  <?php print $field->wrapper_suffix; ?>
  <?php endif; ?>
<?php endforeach; ?>