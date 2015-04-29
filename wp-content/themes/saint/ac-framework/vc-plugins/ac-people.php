<?php
/****************************************/
/**** Alleycat Posts Builder People  ****/ 
/****************************************/

class WPBakeryShortCode_ac_person extends WPBakeryShortCode_ac_posts_builders_base {

  protected $post_type = 'ac_person';
  public $post_category = 'people-category';
  
}

add_action('init', 'ac_person_init');
function ac_person_init() {

	vc_map( array(
	    "base"		=> "ac_person",
	    "name"		=> __("AC People", "alleycat"),
	    "class"		=> "ac",
	    "icon"      => "icon-heart",
	    "params"	=> ac_vc_base_get_builder_params('ac_person', 'people-category'),
	    'description' => __( 'Display People in different styles', 'alleycat' ),	  
		  "category" => __("AC", "alleycat"),
		  "weight" => 54,
	) );
}