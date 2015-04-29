<?php
/**********************************************/
/**** Alleycat Posts Builder Testimonials  ****/ 
/**********************************************/

class WPBakeryShortCode_ac_testimonial extends WPBakeryShortCode_ac_posts_builders_base {

  protected $post_type = 'ac_testimonial';
  public $post_category = 'testimonial-category';
  
}

add_action('init', 'ac_testimonial_init');
function ac_testimonial_init() {

	vc_map( array(
	    "base"		=> "ac_testimonial",
	    "name"		=> __("AC Testimonials", "alleycat"),
	    "class"		=> "ac",
	    "icon"      => "icon-heart",
	    "params"	=> ac_vc_base_get_builder_params('ac_testimonial', 'testimonial-category'),
	    'description' => __( 'Display Testimonials in different styles', 'alleycat' ),	  
		  "category" => __("AC", "alleycat"),
		  "weight" => 53,
	) );
	
}