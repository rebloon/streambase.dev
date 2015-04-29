<?php
/************************************/
/**** Alleycat Button Shortcode  ****/ 
/************************************/

class WPBakeryShortCode_ac_vc_button extends AC_VC_Base {

  protected function content($atts, $content = null) {
  
		$this->content_has_container = false;
    
		extract(shortcode_atts(array(
			'title' => '',
			'href' => '',		
			'target' => '',
			'color_type' => '',
			'font_size' => '',
			'button_color' => '',
			'button_text_color' => '',
			'knockout_color' => '',
			'color' => '',
			'el_class' => '',			
			'icon' => '',
			'icon_position' => '',
			'icon_color_type' => '',
			'icon_color' => '',
			'css_animation' => '',
	    'css' => '',
			'css_extra_class' => '',				
	    ), $atts));
	      
		$btn_style = '';
	  
	  // Add a link if required
	  $link_start = $this->get_link_start($href);
	  $link_end = $this->get_link_end($href);
	  	  	  
	  // Build the CSS
	  $css_class = $this->build_outer_css($atts, $content);
		
		// Colours
		if ($color_type == '') { // default
			$css_class .= ' btn btn-default ';
		}
		else if ($color_type == 'button') {
			$css_class .= ' btn btn-primary ';
		}
		else if ($color_type == 'primary') {
			$css_class .= ' btn ';
			$btn_style = ' background-color:'.shoestrap_getVariable('color_brand_primary');
		}
		else if ($color_type == 'knockout') {
			$css_class .= ' btn btn-knockout ';
			
			if ($knockout_color) {
				$btn_style = 'border-color:'.$knockout_color.'; color:'.$knockout_color.';';
			}
		}
		else if ($color_type == 'knockout-light') {
			$css_class .= ' btn btn-knockout-light ';
		}
		else if ($color_type == 'knockout-dark') {
			$css_class .= ' btn btn-knockout-dark ';
		}
		else if ($color_type == 'custom') {
			$css_class .= ' btn btn-custom';
			
			if ($button_color) {
				$btn_style = ' background-color:'.$button_color.';';
			}

			if ($button_text_color) {			
				$btn_style .= ' color:'.$button_text_color.';';
			}
		}
		
		// Font si
		if ($font_size) {
			$btn_style = 'font-size:'.$font_size.'px;';
		}

			  
	  // Extra CSS
	  $css_class .= ' '.$css_extra_class.' ';
	  
	  // Prepare the style
	  if ($btn_style) {
		  $btn_style = " style='$btn_style' ";
	  }
	 
	  // -- Icon --
		$icon_style = '';	  
		$icon_class = '';
		if ($icon) {
			$icon_class = 'fa fa-'.$icon.' ';			
		}		

		// Colour
		if ($icon_color_type == 'primary') {
			// Get theme primary colour
			$icon_style = ' color:'.shoestrap_getVariable('color_brand_primary').';';
		}
		else {
			$icon_style = ' color:'.$icon_color.';';
		}		

		$icon_align = 'align'.$icon_position;
		$icon_html = '<i class=" smicon-box-icon '.$icon_class.' '.$icon_align.'" style="'.$icon_style.'"></i>';		
				
		// Build the output
		$output = '';

		// Different output with anchor for HTML5 compliance
		if ( $link_start == '' ) {
	    $output .= '<button class="'.$css_class.'" '.$btn_style.'>'.__($title, 'alleycat').$icon_html.'</button>';
		} 
		else 
		{
	    $output .= '<span class="'.$css_class.'" '.$btn_style.'>'.__($title, 'alleycat').$icon_html.'</span>';
	    $output = $link_start.$output.$link_end;
		}
	  
	  return $output;
  }

}

