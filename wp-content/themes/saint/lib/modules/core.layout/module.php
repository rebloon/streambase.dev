<?php

/*
 * The layout core options for the Shoestrap theme
 */
if ( !function_exists( 'shoestrap_module_layout_options' ) ) :
function shoestrap_module_layout_options( $sections ) {

	// AC - Get a helper object
	$ac_redux = new AC_Redux();

  // Layout Settings
  $section = array( 
    'title'       => __( 'Layout', 'shoestrap' ),
    'icon'        => 'el-icon-screen icon-large',
    'description' => '<p>In this area you can select your site\'s layout, the width of your sidebars, as well as other, more advanced options.</p>',
  );

  $fields[] = array( 
    'title'     => __( 'Site Style', 'shoestrap' ),
    'desc'      => __( 'Select the default site layout. <br>Wide - Headers and footers stretch to the edges.  The content fits inside a box<br>Boxed - Headers, footers and the content fit inside a single box', 'shoestrap' ),
    'id'        => 'site_style',
    'default'   => 'wide',
    'type'      => 'image_select',
    'customizer'=> array(),
    'options'   => array( 
      'wide'         => AC_TEMPLATE_URI . '/assets/img/fw.png',
      'boxed'        => AC_TEMPLATE_URI . '/assets/img/boxed.png',
		),
    'compiler'  => true,
  );

  $fields[] = array( 
    'title'     => __( 'Layout', 'shoestrap' ),
    'desc'      => __( 'Select main content and sidebar arrangement. Choose between 1, 2 or 3 column layout.', 'shoestrap' ),
    'id'        => 'layout',
    'default'   => 0,
    'type'      => 'image_select',
    'customizer'=> array(),
    'options'   => array( 
      0         => ReduxFramework::$_url . '/assets/img/1c.png',
      1         => ReduxFramework::$_url . '/assets/img/2cr.png',
      2         => ReduxFramework::$_url . '/assets/img/2cl.png',
      3         => ReduxFramework::$_url . '/assets/img/3cl.png',
      4         => ReduxFramework::$_url . '/assets/img/3cr.png',
      5         => ReduxFramework::$_url . '/assets/img/3cm.png',
    )
  );
  // AC - Super sidebars 
  $fields[] = array( 
    'title'     => __( 'Left Sidebar', 'shoestrap' ),
    'desc'      => __( 'Select the Left sidebar', 'shoestrap' ),
    'id'        => 'layout_left_sidebar',
    'default'   => 'Sidebar-secondary',
    'type'      => 'select',
    'required'  => array( 'layout','=',array( '2', '3', '4', '5' ) ),
    'customizer'=> array(),
    'options'   => $ac_redux->get_sidebar_options()
  );    
  
  $fields[] = array( 
    'title'     => __( 'Right Sidebar', 'shoestrap' ),
    'desc'      => __( 'Select the Right sidebar', 'shoestrap' ),
    'id'        => 'layout_right_sidebar',
    'default'   => 'Sidebar-primary',
    'type'      => 'select',
    'required'  => array( 'layout','=',array( '1', '3', '4', '5' ) ),
    'customizer'=> array(),
    'options'   => $ac_redux->get_sidebar_options()
  );  
  
  
  // Homepage layout
  $fields[] = array(
    'title'     => __( 'Custom Layout for Homepage', 'shoestrap' ),
    'desc'      => __( 'Set the layout for the homepage.', 'shoestrap' ),
    'id'        => 'cpt_home_layout_toggle',
    'default'   => 0,
    'type'      => 'switch',
    'customizer'=> array(),
  );  
  
  $fields[] = array( 
    'title'     => __( 'Homepage Layout', 'shoestrap' ),
    'desc'      => __( 'Select the content and sidebar arrangement. Choose between 1, 2 or 3 column layout.', 'shoestrap' ),
    'id'        => 'home_layout',
    'default'   => 0,
    'type'      => 'image_select',
    'customizer'=> array(),
    'required'  => array( 'cpt_home_layout_toggle','=',array( '1' ) ),    
    'options'   => array( 
      0         => ReduxFramework::$_url . '/assets/img/1c.png',
      1         => ReduxFramework::$_url . '/assets/img/2cr.png',
      2         => ReduxFramework::$_url . '/assets/img/2cl.png',
      3         => ReduxFramework::$_url . '/assets/img/3cl.png',
      4         => ReduxFramework::$_url . '/assets/img/3cr.png',
      5         => ReduxFramework::$_url . '/assets/img/3cm.png',
    )
  );
  
  $fields[] = array( 
    'title'     => __( 'Homepage Left Sidebar', 'shoestrap' ),
    'desc'      => __( 'Select the Left sidebar', 'shoestrap' ),
    'id'        => 'home_layout_left_sidebar',
    'default'   => 'Sidebar-page',
    'type'      => 'select',
    'required'  => array( 'home_layout','=',array( '2', '3', '4', '5' ) ),
    'customizer'=> array(),
    'options'   => $ac_redux->get_sidebar_options()
  );    

  $fields[] = array( 
    'title'     => __( 'Homepage Right Sidebar', 'shoestrap' ),
    'desc'      => __( 'Select the Right sidebar', 'shoestrap' ),
    'id'        => 'home_layout_right_sidebar',
    'default'   => 'Sidebar-page',
    'type'      => 'select',
    'required'  => array( 'home_layout','=',array( '1', '3', '4', '5' ) ),
    'customizer'=> array(),
    'options'   => $ac_redux->get_sidebar_options()
  );   
  
  // Archive layout
  $fields[] = array(
    'title'     => __( 'Custom Layout for Archives (categories, tags, authors, dates)', 'shoestrap' ),
    'desc'      => __( 'Set the layout for Archives.  Note: This does not affect the blog page, as you can set the sidebars on the blog page itself.', 'shoestrap' ),
    'id'        => 'cpt_archive_layout_toggle',
    'default'   => 1,
    'type'      => 'switch',
    'customizer'=> array(),
  );  
  
  $fields[] = array( 
    'title'     => __( 'Archive Layout', 'shoestrap' ),
    'desc'      => __( 'Select the content and sidebar arrangement. Choose between 1, 2 or 3 column layout.', 'shoestrap' ),
    'id'        => 'archive_layout',
    'default'   => 1,
    'type'      => 'image_select',
    'customizer'=> array(),
    'required'  => array( 'cpt_archive_layout_toggle','=',array( '1' ) ),    
    'options'   => array( 
      0         => ReduxFramework::$_url . '/assets/img/1c.png',
      1         => ReduxFramework::$_url . '/assets/img/2cr.png',
      2         => ReduxFramework::$_url . '/assets/img/2cl.png',
      3         => ReduxFramework::$_url . '/assets/img/3cl.png',
      4         => ReduxFramework::$_url . '/assets/img/3cr.png',
      5         => ReduxFramework::$_url . '/assets/img/3cm.png',
    )
  );
  
  $fields[] = array( 
    'title'     => __( 'Archive Left Sidebar', 'shoestrap' ),
    'desc'      => __( 'Select the Left sidebar', 'shoestrap' ),
    'id'        => 'archive_layout_left_sidebar',
    'type'      => 'select',
    'required'  => array( 
    	'archive_layout','=',array( '2', '3', '4', '5' )
    ),    
    'customizer'=> array(),
    'options'   => $ac_redux->get_sidebar_options()
  );    
  
  $fields[] = array( 
    'title'     => __( 'Archive Right Sidebar', 'shoestrap' ),
    'desc'      => __( 'Select the Right sidebar', 'shoestrap' ),
    'id'        => 'archive_layout_right_sidebar',
    'type'      => 'select',
    'required'  => array( 'archive_layout','=',array( '1', '3', '4', '5' ) ),
    'customizer'=> array(),
    'options'   => $ac_redux->get_sidebar_options()
  );  
  
  // Archive post layout
  $fields[] = array( 
    'title'     => __( 'Archive Post Style', 'shoestrap' ),
    'desc'      => __( 'Select the style to use for Archive pages.', 'shoestrap' ),
    'id'        => 'archive_post_style',
    'default'   => 'grid',
    'type'      => 'select',
    'customizer'=> array(),
    'options'   => array(
      'posts'  => __( 'Standard', 'shoestrap' ),
      'grid'    => __( 'Grid', 'shoestrap' ),
      'masonry'   => __( 'Masonry', 'shoestrap' ),
    ),
  );	

  $fields[] = array( 
    'title'     => __( 'Archive Grid Columns', 'shoestrap' ),
    'desc'      => __( 'Select the number of columns for Grid and Masonry post styles.', 'shoestrap' ),
    'id'        => 'archive_grid_cols',
    'default'   => '3',
    'type'      => 'select',
    'customizer'=> array(),
    'required'    => array( 
    	'archive_post_style', '=', array('grid', 'masonry', 'tile') 
    ),
    'options'   => array(
      '2' => __( '2', 'shoestrap' ),
      '3' => __( '3', 'shoestrap' ),
      '4' => __( '4', 'shoestrap' ),
    ),
  );	

	// Post type layout
  $fields[] = array(
    'title'     => __( 'Custom Layouts per Post Type', 'shoestrap' ),
    'desc'      => __( 'Set a default layout for each post type.', 'shoestrap' ),
    'id'        => 'cpt_layout_toggle',
    'default'   => 0,
    'type'      => 'switch',
    'customizer'=> array(),
  );

  $post_types = get_post_types( array( 'public' => true ), 'objects' ); // AC objects is better
  foreach ( $post_types as $post_type ) :
  	// AC Super sidebars
  	// Only include types that support sidebars
  	if ( ac_post_type_has_sidebar($post_type->name) ) :

	    $fields[] = array(
	      'title'     => __( $post_type->labels->name . ' Layout', 'shoestrap' ),
	      'desc'      => __( 'Override the default layout.', 'shoestrap' ),
	      'id'        => $post_type->name . '_layout',
	      'default'   => shoestrap_getVariable( 'layout' ),
	      'type'      => 'image_select',
	      'required'  => array( 'cpt_layout_toggle','=',array( '1' ) ),
	      'options'   => array(
	        0         => ReduxFramework::$_url . '/assets/img/1c.png',
	        1         => ReduxFramework::$_url . '/assets/img/2cr.png',
	        2         => ReduxFramework::$_url . '/assets/img/2cl.png',
	        3         => ReduxFramework::$_url . '/assets/img/3cl.png',
	        4         => ReduxFramework::$_url . '/assets/img/3cr.png',
	        5         => ReduxFramework::$_url . '/assets/img/3cm.png',
	      )
	    );
	   
		  $fields[] = array( 
		    'title'     => __( $post_type->labels->name .' Left Sidebar', 'shoestrap' ),
		    'desc'      => __( 'Select the Left sidebar to show on '.$post_type->labels->name, 'shoestrap' ),
		    'id'        => $post_type->name . '_layout_left_sidebar',
		    'type'      => 'select',
		    'required'  => array( $post_type->name . '_layout','=',array( '2', '3', '4', '5' ) ),    
		    'customizer'=> array(),
		    'options'   => $ac_redux->get_sidebar_options()
		  );    
		  
		  $fields[] = array( 
		    'title'     => __( $post_type->labels->name.' Right Sidebar', 'shoestrap' ),
		    'desc'      => __( 'Select the Right sidebar to show on '.$post_type->labels->name, 'shoestrap' ),
		    'id'        => $post_type->name . '_layout_right_sidebar',
		    'type'      => 'select',
		    'required'  => array( $post_type->name . '_layout','=',array( '1', '3', '4', '5' ) ),
		    'customizer'=> array(),
		    'options'   => $ac_redux->get_sidebar_options()
		  );  
		
		endif;

  endforeach; 

  $fields[] = array( 
    'title'     => __( 'Left Sidebar Width', 'shoestrap' ),
    'desc'      => __( 'Select the number of columns for the Left Sidebar. The page is 12 columns wide.', 'shoestrap' ),
    'id'        => 'layout_primary_width',
    'type'      => 'button_set',
    'options'   => array(
      '1' => '1 Column',
      '2' => '2 Columns',
      '3' => '3 Columns',
      '4' => '4 Columns',
      '5' => '5 Columns'
    ),
    'default' => '3'
  );
  
  $fields[] = array( 
    'title'     => __( 'Right Sidebar Width', 'shoestrap' ),
    'desc'      => __( 'Select the number of columns for the Right Sidebar. The page is 12 columns wide.', 'shoestrap' ),
    'id'        => 'layout_secondary_width',
    'type'      => 'button_set',
    'options'   => array(
      '1' => '1 Column',
      '2' => '2 Columns',
      '3' => '3 Columns',
      '4' => '4 Columns',
      '5' => '5 Columns'
    ),
    'default' => '3'
  );  

	// AC addition  
  $fields[] = array( 
    'title'     => __( 'Subtle sidebars', 'shoestrap' ),
    'desc'      => __( 'Should the sidebars be slightly fainter than the content until hovered over?', 'shoestrap' ),
    'id'        => 'ac_sidebar_faint',
    'default'		=> 1,
    'type'      => 'switch',
    'customizer'=> array(),
  );
  
  $fields[] = array( 
    'title'     => __( 'Custom Grid', 'shoestrap' ),
    'desc'      => __( 'Activate to customise grid sizes for mobile, tablet and desktop.  For advanced users only.', 'shoestrap' ),
    'id'        => 'custom_grid',
    'default'   => 0,
    'type'      => 'switch',
  );

  $fields[] = array( 
    'title'     => __( 'Small Screen / Tablet view', 'shoestrap' ),
    'desc'      => __( 'The width of Tablet screens. Default: 768px', 'shoestrap' ),
    'id'        => 'screen_tablet',
    'required'  => array('custom_grid','=',array('1')),
    'default'   => 768,
    'min'       => 620,
    'step'      => 2,
    'max'       => 2100,
    'advanced'  => true,
    'compiler'  => true,
    'type'      => 'slider'
  );

  $fields[] = array( 
    'title'     => __( 'Desktop Container Width', 'shoestrap' ),
    'desc'      => __( 'The width of normal screens. Default: 992px', 'shoestrap' ),
    'id'        => 'screen_desktop',
    'required'  => array('custom_grid','=',array('1')),
    'default'   => 992,
    'min'       => 620,
    'step'      => 2,
    'max'       => 2100,
    'advanced'  => true,
    'compiler'  => true,
    'type'      => 'slider',

  );

  $fields[] = array( 
    'title'     => __( 'Large Desktop Container Width', 'shoestrap' ),
    'desc'      => __( 'The width of Large Desktop screens. Default: 1200px', 'shoestrap' ),
    'id'        => 'screen_large_desktop',
    'required'  => array('custom_grid','=',array('1')),
    'default'   => 1200,
    'min'       => 620,
    'step'      => 2,
    'max'       => 2100,
    'advanced'  => true,
    'compiler'  => true,
    'type'      => 'slider'
  );

  $fields[] = array( 
    'title'     => __( 'Columns Gutter', 'shoestrap' ),
    'desc'      => __( 'The space between the columns in your grid. Default: 30px', 'shoestrap' ),
    'id'        => 'layout_gutter',
    'required'  => array('custom_grid','=',array('1')),
    'default'   => 30,
    'min'       => 2,
    'step'      => 2,
    'max'       => 100,
    'advanced'  => true,
    'compiler'  => true,
    'type'      => 'slider',
  );

  $section['fields'] = $fields;

  do_action( 'shoestrap_module_layout_options_modifier' );
  
  $sections[] = $section;
  return $sections;

}
endif;
add_filter( 'redux/options/'.REDUX_OPT_NAME.'/sections', 'shoestrap_module_layout_options', 55 ); 


include_once( dirname( __FILE__ ).'/functions.layout.php' );
