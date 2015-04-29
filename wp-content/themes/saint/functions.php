<?php
/*******************/
/**** Functions ****/ 
/*******************/

/* VALUES
------------------------------------------------------------------- */
define('AC_THEME_NAME', 'Saint');
define('ULTIMATE_USE_BUILTIN', 'true'); // Disable VC UA updates

/* PATHS
------------------------------------------------------------------- */
define('AC_TEMPLATE_PATH', get_template_directory());
define('AC_TEMPLATE_URI', get_template_directory_uri()); // Parent URI if a child theme
define('AC_ASSETS_URI', AC_TEMPLATE_URI . '/assets');
define('AC_INCLUDES_PATH', AC_TEMPLATE_PATH . '/includes');
define('AC_INCLUDES_URI', AC_TEMPLATE_URI . '/includes');
define('AC_LIB_PATH', AC_TEMPLATE_PATH . '/lib');
define('AC_FRAMEWORK_PATH', AC_TEMPLATE_PATH . '/ac-framework');
define('AC_FRAMEWORK_URI', get_template_directory_uri().'/ac-framework');
define('AC_COMPOSER_PATH', AC_FRAMEWORK_PATH . '/vc-plugins');
define('AC_PLUGINS_PATH', AC_INCLUDES_PATH . '/plugins');
define('AC_PLUGINS_URI', AC_FRAMEWORK_URI . '/vc-plugins');


/* AC INCLUDES
------------------------------------------------------------------- */
require_once AC_INCLUDES_PATH . '/admin.php';
require_once AC_INCLUDES_PATH . '/activation.php';
require_once AC_INCLUDES_PATH . '/posts.php';
require_once AC_INCLUDES_PATH . '/meta-boxes.php';
require_once AC_INCLUDES_PATH . '/sidebars.php';
require_once AC_INCLUDES_PATH . '/slideshows.php';
require_once AC_INCLUDES_PATH . '/images.php';
require_once AC_INCLUDES_PATH . '/less-variables.php';
require_once AC_INCLUDES_PATH . '/woocommerce.php';
require_once AC_INCLUDES_PATH . '/bbpress.php';
require_once AC_INCLUDES_PATH . '/theme-scripts.php';
require_once AC_INCLUDES_PATH . '/tgm-plugin-activation/alleycat.php';

/* AC FRAMEWORK
------------------------------------------------------------------- */
require_once( AC_FRAMEWORK_PATH . '/ac-framework.php' );
require_once( AC_FRAMEWORK_PATH . '/ac-helper.php' );
require_once( AC_FRAMEWORK_PATH . '/ac-grids.php' );
require_once( AC_FRAMEWORK_PATH . '/ac-posts.php' );
require_once( AC_FRAMEWORK_PATH . '/ac-sliders.php' );
require_once( AC_FRAMEWORK_PATH .	'/ac-custom-post-types/ac-portfolio.php' );
require_once( AC_FRAMEWORK_PATH .	'/ac-custom-post-types/ac-person.php' );
require_once( AC_FRAMEWORK_PATH .	'/ac-custom-post-types/ac-testimonial.php' );
require_once( AC_FRAMEWORK_PATH .	'/ac-custom-post-types/ac-client.php' );
require_once( AC_FRAMEWORK_PATH . '/dd-gallery/dd-gallery-common.php' );
require_once( AC_FRAMEWORK_PATH . '/ac-classes/class-ac-redux.php' );
require_once( AC_FRAMEWORK_PATH . '/mobile-detect/ac-mobile-detect.php' );

/* AC WIDGETS
------------------------------------------------------------------- */
require_once( AC_INCLUDES_PATH . '/widgets/class-ac-portfolio-latest.php' );


