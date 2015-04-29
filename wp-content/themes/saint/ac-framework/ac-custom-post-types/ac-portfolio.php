<?php
/**********************************/
/**** Alleycat Portfolio Type  ****/ 
/**********************************/

add_action( 'init', 'ac_create_portfolio_post_type' );

function ac_create_portfolio_post_type() {

	// Check if the slug has already been defined
	if (! defined('AC_PORTFOLIO_SLUG')) {
		define('AC_PORTFOLIO_SLUG', 'portfolios');
	}

	// Register the taxonomy
	$args = array(
    "label" 							=> _x('Portfolio Categories', 'category label', "alleycat"), 
    "singular_label" 			=> _x('Portfolio Category', 'category singular label', "alleycat"), 
    'public'            	=> true,
	  'hierarchical'      	=> true,
	  'show_ui'           	=> true,
	  'show_in_nav_menus' 	=> false,
	  'args'              	=> array( 'orderby' => 'term_order' ),
		'query_var'         	=> true,
		'rewrite'           	=> array( 'slug' => 'portfolio-category' ),
	);

	register_taxonomy( 'portfolio-category', 'ac_portfolio', $args );



	// Register the type
	register_post_type( 
		'ac_portfolio',
		array(
			'labels' => array(
	      'name' => _x('Portfolio', 'post type general name', "alleycat"),
	      'singular_name' => _x('Portfolio Item', 'post type singular name', "alleycat"),
	      'add_new' => _x('Add New', 'portfolio item', "alleycat"),
	      'add_new_item' => __('Add New Portfolio Item', "alleycat"),
	      'edit_item' => __('Edit Portfolio Item', "alleycat"),
	      'new_item' => __('New Portfolio Item', "alleycat"),
	      'view_item' => __('View Portfolio Item', "alleycat"),
	      'search_items' => __('Search Portfolio', "alleycat"),
	      'not_found' =>  __('No portfolio items have been added yet', "alleycat"),
	      'not_found_in_trash' => __('Nothing found in Trash', "alleycat"),
	      'parent_item_colon' => ''
			),
			'public' => true,
			'menu_icon'=>'dashicons-format-image',
			'has_archive' => true,
			'rewrite' => array('slug' => AC_PORTFOLIO_SLUG),
	    'show_ui' => true,
	    'show_in_menu' => true,
	    'show_in_nav_menus' => true,
	    'hierarchical' => false,
	    'supports' => array('title', 'editor', 'thumbnail', 'revisions', 'excerpt'),
	    'has_archive' => true,
	    'taxonomies' => array('portfolio-category')
		)
	);
	
	// Columns
	add_filter("manage_edit-ac_portfolio_columns", "ac_portfolio_edit_columns");
	function ac_portfolio_edit_columns($columns){  
	  $columns = array(  
	      "cb" => "<input type=\"checkbox\" />",  
	      "thumbnail" => "",
	      "title" => __("Portfolio", "alleycat"),
	      "description" => __("Description", "alleycat"),
	      "portfolio-category" => __("Categories", "alleycat")
	  );  
	
	  return $columns;  
	}	
	
	
}

// Returns the related portfolios
function ac_portfolio_get_related( $post = 0 ) {

	$posts = array();

	// Get the post
	$post = get_post( $post );
	
	// Get the term objects
  $terms = wp_get_object_terms( $post->ID, 'portfolio-category' );	

  // Get the posts for these terms
  $post_ids = array();
  if ( count( $terms ) ) {
		$post_ids = get_objects_in_term( $terms[0]->term_id, 'portfolio-category' );
	}
	
	// Remove this post from the list
	$index = array_search($post->ID,$post_ids);
	if($index !== false){
	  unset($post_ids[$index]);
	}
	
  if ( $post_ids ) {
		$args = array (
			'post_type'  => 'ac_portfolio',
	    'post__in' => $post_ids,
			'posts_per_page'  => 4,
			'orderby'         => 'meta_value',
	    'order'           => 'date',	
		);
	
		$posts = get_posts( $args );
	  
  }	
		
	return $posts;
}	