// Idea Ticker in footer
var idea_ticker_iterator = 1;
var idea_ticker_interator_max = 1;

jQuery(document).ready(function() {
  // Set max for idea ticker rows
  idea_ticker_iterator_max = jQuery('div.view-ideas-for-ticker div.view-content div.views-row').length;
  
  // Idea Ticker in footer
  window.setInterval(idea_engine_control_idea_ticker, 6000);
  
  // Add style to the links in comments
  jQuery('div#comments div.comment ul.inline li a').addClass('btn');
  jQuery('div#comments div.comment ul.inline li a').addClass('btn-success');
  
  // Change form submit buttons from "apply" to "search"
  jQuery('div.views-exposed-form .views-submit-button input.form-submit').attr('value','Search');
  jQuery('div.views-exposed-form .views-submit-button input.form-submit').addClass('btn');
  jQuery('div.views-exposed-form .views-submit-button input.form-submit').addClass('btn-success');
  
  // Add interactivity to the challenge items
  jQuery('.view-search-challenges .one-challenge-container').bind({
    mouseenter: function() {
      jQuery(this).children('.one-challenge-overlay').css('display','block');
    },
    mouseleave: function() {
      jQuery(this).children('.one-challenge-overlay').css('display','none');
    }
  });

  // Add mouseover effect for search ideas page
  jQuery('body.page-search-ideas .view-header .hero-unit .left-right-container .vote-cell').bind( 'mouseenter mouseleave', function() {
    jQuery(this).toggleClass('entered');
    jQuery('.view-search-ideas .view-content .views-field-field-rating').toggleClass('entered');
  });
  
  jQuery('body.page-search-ideas .view-header .hero-unit .left-right-container .search-cell').bind( 'mouseenter mouseleave', function() {
    jQuery(this).toggleClass('entered');
    jQuery('.view-search-ideas .view-filters').toggleClass('entered');
  });
});

/**
 * Function for scripting the idea ticker
 */
function idea_engine_control_idea_ticker() {
  // Hide the current row
  jQuery('div.view-ideas-for-ticker div.views-row-' + idea_ticker_iterator).fadeOut( 1000, function() {
    // Increment and validate
    if( idea_ticker_iterator < idea_ticker_iterator_max ) {
      idea_ticker_iterator++;
    } else {
      idea_ticker_iterator = 1;
    }

    // Show the current idea
    jQuery('div.view-ideas-for-ticker div.views-row-' + idea_ticker_iterator).fadeIn(500);
  });
}