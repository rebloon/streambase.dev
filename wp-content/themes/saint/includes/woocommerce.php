<?php
/***********************/
/****  WooCommerce  ****/ 
/***********************/

// Add WC support
add_theme_support( 'woocommerce' );

// Override the WooCommerce page title
add_filter('woocommerce_show_page_title', 'ac_woocommerce_show_page_title');
function ac_woocommerce_show_page_title() {

	// Don't show the title in the WooCommerce pages as we have our own header for that
	return false;
}

// Returns if WooCommerce is active
function ac_woocommerce_is_active() {
	return (class_exists('WooCommerce'));
}

// Set the image sizes for the WooCommerce images
// This may be done at theme activation (if WooCommerce plugin is already active) or on WooCommerce plugin activation
function ac_woocommerce_set_image_sizes() {

	// Only do this if WooCommerce is active
	if ( ac_woocommerce_is_active() ) {
		
		// Don't do if done before
		$ac_wc_images_sizes_set = get_option( 'ac_wc_images_sizes_set' );
		if ( $ac_wc_images_sizes_set !== '1' ) {
		
			// Update the values
			update_option( 'shop_catalog_image_size', array(
				'width' 	=> '768',
				'height'	=> '512',
				'crop'		=> true
			));
			update_option( 'shop_single_image_size', array(
				'width' 	=> '768',
				'height'	=> '768',
				'crop'		=> false
			));
			update_option( 'shop_thumbnail_image_size',	 array(
				'width' 	=> '90',
				'height'	=> '90',
				'crop'		=> true
			));
		
			// Set that this has been done
			update_option( 'ac_wc_images_sizes_set', '1' );
		}
		
	}
}

// Add social sharing, etc to the WooCommerce product via filters
add_action( 'woocommerce_after_single_product_summary', 'ac_social_sharing', 20);

// Redefine woocommerce_output_related_products()
function woocommerce_output_related_products() {

	// Build the args
	$args = array(
		'posts_per_page' => 4,
		'columns'        => 4
	);

	// Update settings
	woocommerce_related_products($args);
}

if ( !function_exists( 'ac_woocommerce_loop_shop_columns' ) ) :
// Override theme default specification for product # per row
function ac_woocommerce_loop_shop_columns() {
	
	// Get CP value
	$cols = shoestrap_getVariable( 'wc_shop_cols' );
	if (!$cols) {
		$cols = 4;
	}

	return $cols;
}
endif;
add_filter('loop_shop_columns', 'ac_woocommerce_loop_shop_columns', 999);

// Add inline styles
function ac_woocommerce_add_inline_styles() {
	
	// Get the columns
	$cols = apply_filters('loop_shop_columns', '');
	
	// Calc the width
	if ($cols == 0) { // Fallback
		$width = '25%';
	}
	else {
		// Width based on columns
		$width = floor(100/$cols);
		$width = $width.'%';
	}
		
	$style = "
		.archive.woocommerce ul.products li.product, .archive.woocommerce-page ul.products li.product {
			width: ".$width.";
		}
	";

  wp_add_inline_style( 'ac-theme', $style );
}