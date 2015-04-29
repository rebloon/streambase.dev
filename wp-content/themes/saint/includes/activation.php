<?php
/**********************/
/****  Activation  ****/ 
/**********************/

// Setup menus
function ac_activation_setup_menus() {
	
	// Create the menu
	$roots_nav_theme_mod = false;
	
	$primary_nav = wp_get_nav_menu_object('Primary Navigation');
	
	if (!$primary_nav) {
	  $primary_nav_id = wp_create_nav_menu('Primary Navigation', array('slug' => 'primary_navigation'));
	  $roots_nav_theme_mod['primary_navigation'] = $primary_nav_id;
	} else {
	  $roots_nav_theme_mod['primary_navigation'] = $primary_nav->term_id;
	}
	
	if ($roots_nav_theme_mod) {
	  set_theme_mod('nav_menu_locations', $roots_nav_theme_mod);
	}
	
	// Add the pages to the menu
	$primary_nav = wp_get_nav_menu_object('Primary Navigation');
	$primary_nav_term_id = (int) $primary_nav->term_id;
	$menu_items= wp_get_nav_menu_items($primary_nav_term_id);
	
	if (!$menu_items || empty($menu_items)) {
	  $pages = get_pages();
	  foreach($pages as $page) {
	    $item = array(
	      'menu-item-object-id' => $page->ID,
	      'menu-item-object' => 'page',
	      'menu-item-type' => 'post_type',
	      'menu-item-status' => 'publish'
	    );
	    wp_update_nav_menu_item($primary_nav_term_id, 0, $item);
	  }
	}
	
}

// Setup the permalink
function ac_activation_setup_permalinks() {
	if (get_option('permalink_structure') !== '/%postname%/') {
	  global $wp_rewrite;
	  $wp_rewrite->set_permalink_structure('/%postname%/');
	  flush_rewrite_rules();
	}
}

// Setup the pages
function ac_activation_setup_pages() {

	// -- Create the Homepage page --
	$homepage = array(
		'post_title' => 'Home',
		'post_content' => '',
		'post_excerpt' => '',
		'post_status' => 'publish',
		'post_type' => 'page',
		'menu_order' => '0',
	);
	$homepage_id  = wp_insert_post( $homepage );
	
	// Blog page
	$blog = array(
		'post_title' => 'Blog',
		'post_content' => '',
		'post_excerpt' => '',
		'post_status' => 'publish',
		'post_type' => 'page',
		'menu_order' => '0',
	);
	$blog_id  = wp_insert_post( $blog );
	
	// -- WP settings --
	// Homepage
	update_option('page_on_front', $homepage_id);
	// Blog Page
	update_option('page_for_posts', $blog_id); 
	// Homepage as Frontpage
	update_option('show_on_front', 'page'); 
		
}


// WooCommerce Activation
function woocommerce_activate() {

	// Set the WooCommerce image sizes
  ac_woocommerce_set_image_sizes();
  
}
register_activation_hook(WP_PLUGIN_DIR . '/woocommerce/woocommerce.php', 'woocommerce_activate' );

// Returns whether Contact Form 7 is installed
function ac_cf7_is_installed() {
	return defined( 'WPCF7_VERSION' );
}

// Useful method for displaying pluin status/installing plugins
function ac_activation_get_plugin_status($is_installed) {
	if ($is_installed) {
		return " - <span class='installed'>Installed</span>";
	}
	else {
		return " - <span class='not-installed'>Not installed</span>";
	}
}

