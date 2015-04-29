<?php
/**
 * Roots initial setup and constants
 */
function roots_setup() {
  // Make theme available for translation
  load_theme_textdomain('roots', get_template_directory() . '/lang');

  // Register wp_nav_menu() menus (http://codex.wordpress.org/Function_Reference/register_nav_menus)
  register_nav_menus(array(
    'primary_navigation' => __('Primary Navigation', 'alleycat'),
//    'secondary_navigation' => __('Secondary Navigation', 'alleycat'),
  ));

  // Add post thumbnails (http://codex.wordpress.org/Post_Thumbnails)
  add_theme_support('post-thumbnails');

  // Add post formats (http://codex.wordpress.org/Post_Formats)
  // These can be override/re-declared in a child theme/functions.php file
	// V2 add_theme_support('post-formats', array('gallery', 'image', 'quote', 'video'));

  // Tell the TinyMCE editor to use a custom stylesheet
  add_editor_style('assets/admin/editor-style.css');
  
  add_theme_support( 'automatic-feed-links' );  
}
add_action('after_setup_theme', 'roots_setup');