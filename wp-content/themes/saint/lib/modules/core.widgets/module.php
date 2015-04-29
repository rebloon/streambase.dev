<?php

if ( !function_exists( 'shoestrap_remove_roots_widgets' ) ) :
/*
 * Remove default Roots widgets
 */
function shoestrap_remove_roots_widgets() {
  remove_action( 'widgets_init', 'roots_widgets_init' );
}
endif;
add_action( 'widgets_init', 'shoestrap_remove_roots_widgets', 1 );


if ( !function_exists( 'shoestrap_widgets_init' ) ) :
/**
 * Register sidebars and widgets
 */
function shoestrap_widgets_init() {
  $widgets_mode = shoestrap_getVariable( 'widgets_mode' );
  
  // AC - Force 'none' widgets as option removed
	$widgets_mode = 3;
  
  if ( $widgets_mode == 0 ) {
    $class        = 'panel panel-default';
    $before_title = '<div class="panel-heading">';
    $after_title  = '</div><div class="panel-body">';
  
  } elseif ( $widgets_mode == 1 ) {
    $class        = 'well';
    $before_title = '<h3 class="widget-title">';
    $after_title  = '</h3>';

  } else {
    $class        = '';
    $before_title = '<h3 class="widget-title">';
    $after_title  = '</h3>';

  }

  // Sidebars
  register_sidebar( array(
    'name'          => __( 'Primary Sidebar', 'shoestrap' ),
    'id'            => 'sidebar-primary',
    'description'   => 'Primary sidebar - Set sidebar layout in Theme Options.',
    'before_widget' => '<section id="%1$s" class="' . $class . ' widget %2$s">',
    'after_widget'  => '</section>',
    'before_title'  => $before_title,
    'after_title'   => $after_title,
  ));

  register_sidebar( array(
    'name'          => __( 'Secondary Sidebar', 'shoestrap' ),
    'id'            => 'sidebar-secondary',
    'description'   => 'Secondary sidebar - Set sidebar layout in Theme Options.',
    'before_widget' => '<section id="%1$s" class="' . $class . ' widget %2$s">',
    'after_widget'  => '</section>',
    'before_title'  => $before_title,
    'after_title'   => $after_title,
  ));
  
  // AC sidebars
  register_sidebar( array(
    'name'          => __( 'Blog Sidebar', 'shoestrap' ),
    'id'            => 'sidebar-blog',
    'description'   => 'Optional sidebar for use on blog pages.',
    'before_widget' => '<section id="%1$s" class="' . $class . ' widget %2$s">',
    'after_widget'  => '</section>',
    'before_title'  => $before_title,
    'after_title'   => $after_title,
  ));  
  
  register_sidebar( array(
    'name'          => __( 'Pages Sidebar', 'shoestrap' ),
    'id'            => 'sidebar-page',
    'description'   => 'Optional sidebar for use on pages.',
    'before_widget' => '<section id="%1$s" class="' . $class . ' widget %2$s">',
    'after_widget'  => '</section>',
    'before_title'  => $before_title,
    'after_title'   => $after_title,
  ));    
  
  register_sidebar( array(
    'name'          => __( 'Portfolio Sidebar', 'shoestrap' ),
    'id'            => 'sidebar-portfolio',
    'description'   => 'Optional sidebar for use on portfolio pages.',
    'before_widget' => '<section id="%1$s" class="' . $class . ' widget %2$s">',
    'after_widget'  => '</section>',
    'before_title'  => $before_title,
    'after_title'   => $after_title,
  ));      

	if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
	  register_sidebar( array(
	    'name'          => __( 'WooCommerce Sidebar', 'shoestrap' ),
	    'id'            => 'sidebar-woocommerce',
	    'description'   => 'Optional sidebar for use on WooCommerce pages.',
	    'before_widget' => '<section id="%1$s" class="' . $class . ' widget %2$s">',
	    'after_widget'  => '</section>',
	    'before_title'  => $before_title,
	    'after_title'   => $after_title,
	  ));      
	  
	}
	
  register_sidebar( array(
    'name'          => __( 'Sidebar 1', 'shoestrap' ),
    'id'            => 'sidebar-one',
    'description'   => 'Optional sidebar for use on pages.',
    'before_widget' => '<section id="%1$s" class="' . $class . ' widget %2$s">',
    'after_widget'  => '</section>',
    'before_title'  => $before_title,
    'after_title'   => $after_title,
  ));	
  
  register_sidebar( array(
    'name'          => __( 'Sidebar 2', 'shoestrap' ),
    'id'            => 'sidebar-two',
    'description'   => 'Optional sidebar for use on pages.',
    'before_widget' => '<section id="%1$s" class="' . $class . ' widget %2$s">',
    'after_widget'  => '</section>',
    'before_title'  => $before_title,
    'after_title'   => $after_title,
  ));	  
  
  register_sidebar( array(
    'name'          => __( 'Sidebar 3', 'shoestrap' ),
    'id'            => 'sidebar-three',
    'description'   => 'Optional sidebar for use on pages.',
    'before_widget' => '<section id="%1$s" class="' . $class . ' widget %2$s">',
    'after_widget'  => '</section>',
    'before_title'  => $before_title,
    'after_title'   => $after_title,
  ));	
  
  register_sidebar( array(
    'name'          => __( 'Sidebar 4', 'shoestrap' ),
    'id'            => 'sidebar-four',
    'description'   => 'Optional sidebar for use on pages.',
    'before_widget' => '<section id="%1$s" class="' . $class . ' widget %2$s">',
    'after_widget'  => '</section>',
    'before_title'  => $before_title,
    'after_title'   => $after_title,
  ));	    
	
  register_sidebar( array(
    'name'          => __( 'Footer Widget Area 1', 'shoestrap' ),
    'id'            => 'sidebar-footer-1',
    'description'   => 'Appears in the footer section of the site.',
    'before_widget' => '<section id="%1$s" class="' . $class . ' widget %2$s">',
    'after_widget'  => '</section>',
    'before_title'  => $before_title,
    'after_title'   => $after_title,
  ));

  register_sidebar( array(
    'name'          => __( 'Footer Widget Area 2', 'shoestrap' ),
    'id'            => 'sidebar-footer-2',
    'description'   => 'Appears in the footer section of the site.',
    'before_widget' => '<section id="%1$s" class="' . $class . ' widget %2$s">',
    'after_widget'  => '</section>',
    'before_title'  => $before_title,
    'after_title'   => $after_title,
  ));

  register_sidebar( array(
    'name'          => __( 'Footer Widget Area 3', 'shoestrap' ),
    'id'            => 'sidebar-footer-3',
    'description'   => 'Appears in the footer section of the site.',
    'before_widget' => '<section id="%1$s" class="' . $class . ' widget %2$s">',
    'after_widget'  => '</section>',
    'before_title'  => $before_title,
    'after_title'   => $after_title,
  ));

  register_sidebar( array(
    'name'          => __( 'Footer Widget Area 4', 'shoestrap' ),
    'id'            => 'sidebar-footer-4',
    'description'   => 'Appears in the footer section of the site.',
    'before_widget' => '<section id="%1$s" class="' . $class . ' widget %2$s">',
    'after_widget'  => '</section>',
    'before_title'  => $before_title,
    'after_title'   => $after_title,
  ));	

  // Widgets
  register_widget( 'Roots_Vcard_Widget' );
}
endif;
add_action( 'widgets_init', 'shoestrap_widgets_init' );