/* THEME MODULES
------------------------------------------------------------------- */	
// -- Load the theme modules --
require_once AC_LIB_PATH . '/modules/load.modules.php';
require_once AC_LIB_PATH . '/utils.php';
require_once AC_LIB_PATH . '/init.php';            // Initial theme setup and constants
require_once AC_LIB_PATH . '/wrapper.php';         // Theme wrapper class
require_once AC_LIB_PATH . '/sidebar.php';         // Sidebar class
require_once AC_LIB_PATH . '/config.php';          // Configuration
require_once AC_LIB_PATH . '/activation.php';      // Theme activation
require_once AC_LIB_PATH . '/titles.php';          // Page titles
require_once AC_LIB_PATH . '/cleanup.php';         // Cleanup
require_once AC_LIB_PATH . '/nav.php';             // Custom nav modifications
require_once AC_LIB_PATH . '/gallery.php';         // Custom [gallery] modifications
require_once AC_LIB_PATH . '/comments.php';        // Custom comments modifications
require_once AC_LIB_PATH . '/widgets.php';         // Sidebars and widgets
require_once AC_LIB_PATH . '/scripts.php';         // Scripts and stylesheets
require_once AC_LIB_PATH . '/modules/core.menus/functions.navwalker.php'; // AC - Register Custom Navigation Walker


/* IMAGE SIZES
------------------------------------------------------------------- */
// Dynamic.  As the width of the site can change we need to calculate the image sizes dynamically
$three_col = shoestrap_content_width_px() / 4;
add_image_size( 'three-col', $three_col, $three_col, true);


/* AC VC PLUGINS
------------------------------------------------------------------- */
// Only load the Visual Composer elements if the plugin has been installed
if ( ac_visual_composer_is_installed() ) {

	add_action( 'vc_before_init', 'ac_vc_before_init' );  // Init VC
		
	require_once( AC_FRAMEWORK_PATH . '/vc-plugins/ac-row.php' );
	require_once( AC_FRAMEWORK_PATH . '/vc-plugins/ac-vc-base.php' );
	require_once( AC_FRAMEWORK_PATH . '/vc-plugins/ac-image.php' );
	require_once( AC_FRAMEWORK_PATH . '/vc-plugins/ac-text-block.php' );
	require_once( AC_FRAMEWORK_PATH . '/vc-plugins/ac-block-quote.php' );
	require_once( AC_FRAMEWORK_PATH . '/vc-plugins/ac-featured-post.php' );
	require_once( AC_FRAMEWORK_PATH . '/vc-plugins/ac-posts-builder-base.php' );
	require_once( AC_FRAMEWORK_PATH . '/vc-plugins/ac-posts.php' );
	require_once( AC_FRAMEWORK_PATH . '/vc-plugins/ac-portfolio.php' );
	require_once( AC_FRAMEWORK_PATH . '/vc-plugins/ac-testimonials.php' );
	require_once( AC_FRAMEWORK_PATH . '/vc-plugins/ac-people.php' );	
	require_once( AC_FRAMEWORK_PATH . '/vc-plugins/ac-client.php' );	
	require_once( AC_FRAMEWORK_PATH . '/vc-plugins/ac-button.php' );	
	require_once( AC_FRAMEWORK_PATH . '/vc-plugins/ac-galleries.php' );
	require_once( AC_FRAMEWORK_PATH . '/vc-plugins/ac-gallery.php' );	
	
	// Check if WooCommerce is active
	if (ac_woocommerce_is_active()) {
		// If WooCommerce is active include the AC Product
	 	require_once( AC_FRAMEWORK_PATH . '/vc-plugins/ac-product.php' );			
	}

}

/* LOAD FRONTEND & BACKEND INCLUDES
------------------------------------------------------------------- */
if( is_admin() ) {
	// Back end
	require_once( AC_FRAMEWORK_PATH . '/dd-gallery/dd-gallery-admin.php' );	
}
else {	
	// Front end
	require_once( AC_FRAMEWORK_PATH . '/dd-gallery/dd-gallery-render.php' );	
}		

/* LOAD STYLESHEETS
------------------------------------------------------------------- */
// Enqueue first everything that will printed inline with shoestrap_css
add_action( 'wp_enqueue_scripts', 'shoestrap_module_typography_googlefont_links', 50);
add_action( 'wp_enqueue_scripts', 'roots_scripts', 100);

