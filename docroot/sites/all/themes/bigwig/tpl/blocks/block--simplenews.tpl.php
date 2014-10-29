<?php

/**
 * @file
 * Default theme implementation to display a block.
 */
?>
<div id="<?php print $block_html_id; ?>"
	class="widget_newsletter <?php print $classes; ?>" <?php print $attributes; ?>>

	<?php print render($title_prefix); ?>
	<?php if ($block->subject): ?>
	<h2 <?php print $title_attributes; ?>>
		<?php print $block->subject ?>
	</h2>
	<?php endif;?>
	<?php print render($title_suffix); ?>

	<?php print $content ?>
	
	<?php $privacy = theme_get_setting('privacy-policy'); if(!empty($privacy)): ?>
		<p class="outro"><?php print theme_get_setting('privacy-policy'); ?></p>
	<?php endif; ?>
</div>
