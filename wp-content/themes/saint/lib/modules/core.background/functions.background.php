<?php

if ( !function_exists( 'shoestrap_background_css' ) ) :
// Generate some CSS in code as this is case dependant
function shoestrap_background_css() {

  $image_toggle     = shoestrap_getVariable( 'background_image_toggle' );
  $bg_img           = shoestrap_getVariable( 'background_image' );
  $pattern_toggle   = shoestrap_getVariable( 'background_pattern_toggle' );
  $bg_pattern       = shoestrap_getVariable( 'background_pattern' );
  $html_bg          = shoestrap_getVariable( 'html_color_bg' );
//  $bg_color         = shoestrap_getVariable( 'color_body_bg' );
  $bg_color         = $html_bg; // Body is bg for Saint
//  $content_opacity  = shoestrap_getVariable( 'color_body_bg_opacity' );
  $content_opacity  = 100; // 100 for Saint
  $repeat           = shoestrap_getVariable( 'background_repeat' );
  $position         = shoestrap_getVariable( 'background_position_x', 'left' );
  $fixed            = shoestrap_getVariable( 'background_image_position_toggle' );

  // Do not process if there is no need to.
  if ( $image_toggle == 0 && $pattern_toggle == 0 && $bg_color == $html_bg )
    return;

	// AC improved
	// Image first
	$background = ( $image_toggle == 1 && $bg_img != '' ) ? set_url_scheme( $bg_img['url'] ) : '';
	if (! $background) {
		// Pattern fallback
	  $background = ( $pattern_toggle == 1 && $bg_pattern != '' ) ? set_url_scheme( $bg_pattern ) : '';		
	}

  // The Body background color
  $html_bg    = '#' . str_replace( '#', '', $html_bg ) . ';';

  // The Content background color
  $content_bg = '#' . str_replace( '#', '', $bg_color ) . ';';
  $content_bg .= ( $content_opacity != 100 ) ? 'background:' . shoestrap_get_rgba( $content_bg, $content_opacity ) . ';' : '';

  $repeat  = ( !in_array( $repeat, array( 'no-repeat', 'repeat-x', 'repeat-y', 'repeat' ) ) ) ? 'repeat' : $repeat;
  $repeat .= ( $repeat == 'no-repeat' ) ? 'background-size: auto;' : $repeat;

  $position = ( !in_array( $position, array( 'center', 'right', 'left' ) ) ) ? 'left' : $position;

  $style = '';

  if ( ( $image_toggle == 1 || $pattern_toggle == 1 ) && isset( $background ) ) {

		// BG is currently on outer-wrap due to reveal footer
//    $style .= 'body {'; 
    $style .= '#outer-wrap {';

    // Add the background image
    $style .= 'background-image: url( "' . $background . '" );';

    // Add the body background color
    $style .= ( $bg_color != $html_bg ) ? 'background-color: ' . $html_bg . ';' : '';

    // Apply fixed positioning for background when needed
    $style .= ( shoestrap_getVariable( 'background_fixed_toggle' ) == 1 ) ? 'background-attachment: fixed;' : '';

    if ( $image_toggle == 1 ) {
      // Background image positioning
      if ( $fixed == 0 ) {
        // cover
        $style .= 'background-size: cover;';
        $style .= '-webkit-background-size: cover;';
        $style .= '-moz-background-size: cover;';
        $style .= '-o-background-size: cover;';
        $style .= 'background-position: 50% 50%;';
      } else {
        $style .= ' background-repeat: ' . $repeat . ';';
        $style .= ' background-position: top ' . $position . ';';
      }
    }
    $style .= '}';
  } else {
    // Add the body background color
    $style .= ( $bg_color != $html_bg ) ? 'body { background-color: ' . $html_bg . '; }' : '';
  }

//  $style .= ( $bg_color != $html_bg ) ? '.wrap.main-section .content .bg { background: ' . $content_bg . '; }' : '';

  wp_add_inline_style( 'shoestrap_css', $style );
}
endif;