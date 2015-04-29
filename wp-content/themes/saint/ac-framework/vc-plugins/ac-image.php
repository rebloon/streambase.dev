<?php
/***********************************/
/**** Alleycat Image Shortcode  ****/ 
/***********************************/

global $ac_vc_title, 
	$ac_vc_css_animation,
	$ac_vc_design_options;

class WPBakeryShortCode_ac_image extends AC_VC_Base {

  protected function content($atts, $content = null) {
  
  	global $ac_is_mobile;
  
		$this->content_has_container = false;  
  
		extract(shortcode_atts(array(
			'title' => '',
			'image' => '',
			'alignment' => 'left',
			'size' => 'full',
			'parallax' => 'no',
			'parallax_image_height' => '',
			'parallax_image_speed' => '',
			'block_height' => '',
			'text_bg_color' => '',
			'el_class' => '',			
			'href' => '',
			'css_animation' => '',
			'css' => '',
			'css_extra_class' => '',
			'image_click' => 'lightbox'		
	    ), $atts));
	       
	  $outer_style = '';		    
	  	  
	  // Always center align for mobile
	  if ($ac_is_mobile) {
		  $alignment = 'center';
	  }
	  
	  // Alignments
	  $align_class = 'align'.$alignment;
	  $text_align_class = 'text-'.$alignment;
	  
	  // Add centre class if necessary
	  if ($alignment == 'center') {
			$align_class .= " ac-centre-horizontally";  
	  }
	  
	  // Add valign class, dont for parallax
	  if ($parallax && 0) {
		  $valign_class = '';
	  }
	  else {
		  $valign_class = ' ac-center-vertically ';		  
	  }
	  
	  // Build the CSS
	  // Clear the css_animation on the $atts, as css animation is applied later for images only
	  $atts['css_animation'] = '';
	  $css_class = $this->build_outer_css($atts, $content);	  
		$css_class .= ' vc_align_'.$alignment;
		
	  // Build the text
	  $text = '';
	  
	  // Text style
	  $text_style = "";
	  if ($text_bg_color) {
			$text_style = " background-color: $text_bg_color ";
	  }
	  if ($text_style) {
		  $text_style = " style='$text_style' ";
	  }
	  
	  // If fix the content
	  $content = $this->fixPContent($content);

	  // An empty text area leaves H1 tags, so check the content with stripped tags
	  if ( trim(strip_tags($content)) ) {
		  $text = "<div class='text $valign_class $align_class'><div class='inner $align_class $text_align_class' $text_style>" .__($content, 'alleycat'). "</div></div>";		  
	  }
	    
	  // Block height
	  $block_height = floatval($block_height);
	  if ($block_height) {
		  
		  // If block height is set we have a special case.  
			$css_class .= ' ac-block-height-yes ';
		  $outer_style .= " height: ".$block_height."px; ";
		  
	  }
	  else {
			$css_class .= ' ac-block-height-no ';
	  }
	  
	  //  Build the image
	  if ( ($parallax == 'yes') || $block_height ) {
	  
	  	// Parallax image
		  $image_atts = ac_resize_image_for_columns( array('image_id' => $image, 'columns' => 12) );
		  $img_url = $image_atts['url'];
		  $css_class .= ' ac-parallax ';
	
			// Add parallax speed class if selected	  
		  if ($parallax_image_speed) {
			  $css_class .= ' parallax_image_speed-'.$parallax_image_speed.' ';			  
		  }

		  $outer_style .= " background-image: url($img_url); ";
		  $img = '';
		  
		  // Check for image height
		  if ($parallax_image_height == 'window') {
				$css_class .= ' ac-window-height ';
		  }
		  
			// If this isn't parallax (i.e. normal image) set the speed to full
			if ( ($parallax == 'no') ) {
				$css_class .= ' parallax_image_speed-full parallaxing-when-not ';
			}
		  
	  }
	  else {
	  	// Standard image
	  	// Render the full image html for inclusion
			$img = ac_render_image_for_columns( array('image_id' => $image, 'columns' => 12) ); 
			$css_class .= $this->getCSSAnimation($css_animation); // Animation on img only (not parallax)
	  }		  
	  
	  // Add a link if required
	  switch ($image_click) {
		  case 'lightbox' : 
			  $lb_img = ac_resize_image_for_columns( array('image_id' => $image, 'columns' => 12) );		  
				$link_start = '<a class="prettyphoto" href="'.esc_url($lb_img['url']).'" rel="prettyPhoto[rel-'.ac_get_prettyphoto_rel().']"><div>';
    		$link_end = '</div></a>';		  
		  	break;
		  case 'url' :
			  $link_start = $this->get_link_start($href);
			  $link_end = $this->get_link_end($href);		  
		  	break;
		  default :
			  $link_start = '';
			  $link_end = '';
	  }	  
	  	  
	  // Extra CSS
	  $css_class .= ' '.$css_extra_class.' ';
		
		// Build the output
		$output = '';
		$output .= "\n\t".$this->get_title($title);		// Title goes outside main div for parallax compliance
		$output .= $link_start;
		$output .= "\n\t".'<div class="'.esc_attr($css_class).'" style="'.esc_attr($outer_style).'">';
		$output .= "\n\t\t".'<div class="wpb_wrapper">';
		$output .= "\n\t\t\t".$img.$text;
		$output .= "\n\t\t".'</div> '.$this->endBlockComment('.wpb_wrapper');
		$output .= "\n\t".'</div> '.$this->endBlockComment('.ac_image');
		$output .= $link_end;
	  
	  return $output;
  }
  
}	

