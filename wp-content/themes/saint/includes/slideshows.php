<?php
/**********************/
/****  Slideshows  ****/ 
/**********************/

// Prepares posts and args to render the slider
function ac_render_posts_slideshow($args, $posts = null) {
	
	// Define the defaults
	$defaults = array(
		'posts_per_page' => 5,
		'meta_key' => '_thumbnail_id', // only include posts with thumbnail
		'cat' => '',
		'ac_order' => 'order_date_desc',
		'show_title' => true,
		'show_excerpt' => true,
		'excerpt_length' => '',
	);
		
	// Merge in the options
	$args = wp_parse_args( $args, $defaults );	
	
	// Params to variables
	extract($args);
	
	// Generate our posts if not passed in
	if ($posts == null) {
	
		ac_prepare_args_for_get_posts($args);	
			
		// Get our posts
		$posts = get_posts($args);
		
	}
		
	// Clean up the bool values.  Might be "true"
	$show_title = filter_var($show_title, FILTER_VALIDATE_BOOLEAN);
	$show_excerpt = filter_var($show_excerpt, FILTER_VALIDATE_BOOLEAN);

	// Capture and render the output			
	ob_start();
	ac_render_royalslider_from_posts($posts, $args);
	$output = ob_get_contents();
	ob_end_clean();	

	return $output;	
}