<?php
/*****************/
/**** Images  ****/ 
/*****************/

// Constants
define("AC_IMAGE_RATIO_3BY2", 0);
define("AC_IMAGE_RATIO_SQUARE", 1);
define("AC_IMAGE_RATIO_PRESERVE", 3);
define("AC_IMAGE_RATIO_2BY1", 4);
define("AC_IMAGE_RATIO_1BY2", 5);


// -- Common args for image functions-
// image_id 
// columns = number if columns (12 = max)
// $height = 0 = 3/2, 1 = square, 3 = preserve height
// $crop = crop the image
// $full_width = true = maxium page width (outside of grid) or false = within the grid
// $use_placeholder = should a place holder image be used if there is no thumbnail
// $ensure_min_width = don't resize images smaller than the column
	

// Render an image spanning x column
// Columns = number of columns to span
// Args = extra information, tags, class
// $height = 0 = 3/2, 1 = square, 3 = preserve ratio
function ac_render_image_for_columns( $args ) {

	// Defaults	
  $defaults = array(
    "class"       			=> "",
    "tags"     					=> "",
    "ratio"     				=> AC_IMAGE_RATIO_3BY2,
    "crop"     					=> true,
    "full_width"    		=> false,
    "use_placeholder" 	=> false,
    "alt"      					=> "",
    "ensure_min_width"  => true,
  );
  
  if ($args['image_id']) {
	  $defaults["alt"] = ac_get_image_alt( $args['image_id'] );
  }
  
  $args = wp_parse_args( $args, $defaults );

	// Extract extra parameters
	// $tags = full html tag section to add to img
	// $height = image height
	extract($args);
	
	// Get the image
	$image = ac_resize_image_for_columns( $args );
	
	if ($class) {
		$class = " class='".esc_attr($class)."' ";
	}
	
	if ($alt) {
		$alt = " alt='".esc_attr($alt)."' ";
	}
	
	return "<img src='".$image['url']."' width='".$image['width']."' height='".$image['height']."' $class $tags $alt >";
}

// TODO REMOVE UNUSED
// Render an image spanning the given width
// $width = max width to resize.  If false use themes max size
// Args = extra information, tags, class
/*
function ac_render_image_for_width( $image_id, $width = false, $args = array() ) {

	global $ac_full_width_pixels;

	// Defaults
	$class = '';
	$tags = '';
	$square = false;
	$alt = ac_get_image_alt( $image_id );	

	// Extract extra parameters
	// $tags = full html tag section to add to img
	// $square = square image
	extract($args);
	
	// if no width has been given then use the theme default
	if (! $width) {
		$width = $ac_full_width_pixels;
	}

	// Get the image
	$image = ac_resize_image( $image_id, $width ); 
	
	if ($class) {
		$class = " class='".esc_attr($class)."' ";
	}
	
	if ($alt) {
		$alt = " alt='".esc_attr($alt)."' ";
	}
	
	return "<img src='".$image['url']."' width='".$image['width']."' height='".$image['height']."' $class $tags $alt >";
}
*/

// Resizes the image and returns an array of the data
function ac_resize_image( $args ) {
	
	// Defaults	
  $defaults = array(
    "image_id"	=> null,
    "width"			=> ac_get_full_width_px(), // default to full width variable
    "height"		=> null,
		'crop' 			=> true
  );
  $args = wp_parse_args( $args, $defaults );	
	extract($args);	

	if ($height == null) {
		$height = $width;
	}
	$image = shoestrap_image_resize( array(
		'id' => $image_id, 
		'url' => wp_get_attachment_url( $image_id ),
		'width' => $width,
		'height' => $height,
		'crop' => $crop,
	));
	
	return $image;

}

