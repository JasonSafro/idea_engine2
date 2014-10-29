<?php

/**
 * @file
 * This template is used to print a single field in a view.
 *
 * It is not actually used in default Views, as this is registered as a theme
 * function which has better performance. For single overrides, the template is
 * perfectly okay.
 *
 * Variables available:
 * - $view: The view object
 * - $field: The field handler object that can process the input
 * - $row: The raw SQL result that can be used
 * - $output: The processed output that will normally be used.
 *
 * When fetching output from the $row, this construct should be used:
 * $data = $row->{$field->field_alias}
 *
 * The above will guarantee that you'll always get the correct data,
 * regardless of any changes in the aliasing that might happen if
 * the view is modified.
 */
$isotope = ($view->style_plugin->plugin_name == 'isotope') ? 'true' : 'false';
?>

<?php if($isotope == 'true'): ?>
	<?php print $output; ?>
<?php else: ?>

	<?php if(!empty($row->field_field_template[0])): ?>
		<?php switch($row->field_field_template[0]['raw']['value']): case 'image': ?>
			
				<?php if (!empty($row->field_field_flare_image)): ?>
					<?php print $row->field_field_flare_image[0]['rendered']['#markup']; ?>
				<?php endif; ?>
			
			<?php break; case 'video': ?>
			
				<?php if(!empty($row->field_field_video[0])): ?>
					<a href="<?php print $row->field_field_video[0]['rendered']['#markup']; ?>" class="peVideo"></a>
				<?php endif; ?>	
				
			<?php break; case 'slider': case 'gallery': ?>
			
		  	<?php if (!empty($row->field_field_flare_image)): $i = 0; ?>
			    <div class="peSlider peVolo peNeedResize" data-plugin="peVolo" data-controls-arrows="edges-buttons" data-controls-bullets="disabled" data-icon-font="enabled">
					<?php foreach ($row->field_field_flare_image as $image): ?>
					<div data-delay="7" class="visible">
						<?php print $row->field_field_flare_image[$i]['rendered']['#markup']; $i++; ?>
					</div>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
			
		<?php break; endswitch; ?>
		
	<?php else: print $output; endif; ?>
	
<?php endif; ?>