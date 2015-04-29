<?php

/***********************************************/
/**** Alleycat Drag and Drop Gallery Common ****/
/***********************************************/

// Define
define('AC_GALLERY_URI', AC_FRAMEWORK_URI.'/dd-gallery/');

// Items that are common to the back-end and front-end of the Alleycat Gallery Manager

// Create the gallery custom types
add_action( 'init', 'ac_create_gllery_type' );
function ac_create_gllery_type() {

	// Check if the slug has already been defined
	if (! defined('AC_GALLERY_SLUG')) {
		define('AC_GALLERY_SLUG', 'gallery');
	}

	register_post_type( 'ac_gallery',
		array(
			'labels' => array(
				'name' => __( 'Galleries', 'alleycat' ),
				'singular_name' => __( 'Gallery', 'alleycat' )
			),
		'public' => true,
		'show_ui' => false, // hide from the WP Admin UI
		'show_in_menu' => false,
		'show_in_nav_menus' => true,		
		'menu_icon'=>'dashicons-format-gallery',
		'has_archive' => true,
		'rewrite' => array('slug' => AC_GALLERY_SLUG),
		'supports' => array( 'title', 'thumbnail', 'custom-fields')
		)
	); 
}

// Image sizes
add_image_size( "ac-gallery-edit", "500", "350", true );  	// Gallery Editor
add_image_size( "ac-gallery-cover", "448", "335", true ); 	// Gallery cover image

// Defaults
define("ac_gallery_transition",  'move,horizontal');
define("ac_gallery_portfolio_hover_style",  'no-margin');

// -- Register shortcodes --
// Photo Gallery
if (!function_exists('ac_photo_gallery')) {
	function ac_photo_gallery( $atts, $content = null ) {
		extract(shortcode_atts(array(
			'gallery_id'   => ''
	    ), $atts));
	    
			// If we have a gallery ID return the gallery slideshow
			if ($gallery_id) {
				ob_start();
				ac_gallery_render_bg_gallery($gallery_id);
				$output = ob_get_contents();
				ob_end_clean();
				return $output;				
			}
			else {
				// Return the gallery portfolio
				ob_start();
				ac_gallery_render_galleries();
				$output = ob_get_contents();
				ob_end_clean();
				return $output;								
			}
			
	}
	add_shortcode('ac_photo_gallery', 'ac_photo_gallery');
}


// Returns an array of gallery posts
// Homepage and Trash can be excluded
function ac_gallery_get_gallery_posts( $exclude_homepage = false, $exclude_trash = false ) {

	// Basic args
	$args = array(
		'post_type' 			=> 'ac_gallery',
		'orderby' 			 	=> 'menu_order', 
		'order'          	=> 'ASC',
		'posts_per_page' 	=> '-1',
		'post_status'			=> 'any', // show all statues, as galleries hidden from the gallery are private
	);
	
	// Filter out galleries
	$ids_to_ignore = array();

	if ($exclude_homepage) {
		$ids_to_ignore[] = ac_gallery_get_homepage_gallery_post_id();
	}	
	
	if ($exclude_trash) {
		$ids_to_ignore[] = ac_gallery_get_trash_gallery_post_id();
	}	
	
	$args['post__not_in'] = $ids_to_ignore;	

	$posts = get_posts($args);
	
	return $posts;		
	
}

// Return the gallery posts to ignore, as an array
// These include the homepage and trash
function ac_gallery_get_posts_to_ignore() {
	
	// Get the Homepage gallery id
	$homepage_id = ac_gallery_get_homepage_gallery_post_id();
	
	// Get the Trash gallery id
	$trash_id = ac_gallery_get_trash_gallery_post_id();
	
	$ids_to_ignore = array($homepage_id, $trash_id);
	
	return $ids_to_ignore;
}

// Returns the post id of the homepage gallery
function ac_gallery_get_homepage_gallery_post_id()
{

	// The homepage is an ac_gallery type with the title of 'Homepage'
	$homepage = get_page_by_title( "Homepage", OBJECT, 'ac_gallery' );
	
	// This should always exist as the homepage gallery is created at setup
	if ($homepage) {
		return $homepage->ID;
	}
	else {
		return null;
	}

}

// Returns the post id of the trash gallery
function ac_gallery_get_trash_gallery_post_id()
{

	// The homepage is an ac_gallery type with the title of 'Homepage'
	$trash = get_page_by_title( "Trash", OBJECT, 'ac_gallery' );
	
	// This should always exist as the trash gallery is created at setup
	if ($trash) {
		return $trash->ID;
	}
	else {
		return null;
	}

}