add_action('init', 'ac_vc_button_init');
function ac_vc_button_init() {

	global $ac_vc_title, 
		$ac_vc_css_animation,
		$ac_vc_css_class,
    $ac_vc_design_options;
		
	// Build the array, and map later
	$ac_vc_button = array(
	  "base"		=> "ac_vc_button",
	  "name"		=> __("AC Icon Button", "alleycat"),
    "class"		=> "ac",
	  "icon"      => "icon-heart",
    'description' => __( 'Eye catching button with optional icons ', 'alleycat' ),	  
	  "category" => __("AC", "alleycat"),
	  "weight" => 58,        
	  "params"	=> array(
	    array(
	      "type" => "textfield",
	      "heading" => __("Button Text", "alleycat"),
	      "param_name" => "title",
	      "value" => "",
	    ),
	    array(
	      "type" => "vc_link",
	      "heading" => __("Link", "alleycat"),
	      "param_name" => "href",
	      "value" => "",
	    ),			
	    array(
	      "type" => "dropdown",
	      "heading" => __("Link Target", "alleycat"),
	      "param_name" => "target",
	      "value" => array(
	      	__("Same Window", "alleycat") => "", 
	      	__("New Window", "alleycat") => "_blank" )
	    ),
	    array(
				"type" => "number",
				"class" => "",
				"heading" => __("Font Size", "alleycat"),
				"param_name" => "font_size",
				"value" => 20,
				"min" => 10,
				"max" => 100,
				"suffix" => "px",
			),
	    array(
	      "type" => "dropdown",
	      "heading" => __("Button Color", "alleycat"),
	      "param_name" => "color_type",
	      "value" => array(
	      	__("Default", "alleycat") => "",
	      	__("Button", "alleycat") => "button",
	      	__("Primary", "alleycat") => "primary",
	      	__("Knockout", "alleycat") => "knockout",
	      	__("Knockout Light", "alleycat") => "knockout-light",
	      	__("Knockout Dark", "alleycat") => "knockout-dark",
	      	__("Custom", "alleycat") => "custom"
	      )
	    ),
			array(
	      "type" => "colorpicker",
	      "heading" => __("Knockout Color", "alleycat"),
	      "param_name" => "knockout_color",
				"dependency" => array('element' => "color_type", 'value' => array('knockout')),
	      "value" => "#000",
			),	          	    
			array(
	      "type" => "colorpicker",
	      "heading" => __("Button Background Color", "alleycat"),
	      "param_name" => "button_color",
				"dependency" => array('element' => "color_type", 'value' => array('custom')),
	      "value" => "#000",
			),	          	    
			array(
	      "type" => "colorpicker",
	      "heading" => __("Button Text Color", "alleycat"),
	      "param_name" => "button_text_color",
				"dependency" => array('element' => "color_type", 'value' => array('custom')),
	      "value" => "#fff",				
			),
		)
	);

	//
	//  Icon Box
	//=====================================================
	
	// Check if Icon Box installed and use resources if so
	$icon_box_is_active = is_plugin_active("vc-icon-box/vc-icon-box.php");

	// If the Icon Box is active add it to the button array	
	if ($icon_box_is_active) {
	
		$ac_vc_button['params'][] = array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Icon to display:", "alleycat"),
				"param_name" => "icon_type",
				"value" => array(
					"Font Awesome Icon" => "font-awesome",
					"Custom Image Icon" => "custom",
				),
				"description" => __("Select which icon you would like to use", "alleycat")
			);
			
		$ac_vc_button['params'][] = array(
				"type" => "icon",
				"class" => "",
				"heading" => __("Select Icon", "alleycat"),
				"param_name" => "icon",
				"admin_label" => true,
				"value" => "",
				"description" => __("Select an icon to include with the button.", "alleycat"),
				"dependency" => Array("element" => "icon_type","value" => array("font-awesome")),
			);
	
			$ac_vc_button['params'][] = array(
				"type" => "attach_image",
				"class" => "",
				"heading" => __("Upload Image Icon:", "alleycat"),
				"param_name" => "icon_img",
				"admin_label" => true,
				"value" => "",
				"description" => __("Upload the custom image icon.", "alleycat"),
				"dependency" => Array("element" => "icon_type","value" => array("custom")),
			);
		
			$ac_vc_button['params'][] = array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Icon Color", "alleycat"),
				"param_name" => "icon_color_type",
				"value" => array(
					"Primary Color" => "primary",
					"Custom Color" => "custom",
				),
			);
			
			$ac_vc_button['params'][] = array(
				"type" => "colorpicker",
				"class" => "",
				"heading" => __("Select Icon Color", "alleycat"),
				"param_name" => "icon_color",
				"value" => "#000000",
				"dependency" => array(
								"element" => "icon_color_type",
								"value" => array('custom'),
							),
			);
			
			$ac_vc_button['params'][] = array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Icon Border:", "alleycat"),
				"param_name" => "border",
				"value" => array(
					"No Border" => "",
					"Square Border" => "square",
					"Square Border With Background" => "square-solid",
					"Circle Border" => "circle",
					"Circle Border With Background" => "circle-solid",
				),
				"description" => __("Select if you want to display border around icon.", "alleycat")
			);
			
			$ac_vc_button['params'][] = array(
				"type" => "number",
				"class" => "",
				"heading" => __("Icon Border Spacing", "alleycat"),
				"param_name" => "padding",
				"value" => 5,
				"min" => 0,
				"max" => 20,
				"suffix" => "px",
				"description" => __("Select spacing between icon and border.", "alleycat"),
				"dependency" => array(
								"element" => "border",
								"not_empty" => true,
							),
			);
			
			$ac_vc_button['params'][] = array(
				"type" => "number",
				"class" => "",
				"heading" => __("Icon Border Width", "alleycat"),
				"param_name" => "width",
				"value" => "",
				"min" => 1,
				"max" => 10,
				"suffix" => "px",
				"description" => __("Select border width for icon.", "alleycat"),
				"dependency" => array(
								"element" => "border",
								"not_empty" => true,
							),
			);
			
			$ac_vc_button['params'][] = array(
				"type" => "colorpicker",
				"class" => "",
				"heading" => __("Icon Border Color:", "alleycat"),
				"param_name" => "icon_border_color",
				"value" => "",
				"description" => __("Select the color for icon border.", "alleycat"),
				"dependency" => array(
								"element" => "border",
								"not_empty" => true,
							),
			);
			
			$ac_vc_button['params'][] = array(
				"type" => "colorpicker",
				"class" => "",
				"heading" => __("Icon Background Color:", "alleycat"),
				"param_name" => "icon_bg_color",
				"value" => "",
				"description" => __("Select the color for icon background.", "alleycat"),
				"dependency" => array(
								"element" => "border",
								"not_empty" => true,
							),
			);
						
			$ac_vc_button['params'][] = array(
				"type" => "dropdown",
				"class" => "",
				"heading" => __("Icon Position", "alleycat"),
				"param_name" => "icon_position",
				"value" => array(
					"Right of the text" => "right",			
					"Left of the text" => "left",
				),
			);
	} // icon box is active
	
	// CSS, etc.
	$ac_vc_button['params'][]	= $ac_vc_css_animation;
	$ac_vc_button['params'][]	= $ac_vc_css_class;
	$ac_vc_button['params'][]	= $ac_vc_design_options;
	
	vc_map( $ac_vc_button );
	
} // ac_vc_button_init