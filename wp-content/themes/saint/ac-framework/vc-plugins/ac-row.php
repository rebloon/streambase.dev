<?php
/***********************/
/**** Alleycat Row  ****/ 
/***********************/

add_action('init', 'ac_row_init');
function ac_row_init() {
	
	vc_add_param( 'vc_row', array(	
		'type' => 'textfield',
		'heading' => __( 'Row ID', 'alleycat' ),
		'param_name' => 'ac_row_id',
		'description' => __( 'Give a unique ID for the row.  This is used for a One Page menu item, and is also useful for styling the row with CSS.', 'alleycat' ),
	));
	
	vc_add_param( 'vc_row', array(
	  "type" => "dropdown",
	  "heading" => __("Row Width", "alleycat"),
	  "param_name" => "full_width_row",
	  "admin_label" => true,
	  "value" => array(
	  	__("Boxed", "alleycat") => '', 
	  	__("Full Width Background", "alleycat") => "bg",
	  	__("Full Width Content", "alleycat") => "yes"
	  ),
	  "description" => __("Full Width Background extends the background across the entire screen.  Full Width Content extends the content and background across the entire screen.  Note: this only works on Wide Layout, and not Boxed Layout.  Full Width rows only work when the page has no sidebars.", "alleycat"),
		'class' => 'ac_vc_visual_options'  
	));
		
}