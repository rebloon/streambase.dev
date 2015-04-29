<?php
/************************/
/**** Alleycat Posts ****/ 
/************************/

// Returns the URL for the current page, post
function ac_get_current_url() {
	// Get the post ID
  // This will be a valid ID for a page, but 0 for the Front Page	
  $page_id = ac_get_post_id();

	if ($page_id) {
		return get_permalink($page_id);
	}
	else {
		// Assumed front page
		return home_url();
	}
	
}

// Returns whether this page is the blog page as set in the WP Reading settings
function ac_is_blog_page() {
	
	//	1.  Check a value has been set in the WP settings
	$show_on_front = get_option('show_on_front');
	$page_for_posts = get_option('page_for_posts');
	
	// Check we have values set
	if ( ($show_on_front == 'page') && ($page_for_posts) ) {
		
		// Check if this is the posts page
		return is_home();
	}
	
	return false;
}



// Returns the actual post ID outside of the loop
function ac_get_post_id() {
	$page_id     = get_queried_object_id();
	
	return $page_id;
}

// Returns the real post type, even of posts outside of the loop
function ac_get_post_type() {

	$post_id = ac_get_post_id();

	// Post ID will be zero if some circumstances, so return unknown if no id
	if ($post_id == 0) {
		return 'unknown';
	}
	else {
		return get_post_type($post_id);
	}
	
}


// Returns the terms for a post
// Excludes Uncategorized
function ac_get_the_term_list( $id, $taxonomy, $before = '', $sep = '', $after = '' ) {

	$term_links = array();
	$terms = get_the_terms( $id, $taxonomy );

	if ( is_wp_error( $terms ) )
		return $terms;

	if ( empty( $terms ) )
		return false;

	foreach ( $terms as $term ) {
		$link = get_term_link( $term, $taxonomy );
		if ( is_wp_error( $link ) )
			return $link;
			
		// AC - do not include Uncategorized term
		if ($term->term_id != 1)	{
			$term_links[] = '<a href="' . esc_url( $link ) . '" rel="tag">' . $term->name . '</a>';			
		}

	}

	$term_links = apply_filters( "term_links-$taxonomy", $term_links );
	
	$term_links_str = '';
	if ($term_links) {
		$term_links_str = join( $sep, $term_links );
	}

	return $before . $term_links_str . $after;
}



// Returns all of the term id's for a given taxonomy for an array of posts
function ac_get_terms_for_posts( $posts, $category_name ) {

	$allids = array();
	
	// Loop the posts
	foreach( $posts as $post ) {
	
		// Get the term ids for this post
		$ids = wp_get_post_terms($post->ID, $category_name, array("fields" => "ids"));
		
		// Add the term ids to the master list, avoiding duplicates
		if (! empty($ids)) {
			$allids = array_unique(array_merge($allids, $ids), SORT_REGULAR);			
		}
		
	}
	
	return $allids;

}

// Check the post data before saving
function ac_validate_post_data_page_template($post_id) {
	
	// Page
	if ( get_post_type($post_id) == 'page' ) {

		// WordPress will prevent post data saving if a page template has been selected that does not exist
		// This is especially a problem when switching to our theme, and old page templates are in the post data		
		// Unset the page template if the page doesn't exist to allow the post to save

		// Get the WP template name
		$template_file_name = get_post_meta($post_id,'_wp_page_template',TRUE);
		
		// Check the template exists
		if (! ac_page_template_exists($template_file_name) ) {

			// Template doesn't exist so remove the data to allow WP to save
			$post = get_post($post_id);
			delete_post_meta($post_id, '_wp_page_template');
		}	
		
	}
}

// Checks if a page template exists
function ac_page_template_exists($template_file_name) {
	
	// Get the templates
	$page_templates = wp_get_theme()->get_page_templates();

	// Just return if there is an index for our template
	return isset( $page_templates[ $template_file_name ] );
}


// Validate post data when the edit for is displayed
add_action('edit_form_top', 'ac_edit_form_top_hook');
function ac_edit_form_top_hook($post) {
	ac_validate_post_data_page_template($post->ID);
}



/* IMAGES
---------------------------------------------------------------- */

// Get the alt text for an image
function ac_get_image_alt( $image_id ) {

	// Based on WP wp_get_attachment_image()
	
	$attachment = get_post($image_id);	

	$alt = trim(strip_tags( get_post_meta($image_id, '_wp_attachment_image_alt', true) ));

	if ( empty($alt) ) {
		$alt = trim(strip_tags( $attachment->post_excerpt )); // If not, Use the Caption
	}
	if ( empty($alt) ) {
		$alt = trim(strip_tags( $attachment->post_title )); // Finally, use the title		
	}

	return $alt;
}