<?php
/****************************************/
/**** Alleycat Promo Text Block Shortcode  ****/ 
/****************************************/

class WPBakeryShortCode_ac_text_block extends AC_VC_Base {

  protected function content($atts, $content = null) {
  
		$this->content_has_container = false;  

		extract(shortcode_atts(array(
			'title' => '',						
			'image' => '',
			'alignment' => 'left',
			'size' => 'full',
	    'el_class' => '',
			'href' => '',
			'bg_image_style' => 'stretch',
			'css_animation' => '',
			'css' => '',
			'css_extra_class' => '',				
	    ), $atts));
	    
	  $outer_style = '';		    
	  
	  // Add a link if required
	  $link_start = $this->get_link_start($href);
	  $link_end = $this->get_link_end($href);
	  
	  // Alignment
	  $text_align_class = 'text-'.$alignment;
	  		  
	  // Build the CSS
	  $css_class = $this->build_outer_css($atts, $content);	  
		$css_class .= ' bg_'.$bg_image_style;
		
	  // Build the text
	  $text = "<div class='text $text_align_class'><p>" .do_shortcode($content). "</p></div>";
	  
	  //  Background image
		if ($image) {
		  $image_atts = wp_get_attachment_image_src( $image, $size ); 
		  $img_url = $image_atts[0];
		  $outer_style = " background-image: url($img_url); ";
	  }
	  		    		  
	  // Extra CSS
	  $css_class .= ' '.$css_extra_class.' ';
		
		// Build the output
		$output = "\n\t".$this->get_title($title);
		$output .= $link_start;			
		$output .= "\n\t".'<div class="'.esc_attr($css_class).'" style="'.esc_attr($outer_style).'">';
		$output .= "\n\t\t".'<div class="wpb_wrapper">';
		$output .= "\n\t\t\t".__($text, 'alleycat');
		$output .= "\n\t\t".'</div> '.$this->endBlockComment('.wpb_wrapper');
		$output .= "\n\t".'</div> '.$this->endBlockComment($this->settings['base']);
		$output .= $link_end;
	  
	  return $output;
  }

}	

add_action('init', 'ac_text_block_init');
function ac_text_block_init() {

	global $ac_vc_title, 
		$ac_vc_css_animation,
		$ac_vc_css_class,
    $ac_vc_design_options;

	vc_map( array(
	    "base"		=> "ac_text_block",
	    "name"		=> __("AC Promo Text Block", "alleycat"),
	    "class"		=> "ac",
	    "icon"      => "icon-heart",
		  "category" => __("AC", "alleycat"),
	    'description' => __( 'Promo text with background and link', 'alleycat' ),	  
		  "weight" => 60,
	    "params"	=> array(
	    	$ac_vc_title,    
	      array(
	        "type" => "textarea_html",
	        "holder" => "div",
	        "class" => "",
	        "heading" => __("Text", "alleycat"),
	        "param_name" => "content",
	        "value" => __("<h1>Enter your text here</h1>", "alleycat")
	      ),
		    array(
		      "type" => "dropdown",
		      "heading" => __("Text alignment", "alleycat"),
		      "param_name" => "alignment",
		      "value" => array(__("Align left", "alleycat") => "", __("Align right", "alleycat") => "right", __("Align center", "alleycat") => "center")
		    ),	          
		    array(
		      "type" => "attach_image",
		      "heading" => __("Background Image", "alleycat"),
		      "param_name" => "image",
		      "value" => ""
		    ),
		    array(
		      "type" => "dropdown",
		      "heading" => __("Background Image Style", "alleycat"),
		      "param_name" => "bg_image_style",
		      "value" => array(__("Stretch to cover the background", "alleycat") => "stretch", __("Fit in the centre of the box", "alleycat") => "fit")
		    ),
		    array(
		      "type" => "vc_link",
		      "heading" => __("URL (Link)", "alleycat"),
		      "param_name" => "href",
		    ),
				$ac_vc_css_animation,
				$ac_vc_css_class,
		    $ac_vc_design_options	
	    )
	) );

}