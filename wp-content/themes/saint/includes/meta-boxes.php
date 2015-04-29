<?php
/*******************************/
/****  Meta Boxes Includes  ****/ 
/*******************************/

// Returns the meta data for a post
function ac_get_meta( $key, $args = array(), $post_id = null )
{

	// Page level meta is only relevant on singulars, or is blog page (which WP thinks is not singular)	
	if (function_exists('rwmb_meta') && (is_singular() || ac_is_blog_page()) ) {
		return rwmb_meta( 'ac_'.$key, $args, $post_id );
	}
	else {
		return null; // return null for all options
	}
	
}

// Register the options for the theme
add_filter( 'rwmb_meta_boxes', 'ac_register_meta_boxes' );
function ac_register_meta_boxes( $meta_boxes )
{
	global $post_types_with_author_bio;

	$prefix = 'ac_';
	
	// Page Title post types
	$page_title_post_types = array('post', 'page', 'product', 'ac_portfolio', 'ac_person');
	
	// Slideshow post types
	$slideshow_post_types = array('post', 'page', 'product', 'ac_person');

	// Slideshows
	$slideshow_options = array(
		'' => __( 'None', 'alleycat'),
		'ac' => __( 'Alleycat Slider', 'alleycat')
	);
	// Add Rev Slider if installed
	if ( ac_revslider_is_installed() ) {
		$slideshow_options['revslider'] = __( 'Revolution Slider', 'alleycat');
	}
		
	// Sidebars
	$ac_mb_sidebars = array();

	foreach ( $GLOBALS['wp_registered_sidebars'] as $sidebar ) {	
		$ac_mb_sidebars[ $sidebar['id'] ] = __($sidebar['name'], 'alleycat');		
	}
	
	// Text align
	$ac_mb_text_align = array(
		'' => __( 'Left', 'alleycat'),
		'center' => __( 'Center', 'alleycat'),
		'right' => __( 'Right', 'alleycat'),
	);
	
	
	
	// -- Fields for Post Types ---

	// PORTFOLIO
	$meta_boxes[] = array(
		'id' => 'ac_portfolio',
		'title' => __( 'Portfolio Options', 'alleycat'),
		'pages' => array( 'ac_portfolio' ),
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array(

			array(
				'name'     => __( 'Template Type', 'alleycat'),
				'id'       => "{$prefix}template_type",
				'type'     => 'select',
				'options'  => array(
					'top-images' => __( 'Images at Top', 'alleycat'),
					'side-images' => __( 'Images at Side', 'alleycat'),
				),
				'std'         => 'top-images',
			),
			array(
				'name' => __( 'Open the images in a lightbox, when clicked', 'alleycat'),
				'id'   => "{$prefix}open_in_lightbox",
				'type' => 'checkbox',
				'std'  => 0,
			),									
			array(
				'name'             => __( 'Images', 'alleycat'),
				'id'               => "{$prefix}images",
				'type'             => 'image_advanced',
				'max_file_uploads' => 999,
			),
			array(
				'name' => __( 'Include the Featured Image in the portfolio', 'alleycat'),
				'id'   => "{$prefix}include_featured_image",
				'type' => 'checkbox',
				'std'  => 1,
			),			
			array(
				'name'  => __( 'External URL', 'alleycat'),
				'id'    => "{$prefix}url",
				'desc'  => __( 'Enter an external website URL for this portfolio (e.g. http://dribbble.com/yoga)', 'alleycat'),
				'type'  => 'url',
				'std'   => '',
			),			
			array(
				'name' => __( 'Show the Portfolio Sidebar?', 'alleycat'),
				'id'   => "{$prefix}show_portfolio_sidebar",
				'type' => 'checkbox',
				'std'  => 1,
			),			
			array(
				'name'     => __( 'Tile Masonry Size', 'alleycat'),
				'id'       => "{$prefix}tile_masonry_size",
				'desc'  => __( 'Select the size of the tile when the portfolio item is shown in the Tile Masonry format', 'alleycat'),				
				'type'     => 'select',
				'options'  => array(
					'' 							=> __( 'Small', 'alleycat'),
					'large' 	=> __( 'Large', 'alleycat'),
					'landscape' 		=> __( 'Landscape', 'alleycat'),
					'tall' 					=> __( 'Tall', 'alleycat'),
				),
				'std'         => '',
			),
		)
	);
	

	// PEOPLE
	$meta_boxes[] = array(
		'id' => 'ac_person',
		'title' => __( 'Person Data', 'alleycat'),
		'pages' => array( 'ac_person' ),
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array(

			array(
				'name'  => __( 'Position', 'alleycat'),
				'id'    => "{$prefix}position",
				'type'  => 'text',
				'std'   => '',
			),
			array(
				'name'  => __( 'Phone Number', 'alleycat'),
				'id'    => "{$prefix}phone_number",
				'type'  => 'text',
				'std'   => '',
			),			
			array(
				'name'  => __( 'Email Address', 'alleycat'),
				'id'    => "{$prefix}email_address",
				'type'  => 'text',
				'std'   => '',
			),
			array(
				'name'  => __( 'Website Address', 'alleycat'),
				'id'    => "{$prefix}web_address",
				'type'  => 'text',
				'std'   => '',
			),			
			array(
				'name'  => __( 'Facebook URL', 'alleycat'),
				'id'    => "{$prefix}facebook",
				'type'  => 'text',
				'std'   => '',
			),
			array(
				'name'  => __( 'Twitter URL', 'alleycat'),
				'id'    => "{$prefix}twitter",
				'type'  => 'text',
				'std'   => '',
			),
			array(
				'name'  => __( 'LinkedIn URL', 'alleycat'),
				'id'    => "{$prefix}linkedin",
				'type'  => 'text',
				'std'   => '',
			),
			array(
				'name'  => __( 'Google+ URL', 'alleycat'),
				'id'    => "{$prefix}googleplus",
				'type'  => 'text',
				'std'   => '',
			),
			array(
				'name'  => __( 'Instagram URL', 'alleycat'),
				'id'    => "{$prefix}instagram",
				'type'  => 'text',
				'std'   => '',
			),			
			array(
				'name'  => __( 'Pinterest URL', 'alleycat'),
				'id'    => "{$prefix}pinterest",
				'type'  => 'text',
				'std'   => '',
			),
			array(
				'name'  => __( 'Flickr URL', 'alleycat'),
				'id'    => "{$prefix}flickr",
				'type'  => 'text',
				'std'   => '',
			),
			array(
				'name'  => __( 'Dribble URL', 'alleycat'),
				'id'    => "{$prefix}dribbble",
				'type'  => 'text',
				'std'   => '',
			),
		)
	);
	
	
	// CLIENT
	$meta_boxes[] = array(
		'id' => 'ac_client',
		'title' => __( 'Client Data', 'alleycat'),
		'pages' => array( 'ac_client' ),
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array(
			array(
				'name'     => __( 'Client Link', 'alleycat'),
				'id'       => "{$prefix}client_link",
				'desc'  => __( 'Enter the link for the client if you want the image to be clickable. (e.g. http://alleycatthemes.com/)', 'alleycat'),
				'type'  => 'url',
				'std'   => '',
			),			
		)
	);	
		
	
	// PAGES
	$meta_boxes[] = array(
		'id' => 'ac_page_title',
		'title' => __( 'Page Options', 'alleycat'),
		'pages' => $page_title_post_types,
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array(
			array(
				'name' => __( 'Show Share Buttons', 'alleycat'),
				'id'   => "{$prefix}page_show_share_buttons",
				'type' => 'checkbox',
				'std'  => false,
				'desc'  => __( 'Show the share buttons at the bottom of the page.', 'alleycat'),
			),
			array(
				'name' => __( 'Full Width Page', 'alleycat'),
				'id'   => "{$prefix}page_full_width",
				'type' => 'checkbox',
				'std'  => 0,
				'desc'  => __( 'Make the page the full width of the browser, ignoring any theme width settings.', 'alleycat'),
			),			
			array(
				'name' => __('Page Menu', 'alleycat'),
				'id'   => "{$prefix}page_menu",
				'type' => 'select',
				'options' => ac_get_menu_list(),
				'multiple' => false,
				'std'  => '',
				'desc' => __('Select a menu to use on this page.  This is great for One Page menus.', 'alleycat'),
			),		
			array(
				'name'     => __( 'Transparent Header', 'alleycat'),
				'id'       => "{$prefix}page_transparent_header",
				'type'     => 'select',
				'options'  => array(
					'' 				=> __( 'Automatic', 'alleycat'),
					'disable' => __( 'Disable', 'alleycat'),
					'force' 	=> __( 'Force', 'alleycat'),
				),
				'multiple'    => false,
				'std'         => ''
			),			
			array(
				'name' => __( 'Hide Featured Image', 'alleycat'),
				'id'   => "{$prefix}page_hide_featured_image",
				'type' => 'checkbox',
				'std'  => false,
				'desc'  => __( 'Hide the Featured Image at the top of the page.', 'alleycat'),
			),							
			array(
				'type' => 'heading',
				'name' => __( 'Page Title', 'alleycat'),
				'id'   => 'page_title_heading',
				'class' => 'ac-page-title'
			),		
			array(
				'name'     => __( 'Page Title Type', 'alleycat'),
				'id'       => "{$prefix}page_title_type",
				'type'     => 'select',
				'options'  => array(
					'standard' => __( 'Standard', 'alleycat'),
					'custom' => __( 'Custom', 'alleycat'),
					'none' => __( 'None', 'alleycat'),
				),
				'multiple'    => false,
				'std'         => '0',
				'class' => 'ac-page-title'				
			),
			array(
				'name'     => __( 'Page Subtitle', 'alleycat'),
				'id'       => "{$prefix}page_subtitle",
				'type'     => 'text',
				'std'   => '',
				'class' => 'ac-page-subtitle'
			),
			array(
				'name'     => __( 'Text Color', 'alleycat'),
				'id'   => "{$prefix}page_title_title_color",
				'type' => 'color',
				'class' => 'ac_page_title_advanced',
			),						
			array(
				'name'     => __( 'Background Color', 'alleycat'),
				'id'   => "{$prefix}page_title_bg_color",
				'type' => 'color',
				'class' => 'ac_page_title_advanced',
			),			
			array(
				'name'             => __( 'Background Image', 'alleycat'),
				'id'               => "{$prefix}page_title_image",
				'type'             => 'image_advanced',
				'max_file_uploads' => 1,
				'class' => 'ac_page_title_advanced',				
			),			
			array(
				'name'    => __( 'Title Align', 'alleycat'),
				'id'      => "{$prefix}page_title_align",
				'type'    => 'radio',
				'options' => $ac_mb_text_align,
				'class' => 'ac_page_title_advanced',				
			),
			array(
				'type' => 'heading',
				'name' => __( 'Padding', 'alleycat'),
				'id'   => 'padding_heading',
			),
			array(
				'name' => __( 'Remove Top Spacing', 'alleycat'),
				'id'   => "{$prefix}page_no_top_space",
				'type' => 'checkbox',
				'std'  => 0,
				'desc'  => __( 'Remove the spacing at the top of the page.', 'alleycat'),
			),			
			array(
				'name' => __( 'Remove Bottom Spacing', 'alleycat'),
				'id'   => "{$prefix}page_no_bottom_space",
				'type' => 'checkbox',
				'std'  => 0,
				'desc'  => __( 'Remove the spacing at the bottom of the page.', 'alleycat'),				
			),
		)
	);	
	
	// SLIDESHOW		
	// Build the array without Rev Slider
	$slideshows = array(
		'id' => 'ac_slideshow',
		'title' => __( 'Slideshow', 'alleycat'),
		'pages' => $slideshow_post_types,
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array(
			array(
				'name'     => __( 'Slideshow Type', 'alleycat'),
				'id'       => "{$prefix}slideshow_type",
				'type'     => 'select',
				'options'  => $slideshow_options,
				'multiple'    => false,
				'std'         => '',
			),			
			array(
				'name'             => __( 'Alleycat Slideshow Images', 'alleycat'),
				'id'               => "{$prefix}images",
				'type'             => 'image_advanced',
				'max_file_uploads' => 999,
				'class'						 => 'ac_slideshow_images_row'
			),
			array(
				'name' => __( 'Include the Featured Image as the first slide in the slideshow', 'alleycat'),
				'id'   => "{$prefix}include_featured_image",
				'type' => 'checkbox',
				'std'  => 1,
			),						
								
		)
	);
	// Rev slider.  Check for Rev Slider and add to the array if installed
	if ( ac_revslider_is_installed() ) {
	
		// Create the arry
		$rev_sliders_select = array(
				'name'  => __( 'Revolution Slideshow', 'alleycat'),
				'id'    => "{$prefix}revolution_slideshow",
				'type'     => 'select',
				'options'  => ac_get_revsliders(),
				'multiple'    => false,
				'std'         => '0',
				
		);
		
		// Add to the correct position
		array_splice($slideshows['fields'], 2, 0, array($rev_sliders_select));
	};
	// Add slideshows to the main array	
	$meta_boxes[] = $slideshows;
	
	// SIDEBARS
	$meta_boxes[] = array(
		'id' => 'ac_sidebar',
		'title' => __( 'Sidebar Options', 'alleycat'),
		'pages' => array( 'post', 'page' ),
		'context' => 'side',
		'priority' => 'low',
		'fields' => array(		
		
			array(
				'name'     => __( 'Sidebars', 'alleycat'),
				'id'       => "{$prefix}layout_override",
				'type'     => 'select',
				'options'  => array(
					'0' => __( 'Default', 'alleycat'),
					'1' => __( 'Override', 'alleycat'),
				),
				'std'         => '0',
			),		
		
			array(
				'name'     => __( 'Sidebar Layout', 'alleycat'),
				'id'       => "{$prefix}layout",
				'type'     => 'image_select',
				'class'		 => 'sidebar_layout',
				'options'  => array(
	        0         => ReduxFramework::$_url . '/assets/img/1c.png',
	        1         => ReduxFramework::$_url . '/assets/img/2cr.png',
	        2         => ReduxFramework::$_url . '/assets/img/2cl.png',
	        3         => ReduxFramework::$_url . '/assets/img/3cl.png',
	        4         => ReduxFramework::$_url . '/assets/img/3cr.png',
	        5         => ReduxFramework::$_url . '/assets/img/3cm.png',
				),
				'std'         => 'one',
			),

			array(
				'name'     => __( 'Left Sidebar', 'alleycat'),
				'id'       => "{$prefix}left_sidebar",
				'type'     => 'select',
				'options'  => $ac_mb_sidebars,
				'multiple'    => false,
				'std'         => '-1',
			),

			array(
				'name'     => __( 'Right Sidebar', 'alleycat'),
				'id'       => "{$prefix}right_sidebar",
				'type'     => 'select',
				'options'  => $ac_mb_sidebars,
				'multiple'    => false,
				'std'         => '-1',
			),
		
		)
	);
	
	// AUTHOR
	$meta_boxes[] = array(
		'id' => 'ac_author',
		'title' => __( 'Author Info', 'alleycat'),
		'pages' => $post_types_with_author_bio,
		'context' => 'side',
		'priority' => 'low',
		'fields' => array(
			array(
				'name'     	=> __( 'Show Author Bio', 'alleycat'),
				'id'       	=> "{$prefix}author_bio_show",
				'type'     	=> 'select',
				'options'  	=> array(
					'' 				=> __( 'Default', 'alleycat'),
					'true' 		=> __( 'Yes', 'alleycat'),
					'false' 	=> __( 'No', 'alleycat'),					
				),
				'desc'  		=> __( 'Default will use the settings from the Theme Options.', 'alleycat'),				
				'multiple'  => false,
				'std'       => '',
			),											
		)
	);	
	

	// TESTIMONIALS
	$meta_boxes[] = array(
		'id' => 'ac_testimonial',
		'title' => __( 'Testimonial Data', 'alleycat'),
		'pages' => array( 'ac_testimonial' ),
		'context' => 'normal',
		'priority' => 'high',
		'fields' => array(

			array(
				'name'  => __( 'Author Information', 'alleycat'),
				'id'    => "{$prefix}author",
				'type'  => 'wysiwyg',
				'std'   => '',
				'options' => array(
					'textarea_rows' => 4,
					'teeny'         => true,
					'media_buttons' => false,
				),				
			),
			array(
				'name'  => __( 'Author URL', 'alleycat'),
				'id'    => "{$prefix}author_url",
				'type'  => 'url',
				'std'   => '',
			),
			
		)
	);
	
	// Apply a filter in case the child theme wants to edit
	$meta_boxes = apply_filters('ac_edit_meta_boxes', $meta_boxes);
	
	return $meta_boxes;		

}


/**********************************/
/****  WP Meta Boxes Function  ****/ 
/**********************************/

// Set meta box hidden defaults
function ac_default_hidden_meta_boxes( $hidden, $screen ) {
	
	// Set Rev Slider dropdown to hidden
	$hidden[] = 'mymetabox_revslider_0';

	return $hidden;
}
 
add_action( 'default_hidden_meta_boxes', 'ac_default_hidden_meta_boxes', 10, 2 );