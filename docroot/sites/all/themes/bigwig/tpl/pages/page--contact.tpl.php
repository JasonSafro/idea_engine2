<?php

/**
 * @file
 * Default theme implementation to display a single Drupal page.
 */

  require( dirname(dirname(__FILE__)).'/misc/header.php' );
?>
      
	<div class="site-body">
    <a id="main-content"></a>
		<?php if ($title): ?>
			<div class="page-title">
				<div class="pe-container">
					<?php print render($title_prefix); ?>
						<h1><?php print $title; ?></h1>
					<?php print render($title_suffix); ?>
				</div>
			</div>
		<?php endif; ?>
	
		<div class="row-fluid pe-block">
			<div class="span12 gmapWrap">
				<div id="gmaps" class="gmap" data-latitude="<?php print theme_get_setting('latitude'); ?>" data-longitude="<?php print theme_get_setting('longitude'); ?>" data-zoom="12" >
				</div>
			</div>
		</div><!--end gmaps -->	
				
		<div class="pe-container">
			<?php if ((!empty($tabs['#primary'])) || $messages): ?>
			<div class="row-fluid admin-help">
				<?php if ($tabs): ?>
					<div class="tabs primary">
						<?php print render($tabs); ?>
					</div>
				<?php endif; ?>
				
				<?php print $messages; ?>
			</div>
			<?php endif; ?>
			
			<div class="row-fluid pe-block">
				<?php if ($page['sidebar_left']): ?>
					<?php print render($page['sidebar_left']); ?>
				<?php endif; ?>
	
		        <?php print render($page['content']); ?>
		
				<?php if ($page['sidebar_right']): ?>
					<?php print render($page['sidebar_right']); ?>
				<?php endif; ?>
				
			</div> <!-- /.row-fluid /.pe-block -->
		</div><!-- /.pe-container -->
	</div> <!-- /.site-body -->

				
  <?php require( dirname(dirname(__FILE__)).'/misc/footer.php' ); ?>
  