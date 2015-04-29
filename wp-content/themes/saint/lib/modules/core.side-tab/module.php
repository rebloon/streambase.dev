<?php
/**********************************/
/****  Redux Side Tab Options  ****/ 
/**********************************/

if ( !function_exists( 'shoestrap_module_sidetab_options' ) ) :
function shoestrap_module_sidetab_options( $sections ) {

  $fields = array();
  $section = array(
    'title' => __( 'Side Tab', 'shoestrap' ),
    'icon' => 'el-icon-address-book icon-large'
  );
  
  $fields[] = array( 
    'title'       => '',
    'desc'        => 'Enter the details here for a side tab to appear on every page.  This is perfect for a Contact Us tab.',
    'id'          => 'help-sidetab',
    'default'     => __( '', 'shoestrap' ),
    'type'        => 'info'
  );  
  
  $fields[] = array( 
    'title'     => __( 'Enable the Side Tab', 'shoestrap' ),
    'desc'      => __( 'Turn the side tab on and off.', 'shoestrap' ),
    'id'        => 'side_tab_active',
    'default'   => 1,
    'type'      => 'switch',
  );
   
  $fields[] = array( 
    'title'     => __( 'Tab text', 'shoestrap' ),
    'desc'      => __( 'The text to show in the tab.', 'shoestrap' ),
    'id'        => 'side_tab_text',
    'default'   => __( 'Contact Us', 'roots' ),
    'type'      => 'text',
    'required'  => array('side_tab_active','=',array('1')),    
  );  

  $fields[] = array( 
    'title'     => __( 'Tab URL', 'shoestrap' ),
    'desc'      => __( 'The URL for the tab link.	 Include http://', 'shoestrap' ),
    'id'        => 'side_tab_url',
    'default'   => __( '', 'roots' ),
    'type'      => 'text',
    'required'  => array('side_tab_active','=',array('1')),    
  );  
  
  $fields[] = array( 
    'title'     => __( 'Open the link in a new window', 'shoestrap' ),
    'desc'      => __( 'This will make the link open in a new tab or window.', 'shoestrap' ),
    'id'        => 'side_tab_new_window',
    'default'   => 1,
    'type'      => 'switch',
    'required'  => array('side_tab_active','=',array('1')),    
  );

/*
  $fields[] = array( 
    'title'     => __( 'Tab position', 'shoestrap' ),
    'desc'      => __( 'Select the position on the page for the tab.', 'shoestrap' ),
    'id'        => 'side_tab_position',
    'default'   => 'left',
    'type'      => 'select',
    'customizer'=> array(),
    'options'   => array(
      'left'  	=> __( 'Left', 'shoestrap' ),
      'right'   => __( 'Right', 'shoestrap' ),
    ),
    'required'  => array('side_tab_active','=',array('1')),    
  );	
*/
	
  $fields[] = array( 
    'title'       => __( 'Position from the top', 'shoestrap' ),
    'desc'        => __( 'The position on the page where the tab should appear. 0 is the top, 100 is the bottom.', 'shoestrap' ),
    'id'          => 'side_tab_top',
    'default'   => 40,
    'min'       => 0,
    'step'      => 1,
    'edit'      => 1,    
    'max'       => 100,
    'type'      => 'slider',
    'compiler'    => true,
    'required'  => array('side_tab_active','=',array('1')),    
  );    
  
  $fields[] = array( 
    'title'       => __( 'Text colour', 'shoestrap' ),
    'desc'        => __( 'The colour of the text on the tab.', 'shoestrap' ),
    'id'          => 'side_tab_text_colour',
    'default'     => '#ffffff',
    'compiler'    => true,    
    'customizer'  => array(),
    'transparent' => false,    
    'type'        => 'color',
    'required'  => array('side_tab_active','=',array('1')),    
  );  
  
  $fields[] = array( 
    'title'       => __( 'Tab colour', 'shoestrap' ),
    'desc'        => __( 'The background colour of the tab.', 'shoestrap' ),
    'id'          => 'side_tab_bg_colour',
    'default'     => '#000000',
    'compiler'    => true,
    'customizer'  => array(),
    'transparent' => false,    
    'type'        => 'color',
    'required'  => array('side_tab_active','=',array('1')),    
  );  
  
  $section['fields'] = $fields;
  
  $sections[] = $section;
  return $sections;
}
endif;
add_filter( 'redux/options/'.REDUX_OPT_NAME.'/sections', 'shoestrap_module_sidetab_options', 91 );

include_once( dirname( __FILE__ ).'/functions.side-tab.php' );