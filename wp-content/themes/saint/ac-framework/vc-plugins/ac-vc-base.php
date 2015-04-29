<?php
/***********************************/
/**** Alleycat VC Plugins Base  ****/ 
/***********************************/

// Base class for all AC VC plugins to inherit from
// Contains common methods
abstract class AC_VC_Base extends WPBakeryShortCode {

	// Settings for this plugin  
  protected $content_has_container = true; // Does the main content have a 'container' class.

	// Returns the CSS for the outer container based on the object settings
  protected function build_outer_css($atts, $content = null) {
  
  	// Make all of the atts local variables, establish some defaults
		extract(shortcode_atts(array(
	    'el_class' => '',		
			'css_animation' => '',
			'css' => '',
			'css_extra_class' => '',		
	  ), $atts));
	  
	  // Prepare variables
	  $container_class = '';
	  if ($this->content_has_container) {
			$container_class = ' container ';  
	  }
  
	  // Css class
		$css_class =  apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $this->settings['base'].' wpb_content_element '.$container_class.$el_class.vc_shortcode_custom_css_class( $css, ' ' ), $this->settings['base'], $atts );
		$css_class .= $this->getCSSAnimation($css_animation); 		
		
	  // Extra CSS
	  $css_class .= ' '.$css_extra_class.' ';		
			  
	  return $css_class;
  
  }
  
  // Returns the HTML for the Title
  protected function get_title($title) {
  
  	$title = trim($title);
  
	  if ($title) {
			$title = "<div class='ac-vc-title'><span class='vc_sep_holder'><span class='vc_sep_line'></span></span><h2>".__($title, 'alleycat')."</h2><span class='vc_sep_holder'><span class='vc_sep_line'></span></span></div>";
	  }
	  
	  return $title;
  }
  
  // Returns the url part of the link
  protected function get_link_url($href, $class = '') {
  
  	// Break apart in array
  	$href = vc_build_link($href);
  	
  	// Make variables
  	extract($href);
  	  
	  $url = trim($url);

  	return $url;
  
  }  
  
  // Return the start of the anchor
  // Accepts a VC Link string
  protected function get_link_start($href, $class = '') {
  
  	// Break apart in array
  	$href = vc_build_link($href);
  	
  	// Make variables
  	extract($href);
  	  
	  $url = trim($url);

  	if ( $url ) {
  	  	
			// Add a title if defined  		
  		if ($title) {
	  		$title = " title='".esc_attr(__($title, 'alleycat'))."' ";
  		}  	
  	
  		// Add a target if defined
  		if ($target) {
	  		$target = " target='".esc_attr($target)."' ";
  		}		
  		
  		// Add a class if defined
  		if ($class) {
	  		$class = " class='".esc_attr($class)."' ";
  		}		 		
  	
		  return "<a href='$url' $title $target $class>";
  	}
  	
  	return '';

  }
  

  // Return the end of the anchor
  protected function get_link_end($href) {
  
  	// Break apart in array
  	$href = vc_build_link($href);
  	
  	// Make variables
  	extract($href);  

	  $url = trim($url);

  	if ( $url ) {
		  return "</a>";
  	}
  	
  	return '';
	  
  }

	// Remove open </p> etc  
  protected function fixPContent($content = null) {
	  $content = preg_replace( '#^<\/p>|^<br \/>|<p>$#', '', $content );
	  $s = array(
	              '/'.preg_quote('</div>', '/').'[\s\n\f]*'.preg_quote('</p>', '/').'/i',
	              '/'.preg_quote('<p>', '/').'[\s\n\f]*'.preg_quote('<div ', '/').'/i',
	              '/'.preg_quote('<p>', '/').'[\s\n\f]*'.preg_quote('<section ', '/').'/i',
	              '/'.preg_quote('</section>', '/').'[\s\n\f]*'.preg_quote('</p>', '/').'/i'
	            );
	  $r = array("</div>", "<div ", "<section ", "</section>");
	  $content = preg_replace($s, $r, $content);
	  $content = trim($content);
	  return $content;
  }  
  
  
  
}





//
//  Common fields for utils
//===================================

// Base utils for AC VC Plugins
global $ac_vc_title,
	$ac_vc_css_animation, 
	$ac_vc_css_image_border_shape, 
	$ac_vc_css_class,
	$ac_vc_design_options;
	
