<?php
/***************************************/
/**** Alleycat Posts Builder Posts  ****/ 
/***************************************/

class WPBakeryShortCode_ac_posts extends WPBakeryShortCode_ac_posts_builders_base {

  protected $post_type = 'post';
  public $post_category = 'category';

}

add_action('init', 'ac_posts_init');
function ac_posts_init() {

	vc_map( array(
	    "base"		=> "ac_posts",
	    "name"		=> __("AC Posts", "alleycat"),
	    "class"		=> "ac",
	    "icon"      => "icon-heart",
	    "params"	=> ac_vc_base_get_builder_params('post', 'category'),
	    'description' => __( 'Display Posts in different styles', 'alleycat' ),	  
		  "category" => __("AC", "alleycat"),
		  "weight" => 51,
	) );
	
}