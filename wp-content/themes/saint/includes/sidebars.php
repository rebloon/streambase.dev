<?php
/*********************************/
/****  Sidebar Functionality  ****/ 
/*********************************/

/*
	Sidebars
	0 = None
	1 = Right only
	2 = Left only
	3 = Both left
	4 = Both right
	5 = Both sides
*/

// Returns if the current post's post_type has sidebars
// if $post_type = null the current post type is used
if ( !function_exists( 'ac_post_type_has_sidebar' ) ) :
function ac_post_type_has_sidebar( $post_type = null ) {

	if ( $post_type == null ) {
		$post_type = get_post_type();
	}

	$post_types_without_sidebars = ac_get_post_types_without_sidebars();

	return !in_array( $post_type , $post_types_without_sidebars );
}
endif;

// Returns if the current post's post_type has sidebars
if ( !function_exists( 'ac_get_post_types_without_sidebars' ) ) :
function ac_get_post_types_without_sidebars() {

	return array(
		'ac_portfolio',
		'shop_coupon', // WooCommerce
		'product_variation'
	);
}
endif;


// Get the name for the primary sidebar
function ac_get_left_sidebar() {
	
	$sidebar = ac_get_sidebar('left');
	if ( isset($sidebar[1])) {
		return $sidebar[1];		
	}

	return '';
}

// Get the name for the secondary sidebar
function ac_get_right_sidebar() {

	$sidebar = ac_get_sidebar('right');
	if ( isset($sidebar[1])) {
		return $sidebar[1];		
	}

	return '';

}

// Get the sidebar name based on whether primary or secondary
// $side = 'left' or 'right'
// Returns an array 1: layout id, 2: sidebar id
function ac_get_sidebar($side) {

	// Get the real post ID, as this is likely outside of the loop
	$post_id = ac_get_post_id();
	
	// Default to the site default
	$shoestrap_layout = shoestrap_getVariable('layout');
	
	$sidebar = shoestrap_getVariable('layout_'.$side.'_sidebar'); 
	
	// Singular.  Always check for singlular first as HP or blog could be a page
	if ( is_singular() || ac_is_blog_page() || is_post_type_archive() ) {
	

	
		// Does this post type support sidebars?
		if ( ac_post_type_has_sidebar( get_post_type( $post_id ) ) ) {

			// Check if the post itself has sidebar layout defined
			$layout_override = ac_get_meta('layout_override', null, $post_id); 
			$layout = ac_get_meta('layout', null, $post_id); 
								
			// Post has a layout so use these values.  -1 is default so fall-through to parent.
			if ( $layout_override && isset($layout) && ($layout != -1) ) {
	
				$shoestrap_layout	= $layout;
				$sidebar = ac_get_meta($side.'_sidebar', null, $post_id);				
											
			}
			// Post doesn't have specific layout so use Post Type values
			else {
			
				// Check if post type layouts are on
				if ( shoestrap_getVariable('cpt_layout_toggle') ) {
		
					$post_type = get_post_type( ac_get_post_id() );
					$post_type_layout = shoestrap_getVariable($post_type.'_layout');
			
					// Post Type has a layout			
					if ( isset($post_type_layout) ) {
						$shoestrap_layout	= $post_type_layout;
						$sidebar = shoestrap_getVariable($post_type.'_layout_'.$side.'_sidebar');				
					}									
					
				}
				
			}
			
		}
		// Post type doesn't have sidebars
		else {

			$shoestrap_layout = -1;  // -1 = What is zero ?
			$sidebar = '';
		}
	
	
	}	
	// Frontpage
	else if (is_front_page()) {

		if ( shoestrap_getVariable('cpt_home_layout_toggle') ) {
			$shoestrap_layout = shoestrap_getVariable('home_layout');		
			$sidebar = shoestrap_getVariable('home_layout_'.$side.'_sidebar');
		}

	}
	// Taxonomy pages
	else if ( is_tax() || is_archive() ) { // is_archive() = Category, Tag, Author, Date
	
		if ( shoestrap_getVariable('cpt_archive_layout_toggle') ) {
			$shoestrap_layout = shoestrap_getVariable('archive_layout');		
			$sidebar = shoestrap_getVariable('archive_layout_'.$side.'_sidebar');			
		}	
		
	}

	// Ensure the layout supports both sidebars
	if ( $side == 'left' ) {

		if ( in_array( $shoestrap_layout, array( '2', '3', '4', '5' ) ) ) {

		}
		else {
			$sidebar = '';
		}
	
	}

	if ( $side == 'right' ) {

		if ( in_array( $shoestrap_layout, array( '1', '3', '4', '5' ) ) ) {
		}
		else {
			$sidebar = '';
		}				
	
	}
	
	return array($shoestrap_layout, $sidebar);
	
}

// Returns the sidebar-layout class
function ac_get_sidebar_class() {

	$sidebar_class = '';

  $layout = shoestrap_getLayout();
  
  // Do we have an active sidebar?
  if (ac_has_active_sidebar()) {

		// No sidebars = 0 or -1
	  if ($layout > 0) {
		  // AC add sidebar-{layout} class
		  $sidebar_class .= " sidebar-".$layout." ";	  
	  }
	  else {
			$sidebar_class .= " no-sidebar ";
	  }
	  
	}
	else {
		$sidebar_class .= " no-sidebar ";
	}
  
  // Faint hover sidebars?  If it's on add a class to trigger the CSS
	$ac_sidebar_faint	= shoestrap_getVariable('ac_sidebar_faint');
	if ($ac_sidebar_faint) {
		$sidebar_class .= " ac_sidebar_faint ";
	}
  
  return $sidebar_class;
	
}

// Does the layout have sidebars and do any of those sidebars have widgets?
function ac_has_active_sidebar() {
	
	// Get the layout ID
	$layout = shoestrap_getLayout();

	// Get the selected sidebars.  They may be selected, but no widgets loaded
  $left_sidebar = ac_get_left_sidebar();
  $right_sidebar = ac_get_right_sidebar();
  
  // Check the layout and see if widgets loaded
	switch ($layout) {
	    case 0: // No sidebars
	        return false; // Always no sidebars
	    case 1:
	        return is_active_sidebar( $right_sidebar );
	    case 2:
	        return is_active_sidebar( $left_sidebar );
	    case 3:
	    case 4:
	    case 5:	    	    
	        return is_active_sidebar( $left_sidebar ) || is_active_sidebar( $right_sidebar );	        
	}  
		
}