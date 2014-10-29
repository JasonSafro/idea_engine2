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
		
		<?php if ($page['prescript']): ?>
			<?php print render($page['prescript']); ?>
		<?php endif; ?>
				
		<div class="pe-container">
			<?php if ((!empty($tabs['#primary'])) || $messages): ?>
			<div class="row-fluid admin-help">
				<?php print $messages; ?>
				<?php if ($tabs): ?>
					<div class="tabs primary">
						<?php print render($tabs); ?>
					</div>
				<?php endif; ?>
			</div>
			<?php endif; ?>
			
			<div class="pe-spacer pe-spacer-content size50"></div>
				
			<div class="row-fluid pe-block">
				<?php if ($page['sidebar_left']): ?>
					<?php print render($page['sidebar_left']); ?>
				<?php endif; ?>
	
		        <?php print render($page['content']); ?>
		
				<?php if ($page['sidebar_right']): ?>
					<?php print render($page['sidebar_right']); ?>
				<?php endif; ?>
				
			</div> <!-- /.row-fluid /.pe-block -->
			
			<?php if ($page['postscript']): ?>
				<?php print render($page['postscript']); ?>
			<?php endif; ?>
		</div><!-- /.pe-container -->
		
	</div> <!-- /.site-body -->

  <?php require( dirname(dirname(__FILE__)).'/misc/footer.php' ); ?>