// title field
$ac_vc_title = array(
  "type" => "textfield",
  "heading" => __("Title", "alleycat"),
  "param_name" => "title",
  "description" => __("Enter a title to appear above the content.", "alleycat"),
  'class' => 'ac_vc_visual_options'
);
	
// CSS animations
$ac_vc_css_animation = array(
  "type" => "dropdown",
  "heading" => __("Animation", "alleycat"),
  "param_name" => "css_animation",
  "admin_label" => true,
  "value" => array(
  	__("No", "alleycat") => '', 
  	__("Top to bottom", "alleycat") => "top-to-bottom", 
  	__("Bottom to top", "alleycat") => "bottom-to-top", 
  	__("Left to right", "alleycat") => "left-to-right", 
  	__("Right to left", "alleycat") => "right-to-left", 
  	__("Appear from center", "alleycat") => "appear"),
  "description" => __("Select animation type if you want this element to be animated when it appears. Note: Works only in modern browsers.", "alleycat"),
  'class' => 'ac_vc_visual_options'
);

// CSS Class field
$ac_vc_css_class = array(
  "type" => "textfield",
  "heading" => __("CSS Class", "alleycat"),
  "param_name" => "css_extra_class",
  "description" => __("Enter CSS classes separated by a space to apply them to the element.", "alleycat"),
  'class' => 'ac_vc_visual_options'
);

// Image border shape
$ac_vc_css_image_border_shape = array(
  "type" => "dropdown",
  "heading" => __("Image Shape", "alleycat"),
  "param_name" => "img_border_shape",
  "admin_label" => true,
  "value" => array(
  	__("Square", "alleycat") => '', 
  	__("Square with Rounded Corners", "alleycat") => "rounded-corners-border",
  	__("Circle", "alleycat") => "circle-border"
  )
);

// VC Design Options Tab
$ac_vc_design_options =  array(
  'type' => 'css_editor',
  'heading' => __( 'Css', 'alleycat' ),
  'param_name' => 'css',
  'group' => __( 'Design options', 'alleycat' )
);



//
//  Common base fields for post builder plugins
//=====================================================

// Base builder params

