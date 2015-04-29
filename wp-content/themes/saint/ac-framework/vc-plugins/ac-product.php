<?php
/*******************************************/
/**** Alleycat Posts Builder Postfolio  ****/ 
/*******************************************/

class WPBakeryShortCode_ac_product extends WPBakeryShortCode_ac_posts_builders_base {

  protected $post_type = 'product';
  public $post_category = 'product_cat';
  
}

add_action('init', 'ac_product_init');
function ac_product_init() {

	vc_map( array(
	    "base"		=> "ac_product",
	    "name"		=> __("AC WooCommerce Products", "alleycat"),
	    "class"		=> "ac",
	    "icon"      => "icon-heart",
	    "params"	=> ac_vc_base_get_builder_params('ac_product', 'product_cat'),
	    'description' => __( 'Display Products in a carousel', 'alleycat' ),	  
		  "category" => __("AC", "alleycat"),
		  "weight" => 52,
	) );
}