vc_map( array(
    "base"		=> "ac_image",
    "name"		=> __("AC Image", "alleycat"),
    "class"		=> "ac",
    "icon"      => "icon-heart",
	  "category" => __("AC", "alleycat"),
    'description' => __( 'Full width images with title and text overlay', 'alleycat' ),	  
//    'description' => __( 'Full width images with parallax and title option', 'alleycat' ),	  
	  "weight" => 61,
    "params"	=> array(
    	$ac_vc_title,
	    array(
	      "type" => "attach_image",
	      "heading" => __("Image", "alleycat"),
	      "param_name" => "image",
	      "value" => ""
	    ),
	    /*
	    array(
	      "type" => "dropdown",
	      "heading" => __("Parallax", "alleycat"),
	      "param_name" => "parallax",
	      "value" => array(__("No", "alleycat") => "", __("Yes", "alleycat") => "yes" )
	    ),
	    array(
	      "type" => "dropdown",
	      "heading" => __("Parallax Image Size", "alleycat"),
	      "param_name" => "parallax_image_height",
	      "value" => array(__("Fit to Block", "alleycat") => "", __("Fit to Window", "alleycat") => "window" ),
	      "description" => __("Fit to Block generally looks better, but use Fit to Window if the image seems too small.", "alleycat"),
				"dependency" => Array('element' => "parallax", 'value' => array('yes')),
	    ),
	    array(
	      "type" => "dropdown",
	      "heading" => __("Parallax Scroll", "alleycat"),
	      "param_name" => "parallax_image_speed",
	      "value" => array(
	      	__("Fixed", "alleycat") => "",
	      	__("Slow", "alleycat") => "slow", 
//	      	__("Medium", "alleycat") => "medium",
//	      	__("Fast", "alleycat") => "fast"
	      ),
//	      "description" => __("", "alleycat"),
				"dependency" => Array('element' => "parallax", 'value' => array('yes')),	      
	    ),*/	
	    array(
	      "type" => "dropdown",
	      "heading" => __("What should happen when you click the image?", "alleycat"),
	      "param_name" => "image_click",
	      "value" => array(
	      	__("Open the image in a lightbox", "alleycat") => "lightbox",
	      	__("Visit a URL", "alleycat") => "url", 
	      	__("Nothing", "alleycat") => "nothing", 
	      ),
	    ),
	    array(
	      "type" => "vc_link",
	      "heading" => __("URL (Link)", "alleycat"),
	      "param_name" => "href",
	      "description" => __("Enter a URL to link this image to a webpage.", "alleycat"),
				"dependency" => Array('element' => "image_click", 'value' => array('url')),	      
	    ),
	    array(
	      "type" => "textfield",
	      "heading" => __("Image Height", "alleycat"),
	      "param_name" => "block_height",
	      "value" => "",
	      "description" => __("Set an optional value to override the image height.  Set the value in pixels.  (e.g. 300)", "alleycat")
	    ),		
	    array(
	      "type" => "dropdown",
	      "heading" => __("Include a Text overlay?", "alleycat"),
	      "param_name" => "include_text",
	      "value" => array(
	      	__("No", "alleycat") => "",
	      	__("Yes", "alleycat") => "true",
	      )
	    ),	    		    	        	    	    
      array(
        "type" => "textarea_html",
//          "holder" => "div",
        "class" => "",
        "heading" => __("Text", "alleycat"),
        "param_name" => "content",
        "value" => __("", "alleycat"),
				"dependency" => Array('element' => "include_text", 'value' => array('true')),     
      ),
			array(
	      "type" => "colorpicker",
	      "heading" => __("Text Background Color", "alleycat"),
	      "param_name" => "text_bg_color",
	      "value" => '#ffffff',
				"dependency" => Array('element' => "include_text", 'value' => array('true')),	      
			),	                
	    array(
	      "type" => "dropdown",
	      "heading" => __("Text Alignment", "alleycat"),
	      "param_name" => "alignment",
	      "value" => array(
	      	__("Align left", "alleycat") => "", 
	      	__("Align right", "alleycat") => "right", 
	      	__("Align center", "alleycat") => "center"
	      ),
				"dependency" => Array('element' => "include_text", 'value' => array('true')),	      
	    ),	    
			$ac_vc_css_animation,
			$ac_vc_css_class,
			$ac_vc_design_options
    )
) );