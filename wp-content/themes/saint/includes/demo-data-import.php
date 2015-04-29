<?php
/**********************************/
/**** Demo Data Importer ****/
/************************************/

// Imports WP demo data, theme options, widgets, etc.

// Dont allow direct access
if ( !defined('ABSPATH') ) {
	exit;	
}

// Import the demo data
function ac_demo_data_import() {

	global $wpdb;

	// Let WP know we are importing	
	if ( ! defined('WP_LOAD_IMPORTERS') ) 
		define('WP_LOAD_IMPORTERS', true); 
		
	// Import plugin may already be active
	if ( !is_plugin_active( 'wordpress-importer/wordpress-importer.php' ) ) {
		// We need to include WP data import plugin
		if ( ! class_exists( 'WP_Import' ) ) { 
			require_once(	AC_INCLUDES_PATH . '/wordpress-importer/wordpress-importer.php' );
		}	

		// We need to include WP data importer		
		if ( ! class_exists( 'WP_Importer' ) ) { 
			require_once( ABSPATH . 'wp-admin/includes/class-wp-importer.php' );
		}

	} 
	
	// Check we have our Importer
	if ( class_exists( 'WP_Importer' ) && class_exists( 'WP_Import' ) ) { 

		// Create the importer
		$importer = new WP_Import();

		// -- CONTENT --
		// Import WP exported content (posts, pages, menu items, etc).
		$importer->fetch_attachments = true;
		ob_start();
		$importer->import(AC_DD_THEME_XML_PATH);
		ob_end_clean();
		
		// -- MENU ITEMS --
		// Assign the menu to our location
		$locations = get_theme_mod( 'nav_menu_locations' );

		// Get the menus
		$menus = wp_get_nav_menus(); 
		
		// Assign the menu
		if($menus) {
			foreach($menus as $menu) {
				// If it's the main menu assign to the Main Menu
				if ($menu->slug == 'primary') {
					$locations['primary_navigation'] = $menu->term_id;					
				}
			}
		}

		// Store the locations
		set_theme_mod( 'nav_menu_locations', $locations ); 

		// -- THEME OPTIONS --
		$ac_dd_theme_options_txt_path = wp_remote_get( AC_DD_THEME_OPTIONS_TXT_URI );
		$ac_dd_theme_options_txt_path = unserialize( base64_decode( $ac_dd_theme_options_txt_path['body'] ));
		update_option( AC_THEME_NAME.'_options', $ac_dd_theme_options_txt_path );

		// -- WIDGETS --
		ac_data_importer_import_widgets(AC_DD_WIDGETS_PATH);
		
		// -- REV SLIDER --
		$rev_directory = AC_INCLUDES_PATH . '/demo-data/rev_sliders/';
		ac_import_rev_sliders( $rev_directory );
		
		// -- AC Gallery --
		// Remove duplicate Homepage, New Gallery and Trash galleries
		$post = get_page_by_path( 'homepage', OBJECT, 'ac_gallery' );
		wp_delete_post( $post->ID, true ); 
		$post = get_page_by_path( 'New Gallery', OBJECT, 'ac_gallery' );
		wp_delete_post( $post->ID, true ); 
		$post = get_page_by_path( 'trash', OBJECT, 'ac_gallery' );
		wp_delete_post( $post->ID, true ); 

		// Set reading options
		$homepage = get_page_by_title( 'Home' );
		if($homepage->ID) {
			update_option('show_on_front', 'page');
			update_option('page_on_front', $homepage->ID);
		}		
				
		$posts_page = get_page_by_title( 'Blog' ); 
		if($posts_page->ID) {
			update_option('show_on_front', 'page');
			update_option('page_for_posts', $posts_page->ID);
		}		
		
		// Hide Hello World! post
	  $my_post = array(
	      'ID'           => 1,
	      'post_status' => 'draft'
	  );
	  wp_update_post( $my_post );
	  
	  // Store that the import has been run
		update_option( 'ac_demo_data_imported', '1' );
		
		// Hookup message to user
		add_action( 'admin_notices', 'ac_demo_data_finished_msg' );

	}
}


