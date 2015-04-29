<?php
/*********************************/
/**** Alleycat Featured Post  ****/ 
/*********************************/

class WPBakeryShortCode_ac_featured_post extends AC_VC_Base {

  protected function content($atts, $content = null) {
  
			$this->content_has_container = false;  

			extract(shortcode_atts(array(
				'title' => '',			
				'featured_post' => '',
				'alignment' => 'left',
		    'el_class' => '',
				'css_animation' => '',
				'css' => '',
				'css_extra_class' => '',				
		    ), $atts));
		    	  	  
		  // Alignments
		  $align_class = 'pull-'.$alignment;
		  $text_align_class = 'text-'.$alignment;
		  
		  // Links
		  $a_start = "<a href='".get_permalink($featured_post)."' />";
		  $a_end = "</a>";
		  		  
		  // Build the CSS
			$css_class = $this->build_outer_css($atts, $content);		  
			$css_class .= ' vc_align_'.$alignment;

			if ($alignment == 'left') {
				$align_class = 'ac-page-left-side';
				$img_align = 'ac-page-right-side';
			}
			else {
				$align_class = 'ac-page-right-side';
				$img_align = 'ac-page-left-side';
			}			
			
		  // Build the text
		  $text = "<div class='text $align_class col-sm-6 ac-center-vertically'>";
		  $text .= $a_start;		  
		  $text .= "<h2>".__(get_the_title($featured_post), 'alleycat')."</h2>";
		  $text .= "<p class='ac-body-color-a'>".__(ac_get_excerpt($featured_post, false, false, false), 'alleycat')."</p>";
		  $text .= $a_end;		  
		  $text .= "</div>";
		  	  
		  // Build the image
		  // Get the featured image id
		  $image_id = get_post_thumbnail_id( $featured_post );
		  		    
		  $image = "<div class='image $img_align col-sm-6'>";
		  $image .= $a_start.ac_render_image_for_columns( array('image_id' => $image_id, 'columns' => 6, 'use_placeholder' => true) ).$a_end;
		  $image .= "</div>";
		  
		  // Extra CSS
		  $css_class .= ' '.$css_extra_class.' ';		  		  
			
			// Build the output
			$output = '';
			$output .= "\n\t".'<div class="'.esc_attr($css_class).'" >';
			$output .= "\n\t".$this->get_title($title);
			$output .= "\n\t\t".'<div class="wpb_wrapper">';
			$output .= "\n\t\t\t".$image.$text;
			$output .= "\n\t\t".'</div> '.$this->endBlockComment('.wpb_wrapper');
			$output .= "\n\t".'</div> '.$this->endBlockComment('.ac_image');
		  
		  return $output;
  }

}	

add_action('init', 'ac_featured_post_init');
function ac_featured_post_init() {

	global $ac_vc_title, 
		$ac_vc_css_animation,
		$ac_vc_css_class,
    $ac_vc_design_options;

	vc_map( array(
	    "base"		=> "ac_featured_post",
	    "name"		=> __("AC Featured Post", "alleycat"),
	    "class"		=> "ac",
	    "icon"      => "icon-heart",
	    'description' => __( 'Easily insert post details into a page', 'alleycat' ),	  
		  "category" => __("AC", "alleycat"),
		  "weight" => 57,
	    "params"	=> array(
	    	$ac_vc_title,
		    array(
		      "type" => "dropdown",
		      "heading" => __("Post", "alleycat"),
		      "param_name" => "featured_post",
		      "value" => ac_vc_get_posts_for_select(),
					"description" => __("Select the post to feature.", "alleycat")	      
		    ),
		    array(
		      "type" => "dropdown",
		      "heading" => __("Text Alignment", "alleycat"),
		      "param_name" => "alignment",
		      "value" => array(__("Align left", "alleycat") => "", __("Align right", "alleycat") => "right")
		    ),	    
				$ac_vc_css_animation,
				$ac_vc_css_class,
				$ac_vc_design_options
	    )
	) );
	
}