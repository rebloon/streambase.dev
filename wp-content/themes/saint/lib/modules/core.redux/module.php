<?php

if ( !class_exists( 'ReduxFramework' ) && file_exists( dirname( __FILE__ ) . '/ReduxFramework/ReduxCore/framework.php' ) ) :
  include_once( dirname( __FILE__ ) . '/ReduxFramework/ReduxCore/framework.php' );
endif;

/*
 * Require the framework class before doing anything else, so we can use the defined urls and dirs
 * Also if running on windows you may have url problems, which can be fixed by defining the framework url first
 */

if ( class_exists( 'ReduxFramework' ) ) :
define('REDUX_OPT_NAME', AC_THEME_NAME.'_options');
  function shoestrap_redux_init() {
  
  $args = array();

  // Choose a custom option name for your theme options, the default is the theme name in lowercase with spaces replaced by underscores
  $args['opt_name']               = REDUX_OPT_NAME;
  $args['customizer']             = false;
  $args['google_api_key']         = '';
  $args['global_variable']        = 'redux';
  $args['default_show']           = true;
  $args['default_mark']           = ''; // AC '*';
  $args['page_slug']              = REDUX_OPT_NAME;
  $theme                          = wp_get_theme();
  $args['display_name']           = $theme->get( 'Name' );
  $args['menu_title']             = __( 'Theme Options', 'shoestrap' );
  $args['display_version']        = $theme->get( 'Version' );    
  $args['page_position']          = 99;
  $args['dev_mode']               = false;
  $args['page_type']              = 'submenu';
  $args['page_parent']            = 'themes.php';

  $sections = array();
  $sections = apply_filters( 'shoestrap_add_sections', $sections );

  $ReduxFramework = new ReduxFramework( $sections, $args );

  if ( !empty( $redux['dev_mode'] ) && $redux['dev_mode'] == 1 ) :
    $ReduxFramework->args['dev_mode']     = true;
    $ReduxFramework->args['system_info']  = true;
  endif;
}
add_action('init', 'shoestrap_redux_init');
endif;

// Saving functions on import, etc
// If a compiler field was altered or import or reset defaults
add_action( 'redux/options/' . REDUX_OPT_NAME . '/compiler' , 'shoestrap_makecss' );
