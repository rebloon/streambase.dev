<?php

if ( !function_exists( 'ac_page_title_header_class' ) ) :
// Gets the page title class for the post
function ac_page_title_header_class( $post = 0 ) {

	// Not needed at present 
	// $post = get_post( $post );
	
	$css_classes = '';
	
	// Get page title type
	$page_title_type = ac_get_meta('page_title_type');	
	if ($page_title_type == 'custom') {
		$css_classes .= ' ac-page-title-custom ';
	}

	// Include container class for fixed/boxed
	return ' ac-page-title ' .$css_classes.shoestrap_outer_container_class('page-title') . ' ' .ac_get_hide_until_fade_class();

}
endif;

if ( !function_exists( 'ac_page_title_header_style' ) ) :
// Gets the page title style for the post
function ac_page_title_header_style( $post = 0 ) {

	global $ac_full_width_pixels;

	$post = get_post( $post );
	
	// Only return style for custom header
	$page_title_type = ac_get_meta('page_title_type');
	if ($page_title_type == 'custom') {

		$bg_color = ac_get_meta('page_title_bg_color');
		if ($bg_color) {
			$bg_color = 'background-color: '.$bg_color.'; ';
		}
	
		$bg_img = ac_get_meta('page_title_image', array('type' => 'image_advanced') );
		$bg_img_style = '';
		if ($bg_img) {
			$bg_img = $bg_img[key($bg_img)];
	
			// Resize to max allowed for site
			$img_args = array(
				'image_id' 	=>	$bg_img['ID'],
				'width' 		=> ac_get_full_width_px(),
				'height' 		=> 600,
			);
			$image = ac_resize_image( $img_args );
			$bg_img_style = 'background-image: url('.$image['url'].'); ';
		}
		
		return $bg_color . $bg_img_style;
		
	}
	
	return '';

}
endif;