if (!function_exists('ac_enqueue_styles')) {
	// Enqueue all of the scripts with dependencies
	function ac_enqueue_styles() {
		// Avoid dependencies as these can cause scripts to not load
		// Only depend on js_composer_front if registered
		$rs_deps = array();
		if ( wp_style_is( 'js_composer_front', 'registered' ) ) {
			$rs_deps[] = 'js_composer_front';
		}

    wp_enqueue_style('royalslider', AC_INCLUDES_URI . '/royalslider/royalslider.css', $rs_deps, NULL, 'screen');
		wp_enqueue_style('ac-fontello', AC_INCLUDES_URI. '/fonts/css/fontello.css');
    wp_enqueue_style('ac-framework', AC_TEMPLATE_URI . '/ac-framework/ac-framework.css', array(), NULL, 'screen');
    wp_enqueue_style('ac-vc-plugins', AC_TEMPLATE_URI . '/ac-framework/vc-plugins/ac-vc-plugins.css', array(), NULL, 'screen');
    wp_enqueue_style('ac-theme-styles', AC_INCLUDES_URI . '/theme-scipts.css', array(), NULL, 'screen');  
    // Load the SS stylesheet
    wp_enqueue_style('shoestrap_css', shoestrap_css( 'url' ), array(), null);
		// Load the Alleycat stylesheet.  Ensure dependencies are AC scripts, and therefore always loaded
    wp_enqueue_style('ac-alleycat', alleycat_css(), array('shoestrap_css', 'ac-theme-styles', 'royalslider'), NULL, 'screen');
		// Load the Wordpress stylesheet last
    wp_enqueue_style('ac-theme', AC_TEMPLATE_URI . '/style.css', array('ac-alleycat'), NULL, 'screen');
	}		
	add_action('wp_enqueue_scripts', 'ac_enqueue_styles', 9999);  // We need to be very late to ensure our scripts are last

}

add_action( 'wp_enqueue_scripts', 'shoestrap_user_css', 11000 ); // Theme Options CSS
add_action( 'wp_enqueue_scripts', 'shoestrap_background_css', 10001 ); // Attach after main enqueues (9999)
add_action( 'wp_enqueue_scripts', 'shoestrap_navbar_css', 10002 );
add_action( 'wp_enqueue_scripts', 'shoestrap_footer_css', 10050 ); 
remove_action( 'wp_enqueue_scripts', 'bbp_enqueue_scripts', 10 );
add_action('wp_enqueue_scripts', 'shoestrap_bbp_styles', 11030); // ensure after ac_enqueue_styles
add_action('wp_enqueue_scripts', 'ac_add_inline_styles', 11050); 


/* LOAD FRONTEND SCRIPTS
------------------------------------------------------------------- */
if (!function_exists('ac_enqueue_scripts')) {
	function ac_enqueue_scripts() {
	
		ac_load_isotope(); // Load Isotope if not already enqueued by VC
		ac_load_prettyphoto();
	
    wp_enqueue_script('royalslider', AC_INCLUDES_URI . '/royalslider/jquery.royalslider.min.js', array('jquery'), false, true);
    wp_enqueue_script('ac-framework', AC_FRAMEWORK_URI . '/ac-framework.js', array('jquery'), false, false); // Do not load into footer.  Needs early loading for Ready and Load events    
    wp_enqueue_script('ac-theme-scripts', AC_INCLUDES_URI . '/theme-scripts.js', array('jquery'), false, true);    
		
	}
	add_action('wp_enqueue_scripts', 'ac_enqueue_scripts');
}		

add_action( 'wp_enqueue_scripts', 'shoestrap_user_js', 999 );	 // Theme Options JS.  Should be very late in the queue
add_action('wp_enqueue_scripts', 'roots_google_analytics', 12000); // Very late


/* LOAD BACKEND SCRIPTS
------------------------------------------------------------------- */
function ac_admin_scripts() {

	wp_enqueue_style('ac-vc-admin', AC_PLUGINS_URI. '/ac-vc-admin.css', array('js_composer'));
	wp_enqueue_style('ac-admin', AC_INCLUDES_URI. '/admin.css');
  wp_enqueue_script('ac-admin', AC_INCLUDES_URI . '/admin.js', 'jquery', false, true);

}
add_action('admin_enqueue_scripts', 'ac_admin_scripts');
	



/* SETTINGS YOU CAN CHANGE
------------------------------------------------------------------- */
global $ac_full_width_pixels,
	$post_types_with_no_archive_header,
	$post_types_with_author_bio;

// The maxium width any images should be when outside of the grid = 1920; // The maxium width any images should be when outside of the grid
$ac_full_width_pixels = 1600;

// An array of the post types that don't have archive page titles
$post_types_with_no_archive_header = array( 'ac_gallery' );

// Array of post types with Author Bio
$post_types_with_author_bio = array('post', 'page');



/* ------------------------------------------------------------------- */
// Add your own cool functions below here....... :)

