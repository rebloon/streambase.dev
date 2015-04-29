<?php
/*******************************/
/****  Redux Pages Options  ****/ 
/*******************************/

if ( !function_exists( 'shoestrap_module_pages_options' ) ) :
function shoestrap_module_pages_options( $sections ) {

  $fields = array();
  // Pages
  $section = array(
    'title' => __( 'Pages', 'shoestrap' ),
    'icon' => 'el-icon-file-edit icon-large'
  );
  
  // AC - Page Titles
  $fields[] = array( 
    'title'       => 'Page Titles',
    'desc'        => 'Set the default page title settings here.  You can override these on each page.',
    'id'          => 'help6',
    'default'     => __( '', 'shoestrap' ),
    'type'        => 'info'
  );  
  
  $fields[] = array( 
    'title'       => __( 'Page Title Background Color', 'shoestrap' ),
    'desc'        => __( '', 'shoestrap' ),
    'id'          => 'page_title_bg_color',
    'default'     => '#f3f3f3',
    'compiler'    => true,
    'customizer'  => array(),
    'transparent' => false,    
    'type'        => 'color'
  );  
  
  $fields[] = array( 
    'title'       => __( 'Page Title Padding', 'shoestrap' ),
    'desc'        => __( 'The amount of space above and below the page title', 'shoestrap' ),
    'id'          => 'page_title_padding',
    'default'   => 90,
    'min'       => 0,
    'step'      => 1,
    'edit'      => 1,    
    'max'       => 200,
    'type'      => 'slider',
    'compiler'    => true,    
  );    
  
  $fields[] = array( 
    'title'       => __( 'Custom Page Title Padding', 'shoestrap' ),
    'desc'        => __( 'The amount of space above and below the custom page title', 'shoestrap' ),
    'id'          => 'custom_page_title_padding',
    'default'   => 150,
    'min'       => 0,
    'step'      => 1,
    'edit'      => 1,    
    'max'       => 300,
    'type'      => 'slider',
    'compiler'    => true,    
  );    

  // AC - PUser Bio
  $fields[] = array( 
    'title'       => 'Author Bio',
    'desc'        => 'Set whether the author bio should appear on posts.',
    'id'          => 'help_author_bio',
    'default'     => __( '', 'shoestrap' ),
    'type'        => 'info'
  );
  
  $fields[] = array( 
    'title'     => __( 'Show Author Bio', 'shoestrap' ),
    'desc'      => __( 'Should the Author Bios be displayed?', 'shoestrap' ),
    'id'        => 'author_bio_show',
    'default'   => 1,
    'type'      => 'switch',
    'customizer'=> true,
  );
  
  $fields[] = array( 
    'title'     => __( 'Show on Posts', 'shoestrap' ),
    'desc'      => __( 'Show Author Bio on Posts?', 'shoestrap' ),
    'id'        => 'author_bio_show_post',
    'default'   => 1,
    'type'      => 'switch',
    'customizer'=> true,
    'required'  => array('author_bio_show','=',array('1')),
  );  

  $fields[] = array( 
    'title'     => __( 'Show on Pages', 'shoestrap' ),
    'desc'      => __( 'Show Author Bio on Pages?', 'shoestrap' ),
    'id'        => 'author_bio_show_page',
    'default'   => 0,
    'type'      => 'switch',
    'customizer'=> true,
    'required'  => array('author_bio_show','=',array('1')),    
  );    
    
  $section['fields'] = $fields;
  
  $sections[] = $section;
  return $sections;
}
endif;
add_filter( 'redux-sections-'.REDUX_OPT_NAME, 'shoestrap_module_pages_options', 85 );