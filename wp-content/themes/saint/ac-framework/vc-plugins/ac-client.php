<?php
/****************************************/
/**** Alleycat Posts Builder Client  ****/ 
/****************************************/

class WPBakeryShortCode_ac_client extends WPBakeryShortCode_ac_posts_builders_base {

  protected $post_type = 'ac_client';
  public $post_category = 'client-category';
  
}

add_action('init', 'ac_client_init');
function ac_client_init() {

	vc_map( array(
	    "base"		=> "ac_client",
	    "name"		=> __("AC Clients", "alleycat"),
	    "class"		=> "ac",
	    "icon"      => "icon-heart",
	    "params"	=> ac_vc_base_get_builder_params('ac_client', 'client-category'),
	    'description' => __( 'Display Client information', 'alleycat' ),	  
		  "category" => __("AC", "alleycat"),
		  "weight" => 55,
	) );
}