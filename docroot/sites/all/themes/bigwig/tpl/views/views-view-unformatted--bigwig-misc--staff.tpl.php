<?php

/**
 * @file
 * Default simple view template to display a list of rows.
 *
 * @ingroup views_templates
 */
?>
<h3 class="title"><?php print t('Other Staff'); ?></h3>

<div class="pe-block row-fluid">
<?php foreach ($rows as $id => $row): ?>
	<?php if(($id % 3 == 0) && $id > 0): ?>
		<?php print ('</div><div class="pe-block row-fluid">'); ?>
	<?php endif; ?>
    <?php print ('<div class="span4 small-profile">'.$row.'</div>'); ?>
<?php endforeach; ?>
</div>