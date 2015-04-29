<?php

/*
 * The Featured Images core options for the Shoestrap theme
 */
if ( !function_exists( 'shoestrap_module_featured_images_options' ) ) :
function shoestrap_module_featured_images_options( $sections ) {

  // Blog Options
  $section = array( 
    'title'     => __( 'Featured Images', 'shoestrap' ),
    'icon'      => 'el-icon-picture icon-large',
  );

  $fields[] = array( 
    'id'        => 'help3',
    'desc'      => __( 'Select if you want to display the featured images in post archives and individual posts.', 'shoestrap' ),
    'type'      => 'info',
  );
  
  // AC
  $fields[] = array( 
    'title'     => __( 'Featured Image Height', 'shoestrap' ),
    'desc'      => __( 'Select the height of your featured images.', 'shoestrap' ),
    'id'        => 'ac_feat_img_height',
    'default'   => 350,
    'min'       => 100,
    'step'      => 1,
    'max'       => 800, //shoestrap_getVariable( 'screen_large_desktop' ),
    'edit'      => 1,
    'type'      => 'slider',
    'compiler'  => true,    
  );
  

  $fields[] = array( 
    'title'     => __( 'Featured Images on Archives', 'shoestrap' ),
    'desc'      => __( 'Display featured images on post archives ( such as categories, tags, month view etc ).', 'shoestrap' ),
    'id'        => 'feat_img_archive',
    'default'   => 1,
    'type'      => 'switch',
    'customizer'=> true,
  );


  $fields[] = array( 
    'title'     => __( 'Featured Images', 'shoestrap' ),
    'desc'      => __( 'Display featured images on posts and pages at the top of the page.', 'shoestrap' ),
    'id'        => 'feat_img_post',
    'default'   => 1,
    'type'      => 'switch',
    'customizer'=> true,
  );

  $section['fields'] = $fields;

  $section = apply_filters( 'shoestrap_module_featured_images_options_modifier', $section );
  
  $sections[] = $section;
  return $sections;

}
endif;
add_filter( 'redux/options/'.REDUX_OPT_NAME.'/sections', 'shoestrap_module_featured_images_options', 90 );

// Simply include our alternative functions for image resizing
include_once( dirname(__FILE__).'/resize.php' );
include_once( dirname(__FILE__).'/functions.images.php' );
