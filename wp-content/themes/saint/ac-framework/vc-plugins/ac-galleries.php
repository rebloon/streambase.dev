<?php
/*******************************************/
/**** Alleycat Posts Builder Galleries  ****/ 
/*******************************************/

// Galleries = list of Gallery

class WPBakeryShortCode_ac_galleries extends WPBakeryShortCode_ac_posts_builders_base {

  protected $post_type = 'ac_gallery';
  public $post_category = '';
  
  protected function filter_posts($args) {
	  
	  parent::filter_posts($args);
  
  	// We need to exclude the Homepage and Tash galleries from the general results
		$ids_to_ignore = ac_gallery_get_posts_to_ignore();
		
		$args['post__not_in'] = $ids_to_ignore;
		
		// Clear meta_key which is used to only show posts with thumbnails, as ac_gallery doesn't have a thumbnail
		$args['meta_key'] = '';
		
		return $args;
  }
  
}

add_action('init', 'ac_galleries_init');
function ac_galleries_init() {

	vc_map( array(
	    "base"		=> "ac_galleries",
	    "name"		=> __("AC Galleries", "alleycat"),
	    "class"		=> "ac",
	    "icon"      => "icon-heart",
	    "params"	=> ac_vc_base_get_builder_params('ac_gallery', '', "ac_galleries"),
	    'description' => __( 'Display Gallery items in different styles', 'alleycat' ),	  
		  "category" => __("AC", "alleycat"),
		  "weight" => 56,
	) );
	
}