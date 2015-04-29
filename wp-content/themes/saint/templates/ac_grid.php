<?php
/**************************/
/**** AC Grid Template ****/ 
/**************************/

global $post;

// Build links
$a_start = '';
$a_end = '';
if (get_permalink($post->ID)) {
	$a_start = "<a href='".get_permalink($post->ID)."' >";
	$a_end = "</a>";
}

// Excerpt
if ($show_excerpt) {

  // Apply a excerpt length if given
  if (isset($excerpt_length)) {
		$excerpt_length = intval($excerpt_length);  	  
  }
  else {
		$excerpt_length = false; // This will use the site default
  }
    
  // Hide read more link on some post types
  if ($post_type == 'ac_gallery') {
	  $show_read_more = false;
  }

	// Add social icons to read more
	$excerpt = ac_get_excerpt($post, $excerpt_length, $show_read_more, true, ac_person_get_all_social_icons());
}

// Terms
$show_terms = true;
if (get_post_type() == 'ac_person') {
	$show_terms = false;
}
			
// Get terms slugs for Isotope filtering
$terms = ' all ';
$post_terms = get_the_terms( $post->ID, $post_category );

if(!empty($post_terms)) {
	foreach($post_terms as $post_term){
		$terms .= ' ' . $post_term->slug . ' ';
	}
}

// Get the post classes
$classes = implode(" ", get_post_class());
?>			

<div class='ac-grid-col <?php echo esc_attr($classes); ?> <?php echo $cols_class . esc_attr($terms) .esc_attr(ac_get_hide_until_fade_class()); ?>'>	
	<div class='ac-grid-post'>
	
	<?php
		// Write out the post
							
		// Check for content overrides
		// Testimonials and Post-Quotes use testimonial format
		if ( 	(get_post_type() == 'ac_testimonial') || 
					( (get_post_type() == 'post') && (get_post_format() == 'quote') )
				) {
			echo ac_testimonial_render($post->ID, true, $excerpt_length);
		}
		// Format a standard grid representation
		else { ?>

		<?php if ( ac_has_post_thumbnail($post->ID)) : ?>
			<div class='image'>				
				<?php echo $a_start; ?>
				<?php echo ac_resize_image_for_grid( array( 'image_id' => ac_get_post_thumbnail_id($post->ID), 'columns' => $cols, 'ratio' => ac_get_height_style_for_post($post->ID) ) ); ?>
				<?php echo $a_end; ?>
			</div>
		<?php endif; ?>

		<?php if ( ($show_title) || ($show_excerpt) ) : ?>
		<div class='text'>
			<?php if ($show_title): ?><?php echo $a_start; ?><h3 class='ac-grid-title'><strong><?php echo get_the_title($post->ID); ?></strong></h3><?php echo $a_end; ?><?php endif; ?>
			
		  <?php echo ac_person_get_position(); ?>
			
			<?php if ($show_terms) : ?>
			<div class='ac-grid-terms'><?php echo ac_get_the_term_list($post->ID, $post_category, '', ', ', ''); ?></div>
			<?php endif; ?>
			<?php if ($show_excerpt): ?><?php echo $excerpt; ?><?php endif; ?>
			
		</div>							
		<?php endif; ?>
		
	<?php } ?>
			
	</div>
</div>