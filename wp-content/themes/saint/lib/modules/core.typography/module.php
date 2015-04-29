<?php

if ( !function_exists( 'shoestrap_module_typography_options' ) ) :
/*
 * The typography core options for the Shoestrap theme
 */
function shoestrap_module_typography_options( $sections ) {

  // Typography Options
  $section = array(
    'title'   => __( 'Typography', 'shoestrap' ),
    'icon'    => 'el-icon-font icon-large',
  );

  $fields[] = array( 
    'title'     => __( 'Base Font', 'shoestrap' ),
    'desc'      => __( 'The main font for your site.', 'shoestrap' ),
    'id'        => 'font_base',
    'compiler'  => true,
    'units'     => 'px',
    'default'   => array( 
      'font-family'   => 'Raleway',
      'font-size'     => '15px',
      'line-height'   => '26px',
      'google'        => 'true',
      'subsets'				=> 'latin',
      'color'         => '#555555',
      'subsets'         => 'latin',
      'font-style'    => 400,
      'update_weekly' => true // Enable to force updates of Google Fonts to be weekly
    ),
    'preview'   => array( 
      'text'        => __( 'This is my preview text!', 'shoestrap' ), //this is the text from preview box
      'font-size'   => '30px' //this is the text size from preview box
    ),
    'type'      => 'typography',
  );

  $fields[] = array( 
    'title'     => __( 'Heading Overrides', 'shoestrap' ),
    'desc'      => __( 'Switch On to specify custom values for each heading.', 'shoestrap' ),
    'id'        => 'font_heading_custom',
    'default'   => 1,
    'compiler'  => true,
    'type'      => 'switch',
    'customizer'=> array(),
  );

  $fields[] = array( 
    'title'     => __( 'H1 Font', 'shoestrap' ),
    'id'        => 'font_h1',
    'compiler'  => true,
    'units'     => '%',
    'default'   => array( 
      'font-family' => 'Raleway',
      'font-size'   => '400%',
      'line-height' => '125%',
      'color'       => '#444444',
      'google'      => 'true',
      'font-style'  => 700,

    ),
    'preview'   => array( 
      'text'        => __( 'This is my preview text!', 'shoestrap' ), //this is the text from preview box
      'font-size'   => '30px' //this is the text size from preview box
    ),
    'type'      => 'typography',
    'required'  => array('font_heading_custom','=',array('1')),
  );

  $fields[] = array( 
    'id'        => 'font_h2',
    'title'     => __( 'H2 Font', 'shoestrap' ),
    'compiler'  => true,
    'units'     => '%',
    'default'   => array( 
      'font-family' => 'Raleway',
      'font-size'   => '240%',
      'line-height' => '125%',
      'color'       => '#444444',
      'google'      => 'true',
      'font-style'  => 700,
    ),
    'preview'   => array( 
      'text'        => __( 'This is my preview text!', 'shoestrap' ), //this is the text from preview box
      'font-size'   => '30px' //this is the text size from preview box
    ),
    'type'      => 'typography',
    'required'  => array('font_heading_custom','=',array('1')),    
  );

  $fields[] = array( 
    'id'        => 'font_h3',
    'title'     => __( 'H3 Font', 'shoestrap' ),
    'compiler'  => true,
    'units'     => '%',
    'default'   => array( 
      'font-family' => 'Raleway',
      'font-size'   => '170%',
      'line-height' => '125%',
      'color'       => '#444444',
      'google'      => 'true',
      'font-style'  => 700,
    ),
    'preview'   => array( 
      'text'        => __( 'This is my preview text!', 'shoestrap' ), //this is the text from preview box
      'font-size'   => '30px' //this is the text size from preview box
    ),
    'type'      => 'typography',
    'required'  => array('font_heading_custom','=',array('1')),
  );

  $fields[] = array( 
    'title'     => __( 'H4 Font', 'shoestrap' ),
    'id'        => 'font_h4',
    'compiler'  => true,
    'units'     => '%',
    'default'   => array( 
      'font-family' => 'Raleway',
      'font-size'   => '140%',
      'line-height' => '125%',
      'color'       => '#444444',
      'google'      => 'true',
      'font-style'  => 600,
    ),
    'preview'   => array( 
      'text'    => __( 'This is my preview text!', 'shoestrap' ), //this is the text from preview box
      'font-size'   => '30px' //this is the text size from preview box
    ),
    'type'      => 'typography',
    'required'  => array('font_heading_custom','=',array('1')),
  );

  $fields[] = array( 
    'title'     => __( 'H5 Font', 'shoestrap' ),
    'id'        => 'font_h5',
    'compiler'  => true,
    'units'     => '%',
    'default'   => array( 
      'font-family' => "'Palatino Linotype', 'Book Antiqua', Palatino, serif", 
      'font-size'   => '170%',
      'line-height' => '100%',
      'color'       => '#c49f3c',
      'google'      => 'true',
      'font-style'  => '700italic',
    ),
    'preview'       => array( 
      'text'        => __( 'This is my preview text!', 'shoestrap' ), //this is the text from preview box
      'font-size'   => '30px' //this is the text size from preview box
    ),
    'type'      => 'typography',
    'required'  => array('font_heading_custom','=',array('1')),
  );

  $fields[] = array( 
    'title'     => __( 'H6 Font', 'shoestrap' ),
    'id'        => 'font_h6',
    'compiler'  => true,
    'units'     => '%',
    'default'   => array( 
      'font-family' => 'Raleway',
      'font-size'   => '120%',
      'line-height' => '100%',
      'color'       => '#9e9e9e',
      'google'      => 'true',
      'font-style'  => 400,
    ),
    'preview'   => array( 
      'text'        => __( 'This is my preview text!', 'shoestrap' ), //this is the text from preview box
      'font-size'   => '30px' //this is the text size from preview box
    ),
    'type'      => 'typography',
    'required'  => array('font_heading_custom','=',array('1')),
  );

  $section['fields'] = $fields;

  $section = apply_filters( 'shoestrap_module_typography_options_modifier', $section );
  
  $sections[] = $section;
  return $sections;

}
add_filter( 'redux/options/'.REDUX_OPT_NAME.'/sections', 'shoestrap_module_typography_options', 80 ); 
endif;

include_once( dirname( __FILE__ ).'/functions.typography.php' );