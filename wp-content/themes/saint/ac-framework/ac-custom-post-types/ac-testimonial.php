<?php
/*******************************/
/**** Alleycat Testimonial  ****/ 
/*******************************/

add_action( 'init', 'ac_create_testimonial_post_type' );

function ac_create_testimonial_post_type() {

	// Check if the slug has already been defined
	if (! defined('AC_TESTIMONIAL_SLUG')) {
		define('AC_TESTIMONIAL_SLUG', 'testimonials');
	}

	// Register the taxonomy
	$args = array(
    "label" 							=> _x('Testimonial Categories', 'category label', "alleycat"), 
    "singular_label" 			=> _x('Testimonial Category', 'category singular label', "alleycat"), 
    'public'            	=> true,
	  'hierarchical'      	=> true,
	  'show_ui'           	=> true,
	  'show_in_nav_menus' 	=> false,
	  'args'              	=> array( 'orderby' => 'term_order' ),
		'query_var'         	=> true,
		'rewrite'           	=> false,
	);

	register_taxonomy( 'testimonial-category', 'ac_testimonial', $args );



	// Register the type
	register_post_type( 
		'ac_testimonial',
		array(
			'labels' => array(
	      'name' => _x('Testimonials', 'post type general name', "alleycat"),
	      'singular_name' => _x('Testimonial', 'post type singular name', "alleycat"),
	      'add_new' => _x('Add New', 'Testimonial', "alleycat"),
	      'add_new_item' => __('Add New Testimonial', "alleycat"),
	      'edit_item' => __('Edit Testimonial', "alleycat"),
	      'new_item' => __('New Testimonial', "alleycat"),
	      'view_item' => __('View Testimonial', "alleycat"),
	      'search_items' => __('Search Testimonial', "alleycat"),
	      'not_found' =>  __('No Testimonials have been added yet', "alleycat"),
	      'not_found_in_trash' => __('Nothing found in Trash', "alleycat"),
	      'parent_item_colon' => ''
			),
			'public' => true,
			'menu_icon'=>'dashicons-editor-quote',
			'has_archive' => true,
			'rewrite' => array('slug' => AC_TESTIMONIAL_SLUG),
	    'show_ui' => true,
	    'show_in_menu' => true,
	    'show_in_nav_menus' => false,
	    'supports' => array('title', 'editor', 'thumbnail', 'revisions'),
	    'has_archive' => true,
	    'taxonomies' => array('testimonial-category')
		)
	);
	
	// Columns
	add_filter("manage_edit-ac_testimonial_columns", "ac_testimonial_edit_columns");
	  
	function ac_testimonial_edit_columns($columns){  
	  $columns = array(  
	      "cb" => "<input type=\"checkbox\" />",  
	      "thumbnail" => "",
	      "title" => __("Testimonial", "alleycat"),
	      "description" => __("Description", "alleycat"),
	      "testimonial-category" => __("Categories", "alleycat")
	  );  
	
	  return $columns;  
	}	
	
}