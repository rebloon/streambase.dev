<?php
/************************/
/**** Index Template ****/ 
/************************/

// Used for the standard blog "latest posts" view: homepage and blog

// Header
// Do not load the in-page title for the front page, ok for others (archives, blog, etc).
if (! is_front_page()) {
	get_template_part('templates/page', 'header');	
}

if ( have_posts() ) :

	// Loop the entries
	while (have_posts()) : the_post();
	  do_action( 'shoestrap_before_the_content' );
	
	  // AC - Load the content template based on post-type and post-format
		ac_load_post_content();	
	
	endwhile;
	
else :
	// If no content, include the "No posts found" template.
	get_template_part( 'templates/list-no_results', 'index' );
	
endif;

// Include pagination
get_template_part('templates/list-pagination', 'index');