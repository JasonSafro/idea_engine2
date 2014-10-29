<div class="site-wrapper">
    <div class="sticky-bar">
    
    <?php if($page['header_left'] || $page['header_right']): ?>
    <div class="info-bar">
    	<div class="pe-container">
    		<div class="row-fluid">
    			<?php if($page['header_left']): ?>
					<?php print render($page['header_left']); ?>
				<?php endif; ?>
				<?php if($page['header_right']): ?>
					<?php print render($page['header_right']); ?>
				<?php endif; ?>
    		</div><!-- /.row-fluid -->
    	</div><!-- /.pe-container -->
    </div><!-- /.info-bar -->
    <?php endif; ?>
    
 		<div class="menu-bar">
 			<div class="pe-container">
 				<header class="row-fluid">
				
          <div class="span12">
          <?php if ($logo): ?>
            <div class="span4 logo">
              <a href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>" rel="home" id="logo">
                <img src="<?php print $logo; ?>" alt="<?php print t('Home'); ?>" />
              </a>

              <?php if ($site_name || $site_slogan): ?>
                <div id="name-and-slogan">
                  <?php if ($site_name): ?>
                    <?php if ($title): ?>
                      <div id="site-name"><strong>
                        <a href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>" rel="home"><span><?php print $site_name; ?></span></a>
                      </strong></div>
                          <?php else: /* Use h1 when the content title is empty */ ?>
                      <h1 id="site-name">
                        <a href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>" rel="home"><span><?php print $site_name; ?></span></a>
                      </h1>
                    <?php endif; ?>
                  <?php endif; ?>
          
                  <?php if ($site_slogan): ?>
                    <div id="site-slogan"><?php print $site_slogan; ?></div>
                  <?php endif; ?>
                </div> <!-- /#name-and-slogan -->
              <?php endif; ?>
              
            </div><!-- /.span4 /.logo -->
          <?php endif; ?>
		    
          <div class="menu-wrap span8">
            <?php if( user_is_logged_in() ) : ?>
            <ul class="header-actions">
              <li><a class="btn btn-primary" href="/node/add/idea">Share your idea</a></li>
              <li><a class="btn btn-primary" href="/search/ideas">Vote</a></li>
              <li><a class="btn btn-primary" href="/search/groups">Join a Group</a></li>
              <li><a class="btn btn-primary" href="/search/challenges">Answer the Challenge</a></li>
            </ul>
            <?php endif; ?>
          </div>
        </div>

        
				<?php if ($main_menu || $secondary_menu): ?>
				<div class="menu-wrap span12">
					<nav id="navigation" class="mainNav clearfix">
						<?php $menu_name = variable_get('menu_main_links_source', 'main-menu'); $tree = menu_tree($menu_name); print drupal_render($tree); ?>
						<?php print theme('links__system_secondary_menu', array('links' => $secondary_menu, 'attributes' => array('id' => 'secondary-menu', 'class' => array('links', 'inline', 'clearfix')))); ?>
					</nav> <!-- /#navigation -->
					<div id="drop-nav" class="mobile-nav" data-label="Menu..."></div>	
				</div><!-- /.menu-wrap /.span8 -->
				<?php endif; ?>
				</header><!-- /.row-fluid -->
			</div><!-- /.pe-container -->
		</div><!-- /.menu-bar -->
		
	</div> <!-- /.sticky-bar -->