<?php

if ( !function_exists( 'shoestrap_module_advanced_options' ) ) :
/*
 * The advanced core options for the Shoestrap theme
 */
function shoestrap_module_advanced_options( $sections ) {
  // Advanced Settings
  $section = array( 
    'title'   => __( 'Advanced', 'shoestrap' ),
    'icon'    => 'el-icon-cogs icon-large'
  );  
  
  $fields[] = array( 
    'title'     => __( 'Excerpt length', 'shoestrap' ),
    'desc'      => __( 'Choose how many words should be used for excerpts.', 'shoestrap' ),
    'id'        => 'post_excerpt_length',
    'default'   => 55,
    'min'       => 10,
    'step'      => 1,
    'max'       => 300,
    'edit'      => 1,
    'type'      => 'slider'
  );
  
  $fields[] = array( 
    'title'     => __( '"Read more" text', 'shoestrap' ),
    'desc'      => __( 'Text to replace Read More', 'shoestrap' ),
    'id'        => 'post_excerpt_link_text',
    'default'   => __( 'Continued', 'roots' ),
    'compiler'  => true,    
    'type'      => 'text'
  );
  
  $fields[] = array( 
    'title'     => __( 'Page load fade in', 'shoestrap' ),
    'desc'      => __( 'Enable subtle loading transitions.', 'shoestrap' ),
    'id'        => 'ac_fade_in_toggle',
    'default'   => 1,
    'type'      => 'switch',
  );    

  $fields[] = array( 
    'title'     => __( 'Select pagination style', 'shoestrap' ),
    'desc'      => __( 'Switch between Next/Prev buttons or Page Number pagination.', 'shoestrap' ),
    'id'        => 'pagination',
    'type'      => 'button_set',
    'options'   => array(
      'pager'       => 'Default Pager',
      'pagination'  => 'Default Pagination'
    ),
    'default'   => 'pager',
    'customizer'=> array()
  );

  $fields[] = array( 
    'title'     => __( 'Enable Retina mode', 'shoestrap' ),
    'desc'      => __( 'Images will be served at 2x size for retina devices.  Requires images to be uploaded at 2x the typical size desired.', 'shoestrap' ),
    'id'        => 'retina_toggle',
    'default'   => 1,
    'type'      => 'switch',
    'customizer'=> array(),
  );

  $fields[] = array( 
    'title'     => __( 'Google Analytics ID', 'shoestrap' ),
    'desc'      => __( 'Paste your Google Analytics ID here to enable analytics tracking.  Only non-admin users will be tracked.  Only Universal Analytics properties. Your user ID should be in the form of UA-XXXXX-Y.', 'shoestrap' ),
    'id'        => 'analytics_id',
    'default'   => '',
    'type'      => 'text',
  );

  $fields[] = array( 
    'title'     => 'Border-Radius and Padding Base',
    'id'        => 'help2',
    'desc'      => __( 'The following settings affect various areas of your site, most notably buttons.', 'shoestrap' ),
    'type'      => 'info',
  );

  $fields[] = array( 
    'title'     => __( 'Border-Radius', 'shoestrap' ),
    'desc'      => __( 'You can adjust the corner-radius of all elements in your site here. This will affect buttons, navbars, widgets and many more. Default: 4', 'shoestrap' ),
    'id'        => 'general_border_radius',
    'default'   => 4,
    'min'       => 0,
    'step'      => 1,
    'max'       => 50,
    'advanced'  => true,
    'compiler'  => true,
    'type'      => 'slider',
  );

  $fields[] = array( 
    'title'     => __( 'Padding Base', 'shoestrap' ),
    'desc'      => __( 'You can adjust the padding base. Default: 8', 'shoestrap' ),
    'id'        => 'padding_base',
    'default'   => 8,
    'min'       => 0,
    'step'      => 1,
    'max'       => 20,
    'advanced'  => true,
    'compiler'  => true,
    'type'      => 'slider',
  );
  
  if (ac_woocommerce_is_active()) {
	  $fields[] = array( 
	    'title'     => __( 'WooCommerce Shop Columns', 'shoestrap' ),
	    'desc'      => __( 'Set the number of columns for the shop', 'shoestrap' ),
	    'id'        => 'wc_shop_cols',
	    'default'   => 3,
	    'min'       => 1,
	    'step'      => 1,
	    'max'       => 6,
	    'advanced'  => true,
	    'type'      => 'slider',
	  );  
	}

  $fields[] = array( 
    'title'     => __( 'Custom CSS', 'shoestrap' ),
    'desc'      => __( 'You can write your custom CSS here. This code will appear in a script tag appended in the header section of the page.', 'shoestrap' ),
    'id'        => 'user_css',
    'default'   => '',
    'type'      => 'ace_editor',
    'mode'      => 'css',
    'theme'     => 'monokai',
  );

  $fields[] = array( 
    'title'     => __( 'Custom LESS', 'shoestrap' ),
    'desc'      => __( 'You can write your custom LESS here. This code will be compiled with the other LESS files of the theme and be appended to the header.', 'shoestrap' ),
    'id'        => 'user_less',
    'default'   => '',
    'type'      => 'ace_editor',
    'mode'      => 'less',
    'theme'     => 'monokai',
    'compiler'  => true,
  );  

  $fields[] = array( 
    'title'     => __( 'Custom JS', 'shoestrap' ),
    'desc'      => __( 'You can write your custom JavaScript/jQuery here. Include &lt;script&gt; tags.', 'shoestrap' ),
    'id'        => 'user_js',
    'default'   => '',
    'type'      => 'ace_editor',
    'mode'      => 'javascript',
    'theme'     => 'monokai',
  );

  $fields[] = array( 
    'title'     => __( 'Minimize CSS', 'shoestrap' ),
    'desc'      => __( 'Minimize the generated CSS. This should be ON for production sites. Default: OFF.', 'shoestrap' ),
    'id'        => 'minimize_css',
    'default'   => 0,
    'compiler'  => true,
    'customizer'=> array(),
    'type'      => 'switch',
  );

  $section['fields'] = $fields;

  $section = apply_filters( 'shoestrap_module_advanced_options_modifier', $section );
  
  $sections[] = $section;
  
  return $sections;

}
endif;
add_filter( 'redux/options/'.REDUX_OPT_NAME.'/sections', 'shoestrap_module_advanced_options', 95 );

include_once( dirname( __FILE__ ).'/functions.advanced.php' );
include_once( dirname( __FILE__ ).'/debug-hooks.php' );