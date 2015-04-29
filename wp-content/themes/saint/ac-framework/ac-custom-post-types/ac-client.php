<?php
/*******************************/
/**** Alleycat Client Type  ****/ 
/*******************************/

add_action( 'init', 'ac_create_client_post_type' );

function ac_create_client_post_type() {

	// Check if the slug has already been defined
	if (! defined('AC_CLIENT_SLUG')) {
		define('AC_CLIENT_SLUG', 'client');
	}

	// Register the taxonomy
	$args = array(
    "label" 							=> _x('Client Categories', 'category label', "alleycat"), 
    "singular_label" 			=> _x('Client Category', 'category singular label', "alleycat"), 
    'public'            	=> true,
	  'hierarchical'      	=> true,
	  'show_ui'           	=> true,
	  'show_in_nav_menus' 	=> false,
	  'args'              	=> array( 'orderby' => 'term_order' ),
		'query_var'         	=> true,
		'rewrite'           	=> false,
	);

	register_taxonomy( 'client-category', 'ac_client', $args );



	// Register the type
	register_post_type( 
		'ac_client',
		array(
			'labels' => array(
	      'name' => _x('Clients', 'post type general name', "alleycat"),
	      'singular_name' => _x('Client', 'post type singular name', "alleycat"),
	      'add_new' => _x('Add New', 'portfolio item', "alleycat"),
	      'add_new_item' => __('Add New Client', "alleycat"),
	      'edit_item' => __('Edit Client', "alleycat"),
	      'new_item' => __('New Client', "alleycat"),
	      'view_item' => __('View Client', "alleycat"),
	      'search_items' => __('Search Clients', "alleycat"),
	      'not_found' =>  __('No clients have been added yet', "alleycat"),
	      'not_found_in_trash' => __('Nothing found in Trash', "alleycat"),
	      'parent_item_colon' => ''
			),
			'public' => true,
			'menu_icon'=>'dashicons-admin-users',
			'has_archive' => true,
			'rewrite' => array('slug' => AC_CLIENT_SLUG),
	    'show_ui' => true,
	    'show_in_menu' => true,
	    'show_in_nav_menus' => true,
	    'supports' => array('title', 'thumbnail', 'revisions'),
	    'has_archive' => true,
	    'taxonomies' => array('client-category')
		)
	);
	
	// Columns
	add_filter("manage_edit-ac_client_columns", "ac_client_edit_columns");
	function ac_client_edit_columns($columns){  
	  $columns = array(  
	      "cb" => "<input type=\"checkbox\" />",  
	      "thumbnail" => "",
	      "title" => __("Client", "alleycat"),
	      "description" => __("Description", "alleycat"),
	      "client-category" => __("Categories", "alleycat")
	  );  
	
	  return $columns;  
	}	
	
}