<?php

/**
 * @file
 * Default theme implementation to display a node.
 */

/* Query Portfolio Nodes */
$query = new EntityFieldQuery();
$query->entityCondition('entity_type', 'node');
$query->propertyCondition('status', 1);
$query->entityCondition('bundle', 'portfolio');
$result = $query->execute();

if (isset($result['node'])) {
	$portfolio_nids = array_keys($result['node']);
	$portfolios = entity_load('node', $portfolio_nids);
}

/* Generate Paginator */
$nid = $node->nid;
$first = reset($result['node']);
$last = end($result['node']);
$current = (int)array_search($nid, $portfolio_nids);

switch($nid) {
	case $first->nid: $prev = $last->nid; $next = $portfolio_nids[$current + 1];	break;
	case $last->nid: $prev = $portfolio_nids[$current - 1]; $next = $first->nid;	break;
	default: $prev = $portfolio_nids[$current - 1]; $next = $portfolio_nids[$current + 1]; break;
}

$path = "node/".$node->nid; 
$options = array('absolute' => TRUE); 
$url = url($path, $options);

?>

<div id="node-<?php print $node->nid; ?>" class="row-fluid project pe-block <?php print $classes; ?> clearfix" <?php print $attributes; ?>>


	<?php if(!empty($node->field_template)): ?>
	<div class="row-fluid">
	  	<div class="span12 media">

			<?php switch($node->field_template['und'][0]['value']): case 'image': ?>
		
			<?php if (!empty($node->field_flare_image)): $i = 0; ?>
				<?php foreach ($node->field_flare_image['und'] as $image): ?>
					<?php $file = file_load($node->field_flare_image['und'][$i]['img']); ?>
				
					<div class="span12 post-image">
						<img src="<?php print image_style_url('bigwig_940x460', $file->uri); $i++; ?>" />
					</div>
				<?php endforeach; ?>
			<?php endif; ?>
			
			<?php break; case 'video': ?>
			
				<?php if(!empty($node->field_video['und'][0]['value'])): ?>
				  <a href="<?php print $node->field_video['und'][0]['value']; ?>" class="peVideo"></a>
				<?php endif;?>
				
			<?php break; case 'slider': ?>
			
			  	<?php if (!empty($node->field_flare_image)): $i = 0; ?>
				    <div class="peSlider peVolo peNeedResize" 
				    	data-plugin="peVolo" 
				    	data-controls-arrows="edges-buttons" 
				    	data-controls-bullets="disabled" 
				    	data-icon-font="enabled">
						<?php foreach ($node->field_flare_image['und'] as $image): ?>
							<?php $file = file_load($node->field_flare_image['und'][$i]['img']); ?>
							<div data-delay="7" class="visible">
								<img src="<?php print image_style_url('bigwig_940x460', $file->uri); $i++; ?>" />
							</div>
						<?php endforeach; ?>
					</div><!-- /.peSlider -->
				<?php endif; ?>
			  	
			<?php break; case 'gallery': ?>
				<?php require_once dirname(dirname(dirname(__FILE__))) . '/includes/project_masonry.inc'; ?>
			<?php break; endswitch; ?>
	
		</div>
	</div>

	<!-- PROJECT INFO -->
	<div class="row-fluid">
		<section class="span8 project-description">
			<?php if(!empty($node->body['und'][0]['summary'])): ?>
			<p class="intro">
				<?php print $node->body['und'][0]['summary']; ?>
			</p>
			<?php endif; ?>

			<?php if(!empty($node->body['und'][0]['value'])): print $node->body['und'][0]['value']; endif; ?>
		</section>

		<section class="span4 project-data">
			<div class="inner-spacer-left-lrg">

				<div class="project-nav">
					<a href="<?php print url('node/' . $prev, array('absolute' => TRUE)); ?>" class="prev-btn">Prev</a> <a
						href="<?php print url('node/' . $next, array('absolute' => TRUE)); ?>" class="next-btn">Next</a>
				</div>

			<?php if (!empty($node->field_project_info['und'][0]['value'])): ?>
				<h6>Project Data</h6>
				<span class="line-sml"></span>
				<div class="row-fluid">
					<?php print $node->field_project_info['und'][0]['value']; ?>
				</div>
			<?php endif; ?>

			</div>
		</section>
	</div>
	
	<!-- SHARE BUTTONS -->
	<?php if(!empty($node->field_share)): ?>	
		<div class="shareBox">                  									
			<h6>Share: </h6>
			
			<?php if(!empty($node->field_share['und'])): ?>
				<?php $i = 0; foreach($node->field_share['und'] as $item): ?>
						<button class="share <?php print $node->field_share['und'][$i]['value']; ?>"></button>
				<?php $i++; endforeach; ?>
			<?php endif; ?>
		</div>
		<div class="divider dotted"></div>
	<?php endif; ?>

	<?php else: ?>


	<?php
		// We hide the comments and links now so that we can render them later.
		hide($content['comments']);
		hide($content['links']);
		print render($content);
	?>

	<?php print render($content['links']); ?>

	<?php print render($content['comments']); ?>

	<?php endif; ?>

</div>
