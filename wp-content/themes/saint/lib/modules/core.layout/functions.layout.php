<?php

if ( !function_exists( 'shoestrap_getLayout' ) ) :
// Returns the layout id (-1, 0 = no sidebars, 1, 2, 3, 4, 5)
function shoestrap_getLayout() {

	// Use the theme method
	$sidebar_info = ac_get_sidebar("left");
	
	return $sidebar_info[0];
}
endif;


if ( !function_exists( 'shoestrap_setLayout' ) ) :
/*
 *Override the layout value globally
 */
function shoestrap_setLayout( $val ) {
  global $shoestrap_layout, $redux;
  $shoestrap_layout = intval( $val );
}
endif;

if ( !function_exists( 'shoestrap_section_class' ) ) :
/*
 * Calculates the classes of the main area, main sidebar and secondary sidebar
 */
function shoestrap_section_class( $target, $echo = false ) {
  global $redux;
  
  $layout = shoestrap_getLayout();
  $first  = intval( shoestrap_getVariable( 'layout_primary_width' ) );
  $second = intval( shoestrap_getVariable( 'layout_secondary_width' ) );
    
  // disable responsiveness if layout is set to non-responsive
  $base = ( shoestrap_getVariable( 'site_style' ) == 'static' ) ? 'col-xs-' : 'col-sm-';
  
  // AC - Super sidebars
  $first_sidebar = ac_get_left_sidebar();
  $second_sidebar = ac_get_right_sidebar();
      
  // Set some defaults so that we can change them depending on the selected template
  $main       = $base . 12;
  $primary    = NULL;
  $secondary  = NULL;
  $wrapper    = NULL;
  
  if ( is_active_sidebar( $first_sidebar ) && is_active_sidebar( $second_sidebar ) ) {

    if ( $layout == 5 ) {
      $main       = $base . ( 12 - floor( ( 12 * $first ) / ( 12 - $second ) ) );
      $primary    = $base . floor( ( 12 * $first ) / ( 12 - $second ) );
      $secondary  = $base . $second;
      $wrapper    = $base . ( 12 - $second );
    } elseif ( $layout >= 3 ) {
      $main       = $base . ( 12 - $first - $second );
      $primary    = $base . $first;
      $secondary  = $base . $second;
    } elseif ( $layout >= 1 ) {
      $main       = $base . ( 12 - $first );
      $primary    = $base . $first;
      $secondary  = $base . $second;
    }

  } elseif ( !is_active_sidebar( $second_sidebar ) && is_active_sidebar( $first_sidebar ) ) {

    /* AC not required if ( $layout >= 1 ) */ {
      $main       = $base . ( 12 - $first );
      $primary    = $base . $first;
    }

  } elseif ( is_active_sidebar( $second_sidebar ) && !is_active_sidebar( $first_sidebar ) ) {

    /* AC not required if ( if ( $layout >= 3 ) */ {
      $main       = $base . ( 12 - $second );
      $secondary  = $base . $second;
    }
    
  }

  
  if ( $target == 'primary' )
    $class = $primary;
  elseif ( $target == 'secondary' )
    $class = $secondary;
  elseif ( $target == 'wrapper' )
    $class = $wrapper;
  else
    $class = $main;
    
  if ( $target != 'wrap'  ) {
    // echo or return the result.
    if ( $echo )
      echo $class;
    else
      return $class;

  } else {
    if ( $layout == 5 )
      return true;
    else
      return false;
  }
}
endif;


if ( !function_exists( 'shoestrap_layout_body_class' ) ) :
/**
 * Add and remove body_class() classes to accomodate layouts
 */
