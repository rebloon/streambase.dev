<?php
/**************************/
/**** Archive Template ****/ 
/**************************/

// Used for all archive views
global $wp_query;

// Show the posts based on the format specified
$archive_post_style = shoestrap_getVariable( 'archive_post_style' );

// Check for Grid or Masonry layout
if ( in_array( $archive_post_style, array('grid', 'masonry') ) ) {

	if ( have_posts() ) :
	
		// Col number
		$archive_grid_cols = shoestrap_getVariable( 'archive_grid_cols' );
		
		switch ($archive_post_style) {
		    case 'grid':
		    case 'masonry':
		    
			    	// We need the category for the post type for the grid filter to work
			    	$post_category = '';
				    // Get them all
				    $taxonomy_names = array();
				    if ( isset($wp_query->query['post_type']) ) {
							$taxonomy_names = get_object_taxonomies( $wp_query->query['post_type'] );				    
				    }
	
						if ( count($taxonomy_names) > 0 ) {
							$post_category = $taxonomy_names[0];
						}
						
						// Build the args for the grid
		    		$args = array(
		    			'layout' => $archive_post_style,
		    			'post_category' => $post_category,
		    			'show_cat_filter' => true,
		    			'column_count' => $archive_grid_cols
		    		);
						echo ac_posts_grid( $args, $wp_query->posts );
		        
		        break;
		    default:    
		        break;
				}	
			
	else :
		// If no content, include the "No posts found" template.
		get_template_part( 'templates/list-no_results', 'archive' );
		
	endif;		
			

}
// Standard WP loop
else {

	if ( have_posts() ) :

		while (have_posts()) : the_post();
		  do_action( 'shoestrap_before_the_content' );
	
		  // AC - Load the content template based on post-type and post-format
			ac_load_post_content();
		
		endwhile;
		
	else :
		// If no content, include the "No posts found" template.
		get_template_part( 'templates/list-no_results', 'archive' );
		
	endif;		
	
}

// Include pagination
get_template_part('templates/list-pagination', 'archive');