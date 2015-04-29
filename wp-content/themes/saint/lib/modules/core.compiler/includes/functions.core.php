<?php


if ( !function_exists( 'shoestrap_css' ) ) :
/*
 * Gets the css path or url to the stylesheet
 * If $target = 'path', return the path
 * If $target = 'url', return the url
 *
 * If echo = true then print the path or url.
 */
function shoestrap_css( $target = 'path', $echo = false ) {
  global $blog_id;

  $defaultfile = '/assets/css/app';
  // If this is a multisite installation, append the blogid to the filename
  $cssid    = ( is_multisite() && $blog_id > 1 ) ? '_id-' . $blog_id : null;
  
  $css_uri  = get_template_directory_uri() . $defaultfile . $cssid . '.css';
  $css_path = get_template_directory() . $defaultfile . $cssid . '.css';

  if ( !is_writable( $css_path ) )
    $css_uri = get_template_directory_uri() . $defaultfile . '-default.css';

  if ( is_child_theme() ) {
    $child_style = get_stylesheet_directory() . $defaultfile . $cssid . '.css';
    $child_style_writable = ( is_writable( $child_style ) ) ? true : false;

    if ( $child_style_writable ) {
      $css_path = $child_style;
      $css_url  = get_stylesheet_directory_uri() . $defaultfile . $cssid . '.css';
      $css_uri  = get_template_directory_uri() . $defaultfile . '-default.css';
    }
  }

  $return = ( $target == 'url' ) ? $css_uri : $css_path;
  
  if ( $echo )
    echo $return;
  else
    return $return;
}
endif;


if ( !function_exists( 'alleycat_css' ) ) :
/*
 * Gets the css path or url to the stylesheet
 * Returns the default if ours cannot be generated
 */
function alleycat_css() {

	$ac_css_path = get_template_directory() . '/assets/css/alleycat.css';
	$ac_css_url = get_template_directory_uri() . '/assets/css/alleycat.css';
  $ac_default_url = get_template_directory_uri() . '/assets/css/alleycat-default.css';
  
  // If the generate file exists return that
  if ( file_exists($ac_css_path) ) {
	  return $ac_css_url;
  }
  else {
	  // Return the default file, as that always exists
	  return $ac_default_url;	  
  }
  
}
endif;


if ( !function_exists( 'shoestrap_css_not_writeable' ) ) :
/*
 * Admin notice if css is not writable
 */
function shoestrap_css_not_writeable( $array ) {
  global $current_screen, $wp_filesystem;

	$css_folder = get_template_directory() . '/assets/css/';
	$app_css_path = get_template_directory() . '/assets/css/app.css';
	$ac_css_path = get_template_directory() . '/assets/css/alleycat.css';
		
	// ! The compile should already have been attempted at this point as the hook is earlier !
	// If the files are writable the files will exist
	
	// The CSS folder is not writable and the files don't exist, user needs folder write permissions
	if ( !is_writable( $css_folder ) && !file_exists( $app_css_path ) && !file_exists( $ac_css_path ) ) {
	  $content = __( 'The following folder does not have write permission.  Please update the write permissions for this folder, it is required for the Theme Options.', 'shoestrap' );
	  $content .= '<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$css_folder;
	  add_settings_error( 'shoestrap', 'create_file', $content, 'error' );                  
	  settings_errors();	    
	}
	else if ( !is_writable( $app_css_path ) || !is_writable( $ac_css_path ) ) {
		// Check if the CSS files are writeable.  Seems like an unlikely scenario, but you never know.    
	  $content = __( 'The following files do not have write permissions.  Please update the write permissions for these files, they are required for the Theme Options.', 'shoestrap' );
		if ( !is_writable( $app_css_path ) ) {
	    $content .= '<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/wp-content/themes/saint/assets/css/app.css';
		}
		if ( !is_writable( $ac_css_path ) ) {
	    $content .= '<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/wp-content/themes/saint/assets/css/alleycat.css';
		}
	  add_settings_error( 'shoestrap', 'create_file', $content, 'error' );                  
	  settings_errors();
	}
		
}
endif;
add_action( 'admin_notices', 'shoestrap_css_not_writeable');


if ( !function_exists( 'shoestrap_process_font' ) ) :
function shoestrap_process_font( $font ) {
  
  if ( empty( $font['font-weight'] ) )
    $font['font-weight'] = "inherit";

  if ( empty( $font['font-style'] ) )
    $font['font-style'] = "inherit";

  if ( isset( $font['font-size'] ) )
    $font['font-size'] = filter_var( $font['font-size'], FILTER_SANITIZE_NUMBER_INT );

  return $font;
}
endif;


// Checks if the LESS files need compiling
function ac_check_less_for_recompile() {
	
//				shoestrap_makecss(); return;

	$css_folder = get_template_directory() . '/assets/css/';
	$app_css_path = get_template_directory() . '/assets/css/app.css';
	$ac_css_path = get_template_directory() . '/assets/css/alleycat.css';
	
	// Dont raise an error if not, as this is handled by shoestrap_css_not_writeable()
	// Check files exist and are writeable OR folder is writeable and files don't exist
	
	// If the CSS files are writeable and exists compile if they are out of data
	if 	( is_writable($app_css_path) && is_writable($ac_css_path) ) {

		// Check the app.less -> app.css exists or needs updating
		// This will happen when the theme is first run or files have been updated
		$app_less_needs_compiling = ( filemtime( get_template_directory() . '/assets/less/app.less' ) > filemtime( $app_css_path ) );
		
		// Check the alleycat.less -> alleycat.css exists or needs updating
		// This will happen when the theme is first run or files have been updated
		$alleycat_less_needs_compiling = ( filemtime( get_template_directory() . '/assets/less/alleycat.less' ) > filemtime( $ac_css_path ) );
		
		// Check the files need updating
		if ($app_less_needs_compiling || $alleycat_less_needs_compiling) {
			shoestrap_makecss();
		}
		
	}
	// Files don't exist so check folder is writeable
	else if ( is_writable( $css_folder ) && !file_exists( $app_css_path ) && !file_exists( $ac_css_path ) ) {

		// Check if any of the css files are missing.  This will happen on first run or theme update
		$app_less_is_missing = !file_exists( $app_css_path );
		$alleycat_less_is_missing = !file_exists( $ac_css_path );			
		
		// Check the files need updating
		if ($app_less_is_missing || $alleycat_less_is_missing) {
			shoestrap_makecss();
		}
		
	}
	
}

// -- CHECK FOR LESS RECOMPILE --
// Hook wp_enqueue_scripts as it's late, but before admin_notices.  
// We have to be later than admin_init as that's when the options are built for a new install.
// Those options are needed to build the variables for the LESS compilation
if (! defined('AC_DISABLE_AUTO_LESS_COMPILE') ) {
	add_action('wp_enqueue_scripts', 'ac_check_less_for_recompile', 1); // This is for the front-end only.  Fires before styles are included
	add_action('admin_init', 'ac_check_less_for_recompile', 9999); // This fires on admin only, after options setup	
}