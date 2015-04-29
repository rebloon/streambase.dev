<?php
/**********************/
/****  Slideshows  ****/ 
/**********************/

// Renders a slideshow for a post
// Returns whether a slideshow was rendered
function ac_render_post_slideshow( $full_width ) {

	// Check the slideshow type
	$slideshow_type = ac_get_meta('slideshow_type');
	
	if ($slideshow_type == '') {
		// No slideshow
		return false;
	}
	elseif ($slideshow_type == 'ac') {
	
		// Render the AC slideshow
		return ac_render_ac_easy_slideshow($full_width);
		
	}
	elseif ($slideshow_type == 'revslider') {	
	
		if ( ac_revslider_is_installed () ) {

			// Get the RevSlider id
			$revolution_slideshow = ac_get_meta('revolution_slideshow');
			if( $revolution_slideshow ) {
				putRevSlider($revolution_slideshow);		
				return true;
			}
			
		}
	

	}
	
}

// Renders an AC Slider
// Returns whether a slideshow was rendered
// $full_width = should the size be full width or within the grid?
function ac_render_ac_easy_slideshow( $full_width = false ) {

	// We need to build an array of posts to pass through to the RoyalSlider function
	$posts = array();
	
	// Should we include the featured image?
	if ( has_post_thumbnail() && ( ac_get_meta('include_featured_image') == 1 ) ) {
			$posts[] = get_post(get_post_thumbnail_id());
	}

	// Get the images to use
	$images = ac_get_meta('images', array('type' => 'image_advanced'));
	
	// Add them to the slides
	foreach($images as $image) {
		// Add to our slides
		$posts[] = get_post($image['ID']);
	}
	
	$args = array(
		'slider_style' => 'no-caption',
		'slider_size' => 'square', // use ratio for force bigger height, which is control in the theme options
		'class' => 'ac_easy_slider',
	);
	
	if ($full_width) {
		$args['full_width'] = true;
	}

	// Render the slideshow
	if ( count($posts) ) {
		echo ac_render_posts_slideshow($args, $posts);
		return true;
	}
	
	return false;
}

// Renders a revolution slider.  Used for pages, portfolios, etc.
/*
$slides = array (
	'img' => 'img.jpg' 
)
*/
function ac_render_rev_slider($slides) {

	// Get the slideshow settings from the Options
	$autoplay = shoestrap_getVariable('aeis_autoplay');
	$transition = shoestrap_getVariable('aeis_transition'); 
	$delay = shoestrap_getVariable('aeis_slideshow_delay'); 
	if ($delay) {
		$delay = $delay * 1000; // miliseconds
	}
	else {
		$delay = 5000;
	}
	$show_time_line = shoestrap_getVariable('aeis_show_timer_line'); 

?>

<div class="rev_slider_wrapper fullwidthbanner-container ac-full-width-row">
	<div class="rev_slider fullwidthabanner rev-slider-page-top">
  	<ul>
<?php
	// Print out the slides
	foreach($slides as $slide) { 		?> 
		<li data-transition="<?php echo $transition; ?>" data-slotamount="7" >
			<img src="<?php echo $slide['img']; ?>" /> 
		</li>
<?php
	}
?>

    </ul>

<?php if ( $show_time_line ) : ?>
		<div class="tp-bannertimer"></div>
<?php endif; ?>
	</div>
</div>

<script>
    jQuery(document).ready(function() {
       jQuery('.rev-slider-page-top').show().revolution(
          {
              delay:<?php echo $delay; ?>,
              startheight:500,
              startwidth:1600,
    
              hideThumbs:300,
    
              thumbWidth:100,	
              thumbHeight:50,
              thumbAmount:5,
    
              navigationType:"both",					
              navigationArrows:"verticalcentered",		
              navigationStyle:"round",				
    
              touchenabled:"on",
              onHoverStop:"on",
    
              navOffsetHorizontal:0,
              navOffsetVertical:20,

<?php	if ( $autoplay ) : ?>
              stopAtSlide:-1,
              stopAfterLoops:-1,
<?php else : ?>
							stopLoop:"on",
							stopAfterLoops:0,
							stopAtSlide:1,
<?php endif; ?>              
    
              shadow:0,
              fullWidth:"off"					
          });
    });
</script>

<?php

}