// Gets the image width based on the column span
// $columns = number of columns to span.  Assume 12 cols is 100% of desktop grid
// $height
// $full_width = should the size be full width or within the grid?
function ac_get_image_size_by_columns( $args ) {

	global $ac_full_width_pixels;
	
	// Defaults	
  $defaults = array(
    "columns"			=> null,
    "height"			=> 0,
    "full_width"	=> false,
  );
  $args = wp_parse_args( $args, $defaults );	
	extract($args);		

	// Convert columns to percentage
	if ($columns != 0) {
		$columns = (12 / $columns);
	}
	else {
		$columns = 12;
	}	
	
	// Check for max width
	if ($full_width) {
		// Check for the value given in functions.php
		if ($ac_full_width_pixels) {
			$page_width = $ac_full_width_pixels;
		}
		else {
			// Fallback if values missing from functions.php
			$page_width = 1600;
		}
	}
	else {
		// Page width should be 100% of the desktop grid
		$page_width = $container  = filter_var( shoestrap_getVariable( 'screen_large_desktop' ), FILTER_SANITIZE_NUMBER_INT );
	}

	// Calc width from site size / cols
	if ($columns > 0) {
		$width = round($page_width / $columns);
	} 
	else {
		// Div by zero fallback
		$width = $page_width;
	}
	
	// Mobile check
	// Ensure the width is >= the smallest screen setting, to ensure full width image at mobile size
	$small_width = shoestrap_getVariable( 'screen_tablet', true );
	if ( $width < $small_width ){
		$width = $small_width;
	}		
		
	return $width;	
	
}

// Returns best image size for columns to span
// $columns = number of columns to span
// $ratio= 0 = 3/2, 1 = square, 3 = preserve height, 4 = 2/1, 5 = 1/2
// $full_width = true = maxium page width (outside of grid) or false = within the grid
// $use_placeholder = should a place holder image be used if there is no thumbnail
// $ensure_min_width = don't resize images smaller than the column
function ac_resize_image_for_columns( $args ) {
	
	// Defaults
  $defaults = array(
    "image_id"					=> null,
    "columns"						=> null,
    "ratio"							=> AC_IMAGE_RATIO_3BY2,
    "crop"     					=> true,    
    "full_width"				=> false,
    "use_placeholder"		=> false,
    "ensure_min_width"	=> true,
  );
  $args = wp_parse_args( $args, $defaults );	
	extract($args);	
	
	// Get the image WIDTH based on the columns
	$new_width = ac_get_image_size_by_columns($args);

	// Calc HEIGHT
	$new_height = null;	
	switch ($ratio) {
	  case AC_IMAGE_RATIO_3BY2: // 3/2
				$new_height = round($new_width / (3/2));
	      break;
	  case AC_IMAGE_RATIO_SQUARE: // square
				$new_height = $new_width;
	      break;
	  case AC_IMAGE_RATIO_PRESERVE: // preserve ratio
				// Calc height from new width
				// Get the original images
			  $orig_image = wp_get_attachment_image_src( $image_id, 'full' );
			  // Build args of dimensions
			  $args = array(
			  	'current_height' => $orig_image[2],
			  	'current_width' => $orig_image[1],
			  	'new_width' => $new_width,
			  );
			  // Get the new image dimensions	  
				$resized = ac_resize_image_dimensions($args);	  
				// Store the resized dimensions
				$new_width = $resized['width'];
				$new_height = $resized['height'];
	      break;
	  case AC_IMAGE_RATIO_2BY1: // 2/1
				$new_height = round($new_width * (2/1));
	      break;
	  case AC_IMAGE_RATIO_1BY2: // 1/2
				$new_height = round($new_width * (1/2));
	      break;	      
	}	
			
	// Don't upsize images
	if (! $ensure_min_width) {	
		// Get the original image
	  $orig_image = wp_get_attachment_image_src( $image_id, 'full' );	
	  // If the original is smaller than the column width don't resize
	  if ($orig_image[1] < $img_sizes['width']) {
			$new_width = $orig_image[1];
			$new_height = $orig_image[2];	  
	  }
	}
	
	// Get the URL
	$url = wp_get_attachment_url( $image_id );
	//  If no URL and $use_placeholder, use the placeholder image
	if ( (! $url) && $use_placeholder ) {
		$url = get_template_directory_uri().'/assets/img/blank.png';
	}
	
	// Resize	
	$image = shoestrap_image_resize( array(
		'id' => $image_id, 
		'url' => $url,
		'width' => $new_width,
		'height' => $new_height,
		'crop' => $crop
	));
			
	return $image;

}


