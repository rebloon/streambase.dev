<?php
/*******************************************/
/**** Alleycat Posts Builder Portfolio  ****/ 
/*******************************************/

class WPBakeryShortCode_ac_portfolio extends WPBakeryShortCode_ac_posts_builders_base {

  protected $post_type = 'ac_portfolio';
  public $post_category = 'portfolio-category';
  
}

add_action('init', 'ac_portfolio_init');
function ac_portfolio_init() {

	vc_map( array(
	    "base"		=> "ac_portfolio",
	    "name"		=> __("AC Portfolio", "alleycat"),
	    "class"		=> "ac",
	    "icon"      => "icon-heart",
	    "params"	=> ac_vc_base_get_builder_params('ac_portfolio', 'portfolio-category'),
	    'description' => __( 'Display Portfolio items in different styles', 'alleycat' ),	  
		  "category" => __("AC", "alleycat"),
		  "weight" => 55,
	) );
	
};