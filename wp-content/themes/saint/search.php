<?php
/*********************************/
/**** Search Results Template ****/ 
/*********************************/

if ( have_posts() ) :

	// Loop the results
	while (have_posts()) : the_post();
	
		get_template_part('templates/search-result', '');
	
	endwhile;
	
else :
	// If no content, include the "No posts found" template.
	get_template_part( 'templates/list-no_results', 'search' );
	
endif;		
	
	
// Include pagination
get_template_part('templates/list-pagination', 'search');