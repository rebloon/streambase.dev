<?php
/**
 * Theme activation
*/

// Define the demo data file paths.  Defined here as demo-data-import only included when required
define('AC_DD_THEME_OPTIONS_TXT_URI', AC_INCLUDES_URI . '/demo-data/theme_options.txt');
define('AC_DD_THEME_OPTIONS_TXT_PATH', AC_INCLUDES_PATH . '/demo-data/theme_options.txt');
define('AC_DD_WIDGETS_PATH', AC_INCLUDES_PATH . '/demo-data/widgets.txt');
define('AC_DD_THEME_XML_PATH', AC_INCLUDES_PATH . '/demo-data/import.xml');

// Demo data, setup check
function roots_theme_activation_action() {

	// Demo data
	// Check 'Import Demo Data' button has been clicked
	if ( isset($_REQUEST['ac_do_demo_data']) && ($_REQUEST['ac_do_demo_data'] != '') ) {
	
		require_once( AC_INCLUDES_PATH . '/demo-data-import.php' );	
			
		// Import the demo data
		ac_demo_data_import();
		
		// Set the permalinks
		ac_activation_setup_permalinks();				
		
	}

	// Basic Setup
	// Check 'Basic Setup' button has been clicked
	if ( isset($_POST['ac_do_basic_setup']) && ($_POST['ac_do_basic_setup'] != '') ) {
		
		// Setup the pages
		ac_activation_setup_pages();
		// Set the permalinks
		ac_activation_setup_permalinks();		
		// Setup the menus
		ac_activation_setup_menus();
		
	}

	// Default Setup
	if ( isset($_POST['default_setup']) && ($_POST['default_setup'] == 1) ) {
		
		// Nothing to actually do...
		
	}

}
add_action('admin_init','roots_theme_activation_action');

// Perform any post theme activation tasks
function ac_after_switch_theme() {

	ac_woocommerce_set_image_sizes();
	
}
add_action( 'after_switch_theme', 'ac_after_switch_theme' );

// Inform the user the import has finished.  Must remain in this file as demo-data-import may not be loaded
function ac_demo_data_finished_msg() {
  ?>
  <div class="updated">
      <p><?php _e( 'Demo Data Imported.', 'alleycat' ); ?></p>
  </div>
  <?php
}
