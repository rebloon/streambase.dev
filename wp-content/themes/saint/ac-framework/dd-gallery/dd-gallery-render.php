<?php
/****************************************************/
/**** Alleycat Drag and Drop Gallery - Front end ****/
/****************************************************/

// generates the galleries grid
// renders the HTML
function ac_gallery_render_galleries() {
  
  // Settings
  // Gallery hover style
  $hover_style = get_option('portfolio_hover_style', ac_gallery_portfolio_hover_style);
  
  // -- Generate the Gallery grid --
	?>
	<div id='galleries' class='gallery'>
		<?php
	
		// get the galleries
		$gallery_args = array(
			'post_type' => array('ac_gallery'),
			'orderby' 			 => 'menu_order', 
			'order'          => 'ASC',
			'posts_per_page' => '-1'
		);		    	
		$galleries = get_posts( $gallery_args );
		
		foreach($galleries as $gallery) {
		
			// What is this gallery?
			$homepage = ($gallery->post_title == 'Homepage');
			$trash = ($gallery->post_title == 'Trash');				
			
			// Don't print these galleries
			if (!$homepage && !$trash) { 
			
				// Get the cover image.  
				$coverImage = ac_gallery_get_cover_image_for_gallery( $gallery->ID, "ac-gallery-cover" );
				
				// Only show the gallery if it has a cover image
				if ($coverImage) {

					// Format the content				
					$content =  $gallery->post_content;
//					$content = apply_filters('the_excerpt', $content);  // This is causing a looping problem with VC shortcodes
					$content = str_replace('//]]>', ']]&gt;', $content);				

				?>							
					<div class='project'>
						<img src="<?php echo $coverImage; ?>" alt="<?php echo esc_attr(get_the_title($gallery->ID)); ?>" title="<?php echo esc_attr(get_the_title($gallery->ID)); ?>" />
						<div class='cover <?php echo $hover_style; ?>'></div>	
						<div class='container'>
							<a href="<?php echo get_permalink($gallery->ID); ?>" class='text'>
								<div class='title'><?php echo esc_attr(get_the_title($gallery->ID)); ?></div>
								<div class='description'><?php echo $content; ?></div>
							</a>							
						</div>
					</div>
				<?php
					
				}
				
			}
			
		}		
	?>					
	</div> <!-- galleries -->
	<?php
}

// Render a gallery to the background control, using RoyalSlider
// $galleryId = Gallery ID to render
// $args = optional args to merge with the get_posts, show_title, etc.
function ac_gallery_render_bg_royalslider($galleryId, $args = array() )
{

	global $post;
		
	// get the wp posts (images) for the gallery	
	$image_args = array(
		'show_title'		 => true,
		'show_excerpt'	 => true,
		'slider_size' 	 => '3by2', // 3by2, ratio, letterbox
		'slider_style'	 => 'slider-post', // slider-post, slider-gallery, no-caption
		'orderby' 			 => 'menu_order', 
		'order'          => 'ASC',
		'post_type'      => 'attachment',
		'post_parent'    => $galleryId,
		'post_mime_type' => 'image',
		'post_status'    => null,
		'numberposts'    => -1,
		'auto_height'    => false,
	);		    	
	
	// Merge in the options
	$args = wp_parse_args( $args, $image_args );
	
	// Get the images
	$attachments = get_posts($args);
	
	// Product the slideshow
	ac_render_royalslider_from_posts($attachments, $args);
}

