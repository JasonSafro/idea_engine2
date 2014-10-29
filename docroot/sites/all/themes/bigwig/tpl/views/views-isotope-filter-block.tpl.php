<?php
/**
 * @file views-isotope-filter-block.tpl.php
 * Default simple view template to display a list of rows.
 *
 * @ingroup views_templates
 */
?>


<div class="pe-container filter">
	<div class="row-fluid">
		<div class="span12 project-filter">
			<ul class="filter-keywords peIsotopeFilter">
				<li class="first active"><a href="#" data-option-value="*"
					class="selected"><?php print t('All'); ?> </a></li>
				<?php foreach ( $rows as $id => $row ): ?>

				<?php 
				// remove characters that cause problems with classes
				// this is also do to the isotope elements
				$dataoption = trim(strip_tags(strtolower($row)));
				$dataoption = str_replace(' ', '-', $dataoption);
				$dataoption = str_replace('/', '-', $dataoption);
				$dataoption = str_replace('&amp;', '', $dataoption);
				?>

				<li><a data-category="<?php print $dataoption; ?>" href="#"><?php print trim($row); ?>
				</a></li>


				<?php endforeach; ?>
			</ul>
		</div>
	</div>
</div>