// Returns image based on new height
// $columns = number of columns to span
// $ratio = 0 = 3/2, 1 = square, 3 = preserve height, 4 = 2/1, 5 = 1/2
// $full_width = true = maxium page width (outside of grid) or false = within the grid
// $use_placeholder = should a place holder image be used if there is no thumbnail
// $ensure_min_width = don't resize images smaller than the column
function ac_resize_image_for_height( $args ) {
	
	// Defaults
  $defaults = array(
    "image_id"					=> null,
    "height"						=> null,
    "ratio"							=> AC_IMAGE_RATIO_3BY2,
    "crop"     					=> true,    
  );
  $args = wp_parse_args( $args, $defaults );	
	extract($args);	
	
	// Calc HEIGHT
	$new_width = null;	
	switch ($ratio) {
	  case AC_IMAGE_RATIO_3BY2: // 3/2
				$new_width = round($height / (3/2));
	      break;
	  case AC_IMAGE_RATIO_SQUARE: // square
				$new_width = $height;
	      break;
	  case AC_IMAGE_RATIO_PRESERVE: // preserve ratio
				// Calc height from new width
				// Get the original images
			  $orig_image = wp_get_attachment_image_src( $image_id, 'full' );
			  // Build args of dimensions
			  $args = array(
			  	'current_height' => $orig_image[2],
			  	'current_width' => $orig_image[1],
			  	'new_height' => $height,
			  );
			  // Get the new image dimensions	  
				$resized = ac_resize_image_dimensions($args);	  
				// Store the resized dimensions
				$new_width = $resized['width'];
				$new_height = $resized['height'];
	      break;
	  case AC_IMAGE_RATIO_2BY1: // 2/1
				$new_width = round($height * (2/1));
	      break;
	  case AC_IMAGE_RATIO_1BY2: // 1/2
				$new_width = round($height * (1/2));
	      break;	      
	}	
	
	$url = wp_get_attachment_url( $image_id );	
					
	// Resize	
	$image = shoestrap_image_resize( array(
		'id' => $image_id, 
		'url' => $url,
		'width' => $new_width,
		'height' => $height,
		'crop' => $crop
	));
			
	return $image;

}


// Returns HTML img
// $columns = number of columns to span
function ac_resize_image_for_grid( $args ) {
	
	// Defaults	
  $defaults = array(
    "image_id"					=> null,
    "columns"						=> null,
    "ratio"						=> AC_IMAGE_RATIO_3BY2,
  );
  $args = wp_parse_args( $args, $defaults );	
	extract($args);		

	// Resize
	$image = ac_resize_image_for_columns( $args );

	// Return HTML
	return '<img class="grid-image" src="' . $image['url'] . '" alt="'.esc_attr(ac_get_image_alt($image_id)).'" />';
}

// Gets all of the image ids for a post
// Includes the featured image if required.  Also includes attached images
function ac_get_images_for_post( $post = 0, $include_featured_image = true ) {

	// Get the post
	$post = get_post( $post );
	
	$return = array();
	
	// Should we include the featured image?
	if ( $include_featured_image == true ) {

		$feat_img = get_post_thumbnail_id();

		if ($feat_img) {
			// Add to our slides
			$return[] = get_post_thumbnail_id();
		}
	}

	// Get the images to use
	$images = ac_get_meta('images', array('type' => 'image_advanced'));
	
	// Add them to the slides
	foreach($images as $image) {
		
		// Add to our slides
		$return[] = $image['ID'];
	}	
	
	return $return;
	
}

// Resizes an images dimensions based on a new width or height
// Returns an array of width and height
function ac_resize_image_dimensions($args) {

	$result = array(
		'height' => 0,
		'width' => 0
	);
	
	if ( isset($args['current_height']) && isset($args['current_width']) ) { 

		// Get the current ratio
		// Avoid div by zero
		if ($args['current_height'] > 0) {
			$ratio = $args['current_width'] / $args['current_height'];
		}
		else {
			$ratio = 0;
		}

		if ($ratio) {

			// Use the ratio to get the new size
			if ( isset($args['new_height']) ) {
				$result['height'] = $args['new_height'];
				$result['width'] = intval($args['new_height'] * $ratio);
			}
			else if ( isset($args['new_width']) ) {
				$result['width'] = $args['new_width'];
				$result['height'] = intval($args['new_width'] / $ratio);

			}
			
		}		

	}
	
	return $result;

}

// Returns the height setting for the given post or post_id
// $height = 0 = 3/2, 1 = square, 3 = preserve height
function ac_get_height_style_for_post( $post ) {
	$post = get_post( $post ); // post or id
		
	// Always preserve height for client logo
	if (get_post_type( $post ) == 'ac_client') {
		return AC_IMAGE_RATIO_PRESERVE;			
	}
	else {
		return AC_IMAGE_RATIO_3BY2; // default
	}
}