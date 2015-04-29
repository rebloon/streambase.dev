<?php

if ( !function_exists( 'shoestrap_nav_class_pull' ) ) :
function shoestrap_nav_class_pull( $class = 'navbar-nav' ) {
  $ul = ( shoestrap_getVariable( 'navbar_nav_right' ) == '1' ) ? 'nav pull-right ' . $class : 'nav ' . $class;

  return $ul;
}
endif;


if ( !function_exists( 'shoestrap_navbar_pre_searchbox' ) ) :
/*
 * The template for the primary navbar searchbox
 */
function shoestrap_navbar_pre_searchbox() {
  $show_searchbox = shoestrap_getVariable( 'navbar_search' );
  if ( $show_searchbox == '1' ) : ?>
	  <div class='navbar-search-form-container'>
		  <div class='container'>
		    <form role="search" method="get" id="searchform-nav" class="container form-search navbar-form" action="<?php echo home_url('/'); ?>">
		      <label class="hide" for="s-nav"><?php _e('Search for:', 'roots'); ?></label>
		      <input type="text" value="<?php if (is_search()) { echo get_search_query(); } ?>" name="s" id="s-nav" class="form-control search-query" placeholder="<?php _e('Search', 'roots'); ?> <?php bloginfo('name'); ?>">
		      <div id="nav-search-close" class="entypo-icon-cancel"></div>
		    </form>
		  </div>
	  </div>
    <?php
  endif;
}
endif;
add_action( 'shoestrap_inside_header_begin', 'shoestrap_navbar_pre_searchbox', 11 );


if ( !function_exists( 'shoestrap_navbar_class' ) ) :
function shoestrap_navbar_class( $navbar = 'main') {
  $fixed    = shoestrap_getVariable( 'navbar_fixed' );
  $fixedpos = shoestrap_getVariable( 'navbar_fixed_position' );
  $style    = shoestrap_getVariable( 'navbar_style' );
  $transparent = ac_navbar_start_transparent();

  if ( $fixed != 1 )
    $class = 'navbar navbar-static-top';
  else {
    $class = ( $fixedpos == 1 ) ? 'navbar navbar-fixed-bottom' : 'navbar navbar-fixed-top';
    
    if (ac_navbar_start_transparent()) {
		  $class .= ' ac-transparent-navbar ';    	    
    }
  }

  if ( $navbar != 'secondary' )
    return $class . ' ' . $style;
  else
    return 'navbar ' . $style;
}
endif;


if ( !function_exists( 'shoestrap_navbar_css' ) ) :
function shoestrap_navbar_css() {
  $navbar_bg_opacity = shoestrap_getVariable( 'navbar_bg_opacity' );
  $style = "";

  $opacity = ( $navbar_bg_opacity == '' ) ? '0' : ( intval( $navbar_bg_opacity ) ) / 100;

  if ( $opacity != 1 && $opacity != '' ) {
    $bg  = ac_prepare_bg_colour_for_less( shoestrap_getVariable( 'navbar_bg' ) );
    $rgb = shoestrap_get_rgb( $bg, true );
    $opacityie = str_replace( '0.', '', $opacity );

    $style .= '.navbar, .navbar-default {';

    if ( $opacity != 1 && $opacity != '')
      $style .= 'background: transparent; background: rgba('.$rgb.', '.$opacity.'); filter:progid:DXImageTransform.Microsoft.gradient(startColorstr=#'.$opacityie.$bg.',endColorstr=#'.$opacityie.$bg.'); ;';
    else
      $style .= 'background: #'.$bg.';';

    $style .= '}';

  }

  if ( shoestrap_getVariable( 'navbar_margin' ) != 1 )
    $style .= '.navbar-static-top { margin-top:'. shoestrap_getVariable( 'navbar_margin' ) .'px !important; margin-bottom:'. shoestrap_getVariable( 'navbar_margin' ) .'px !important; }';

  wp_add_inline_style( 'shoestrap_css', $style );
}
endif;

if ( !function_exists( 'ac_navbar_start_transparent' ) ) :
// Should the navbar start tansparent, i.e. does this page support transparent navs?
function ac_navbar_start_transparent() {
	
/* 
	Activates when
	1. Page has Alleycat Slider, but no title, or custom title
	2. or Page has Rev slider, but no title, or custom title
	3. or Custom title
	
	Post level switch on
	- Post
	- Page
	- Portfolio
	- Galleries
	
	Disable on post level
	Force on post level
*/

	// Can only apply to singular
	if (! is_singular() ) { 
		return false;
	}		

	// If we have a page setting respect that, irrespective of theme setting
	$page_setting = ac_get_meta('page_transparent_header');

	if ($page_setting == 'disable') {
		return false;
	}
	if ($page_setting == 'force') {
		return true;
	}

	// If the feature is off do nothing
	$theme_on = shoestrap_getVariable('navbar_transparent');
	if (!$theme_on) {
		return false;
	}
		
	// Get values
	$return = false;
	$title = ac_get_meta('page_title_type');
	$slider = ac_get_meta('slideshow_type');
	$post_type = get_post_type();

	// Automatic detection
	$ac_slider_set = ($slider == 'ac');
	$rev_slider_set = ($slider == 'revslider');
	$custom_title_set = ($title == 'custom');
	$is_post = ($post_type == 'post') && (has_post_thumbnail() || $ac_slider_set ||$rev_slider_set);
	$is_page = ($post_type == 'page') && (has_post_thumbnail() || $ac_slider_set ||$rev_slider_set) && ($title == 'none');
		
	$ac_slider_ok = $ac_slider_set && ($title == 'none');
	$rev_slider_ok = $rev_slider_set && ($title == 'none');
	
	// Auto detect
	$return = ($ac_slider_ok || $rev_slider_ok || $custom_title_set || $is_post || $is_page);

	return $return;
}
endif;