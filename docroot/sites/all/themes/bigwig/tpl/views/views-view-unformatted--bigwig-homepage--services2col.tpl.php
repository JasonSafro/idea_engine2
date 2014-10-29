<?php

/**
 * @file
 * Default simple view template to display a list of rows.
 *
 * @ingroup views_templates
 */
?>

<div class="row-fluid">
<?php foreach ($rows as $id => $row): ?>
	<?php if(($id % 2 == 0) && $id > 0): ?>
		<?php print ('</div><div class="row-fluid">'); ?>
	<?php endif; ?>
	<div class="span5-5">
		<div class="feature pe-block">
		    <?php print $row; ?>
	    </div>
    </div>
<?php endforeach; ?>
</div>