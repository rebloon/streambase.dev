<?php

/*
 * The footer core options for the Shoestrap theme
 */
if ( !function_exists( 'shoestrap_module_footer_options' ) ) :
function shoestrap_module_footer_options( $sections ) {

  // Branding Options
  $section = array(
    'title' => __( 'Footer', 'shoestrap' ),
    'icon' => 'el-icon-caret-down icon-large'
  );
  
  $fields[] = array( 
    'title'       => __( 'Parallax Footer Reveal', 'shoestrap' ),
    'id'          => 'footer_parallax',
    'default'     => 1,
    'type'      	=> 'switch',
    'desc'        => __( 'The footer will be revealed using a parallax effect.  This effect does not happen on mobiles, tablets and other touch devices.', 'shoestrap' ),

  );  

  $fields[] = array( 
    'title'       => __( 'Footer Background Color', 'shoestrap' ),
    'id'          => 'footer_background',
    'default'     => '#333333',
    'customizer'  => array(),
    'transparent' => false,    
    'type'        => 'color',
    'compiler'    => true,    
  );
  
  $fields[] = array( 
    'title'       => __( 'Footer Text Color', 'shoestrap' ),
    'id'          => 'footer_color',
    'default'     => '#cccccc',
    'customizer'  => array(),
    'transparent' => false,    
    'type'        => 'color',
    'compiler'    => true,    
  );

  $fields[] = array( 
    'title'       => __( 'Footer Text', 'shoestrap' ),
    'desc'        => __( 'The text that will be displayed in your footer. You can use [year] and [sitename] and they will be replaced appropriately. <br>e.g.: &copy; [year] [sitename]', 'shoestrap' ),
    'id'          => 'footer_text',
    'default'     => '&copy; [year] [sitename]',
    'customizer'  => array(),
    'type'        => 'textarea'
  );

  $fields[] = array( 
    'title'       => 'Footer Border',
    'desc'        => 'Select the border options for your Footer',
    'id'          => 'footer_border',
    'type'        => 'border',
    'all'         => false, 
    'left'        => false, 
    'bottom'      => false, 
    'right'       => false,
    'default'     => array(
      'border-top'      => '0',
      'border-bottom'   => '0',
      'border-style'    => 'solid',
      'border-color'    => '#222222',
    ),
    'compiler'    => true,    
  );

  $fields[] = array( 
    'title'       => __( 'Footer Top Margin', 'shoestrap' ),
    'desc'        => __( 'Select the top margin of footer in pixels. Default: 0px.', 'shoestrap' ),
    'id'          => 'footer_top_margin',
    'default'     => 0,
    'min'         => 0,
    'step'				=> 1,
    'edit'				=> 1,
    'max'         => 200,
    'type'        => 'slider',
  );

  $section['fields'] = $fields;

  $section = apply_filters( 'shoestrap_module_footer_options_modifier', $section );
  
  $sections[] = $section;
  return $sections;
}
endif;
add_filter( 'redux/options/'.REDUX_OPT_NAME.'/sections', 'shoestrap_module_footer_options', 90 );   

include_once( dirname( __FILE__ ) . '/functions.footer.php' );
