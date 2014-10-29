<?php

/**
 * @file
 * Default theme implementation to display a region.
 */
?>

<?php if ($content): ?>
  <div class="<?php print $classes; ?>">
  	<div class="inner-spacer-left-lrg">
    	<?php print $content; ?>
    </div>
  </div>
<?php endif; ?>
