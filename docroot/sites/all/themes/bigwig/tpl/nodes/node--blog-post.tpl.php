<?php

/**
 * @file
 * Default theme implementation to display a node.
 */

/* Query Blog Nodes */
$query = new EntityFieldQuery();
$query->entityCondition('entity_type', 'node')
  	  ->entityCondition('bundle', 'blog_post');
$result = $query->execute();

if (isset($result['node'])) {
	$blog_post_nids = array_keys($result['node']);
	$blog_posts = entity_load('node', $blog_post_nids);
}

/* Generate Paginator */
$nid = $node->nid;
$first = reset($result['node']);
$last = end($result['node']);

switch($nid) {
	case $first->nid: $prev = $last->nid; $next = $nid + 1;	break;
	case $last->nid: $prev = $nid - 1; $next = $first->nid;	break;
	default: $prev = $nid - 1; $next = $nid + 1; break;
}

/* Generate Prev/Next URLs */
$prev_url = url('node/'.$prev, array('absolute' => TRUE));
$next_url = url('node/'.$next, array('absolute' => TRUE));

?>

<div id="node-<?php print $node->nid; ?>" class="post <?php print $classes; ?> clearfix" <?php print $attributes; ?>>

  <!-- POST TITLE -->
  <div class="row-fluid">
	  <div class="span12 post-title">
		  <?php print render($title_prefix); ?>
		  <h1 <?php print $title_attributes; ?>>
			  <?php print $title; ?>
		  </h1>
		  <?php print render($title_suffix); ?>
	  </div>
  </div>
	
  <!-- META INFORMATION -->
  <?php if ($display_submitted): ?>
	<div class="row-fluid">
		<div class="span12">
			<div class="comments">
				<?php if($comment_count != 0): ?>
					<?php print $comment_count; ?>
				<?php else: ?>
					<a href="#comments"><?php print $comment_count; ?></a>
				<?php endif; ?>
				<div class="comment-icon"></div>
			</div>
			<div class="post-meta">
				<span class="user">By <?php print $name; ?></span>
				<span class="date">Posted on <?php print format_date($created, 'custom', 'F jS, Y'); ?></span>
				<?php if(!empty($content['field_categories'])): ?>
					<span class="categories"><span>in</span> <?php print render($content['field_categories']); ?></span>
				<?php endif; ?>
			</div>
		</div>
	</div>
  <?php endif; ?>
	
  <?php if(!empty($node->field_template)): ?>
		
	  <?php switch($node->field_template['und'][0]['value']): case 'image': ?>
	  
	    <?php if (!empty($node->field_image)): $i = 0; ?>
	    <div class="row-fluid">
			<?php foreach ($node->field_image['und'] as $image): ?>
			<div class="span12 post-image">
				<img src="<?php print file_create_url($node->field_image['und'][$i]['uri']); $i++; ?>" />
			</div>
			<?php endforeach; ?>
		</div>
		<?php endif; ?>
		
	  <?php break; case 'slider': ?>
	  
	  <div class="row-fluid">
	  	<div class="span12 post-image">
		  	<?php if (!empty($node->field_image)): $i = 0; ?>
			    <div class="peSlider peVolo peNeedResize" data-plugin="peVolo" data-controls-arrows="edges-buttons" data-controls-bullets="disabled" data-icon-font="enabled">
					<?php foreach ($node->field_image['und'] as $image): ?>
					<div data-delay="7" class="visible">
						<img src="<?php print image_style_url('bigwig_620x350', $node->field_image['und'][$i]['uri']); $i++; ?>" />
					</div>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
		</div>
	  </div>
	  
	  <?php break; case 'video': ?>
	  
		<?php if(!empty($node->field_video['und'][0]['value'])): ?>
		  <a href="<?php print $node->field_video['und'][0]['value']; ?>" class="peVideo"></a>
		<?php endif;?>
	  
	  <?php break; endswitch; ?>
	  
  		<?php if(!empty($node->body['und'][0]['summary'])): ?>
			<p class="intro"><?php print $node->body['und'][0]['summary']; ?></p>	
		<?php endif; ?>
		
		<?php if(!empty($node->body['und'][0]['value'])): print $node->body['und'][0]['value']; endif; ?>
		
  <?php else: ?>
  <!-- RENDER CONTENT -->
	<?php
		hide($content['comments']);
		hide($content['links']);
		hide($content['field_share']);
		hide($content['field_tags']);
		hide($content['field_categories']);
		hide($content['field_template']);
		
		print render($content);
    ?>
  <?php endif; ?>
	
	<!-- SHARE BUTTONS -->
	<?php if(!empty($node->field_share)): ?>	
		<div class="shareBox">                  									
			<h6>Share This Post: </h6>
			
			<?php if(!empty($node->field_share['und'])): ?>
				<?php $i = 0; foreach($node->field_share['und'] as $item): ?>
						<button class="share <?php print $node->field_share['und'][$i]['value']; ?>"></button>
				<?php $i++; endforeach; ?>
			<?php endif; ?>
		</div>
	<?php endif; ?>
	
	<!-- PAGINATION -->
	<?php if(!empty($prev) || !empty($next)): ?>
	<div class="row-fluid post-pagination">
		<div class="span12">		
			<div class="row-fluid">
			
			<!-- PAGE: PREVIOUS -->
			<?php if($nid != $first->nid): ?>
				<?php if( !empty($prev) && isset($blog_posts[$prev]) && !empty($blog_posts[$prev]) ): ?>
					<a href="<?php print $prev_url; ?>" class="span6 prev-post">
						<span>Previous Article</span>
						<h3><?php print $blog_posts[$prev]->title; ?></h3>
						<span class="date"><?php print format_date($blog_posts[$prev]->created, 'custom', 'F jS, Y'); ?></span>
						<i class="icon-left-open"></i>
					</a>
				<?php endif; ?>
			<?php endif;?>
			
			<!-- PAGE: NEXT -->
			<?php if($nid != $last->nid): ?>
				<?php if(!empty($next)): ?>
					<a href="<?php print $next_url; ?>" class="span6 next-post">
						<span>Next Article</span>
						<h3><?php print $blog_posts[$next]->title; ?></h3>
						<span class="date"><?php print format_date($blog_posts[$next]->created, 'custom', 'F jS, Y'); ?></span>
						<i class="icon-right-open"></i>
					</a>
				<?php endif; ?>
			<?php endif;?>
			
			</div><!-- /.row-fluid -->
		</div><!-- /.span12 -->
	</div><!-- /.post-pagination -->
	<?php endif; ?>
	
	<?php print render($content['links']); ?>
	
	<?php print render($content['comments']); ?>

</div>