function shoestrap_layout_body_class( $classes ) {
  $layout     = shoestrap_getLayout();
  $site_style = shoestrap_getVariable( 'site_style' );
  $margin     = shoestrap_getVariable( 'navbar_margin_top' );
  $style      = '';

  $classes[] = ( $layout == 2 || $layout == 3 || $layout == 5 ) ? 'main-float-right' : '';

	// Boxed style
  $classes[] = ( $site_style == 'boxed') ? 'boxed-style' : '';
  
	// One pager
  $page_menu = ac_get_meta("page_menu");
	if ($page_menu) {
		$classes[] = 'one-page';
	}
	
	// Parallax Footer
	$parallax = shoestrap_getVariable( 'footer_parallax' );
	if ($parallax) {
	 $classes[] = ' footer-parallax ';
	}

  // Remove unnecessary classes
  $remove_classes = array();
  $classes = array_diff( $classes, $remove_classes );
  

  return $classes;
}
endif;
add_filter('body_class', 'shoestrap_layout_body_class');


if ( !function_exists( 'shoestrap_container_class' ) ) :
/*
 * Return the container class
 */
function shoestrap_container_class( $region = '' ) {

	// AC Modified
	//$region can be header, main, footer, ac-page-hero-img
	
  $site_style = shoestrap_getVariable( 'site_style' );
  
	// Check for specific scenarios
	// Page is set to full width (affects main only)
	if ( ($region == 'main') && is_singular() && (ac_get_meta('page_full_width') == 1) ) {
		return 'fluid';		
	}
	
	// Gallery Main is fluid, but header and footer remain container
	if ( ($region == 'main') && is_singular('ac_gallery') && ( $site_style == 'wide' ) ) {
		return 'fluid';
	}
	
	// Footer Copyright is always container
	if ( ($region == 'footer-copyright') ) {
	  return 'container';
	}
	
	// Footer Content
	if ( ($region == 'footer-content') ) {
		switch ($site_style) {
		    case 'wide':
          return 'container';
				default :
					return '';
		}  
	}	

	// When boxed some sections dont get container class	
  if ( $site_style == 'boxed' ) {
 
		switch ($region) {
		    case 'header':
           return '';
		}  
  
  }
	// When wide some sections dont get container class	
  elseif ( $site_style == 'wide' ) {
 
		switch ($region) {
		    case 'ac-page-hero-img':
           return '';
		}  
  
  }  
	
  return 'container';		
	
}
endif;

// Returns the class for header, pagetile, footer
function shoestrap_outer_container_class( $region = '' ) {

  $site_style = shoestrap_getVariable( 'site_style' );
  
  if ( $site_style == 'boxed' )
    return 'container';
  else
    return 'fluid';

}

if ( !function_exists( 'shoestrap_content_width_px' ) ) :
/*
 * Calculate the width of the content area in pixels.
 */
function shoestrap_content_width_px( $echo = false ) {
  global $redux;

  $layout = shoestrap_getLayout();

  $container  = filter_var( shoestrap_getVariable( 'screen_large_desktop' ), FILTER_SANITIZE_NUMBER_INT );
  $gutter     = filter_var( shoestrap_getVariable( 'layout_gutter' ), FILTER_SANITIZE_NUMBER_INT );

  $main_span  = filter_var( shoestrap_section_class( 'main', false ), FILTER_SANITIZE_NUMBER_INT );
  $main_span  = str_replace( '-' , '', $main_span );

  $width = $container * ( $main_span / 12 ) - $gutter;

  // Width should be an integer since we're talking pixels, round up!.
  $width = round( $width );

  if ( $echo )
    echo $width;
  else
    return $width;
}
endif;


if ( !function_exists( 'shoestrap_content_width' ) ) :
/*
 * Set the content width
 */
function shoestrap_content_width() {
  global $content_width;
  $content_width = shoestrap_content_width_px();
}
endif;
add_action( 'template_redirect', 'shoestrap_content_width' );

// Returns the width of the page in pixels
// This is set in the grid options
// This may not be 100% accurate because of scaffolding gutters, etc.
function ac_get_page_width_px() {
	$container  = filter_var( shoestrap_getVariable( 'screen_large_desktop' ), FILTER_SANITIZE_NUMBER_INT );
	return $container;
}

// Returns the number of pixels set as the maximum for the theme
// This is normally set in functions.php
// This value is likely to grow over time
function ac_get_full_width_px() {
	global $ac_full_width_pixels;
	
	return $ac_full_width_pixels;
}