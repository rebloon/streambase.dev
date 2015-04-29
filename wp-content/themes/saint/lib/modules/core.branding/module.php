<?php

/*
 * The branding core options for the Shoestrap theme
 */
if ( !function_exists( 'shoestrap_module_branding_options' ) ) :
function shoestrap_module_branding_options( $sections ) {
  $fields = array();
  // Branding Options
  $section = array(
    'title' => __( 'Branding', 'shoestrap' ),
    'icon' => 'el-icon-certificate icon-large'
  );

  $fields[] = array( 
    'title'       => __( 'Logo', 'shoestrap' ),
    'desc'        => __( 'Upload your logo.  Upload a logo 2x the original size for retina devices.', 'shoestrap' ),
    'id'          => 'logo',
    'default'     => '',
    'type'        => 'media',
    'customizer'  => array(),
  );

  $fields[] = array( 
    'title'       => __( 'Custom Favicon', 'shoestrap' ),
    'desc'        => __( 'Upload a favicon image.', 'shoestrap' ),
    'id'          => 'favicon',
    'default'     => '',
    'type'        => 'media',
  );

  $fields[] = array( 
    'title'       => __( 'Apple Icon', 'shoestrap' ),
    'desc'        => __( 'Upload your icon to use on Apple devices.  Recommended size is at least 144px x 144px.', 'shoestrap' ),
    'id'          => 'apple_icon',
    'default'     => '',
    'type'        => 'media',
  );


  $fields[] = array( 
    'title'       => 'Colors',
    'desc'        => '',
    'id'          => 'help6',
    'default'     => __( '', 'shoestrap' ),
    'type'        => 'info'
  );

  $fields[] = array( 
    'title'       => __( 'Accent Color', 'shoestrap' ),
    'desc'        => __( 'Select your primary accent color. This will affect various areas of your site.', 'shoestrap' ),
    'id'          => 'color_brand_primary',
    'default'     => '#c49f3c',
    'compiler'    => true,
    'customizer'  => array(),
    'transparent' => false,    
    'type'        => 'color'
  );

	// AC Button Colour
  $fields[] = array( 
    'title'       => __( 'Button Color', 'shoestrap' ),
    'desc'        => __( 'Select the color to use for buttons.', 'shoestrap' ),
    'id'          => 'color_button',
    'default'     => '#333333',
    'compiler'    => true,
    'customizer'  => array(),
    'transparent' => false,    
    'type'        => 'color'
  );  
  
  $section['fields'] = $fields;

  $section = apply_filters( 'shoestrap_module_branding_options_modifier', $section );
  
  $sections[] = $section;
  return $sections;
}
endif;

add_filter( 'redux/options/'.REDUX_OPT_NAME.'/sections', 'shoestrap_module_branding_options', 50 );

include_once( dirname( __FILE__ ) . '/functions.logo.php' );
include_once( dirname( __FILE__ ) . '/functions.icons.php' );
include_once( dirname( __FILE__ ) . '/functions.page-title.php' ); // AC - page titles
