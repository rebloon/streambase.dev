<?php
/**********************/
/**** Post Header  ****/ 
/**********************/

// -- PAGE HEADER --
// Article header used for posts, pages, etc.
// Includes a configurable header and next/prev controls

// Only do anything if this header is applicable to the page type.  i.e. a single
// Apply a filter for child themes
$show_page_title = true;
$show_page_title = apply_filters('ac_show_page_title_filter', $show_page_title);
if ( ac_page_has_page_title_header() && $show_page_title ) :
	
	// Only style for custom header
	$page_title_type = ac_get_meta('page_title_type');
	
	$page_custom_subtitle = ac_get_meta('page_subtitle');

	if ( ($page_title_type == '') || ($page_title_type == 'standard') || ($page_title_type == 'custom') ) {
	
		// Styles
		$title_class = '';
		$title_style = '';
	
		if ($page_title_type == 'custom') {
		
			// Get post meta data
			$bg_align = ac_get_meta('page_title_align');
			if ( $bg_align ) {
				$title_class .= 'text-'.$bg_align;
			}
			
			// Title text color
			$title_text_color = ac_get_meta('page_title_title_color');
			if ($title_text_color) {
				$title_style .= ' color: '.$title_text_color.'; ';
			}
		
		}
				
		// Show the nav?
		$show_nav = in_array( ac_get_post_type(), array('ac_portfolio', 'product') );
		if ($show_nav) {
			$title_class .= ' ac-title-show-nav ';
		}
		?>

		<header class='<?php echo esc_attr(ac_page_title_header_class()); ?>' style='<?php echo esc_attr(ac_page_title_header_style()); ?>'>
			<div class='container'>
				<div class='row'>
				  <h1 class="entry-title <?php echo esc_attr($title_class); ?>" style='<?php echo esc_attr($title_style); ?>'><strong><?php echo roots_title(); ?></strong></h1>
				  <?php if ($page_custom_subtitle) : ?>
				  <p class="entry-subtitle"><?php echo esc_html($page_custom_subtitle); ?></p>
				  <?php endif; ?>		  
				  <?php if ($show_nav) : ?>
				  <div class='post-nav'>
					  <?php next_post_link('%link', '<span class="entypo-medium entypo-icon-left-open-big"></span>'); ?>
						<?php previous_post_link('%link', '<span class="entypo-medium entypo-icon-right-open-big"></span>'); ?>
				  </div>
				  <?php endif; ?>		  
			  </div>			  
			</div>
		</header>	
		
<?php } ?>		
	
<?php
endif;


// -- IMAGES --
// Apply a filter for child themes
$show_images = true;
$show_images = apply_filters('ac_show_page_header_images', $show_images);
if ( ( is_single(ac_get_post_id()) || is_page(ac_get_post_id() ) ) && $show_images ) {

	// -- Check if this post has a slideshow or image --
	$show_ss = true;	
	// Hide the featured image from the page settings?
	$show_featured_image = !ac_get_meta('page_hide_featured_image');
	// Apple a filter for child theme control
	$show_featured_image = apply_filters('ac_page_hide_featured_image', $show_featured_image);

	$hero_class = ' '.shoestrap_container_class('ac-page-hero-img').' '.ac_get_hide_until_fade_class();

	// Check for post type specific slideshows
	$post_type = get_post_type(ac_get_post_id());
	switch ($post_type) {
	  case 'ac_portfolio' :
	  
	  		$show_ss = false;

	  		$template_type = ac_get_meta("template_type");
	  		if ($template_type == 'top-images') {
	  		?><div class='ac-page-hero-img ac-no-container-padding <?php echo esc_attr($hero_class); ?>'><?php
			  	ac_render_ac_easy_slideshow(true);
			  ?></div><?php
			  	$show_featured_image = false;
	  		}
	  		
	      break;
	  case 'ac_testimonial' :
			  	$show_featured_image = false;	  
	  	break;	      
	  case 'product' : // WooCommerce
			  	$show_featured_image = false;	  
	  	break;
	}

	// Render the standard slideshow
	if ($show_ss) {

		?><div class='ac-page-hero-img  ac-no-container-padding <?php echo esc_attr($hero_class); ?>'><?php	
			$slideshow_rendered = ac_render_post_slideshow(true);
	  ?></div><?php		
		
		// Don't show the featured image if we have a slideshow
		if ($slideshow_rendered) {
			$show_featured_image = false;
		}	
			
	}
	
	// -- FEATURED IMAGE --	
	// Does this WP page have a featured image?
	if ( is_single(ac_get_post_id()) ) {
		switch (get_post_type(ac_get_post_id())) {
		    case 'ac_person' : 
		        return $show_featured_image = false;
		        break;
		}				
	}

	if ( $show_featured_image ) {
		?><div class='ac-page-hero-img ac-no-container-padding <?php echo esc_attr($hero_class); ?>'><?php
		if ( shoestrap_featured_image(true, false) ) {
			//
		};
	  ?></div><?php		
	}	
	
}