// Renders posts as a Royal Slider
// $posts should already be load
// $args contains options  
function ac_render_royalslider_from_posts( $posts, $args ) {
		
	// RoyalSlider expects content in the RS HTML Structure, so do nothing if no posts
	if (empty($posts)) {
		return;
	}

	global $post;
	
	// Defaults
	$auto_height = false;

	// Params to variables
	extract($args);
	
	// $post_parent is the gallery id
	// hide_titles is a gallery setting
	$hide_titles = false; // Default to true for Easy Slider, general use
	if ( isset($post_parent) ) {
		$hide_titles = get_post_meta( $post_parent, 'hide-titles', true );		
	}
	// Ensure proper boolean
	$hide_titles = filter_var($hide_titles, FILTER_VALIDATE_BOOLEAN);
	
	// Get the slideshow settings from the Options
	$autoplay = ac_bool_to_string(shoestrap_getVariable('aeis_autoplay')); 
	$transition = shoestrap_getVariable('aeis_transition'); 
	$delay = shoestrap_getVariable('aeis_slideshow_delay'); 
	if ($delay) {
		$delay = $delay * 1000; // miliseconds
	}
	else {
		$delay = 5000;
	}
	
	$rs_split_nav = false;
	// Check if no click by nav defined
	if ( defined('AC_RS_SPLIT_NAV') ) {
		$rs_split_nav = true;
	}
		
	// Classes
	$classes = '';
	if ($slider_size == 'letterbox') {
		$classes = 'ac-full-width-row';
	}
	if (isset($args['class'])) {
		$classes .= ' ' .$args['class'].' ';		
	}
	
?>
	
  <div class="ac-royalSlider sliderContainer fullWidth clearfix <?php echo $classes; ?> <?php echo $slider_style; ?> <?php echo $slider_size; ?>" data-show-title="<?php echo $show_title; ?>" data-show-excerpt="<?php echo $show_excerpt; ?>" data-slider-size="<?php echo $slider_size; ?>" data-delay="<?php echo $delay; ?>" data-autoplay="<?php echo $autoplay; ?>" data-transition="<?php echo $transition; ?>" data-split-nav="<?php echo $rs_split_nav; ?>" data-auto-height="<?php echo json_encode($auto_height); ?>">
	  <div class="royalSlider heroSlider rsMinW full-width-slider">
		<?php
		
		// Render each image
		if ($posts) {
			foreach ($posts as $post):setup_postdata($post);
						
				// Links
				$a_start = '';
				$a_end = '';
				
				// Only add links for the slider-posts.  Gallery shouldn't click through
				if ($slider_style == 'slider-post') {
					$a_start = "<a href='".get_permalink($post->ID)."'>";
					$a_end = "</a>";
				}

				// Get the post type				
				$post_type = get_post_type($post);
				
				// For testimonials write out the HTML
				if ( $post_type == 'ac_testimonial' ) : ?>
				  <div class="rsContent">
						<?php echo ac_testimonial_render($post->ID); ?>
					</div>
				<?php else: 
				
					// Other post types
					
					// Get the image ID.  Some are featured image, some are the actualy post
					$image_id = ac_get_post_thumbnail_id($post);
					
					// Resize differently for different scenarios
					if ($slider_size == 'nearby') {
						$img = ac_resize_image_for_height(array(
							'height' => 495,
							'ratio'  => AC_IMAGE_RATIO_PRESERVE
						));
						$img_args = array(
							'image_id' => $image_id, 
							'columns' => 1, 
							'ratio' => AC_IMAGE_RATIO_PRESERVE,
							'ensure_min_width' => false
						);						
					}
					else {
						$img_args = array(
							'image_id' 		=> $image_id,
							'columns' 		=> 12,
							'ratio' 			=> AC_IMAGE_RATIO_PRESERVE,
							'full_width' 	=> $full_width
						);
						$img = ac_resize_image_for_columns( $img_args );						
					}
					
					// For nearby images we set the data width and height
					$rsw = '';					
					$rsh = '';					
					if ($slider_size == 'nearby') {
						$rsw = ' data-rsw="'.$img['width'].'" ';
						$rsh = ' data-rsh="495" ';
					}
					
					// Check if the titles are required
					$title = '';
					$content = '';
					if ($hide_titles !== true) {
	
						// Get the title
						$title = $a_start.get_the_title().$a_end;
													
						// Get the content
						$content = $post->post_content;
						$content = apply_filters('the_excerpt', $content); // Use the_excerpt as the_content returns the actual image in the content
						$content = str_replace('//]]>', ']]&gt;', $content);
						$content = "<div class='excerpt'>".$content."</div>";					
						$content = $a_start.ac_person_get_position().$content.$a_end;
						
					}
														
					?>					
				  <div class="rsContent">
				    <img class="rsImg" <?php echo $rsw; ?> <?php echo $rsh; ?> src="<?php echo $img['url']; ?>" alt="<?php esc_attr(the_title()); ?>" />
				    <div class="infoBlock infoBlockLeftBlack rsABlock" data-fade-effect="" data-move-offset="10" data-move-effect="bottom" data-speed="200">
				      <div class="caption"><?php echo $title; ?></div>
				      <div class="description"><?php echo $content; ?></div>
				    </div>
				  </div>			  
				
				<?php endif; ?>
				
			<?php
			endforeach; // image
			
			wp_reset_postdata();
				  
		}
			
		?>
		</div>
							
		<!--Control Bar-->
		<div class='ac-rs-overlay'></div>		
		<div class="ac-rs-controls-wrapper load-item">
				
			<!-- Caption -->
			<div class="slidecaption"></div>
			
			<!-- Description -->
			<div class="slidedescription"></div>				

		</div>
	</div>
		    
<?php		   
	
}


function ac_gallery_render_bg_gallery($galleryId) 
{
	ac_gallery_render_bg_royalslider($galleryId);
}

// Returns the cover image ID for a give Gallery
function ac_gallery_get_cover_image_id_for_gallery( $post ) {

	$post = get_post( $post );

	$img = ''; // Return empty string if no cover image

	// Get the image
	$image_args = array(
		'orderby' 			 => 'menu_order', 
		'order'          => 'ASC',
		'post_type'      => 'attachment',
		'post_parent'    => $post->ID,
		'post_mime_type' => 'image',
		'post_status'    => null,
		'numberposts'    => 1,
	);		    	
	
	$attachments = get_posts($image_args);
	
	// Return the ID
	if ($attachments) {	
		return $attachments[0]->ID;
	}
	
	// Return false for no cover image
	return false;
	
}

// Returns the cover image URL for a give Gallery
function ac_gallery_get_cover_image_for_gallery( $gallery_id, $image_size ) {

	$image_id = ac_gallery_get_cover_image_id_for_gallery( $gallery_id );
	
	if ($image_id) {
		// Return the first instance	
		$img =  wp_get_attachment_image_src($image_id, $image_size, false);
		$img = $img[0];
		
		return $img;
	}
	
	return false;
	
}