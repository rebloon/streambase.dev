<?php

if ( !function_exists( 'shoestrap_user_css' ) ) :
/*
 * echo any custom CSS the user has written to the <head> of the page
 */
function shoestrap_user_css() {
  $header_scripts = shoestrap_getVariable( 'user_css' );
  
  if ( trim( $header_scripts ) != '' )
    wp_add_inline_style( 'ac-theme', $header_scripts );
}
endif;


if ( !function_exists( 'shoestrap_user_js' ) ) :
/*
 * echo any custom JS the user has written to the footer of the page
 */
function shoestrap_user_js() {
  $footer_scripts = shoestrap_getVariable( 'user_js' );

  if ( trim( $footer_scripts ) != '' )
    echo $footer_scripts;
}
endif;


if ( !function_exists( 'shoestrap_excerpt_more' ) ) :
function shoestrap_excerpt_more( $more ) {
  $continue_text = shoestrap_getVariable( 'post_excerpt_link_text' );
  return ' &hellip; <a href="' . get_permalink() . '">' . $continue_text . '</a>';
}
endif;
add_filter('excerpt_more', 'shoestrap_excerpt_more');

function shoestrap_excerpt_length($length) {
  return shoestrap_getVariable( 'post_excerpt_length' );
}
add_filter('excerpt_length', 'shoestrap_excerpt_length');
