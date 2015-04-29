<?php

if ( !function_exists( 'shoestrap_logo' ) ) :
/*
 * The site logo.
 * If no custom logo is uploaded, use the sitename
 */
function shoestrap_logo() {
  $logo  = shoestrap_getVariable( 'logo' );
  
  if ( !empty( $logo['url'] ) )
  {
	  // AC - resize the logo based on the header height
	  
	  // STANDARD LOGO
	  
	  // Use the header height to resize
	  $navbar_height = filter_var( shoestrap_getVariable( 'navbar_height', true ), FILTER_SANITIZE_NUMBER_INT );
	  $args = array(
	  	'current_height' => $logo['height'],
	  	'current_width' => $logo['width'],
	  	'new_height' => $navbar_height,
	  );

	  // Get the new image dimensions	  
		$resized = ac_resize_image_dimensions($args);
		
		// Resize the logo
	  $args = array(
	  	"crop" => false,
		  "height"     => $navbar_height,
		  "width"     => $resized['width'],
		  "url" => $logo['url'],
	  );
	  $image = shoestrap_image_resize( $args );
	  $image = $image['url'];
	  $logo_class = '';
	        
    // TRANSPARENT NAV LOGO
    if (shoestrap_getVariable( 'navbar_fixed' ) == true) {
			$start_logo  = shoestrap_getVariable( 'navbar_transparent_starting_logo' );
			if ($start_logo['url']) {
				
				// Resize the logo
			  $args = array(
			  	"crop" => false,
				  "height"     => $navbar_height,
				  "width"     => $resized['width'],
				  "url" => $start_logo['url'],
			  );
			  $trans_image = shoestrap_image_resize( $args );
			  $trans_image = $trans_image['url'];
				
				// As we have a trans logo, set a class for the main logo to enable fade out
				$logo_class = ' trans-nav-logo ';
				
				echo '<img id="site-logo-start" class="site-logo" src="' . $trans_image . '" alt="' . get_bloginfo( 'name' ) . '">';				
				
								
			}
    }
    
    // Print the logos
    echo '<img id="site-logo" class="site-logo '.$logo_class.'" src="' . $image . '" alt="' . get_bloginfo( 'name' ) . '">';    
    
  }
  else
    echo '<span class="sitename">' . bloginfo( 'name' ) . '</span>';
}
endif;

if ( !function_exists( 'shoestrap_branding_class' ) ) :
function shoestrap_branding_class( $echo = true ) {
  $logo  = shoestrap_getVariable( 'logo' );

  // apply the proper class
  $class = ( !empty( $logo['url'] ) ) ? 'logo' : 'text';

  // echo or return the value
  if ( $echo )
    echo $class;
  else
    return $class;
}
endif;
