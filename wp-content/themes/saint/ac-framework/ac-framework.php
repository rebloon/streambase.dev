<?php
/****************************/
/**** Alleycat Framework ****/ 
/****************************/


// ISOTOPE

// Loads the Isoptope scripts if not already loaded
function ac_load_isotope() {

	if ( ac_visual_composer_is_installed() ) {
	
		// Isotope CSS might already be loaded, so check first
		if ( ! wp_style_is('isotope-css', 'to_do') ) {	
			$isotope_url = plugins_url( 'js_composer/assets/css/isotope.css');			
			wp_register_style( 'isotope-css', $isotope_url, false, WPB_VC_VERSION, 'screen' );	 
		  wp_enqueue_style('isotope-css');			
		}
		
		// Isotope JS might already be loaded, so check first
		if ( ! wp_style_is('isotope-js', 'to_do') ) {	
			$isotope_url = plugins_url( 'js_composer/assets/lib/isotope/jquery.isotope.min.js' );					
	    wp_register_script( 'isotope', $isotope_url, array( 'jquery' ), WPB_VC_VERSION, true);
	    wp_enqueue_script('isotope');			
		}
		
		// Load packery
    wp_enqueue_script('packery', AC_ASSETS_URI.'/js/vendor/packery-mode.pkgd.min.js', array('isotope'));  
    
	}
	
}

// Render a block quote/testimonial
// $except = should already be truncated.
function ac_quote_render($image_id, $excerpt, $author = '', $author_url = '', $img_border_shape = 'circle-border', $image_caption = '', $img_align = 'right', $bg_color = false) {

	// Pass some values to the template
	$template_params = compact('image_id', 'excerpt', 'author', 'author_url', 'img_border_shape', 'image_caption', 'img_align', 'bg_color');

	// We need to return the content so buffer			
	ob_start();
	ac_load_component_content('ac_block_quote', $template_params);
	$content = ob_get_contents();
	ob_end_clean();
	
	return $content;

}


// Render a testimonial
function ac_testimonial_render($testimonial_id, $show_image = true, $excerpt_length = -1) {

	// Get the post
	$post = get_post($testimonial_id);

	// Show the image?  Tiles don't show the image inline	
	if ($show_image) {
		// Get the thumbnail id
		$thumb_id = get_post_thumbnail_id($testimonial_id);
	}
	else {
		$thumb_id = false;
	}
	
	// Get the excerpt
	$excerpt = ac_get_excerpt( $post , $excerpt_length, false, false );
	
	// Author
	$author = ac_get_meta('author', null, $testimonial_id); 
	$author_url = ac_get_meta('author_url', null, $testimonial_id); 
	
	return ac_quote_render($thumb_id, $excerpt, $author, $author_url);
}

// Custom Post Type Columns
function ac_posts_custom_columns($column){  
	global $post;  
	
	switch ($column)  
	{  
	    case "description":  
	        the_excerpt();  
	        break;
	    case "thumbnail":  
	        the_post_thumbnail('thumbnail');  
	        break;
	    case "portfolio-category":
	        echo get_the_term_list($post->ID, 'portfolio-category', '', ', ','');
	        break;
	    case "testimonial-category":
	        echo get_the_term_list($post->ID, 'testimonial-category', '', ', ','');
	        break;
	    case "people-category":
	        echo get_the_term_list($post->ID, 'people-category', '', ', ','');
	        break;
	    case "category":
	        echo get_the_term_list($post->ID, 'category', '', ', ','');
	        break;	        
	}  
}  
add_action("manage_posts_custom_column",  "ac_posts_custom_columns"); // Posts
add_action("manage_pages_custom_column",  "ac_posts_custom_columns"); // Pages


// Add more columns for Post and Page
add_filter("manage_edit-post_columns", "post_edit_columns");
function post_edit_columns($columns){  
  $columns = array(  
      "cb" => "<input type=\"checkbox\" />",  
      "thumbnail" => "",
      "title" => __("Title", "alleycat"),
      "author" => __("Author", "alleycat"),
      "category" => __("Categories", "alleycat"),
      "tags" => __("Tags", "alleycat"),            
      "comments" => '<span title="Comments" class="comment-grey-bubble"></span>',
      "date" => __("Date", "alleycat"),
  );  

  return $columns;  
}	

add_filter("manage_edit-page_columns", "page_edit_columns");
function page_edit_columns($columns){  
  $columns = array(  
      "cb" => "<input type=\"checkbox\" />",  
      "thumbnail" => "",
      "title" => __("Title", "alleycat"),
      "author" => __("Author", "alleycat"),
      "comments" => '<span title="Comments" class="comment-grey-bubble"></span>',
      "date" => __("Date", "alleycat"),      
  );  

  return $columns;  
}

// Does the theme support One Page features?
function ac_one_page_theme() {
	return defined('AC_ONE_PAGER') && AC_ONE_PAGER;
}

// Get a list of menus
function ac_get_menu_list() {
	$menu_list = array( '' => '' );

	$user_menus = get_terms( 'nav_menu', array( 'hide_empty' => false ) ); 
	
	foreach( $user_menus as $menu ) {
		$menu_list[$menu->term_id] = $menu->name;
	}
	
	return $menu_list;
}