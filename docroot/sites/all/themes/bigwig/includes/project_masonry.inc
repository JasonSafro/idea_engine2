<?php 

/* Template: BigWig Masonry Portfolio
 * Rendered in node--portfolio.tpl.php
 */


?>


<div class="row-fluid">

	<div class="peIsotope">
		<div class="peIsotopeContainer peIsotopeGrid" data-cell-width="256" data-cell-height="auto">
			<div class="row-fluid pe-gallery-thumbnails">
				<div class="span12">
	
					<?php if (!empty($node->field_flare_image)): $i = 0; ?>
						<?php foreach ($node->field_flare_image['und'] as $image): ?>
						
						<div class="peIsotopeItem">
						    <?php $img = file_load($node->field_flare_image['und'][$i]['img'])->uri; ?>
						    <?php $name = pathinfo($img, PATHINFO_FILENAME).'.'.pathinfo($img, PATHINFO_EXTENSION); ?>
							<?php $path = variable_get('file_public_path', conf_path() . '/files') . '/bigwig/masonry_thumbnails/'. $name; ?>
							<?php $lazyLoad = variable_get('file_public_path', conf_path() . '/files') . '/bigwig/blank/blank_'; ?>
							
							<span class="cell-title"></span>
						
							<div class="scalable">
							<a <?php if(($node->field_flare_image['und'][$i]['toggle_caption'] == 1) && !empty($node->field_flare_image['und'][$i]['caption'])): ?>
									data-description="<?php print $node->field_flare_image['und'][$i]['caption']; ?>"
									data-title="<?php print $node->field_flare_image['und'][$i]['title']; ?>"
								<?php endif; ?>
								class="peOver"
								data-target="flare"
								data-flare-gallery="gallery"
								data-flare-thumb="<?php print image_style_url('bigwig_320x240', $img); ?>"
								data-flare-plugin="default"
								data-flare-scale="fit"
								href="<?php print file_create_url($img); ?>">
								
								<?php if($node->field_flare_image['und'][$i]['toggle_masonry'] == 1): ?>
			  						<img src="<?php print $GLOBALS['base_url'] . '/'. $path; $i++ ?>"/>
			  					<?php else: ?>
			  						<img src="<?php print image_style_url('bigwig_320x240', $img); $i++ ?>" />
			  					<?php endif; ?>
			  					
			  					</a>
		  					</div>
		  					
		  				</div>
		  				
						<?php endforeach; ?>	
					<?php endif; ?>	
			
				</div><!-- /.span12 -->
			</div><!-- /.row-fluid /.pe-gallery-thumbnails -->
		</div><!-- /.peIsotopeContainer /.peIsotopeGrid -->
	</div><!-- /.peIsotope -->
</div><!-- /.row-fluid -->
	