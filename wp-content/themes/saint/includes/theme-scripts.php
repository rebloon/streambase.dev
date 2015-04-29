<?php
/******************************************/
/****  Theme Scripts Access and Utils  ****/ 
/******************************************/

// ==  Plugin Active Functions ==
// Visual Composer
function ac_visual_composer_is_installed() {
	return class_exists('WPBakeryShortCode');
}

// Setup the VC
function ac_vc_before_init() {
	vc_set_as_theme(true); // Surpress all messages
}	

// == VC Ultimate Addons ==
function ac_vc_ultimate_addons_is_installed() {
	return class_exists('Ultimate_VC_Addons');
}
// Clear default colours,etc on the controls.  This allows then control to use the theme default
// colours set in the CSS
add_action('admin_init', 'ac_vc_ua_clear_colours', 101);
function ac_vc_ua_clear_colours() {	
	
	if ( (! ac_vc_ultimate_addons_is_installed()) || (! ac_visual_composer_is_installed()) ) {
		return;
	}

	// Flip Box	
	if (class_exists('AIO_Flip_Box')) {		
	  $shortcode = WPBMap::getShortCode('icon_counter'); // Base	  
	  vc_shortcode_clear_colors($shortcode);
    // Unset base
    unset($shortcode['base']); 
    //Update the actual parameter
    vc_map_update('icon_counter', $shortcode);
  }
  
  // Counter
	if (class_exists('AIO_Stats_Counter')) {		
	  $shortcode = WPBMap::getShortCode('stat_counter'); // Base	  
	  vc_shortcode_clear_colors($shortcode);
    // Unset base
    unset($shortcode['base']); 
    //Update the actual parameter
    vc_map_update('stat_counter', $shortcode);
  }  

  // Timeline
	if (class_exists('Ultimate_Icon_Timeline')) {
	  $shortcode = WPBMap::getShortCode('icon_timeline'); // Base	  
	  vc_shortcode_clear_colors($shortcode);
    // Unset base
    unset($shortcode['base']); 
    //Update the actual parameter
    vc_map_update('icon_timeline', $shortcode);
  }  

  // Timeline
	if (class_exists('AIO_Info_list')) {
	  $shortcode = WPBMap::getShortCode('info_list'); // Base	  
	  vc_shortcode_clear_colors($shortcode);
    // Unset base
    unset($shortcode['base']); 
    //Update the actual parameter
    vc_map_update('info_list', $shortcode);
  }  
  
  // Info Box
	if (class_exists('AIO_Icons_Box')) {
	  $shortcode = WPBMap::getShortCode('bsf-info-box'); // Base	  
	  vc_shortcode_clear_colors($shortcode);
    // Unset base
    unset($shortcode['base']); 
    //Update the actual parameter
    vc_map_update('bsf-info-box', $shortcode);
  }  
  
  // Advanced Buttons
	if (class_exists('Ultimate_Buttons')) {  
		$shortcode = WPBMap::getShortCode('ult_buttons'); // Base	  
		vc_shortcode_clear_colors($shortcode);
		// Unset base
		unset($shortcode['base']); 
		//Update the actual parameter
		vc_map_update('ult_buttons', $shortcode);
	}
  
}

// Is MNKY | Visual Composer Pricing Boxes installed?
function ac_vc_mnku_pricing_boxes_is_installed() {
	return function_exists('vcpb_core_extend');
}

// Clear any color field in the given shortcode
function vc_shortcode_clear_colors(&$shortcode) {

	foreach($shortcode['params'] as $key => $param)
	{
		// If the field contains 'color' clear the value
	  if (stripos($param['param_name'], 'color') !== false) {
			$shortcode['params'][$key]['value'] = null;		    
	  }
	} 	 
	
}

// Meta Box
function ac_meta_box_is_installed() {
	return function_exists('rwmb_meta');
}

// == Pretty Photo ===
// Pretty Photo is included with Visual Composer

// Load Pretty Photo
function ac_load_prettyphoto() {

	if ( ac_visual_composer_is_installed() ) {
		// Setup lighbox for images
		wp_enqueue_script( 'prettyphoto' );
		wp_enqueue_style( 'prettyphoto' );		
	}
	
}

// Create and return  unique PrettyPhoto ID for this page load
function ac_get_prettyphoto_rel() {
	global $ac_pretty_photo_rel;
	
	// Create a unique PrettyPhoto ID for this page load
	if (! $ac_pretty_photo_rel) {
		$ac_pretty_photo_rel	= rand();
	}	
	
	return $ac_pretty_photo_rel;
}
// == End / Pretty Photo ===