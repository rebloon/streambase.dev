<?php
/*****************************/
/****  Slideshow Options  ****/ 
/*****************************/
if ( !function_exists( 'shoestrap_module_slideshow_options' ) ) :
function shoestrap_module_slideshow_options( $sections ) {

  // Blog Options
  $section = array( 
    'title'     => __( 'Slideshows', 'shoestrap' ),
    'icon'      => 'el-icon-picture icon-large',
  );

  $fields[] = array( 
    'id'        => 'help3',
    'title'     => __( 'Slideshow Settings', 'shoestrap' ),
    'desc'      => __( 'Set the options for all of the theme sliders.  This includes those you insert into a page, and the Alleycat Slider.  Revolution Sliders have their own settings.', 'shoestrap' ),
    'type'      => 'info',
  );

  $fields[] = array( 
    'title'     => __( 'Autoplay', 'shoestrap' ),
    'desc'      => __( 'Should the slideshow automatically play?', 'shoestrap' ),
    'id'        => 'aeis_autoplay',
    'default'   => 1,
    'type'      => 'switch',
    'customizer'=> true,
  );
  
  $fields[] = array( 
    'title'     => __( 'Maximum height in pixels', 'shoestrap' ),
    'id'        => 'aeis_slideshow_height',
    'default'   => 600,
    'min'       => 50,
    'step'      => 1,
    'edit'      => 1,
    'max'       => 800,
    'type'      => 'slider',
    'compiler'    => true,    
  );  
  
  $fields[] = array( 
    'title'     => __( 'Delay between slides (in seconds)', 'shoestrap' ),
    'id'        => 'aeis_slideshow_delay',
    'default'   => 6,
    'min'       => 0.1,
    'step'      => 0.1,
    'edit'      => 0.1,
    'max'       => 30,
    'type'      => 'slider'
  );
  
  $fields[] = array( 
    'title'       => __( 'Transition', 'shoestrap' ),
    'desc'        => __( 'The transition to use between slides.', 'shoestrap' ),
    'id'          => 'aeis_transition',
    'default'     => 'slide',
    'type'        => 'select',
    'customizer'  => array(),
    'options'     => array( 
      'fade'   		=> __( 'Fade', 'shoestrap' ),
      'slide'   	=> __( 'Slide', 'shoestrap' ),      
    )
  );  
      
  $section['fields'] = $fields;

  $section = apply_filters( 'shoestrap_module_featured_images_options_modifier', $section );
  
  $sections[] = $section;
  return $sections;

}
endif;
add_filter( 'redux-sections-'.REDUX_OPT_NAME, 'shoestrap_module_slideshow_options', 89 );

if ( !function_exists( 'shoestrap_core_blog_comments_toggle' ) ) :
function shoestrap_core_blog_comments_toggle() {
  if ( shoestrap_getVariable( 'blog_comments_toggle' ) == 1 ) {
    remove_post_type_support( 'post', 'comments' );
    remove_post_type_support( 'post', 'trackbacks' );
    add_filter( 'get_comments_number', '__return_false', 10, 3 );
  }
}
endif;
add_action( 'init','shoestrap_core_blog_comments_toggle', 1 );

include_once( dirname(__FILE__).'/functions.slideshows.php' );