// Returns the parmams for the given post type
// $base = base component (sub class) base name.  Only needed if different from post_type
function ac_vc_base_get_builder_params( $post_type, $category = '', $base = '' ) {

	global $ac_vc_title,
		$ac_vc_css_animation, 
		$ac_vc_css_image_border_shape, 
		$ac_vc_css_class,
		$ac_vc_design_options;
		
	// Base name
	// If no base is provided we assume it's the same as the $post_type
	if (! $base) {
		$base = $post_type;
	}
	
	// Build the param array that we will return
	$params = array();
	
	// Title
	$params[] = $ac_vc_title;
	
	// Layout
	// Reduced layout for some post types
	if ($base == 'ac_gallery') {
		$layouts = array(
	  	__("Tile", "alleycat") => "tile",
	  	__("Carousel", "alleycat") => "carousel",
	  	__("Slider", "alleycat") => "slider",	  		
		);
	}
	elseif ($base == 'ac_galleries') { 
		$layouts = array(
	  	__("Grid", "alleycat") => "grid",
	  	__("Masonry Grid", "alleycat") => "masonry",
	  	__("Tile", "alleycat") => "tile",	
	  	__("Carousel", "alleycat") => "carousel",
	  	__("Slider", "alleycat") => "slider",
	  	__("Showcase", "alleycat") => "showcase",
		);
	}
	else if ($base == 'ac_client') {
		$layouts = array(
	  	__("Grid", "alleycat") => "grid",
	  	__("Masonry Grid", "alleycat") => "masonry",
	  	__("Tile", "alleycat") => "tile",	
	  	__("Carousel", "alleycat") => "carousel",
		);
	}
	else if ($base == 'ac_testimonial') {
		$layouts = array(
	  	__("Standard", "alleycat") => "posts",
	  	__("Grid", "alleycat") => "grid",
	  	__("Masonry Grid", "alleycat") => "masonry",
	  	__("Masonry Tile", "alleycat") => "tile-masonry",	
	  	__("Carousel", "alleycat") => "carousel",
	  	__("Slider", "alleycat") => "slider",
	  	__("Showcase", "alleycat") => "showcase",
		);
	}
	elseif ($base == 'ac_product') { // WooCommerce product
		$layouts = array(
	  	__("Carousel", "alleycat") => "carousel",	  	
		);
	}
	else {
		$layouts = array(
	  	__("Standard", "alleycat") => "posts",
	  	__("Grid", "alleycat") => "grid",
	  	__("Masonry Grid", "alleycat") => "masonry",
	  	__("Tile", "alleycat") => "tile",	
	  	__("Masonry Tile", "alleycat") => "tile-masonry",	
	  	__("Carousel", "alleycat") => "carousel",
	  	__("Slider", "alleycat") => "slider",
	  	__("Showcase", "alleycat") => "showcase",
		);
	}
	
	$params[] = array(
	  "type" => "dropdown",
	  "heading" => __("Layout", "alleycat"),
	  "param_name" => "layout",
	  "value" => $layouts,
	);
	
	// Columns
	// Grid and Masonry (less cols)
	$params[]	= array(
		  "type" => "dropdown",
		  "heading" => __("Columns", "alleycat"),
		  "param_name" => "column_count",
		  "value" => array(
		  	__("2", "alleycat") => "2",
		  	__("3", "alleycat") => "3",
		  	__("4", "alleycat") => "4",
		  ),
	    "dependency" => Array('element' => "layout", 'value' => array('grid', 'masonry'))
	);

	// Tiles (more cols)	
	$params[]	= array(
		  "type" => "dropdown",
		  "heading" => __("Columns", "alleycat"),
		  "param_name" => "column_count_tile",
		  "value" => array(
		  	__("2", "alleycat") => "2",
		  	__("3", "alleycat") => "3",
		  	__("4", "alleycat") => "4",
		  	__("6", "alleycat") => "6",
		  ),
	    "dependency" => Array('element' => "layout", 'value' => array('tile', 'tile-masonry'))
	);	
		

	// Category
	// If we have a category build the categories
	if ($category) {
	
			// -- Categories --
			$the_categories = array();
						
			// Get the cats for this post type/taxonomy
			$categories = get_categories(array(
				'taxonomy' => $category
			));
		
			// Build an array for the dropdown from the list
			$the_categories[__('All', "alleycat")] = '';
			foreach($categories as $this_category) {
				$the_categories[__($this_category->name, "alleycat")] = $this_category->term_id;
			}
		
			// Category
			$params[] = array(
			  "type" => "dropdown",
			  "heading" => __("Category", "alleycat"),
			  "param_name" => "ac_cat",
			  "value" => $the_categories,
			  "description" => __("Select a category to limit the posts.", "alleycat"),
				'class' => 'ac_vc_visual_options'
			);
		
	}
		
	// Order
	if ($base != 'ac_gallery') {	
		$params[] = array(
			  "type" => "dropdown",
			  "heading" => __("Order", "alleycat"),
			  "param_name" => "ac_order",
			  "value" => array(
			  	__("Date - Newest First", "alleycat") => "order_date_desc",
			  	__("Date - Oldest First", "alleycat") => "order_date_asc",		  
			  	__("Title - A-Z", "alleycat") => "order_title_asc",
			  	__("Title - Z-A", "alleycat") => "order_title_desc",
			  )
		);
	};
		
	// Post selector
	$post_selector = '';
	
	if ($base == 'ac_gallery') {
		// Show a list of galleries to choose from, include the homepage
		
		// Get the galleries
		$posts = ac_gallery_get_gallery_posts(false, true);

		// Convert to the select
		$galleries = array();
		foreach($posts as $post) {
			$galleries[__($post->post_title, 'alleycat')] = $post->ID;
		}
		
		$params[] = array(
		  "type" => "dropdown",
		  "heading" => __("Gallery", "alleycat"),
		  "param_name" => "post_parent",
	    "description" => __("Select the gallery to show.", "alleycat"),		  
		  "value" => $galleries,
		);
		
		// nearby
/*
		$params[] = array(
			  "type" => "dropdown",
			  "heading" => __("Slider type", "alleycat"),
			  "param_name" => "slider_size",
			  "value" => array(
			  	__("Default", "alleycat") => "",					  
			  	__("Side-by-side", "alleycat") => "nearby",
			  ),
		    "dependency" => Array('element' => "layout", 'value' => array('slider')),
		);
*/
			
	}
		
	// Category filter
	if ($category) {	
		$params[] = array(
			  "type" => "dropdown",
			  "heading" => __("Show Category Filter", "alleycat"),
			  "param_name" => "show_cat_filter",
			  "value" => array(
			  	__("Yes", "alleycat") => "true",
			  	__("No", "alleycat") => "false",
			  ),
		    "dependency" => Array('element' => "layout", 'value' => array('grid', 'masonry', 'tile', 'tile-masonry')),
		);
	}
	
	// Show title
	$params[] = array(
		  "type" => "dropdown",
		  "heading" => __("Show Title", "alleycat"),
		  "param_name" => "show_title",
		  "value" => array(
		  	__("Yes", "alleycat") => "true",
		  	__("No", "alleycat") => "false",
		  )
	);
	
	// Show excerpt
	$params[] = array(
		  "type" => "dropdown",
		  "heading" => __("Show Excerpt", "alleycat"),
		  "param_name" => "show_excerpt",
		  "value" => array(
		  	__("Yes", "alleycat") => "true",
		  	__("No", "alleycat") => "false",
		  ),
	    "dependency" => Array('element' => "layout", 'value' => array('grid', 'masonry', 'tile', 'tile-masonry', 'slider'))
	);
	
	// Show excerpt
	$params[] = array(
		  "type" => "dropdown",
		  "heading" => __("Show Read More Button", "alleycat"),
		  "param_name" => "show_read_more",
		  "value" => array(
		  	__("Yes", "alleycat") => "true",
		  	__("No", "alleycat") => "false",
		  ),
	    "dependency" => Array('element' => "layout", 'value' => array('posts', 'grid', 'masonry'))
	);	
	
	// Excerpt length
	$params[] = array(
		  "type" => "textfield",
		  "heading" => __("Excerpt Length", "alleycat"),
		  "param_name" => "excerpt_length",
		  "value" => '',
	    "dependency" => Array('element' => "layout", 'value' => array('grid', 'masonry')),
	    "description" => __("Enter the number of characters at which to truncate the excerpt.  50 is a good value.  Leave blank to let WordPress take care of the excerpt length. Enter 'all' to show all of the post content.", "alleycat"),
	);
	
	// Posts per page
	$no_of_items = "6";
	if ($base == 'ac_gallery') { // no slide style on Gallery	
		$no_of_items = "all"; // default to all
	}

	$params[] = array(
	    "type" => "textfield",
	    "heading" => __("Number of items", "alleycat"),
	    "param_name" => "posts_per_page",
	    "value" => $no_of_items,
	    "description" => __("Maximum number of items shown.  Enter 'all' to show all.", "alleycat")
	);
	
	// Autoplay
	$params[] = array(
		  "type" => "dropdown",
		  "heading" => __("Auto Play", "alleycat"),
		  "param_name" => "autoplay",
	    "description" => __("Should the carousel automatically loop.", "alleycat"),
		  "value" => array(
		  	__("No", "alleycat") => "false",	  
		  	__("Yes", "alleycat") => "true",
		  ),
	    "dependency" => Array('element' => "layout", 'value' => array('carousel'))	  
	);
		
	// CSS animation
	$params[] = $ac_vc_css_animation;
	
	// Post IDs
	if ($base != 'ac_gallery') {
		$params[] = array(
			  "type" => "textfield",
			  "heading" => __("Post IDs", "alleycat"),
			  "param_name" => "post__in",
			  "value" => '',
		    "description" => __("Enter the IDs of posts to show just those posts.", "alleycat"),
		);
	}
	
	// Offset
	if ($base != 'ac_gallery') {
		$params[] = array(
			  "type" => "textfield",
			  "heading" => __("Offset", "alleycat"),
			  "param_name" => "offset",
			  "value" => '',
		    "description" => __("Enter the number of posts to skip.  e.g. to skip the first 2 posts enter 2.", "alleycat"),
		);
	}	
	
	// CSS Class
	$params[] = $ac_vc_css_class;
	$params[] = $ac_vc_design_options;
		
	return $params;
}	

//
//  Functions
//===================================

// Returns all of the posts that can be selected in a AC VC select
function ac_vc_get_posts_for_select() {

	// Get the posts
	$post_types = get_post_types();

	$args = array(
		'posts_per_page'   => -1,
		'orderby'          => 'title',
		'order'            => 'ASC',
		'post_type'        => $post_types,
	);
	
	$posts = get_posts($args);

	// Add each post to an array for the select	
	$output = array();
	
	foreach($posts as $post) {
	
		// Don't add anything with a blank title
		$title = get_the_title($post->ID);
		if ($title) {
			$output[$title] = $post->ID;
		}

	}
	
	return $output;
	
}