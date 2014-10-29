<?php
/**
 * @file views-isotope.tpl.php
 * Default simple view template to display a list of rows.
 *
 * @ingroup views_templates
 */

$display = $view->current_display;
$featured = ($display == 'portfolio_featured' || $display == 'boxed_grid') ? ' span12' : NULL;
$columns = ($display == 'portfolio_columns' || $display == 'projects_columns') ? ' project-item span3' : NULL;

switch($display) {
	case 'gallery_full': $width = 256; $height = 'auto'; break;
	default: $width = 320; $height = 240; break;
}

?>
	<?php if($display == 'boxed_grid' || $display == 'wide_grid'): ?>
	<div class="peIsotope row-fluid">
	<?php endif; ?>
	
	<?php if(($display != 'portfolio_columns') && ($display != 'projects_columns')): ?>
	  <div class="peIsotopeContainer peIsotopeGrid<?php print $featured; ?>" data-cell-width="<?php print $width; ?>" data-cell-height="<?php print $height; ?>" data-sort="none">
	  	<div class="row-fluid pe-gallery-thumbnails">
	  		<div class="span12">
	<?php else: ?>
	   <div class="peIsotopeContainer">
	  	<div class="row-fluid">
	<?php endif; ?>

    <?php $count = 0; ?>
    <?php foreach ( $rows as $id => $row ): ?>
      <?php
      // added for easy multi-color display 
      if ($count == 5) {
        $count = 0;
      }
      $classlist = '';
      $bgstyle = '';
      // pull out isotope-filter class if it exists
      if (strstr($row, '<div class="isotope-filter">')) {

        // Do a regex match
        $pattern = '/(<div class=\"isotope-filter\">)(.+)(<\/div>)/';
        $matches = array();
        $return = preg_match_all( $pattern, $row, $matches );

        if( is_array($matches[2]) ) :
          foreach( $matches[2] as $one_match ) :

            $classes = explode(', ', $one_match);
            foreach ($classes as $class) :
              $class = trim(strip_tags(strtolower($class)));
              $class = str_replace(' ', '-', $class);
              $class = str_replace('/', '-', $class);
              $class = str_replace('&amp;', '', $class);
              $classlist .= ' filter-' . $class; 
            endforeach;
            
          endforeach;
        endif;
      
        $rowparts = explode('<div class="isotope-filter">', $row);
        // $filterclass = explode('</div>', $rowparts[1]);
        // // check for commas and treat as an array for list of taxonomy terms
        // if (strstr($filterclass[0], ',')) {
          // $classes = explode(', ', $filterclass[0]);
          // foreach ($classes as $class) {
            // $class = trim(strip_tags(strtolower($class)));
            // $class = str_replace(' ', '-', $class);
            // $class = str_replace('/', '-', $class);
            // $class = str_replace('&amp;', '', $class);
            // $classlist .= ' filter-' . $class; 
    
          // }
        // } else {
          // //strip divs and normalize naming for just once
          // $classlist = trim(strip_tags(strtolower($filterclass[0])));
          // $classlist = str_replace(' ', '-', $classlist);
          // $classlist = str_replace('/', '-', $classlist);
          // $classlist = 'filter-'.str_replace('&amp;', '', $classlist);     
        // }

        $row = $rowparts[0] . '</div>';
      }
      
      ?>
      <div class="peIsotopeItem <?php print $classlist; print $columns; ?>" <?php print $bgstyle ?>>
        <?php print $row; ?>
        
       <?php if(($display == 'gallery_full') || ($display == 'boxed_grid') || ($display == 'wide_grid') ): ?>
       	</div>
       <?php endif; ?>
      <?php 
      // reset
      $rowparts = NULL;
      $filterclass = NULL;
      $count++;
      ?>
    <?php endforeach; ?>
    <?php if(($display != 'portfolio_columns') || ($display != 'projects_columns')): ?>
  		</div><!-- /.span12 /.pe-gallery-thumbnails -->
  	<?php endif;?>
  </div><!-- /.row-fluid  -->
</div><!-- #isotope-container -->

	<?php if($display == 'boxed_grid' || $display == 'wide_grid'): ?>
	</div>
	<?php endif; ?>