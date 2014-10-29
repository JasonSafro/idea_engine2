<?php

/**
 * @file
 * Default theme implementation to display a region.
 */
?>

<?php if ($content): ?>
<div class="<?php print $classes; ?>">

	<?php print render($page['help']); ?>
	<?php if ($action_links): ?>
	<ul class="action-links">
		<?php print render($action_links); ?>
	</ul>
	<?php endif; ?>

	<?php print $content; ?>

	<?php print $feed_icons; ?>
</div>
<?php endif; ?>
