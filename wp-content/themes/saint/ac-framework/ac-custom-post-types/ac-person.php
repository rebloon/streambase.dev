<?php
/*******************************/
/**** Alleycat Person Type  ****/ 
/*******************************/

add_action( 'init', 'ac_create_person_post_type' );

function ac_create_person_post_type() {

	// Check if the slug has already been defined
	if (! defined('AC_PERSON_SLUG')) {
		define('AC_PERSON_SLUG', 'people');
	}

	// Register the taxonomy
	$args = array(
    "label" 							=> _x('People Categories', 'category label', "alleycat"), 
    "singular_label" 			=> _x('People Category', 'category singular label', "alleycat"), 
    'public'            	=> true,
	  'hierarchical'      	=> true,
	  'show_ui'           	=> true,
	  'show_in_nav_menus' 	=> false,
	  'args'              	=> array( 'orderby' => 'term_order' ),
		'query_var'         	=> true,
		'rewrite'           	=> false,
	);

	register_taxonomy( 'people-category', 'ac_person', $args );



	// Register the type
	register_post_type( 
		'ac_person',
		array(
			'labels' => array(
	      'name' => _x('People', 'post type general name', "alleycat"),
	      'singular_name' => _x('Person', 'post type singular name', "alleycat"),
	      'add_new' => _x('Add New', 'portfolio item', "alleycat"),
	      'add_new_item' => __('Add New Person', "alleycat"),
	      'edit_item' => __('Edit Person', "alleycat"),
	      'new_item' => __('New Person', "alleycat"),
	      'view_item' => __('View Person', "alleycat"),
	      'search_items' => __('Search People', "alleycat"),
	      'not_found' =>  __('No people have been added yet', "alleycat"),
	      'not_found_in_trash' => __('Nothing found in Trash', "alleycat"),
	      'parent_item_colon' => ''
			),
			'public' => true,
			'menu_icon'=>'dashicons-admin-users',
			'has_archive' => true,
			'rewrite' => array('slug' => AC_PERSON_SLUG),
	    'show_ui' => true,
	    'show_in_menu' => true,
	    'show_in_nav_menus' => true,
	    'supports' => array('title', 'editor', 'thumbnail', 'revisions'),
	    'has_archive' => true,
	    'taxonomies' => array('person-category')
		)
	);
	
	// Columns
	add_filter("manage_edit-ac_person_columns", "ac_person_edit_columns");
	function ac_person_edit_columns($columns){  
	  $columns = array(  
	      "cb" => "<input type=\"checkbox\" />",  
	      "thumbnail" => "",
	      "title" => __("Person", "alleycat"),
	      "description" => __("Description", "alleycat"),
	      "people-category" => __("Categories", "alleycat")
	  );  
	
	  return $columns;  
	}	
	
}


// Return the social icon for the person
function ac_person_get_social_icon( $post = 0, $type ) {

	$post = get_post( $post );

	$return = ''; 

	// Get the meta
	$meta = ac_get_meta($type);

	if($meta) {
	
		// Ensure it's a proper URL
		$url = ac_ensure_http( $meta );
		
		// Get the icon class
		$icon_class = "el-icon-".$type;
		
		$return = "<a href='".esc_url($url)."' target='_blank'><span class='$icon_class'></span></a>";		
		
	}
	
	return $return;
}

// Returns all of the social icons for the given/current person post
function ac_person_get_all_social_icons( $post = 0, $tag = 'div' ) {

	$output = '';

	$post = get_post( $post );

	$socials = array(
		'facebook',
		'twitter',
		'linkedin',
		'googleplus',
		'instagram',
		'pinterest',
		'flickr',
		'dribbble',
	);
	
	// Output each social type
	foreach($socials as $social) {
		$output .= ac_person_get_social_icon( $post, $social );
	}
	
	// Add a wrapper
	if ($output) {
		$output = '<'.$tag.' class="ac-social-links">'.$output.'</'.$tag.'>';
	}

	return $output;	
		
}

// Returns a person postion
// Wrapes the content if there is a position
function ac_person_get_position( $post = 0 ) {

	$post = get_post( $post );

	// Get the position	
  $position = ac_get_meta('position'); 
  
  // If we have a position wrap it
  if ($position) {
  	$position = '<h3 class="position">'.$position.'</h3>';
  }
	
	return $position;

}