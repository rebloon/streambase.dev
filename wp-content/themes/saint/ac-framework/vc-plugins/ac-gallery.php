<?php
/*******************************************/
/**** Alleycat Posts Builder Galleries  ****/ 
/*******************************************/

// Gallery = the images from a single gallery

class WPBakeryShortCode_ac_gallery extends WPBakeryShortCode_ac_posts_builders_base {

  protected $post_type = 'attachment';
  protected $post_category = '';
  protected $link_to_lightbox = true;  
  
  protected function filter_posts($args) {
	  
	  parent::filter_posts($args);
  
		// Setup image args
		$args['meta_key'] = null;
		$args['post_mime_type'] = 'image';
		$args['post_status'] = null;

		// Force order as we always want to observe the menu order set by the gallert		
		$args['orderby'] = 'menu_order';
		$args['order'] = 'ASC';
				
		return $args;
  }  
  
}

add_action('init', 'ac_gallery_init');
function ac_gallery_init() {

	vc_map( array(
	    "base"		=> "ac_gallery",
	    "name"		=> __("AC Single Gallery", "alleycat"),
	    "class"		=> "ac",
	    "icon"      => "icon-heart",
	    "params"	=> ac_vc_base_get_builder_params('ac_gallery', ''),
	    'description' => __( 'Full width single gallery slideshow', 'alleycat' ),	  
		  "category" => __("AC", "alleycat"),
		  "weight" => 57,
	) );
	
}