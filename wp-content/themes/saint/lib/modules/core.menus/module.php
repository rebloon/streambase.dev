<?php

/*
 * The header core options for the Shoestrap theme
 */
if ( !function_exists( 'shoestrap_module_menus_options' ) ) :
function shoestrap_module_menus_options( $sections ) {

  // Branding Options
  $section = array( 
    'title' => __( 'Menus', 'shoestrap' ),
    'icon'  => 'el-icon-chevron-right icon-large'
  );

  $fields[] = array( 
    'id'          => 'helpnavbarbg',
    'title'       => __( 'NavBar Styling Options', 'shoestrap' ),
    'desc'   	    => __( 'Customize the look and feel of your navbar below.', 'shoestrap' ),
    'type'        => 'info'
  );    
  
  $fields[] = array( 
    'title'       => __( 'Use Transparent Header', 'shoestrap' ),
    'desc'        => __( 'The Header will automatically become transparent when you have a slider at the top of the page, no page title, or a custom title.  You can also override this on pages and posts.', 'shoestrap' ),    
    'id'          => 'navbar_transparent',
    'default'     => 1,
    'customizer'  => array(),
    'type'        => 'switch'
  );  
  
  $fields[] = array( 
    'title'       => __( 'Header Starting Logo', 'shoestrap' ),
    'desc'        => __( 'This logo will fade to the regular logo when the header is transparent.  Upload a logo 2x the original size for retina devices.', 'shoestrap' ),
    'id'          => 'navbar_transparent_starting_logo',
    'default'     => '',
    'type'        => 'media',
    'customizer'  => array(),
    'required'    => array('navbar_transparent','=',array('1')),    
  );
  
  $fields[] = array( 
    'title'       => __( 'Header Starting Text Color', 'shoestrap' ),
    'id'          => 'navbar_transparent_starting_text_colour',
    'desc'        => __( 'Select the starting color for the NavBar text.', 'shoestrap' ),    
    'default'     => '#252525',
    'compiler'    => true,
    'customizer'  => array(),
    'transparent' => false,    
    'type'        => 'color',
    'required'    => array('navbar_transparent','=',array('1')),
  );  

  $fields[] = array( 
    'title'       => __( 'NavBar Background Color', 'shoestrap' ),
    'id'          => 'navbar_bg',
    'default'     => '#252525',
    'compiler'    => true,
    'customizer'  => array(),
    'transparent' => false,    
    'type'        => 'color'
  );

  $fields[] = array( 
    'title'       => __( 'NavBar Background Opacity', 'shoestrap' ),
    'id'          => 'navbar_bg_opacity',
    'default'     => 100,
    'min'         => 0,
    'step'        => 1,
    'max'         => 100,
    'type'        => 'slider',
  );

  $fields[] = array( 
    'title'       => __( 'Display Branding ( Sitename or Logo ) on the NavBar', 'shoestrap' ),
    'id'          => 'navbar_brand',
    'default'     => 1,
    'customizer'  => array(),
    'type'        => 'switch'
  );

  $fields[] = array( 
    'title'       => __( 'NavBar Positioning', 'shoestrap' ),
    'desc'        => __( 'Set the menu to be always be fixed at the top (or bottom), or to scroll with the page.', 'shoestrap' ),
    'id'          => 'navbar_fixed',
    'default'     => 1,
    'on'          => __( 'Fixed', 'shoestrap' ),
    'off'         => __( 'Scroll', 'shoestrap' ),
    'type'        => 'switch',
    'outer_class' => 'ac_double_colour_switch'
  );

  $fields[] = array( 
    'title'       => __( 'Fixed NavBar Position', 'shoestrap' ),
    'desc'        => __( 'Set the NavBar to be fixed at the top or bottom of the page.', 'shoestrap' ),
    'id'          => 'navbar_fixed_position',
    'required'    => array('navbar_fixed','=',array('1')),
    'default'     => 0,
    'on'         	=> __( 'Bottom', 'shoestrap' ),    
	  'off'         => __( 'Top', 'shoestrap' ),
    'type'        => 'switch',
    'outer_class' => 'ac_double_colour_switch'

  );

  $fields[] = array( 
    'title'       => __( 'NavBar Height', 'shoestrap' ),
    'desc'        => __( 'Set the height of the NavBar in pixels.  Your logo will resize to fit the height automatically.', 'shoestrap' ),
    'id'          => 'navbar_height',
    'default'     => 90,
    'min'         => 38,
    'step'        => 1,
    'max'         => 200,
    'compiler'    => true,
    'type'        => 'slider'
  );

  $fields[] = array( 
    'title'       => __( 'Navbar Font', 'shoestrap' ),
    'id'          => 'font_navbar',
    'compiler'    => true,
    'default'     => array( 
      'font-family' => 'Lato',
      'font-style'  => 400,
      'font-size'   => 12,
      'line-height' => 13, 
      'color'     => '#eeeeee',
      'google'    => 'false',
    ),
    'preview'     => array( 
      'text'      => __( 'This is my preview text!', 'shoestrap' ), //this is the text from preview box
      'size'      => 30 //this is the text size from preview box
    ),
    'type'        => 'typography',
  );

  $fields[] = array( 
    'title'       => __( 'Branding Font', 'shoestrap' ),
    'desc'        => __( 'The branding font for your site.', 'shoestrap' ),
    'id'          => 'font_brand',
    'compiler'    => true,
    'default'     => array( 
      'font-family' => 'Raleway',
      'font-style'  => 700,
      'font-size'   => 24,
      'line-height' => 24, 
      'google'    => 'false',
      'color'     => '#333333',
    ),
    'preview'     => array( 
      'text'      => __( 'This is my preview text!', 'shoestrap' ), //this is the text from preview box
      'size'      => 30 //this is the text size from preview box
    ),
    'type'        => 'typography',
  );

  $fields[] = array( 
    'title'       => __( 'NavBar Margin', 'shoestrap' ),
    'desc'        => __( 'Select the top and bottom margin of the NavBar in pixels. Only applies to Scroll NavBar Position.', 'shoestrap' ),
    'id'          => 'navbar_margin',
    'default'     => 0,
    'min'         => 0,
    'step'        => 1,
    'max'         => 200,
    'type'        => 'slider',
  );

  $fields[] = array( 
    'title'       => __( 'Search form on the NavBar', 'shoestrap' ),
    'desc'        => __( 'Display a search form in the NavBar.', 'shoestrap' ),
    'id'          => 'navbar_search',
    'customizer'  => array(),
    'default'     => 1,
    'type'        => 'switch'
  );

  $fields[] = array( 
    'title'       => __( 'Float NavBar menu to the right', 'shoestrap' ),
    'id'          => 'navbar_nav_right',
    'default'     => 1,
    'customizer'  => array(),
    'type'        => 'switch'
  );

  $fields[] = array( 
    'title'       => __( 'Display social networks in the navbar', 'shoestrap' ),
    'desc'        => __( 'Enable this option to display your social networks as a dropdown menu on the seondary navbar.', 'shoestrap' ),
    'id'          => 'navbar_secondary_social',
    'required'    => array('secondary_navbar_toggle','=',array('1')),
    'default'     => 0,
    'type'        => 'switch',
  );

  $fields[] = array( 
    'title'       => __( 'Secondary NavBar Margin', 'shoestrap' ),
    'desc'        => __( 'Select the top and bottom margin of header in pixels. Default: 0px.', 'shoestrap' ),
    'id'          => 'secondary_navbar_margin',
    'default'     => 0,
    'min'         => 0,
    'max'         => 200,
    'type'        => 'slider',
    'required'    => array('secondary_navbar_toggle','=',array('1')),
  );

  $section['fields'] = $fields;

  $section = apply_filters( 'shoestrap_module_menus_options_modifier', $section );
  
  $sections[] = $section;
  return $sections;

}
endif;
add_filter( 'redux/options/'.REDUX_OPT_NAME.'/sections', 'shoestrap_module_menus_options', 65 );  

include_once( dirname( __FILE__ ) . '/functions.navbar.php' );
include_once( dirname( __FILE__ ) . '/functions.secondary.navbar.php' );
include_once( dirname( __FILE__ ) . '/functions.slide-down.php' );
include_once( dirname( __FILE__ ) . '/wp_bootstrap_navlist_walker.php' );

if ( shoestrap_getVariable( 'navbar_toggle' ) == 'alt' ) :
  include_once( dirname( __FILE__ ) . '/functions.navwalker.php' );
endif;
