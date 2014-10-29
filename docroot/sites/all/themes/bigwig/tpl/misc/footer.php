	<?php if($page['footer_first'] || $page['footer_second'] || $page['footer_third'] || $page['footer_fourth']): ?>
		<div class="pe-spacer size50"></div>
		<div class="footer">
			<footer class="pe-container">
	 			<div class="row-fluid">
				<?php if ($page['footer_first']): ?>
					<?php print render($page['footer_first']); ?>
				<?php endif; ?>
				
				<?php if ($page['footer_second']): ?>
					<?php print render($page['footer_second']); ?>
				<?php endif; ?>
				
				<?php if ($page['footer_third']): ?>
					<?php print render($page['footer_third']); ?>
				<?php endif; ?>
				
				<?php if ($page['footer_fourth']): ?>
					<?php print render($page['footer_fourth']); ?>
				<?php endif; ?>
				</div><!-- /.row-fliud -->
			</footer><!-- /.pe-container -->
		</div><!-- /.footer -->
	<?php endif; ?>
	
	<?php if($page['footer_fifth'] || $page['footer_sixth'] || $page['footer_seventh']): ?>
		<div class="footer small">
		<!--lower footer-->
		<section class="foot-lower">
			<div class="pe-container">
				<div class="row-fluid ">
	
  <?php if($page['footer_fifth'] || $page['footer_sixth']): ?>
					<div class="span12">
					
						<?php if ($page['footer_fifth']): ?>
							<?php print render($page['footer_fifth']); ?>
						<?php endif; ?>
						
						<?php if ($page['footer_sixth']): ?>
							<?php print render($page['footer_sixth']); ?>
						<?php endif; ?>

					</div>
  <?php endif; ?>
          
	<?php if($page['footer_seventh']): ?>
					<div class="span12">
					
						<?php if ($page['footer_seventh']): ?>
							<?php print render($page['footer_seventh']); ?>
						<?php endif; ?>

          </div>
  <?php endif; ?>
  
				</div>
			</div>
		</section>
	<?php endif; ?>
	</div>

</div><!-- /.site-wrapper -->
