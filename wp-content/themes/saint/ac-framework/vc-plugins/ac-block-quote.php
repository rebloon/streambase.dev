<?php
/*****************************************/
/**** Alleycat Block Quote Shortcode  ****/ 
/*****************************************/

class WPBakeryShortCode_ac_block_quote extends AC_VC_Base {

  protected function content($atts, $content = null) {
  
			$this->content_has_container = false;  

			extract(shortcode_atts(array(
				'title' => '',			
		    'el_class' => '',
		    'author' => '',
		    'author_url' => '',
				'image' => '',
				'image_caption' => '',
				'alignment' => 'left',
				'img_border_shape' => '',
				'bg_color' => '',
				'css_animation' => '',
		    'css' => '',
				'css_extra_class' => '',				
		    ), $atts));
		    		  	  
		  // Get the anchor link
		  $link_start = $this->get_link_start($author_url);
		  $link_end = $this->get_link_end($author_url);
		  		  		  
		  // Build the CSS
			$css_class = $this->build_outer_css($atts, $content);
			
			// Ensure there is a <p> tag on the author
			if ($author) {
				$author = "<p>".$author."</p>";
			}
			
			// Get the link url
		  $author_url = $this->get_link_url($author_url);
		  
		  // Wrap the content
		  $content = "<p>".$content."</p>";
			
			// Get the quote html
			$text = ac_quote_render($image, $content, $author, '', $img_border_shape, $image_caption, $alignment, $bg_color);
			
		  		  		  		  		  
		  // Extra CSS
		  $css_class .= ' '.$css_extra_class.' ';		  
			
			// Build the output
			$output = "\n\t".$this->get_title($title);
			$output .= $link_start;
			$output .= "\n\t".'<div class="'.esc_attr($css_class).'">';
			$output .= "\n\t\t".'<div class="wpb_wrapper">';
			$output .= "\n\t\t\t".$text;
			$output .= "\n\t\t".'</div> '.$this->endBlockComment('.wpb_wrapper');
			$output .= "\n\t".'</div> '.$this->endBlockComment($this->settings['base']);
			$output .= $link_end;
		  
		  return $output;
  }

}

add_action('init', 'ac_block_quote_init');
function ac_block_quote_init() {

	global $ac_vc_title, 
		$ac_vc_css_animation, 
		$ac_vc_css_image_border_shape, 
		$ac_vc_css_class, 
		$ac_vc_design_options;
	
	vc_map( array(
	    "base"		=> "ac_block_quote",
	    "name"		=> __("AC Block Quote", "alleycat"),
	    "class"		=> "ac",
	    "icon"      => "icon-heart",
	    'description' => __( 'Block quote with image, author and link ', 'alleycat' ),	  
		  "category" => __("AC", "alleycat"),
		  "weight" => 59,
	    "params"	=> array(
	    	$ac_vc_title,    
	      array(
	        "type" => "textarea_html",
	        "class" => "",
	        "heading" => __("Text", "alleycat"),
	        "param_name" => "content",
	        "value" => __("Enter your text here", "alleycat")
	      ),
		    array(
		      "type" => "textarea",
		      "heading" => __("Author Information", "alleycat"),
		      "param_name" => "author",
		      "value" => ""
		    ),
		    array(
		      "type" => "vc_link",
		      "heading" => __("Author URL", "alleycat"),
		      "param_name" => "author_url",
		      "value" => ""
		    ),	    
		    array(
		      "type" => "attach_image",
		      "heading" => __("Image", "alleycat"),
		      "param_name" => "image",
		      "value" => ""
		    ),
		    array(
		      "type" => "textfield",
		      "heading" => __("Image Caption", "alleycat"),
		      "param_name" => "image_caption",
		      "value" => ""
		    ),	    
				$ac_vc_css_image_border_shape,
		    array(
		      "type" => "dropdown",
		      "heading" => __("Image alignment", "alleycat"),
		      "param_name" => "alignment",
		      "value" => array(__("Align left", "alleycat") => "", __("Align right", "alleycat") => "right")
		    ),	    
				$ac_vc_css_animation,
				$ac_vc_css_class,
		    $ac_vc_design_options
	    )
	) );	
}