// -- Helper functions --

// Import Widgets
// Courtesy of http://wordpress.org/plugins/widget-importer-exporter/
function ac_data_importer_import_widgets($file) {

	// File exists?
	if ( ! file_exists( $file ) ) {
		wp_die(
			__( 'Import file could not be found: $file', 'alleycat' ),
			'',
			array( 'back_link' => true )
		);
	}

	// Get file contents and decode
	$data = file_get_contents( $file );
	$data = json_decode( $data );

	// Import the widget data
	// Make results available for display on import/export page
	$ac_wie_import_results = ac_wie_import_data( $data );
}


function ac_wie_available_widgets() {

	global $wp_registered_widget_controls;

	$widget_controls = $wp_registered_widget_controls;

	$available_widgets = array();

	foreach ( $widget_controls as $widget ) {

		if ( ! empty( $widget['id_base'] ) && ! isset( $available_widgets[$widget['id_base']] ) ) { // no dupes

			$available_widgets[$widget['id_base']]['id_base'] = $widget['id_base'];
			$available_widgets[$widget['id_base']]['name'] = $widget['name'];

		}
		
	}

	return apply_filters( 'ac_wie_available_widgets', $available_widgets );

}

function ac_wie_import_data( $data ) {

	global $wp_registered_sidebars;

	// Have valid data?
	// If no data or could not decode
	if ( empty( $data ) || ! is_object( $data ) ) {
		wp_die(
			__( 'Import data could not be read. Please try a different file.', 'alleycat' ),
			'',
			array( 'back_link' => true )
		);
	}

	// Hook before import
	do_action( 'ac_wie_before_import' );
	$data = apply_filters( 'ac_wie_import_data', $data );

	// Get all available widgets site supports
	$available_widgets = ac_wie_available_widgets();

	// Get all existing widget instances
	$widget_instances = array();
	foreach ( $available_widgets as $widget_data ) {
		$widget_instances[$widget_data['id_base']] = get_option( 'widget_' . $widget_data['id_base'] );
	}

	// Begin results
	$results = array();

	// Loop import data's sidebars
	foreach ( $data as $sidebar_id => $widgets ) {

		// Skip inactive widgets
		// (should not be in export file)
		if ( 'wp_inactive_widgets' == $sidebar_id ) {
			continue;
		}

		// Check if sidebar is available on this site
		// Otherwise add widgets to inactive, and say so
		if ( isset( $wp_registered_sidebars[$sidebar_id] ) ) {
			$sidebar_available = true;
			$use_sidebar_id = $sidebar_id;
			$sidebar_message_type = 'success';
			$sidebar_message = '';
		} else {
			$sidebar_available = false;
			$use_sidebar_id = 'wp_inactive_widgets'; // add to inactive if sidebar does not exist in theme
			$sidebar_message_type = 'error';
			$sidebar_message = __( 'Sidebar does not exist in theme (using Inactive)', 'alleycat' );
		}

		// Result for sidebar
		$results[$sidebar_id]['name'] = ! empty( $wp_registered_sidebars[$sidebar_id]['name'] ) ? $wp_registered_sidebars[$sidebar_id]['name'] : $sidebar_id; // sidebar name if theme supports it; otherwise ID
		$results[$sidebar_id]['message_type'] = $sidebar_message_type;
		$results[$sidebar_id]['message'] = $sidebar_message;
		$results[$sidebar_id]['widgets'] = array();

		// Loop widgets
		foreach ( $widgets as $widget_instance_id => $widget ) {

			$fail = false;

			// Get id_base (remove -# from end) and instance ID number
			$id_base = preg_replace( '/-[0-9]+$/', '', $widget_instance_id );
			$instance_id_number = str_replace( $id_base . '-', '', $widget_instance_id );

			// Does site support this widget?
			if ( ! $fail && ! isset( $available_widgets[$id_base] ) ) {
				$fail = true;
				$widget_message_type = 'error';
				$widget_message = __( 'Site does not support widget', 'alleycat' ); // explain why widget not imported
			}

			// Filter to modify settings before import
			// Do before identical check because changes may make it identical to end result (such as URL replacements)
			$widget = apply_filters( 'ac_wie_widget_settings', $widget );

			// Does widget with identical settings already exist in same sidebar?
			if ( ! $fail && isset( $widget_instances[$id_base] ) ) {

				// Get existing widgets in this sidebar
				$sidebars_widgets = get_option( 'sidebars_widgets' );
				$sidebar_widgets = isset( $sidebars_widgets[$use_sidebar_id] ) ? $sidebars_widgets[$use_sidebar_id] : array(); // check Inactive if that's where will go

				// Loop widgets with ID base
				$single_widget_instances = ! empty( $widget_instances[$id_base] ) ? $widget_instances[$id_base] : array();
				foreach ( $single_widget_instances as $check_id => $check_widget ) {

					// Is widget in same sidebar and has identical settings?
					if ( in_array( "$id_base-$check_id", $sidebar_widgets ) && (array) $widget == $check_widget ) {

						$fail = true;
						$widget_message_type = 'warning';
						$widget_message = __( 'Widget already exists', 'alleycat' ); // explain why widget not imported

						break;

					}
	
				}

			}

			// No failure
			if ( ! $fail ) {

				// Add widget instance
				$single_widget_instances = get_option( 'widget_' . $id_base ); // all instances for that widget ID base, get fresh every time
				$single_widget_instances = ! empty( $single_widget_instances ) ? $single_widget_instances : array( '_multiwidget' => 1 ); // start fresh if have to
				$single_widget_instances[] = (array) $widget; // add it

					// Get the key it was given
					end( $single_widget_instances );
					$new_instance_id_number = key( $single_widget_instances );

					// If key is 0, make it 1
					// When 0, an issue can occur where adding a widget causes data from other widget to load, and the widget doesn't stick (reload wipes it)
					if ( '0' === strval( $new_instance_id_number ) ) {
						$new_instance_id_number = 1;
						$single_widget_instances[$new_instance_id_number] = $single_widget_instances[0];
						unset( $single_widget_instances[0] );
					}

					// Move _multiwidget to end of array for uniformity
					if ( isset( $single_widget_instances['_multiwidget'] ) ) {
						$multiwidget = $single_widget_instances['_multiwidget'];
						unset( $single_widget_instances['_multiwidget'] );
						$single_widget_instances['_multiwidget'] = $multiwidget;
					}

					// Update option with new widget
					update_option( 'widget_' . $id_base, $single_widget_instances );

				// Assign widget instance to sidebar
				$sidebars_widgets = get_option( 'sidebars_widgets' ); // which sidebars have which widgets, get fresh every time
				$new_instance_id = $id_base . '-' . $new_instance_id_number; // use ID number from new widget instance
				$sidebars_widgets[$use_sidebar_id][] = $new_instance_id; // add new instance to sidebar
				update_option( 'sidebars_widgets', $sidebars_widgets ); // save the amended data

				// Success message
				if ( $sidebar_available ) {
					$widget_message_type = 'success';
					$widget_message = __( 'Imported', 'alleycat' );
				} else {
					$widget_message_type = 'warning';
					$widget_message = __( 'Imported to Inactive', 'alleycat' );
				}

			}

			// Result for widget instance
			$results[$sidebar_id]['widgets'][$widget_instance_id]['name'] = isset( $available_widgets[$id_base]['name'] ) ? $available_widgets[$id_base]['name'] : $id_base; // widget name or ID if name not available (not supported by site)
			$results[$sidebar_id]['widgets'][$widget_instance_id]['title'] = $widget->title ? $widget->title : __( 'No Title', 'alleycat' ); // show "No Title" if widget instance is untitled
			$results[$sidebar_id]['widgets'][$widget_instance_id]['message_type'] = $widget_message_type;
			$results[$sidebar_id]['widgets'][$widget_instance_id]['message'] = $widget_message;

		}

	}

	// Hook after import
	do_action( 'ac_wie_after_import' );

	// Return results
	return apply_filters( 'ac_wie_import_results', $results );

}
