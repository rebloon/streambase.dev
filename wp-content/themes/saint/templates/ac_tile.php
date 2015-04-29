<?php
/**************************/
/**** AC Tile Template ****/ 
/**************************/

global $post;

// == Vars passed in =
// $cols = column span
// $column_count = number of columns
// $cols_class = column CSS class, not always used
// $layout = posts, grid, tiles, etc.

// Vars
$image = ''; // Image HTML
$img_cols = $cols; // Default to $cols param
$img_height_style = ac_get_height_style_for_post($post->ID);

// Build links
$a_start = '';
$a_end = '';
if (get_permalink($post->ID)) {
	$a_start = "<a href='".get_permalink($post->ID)."' >";
	$a_end = "</a>";
}

// Post specifics
if (get_post_type($post) == 'ac_testimonial') {
	
	// Get the author URL
	$author_url = ac_get_meta('author_url', null, $post->ID);
	
	// Only link to the author url if given
	if ($author_url) {
		$a_start = '<a href="'.$author_url.'">';
	}
	else {
			// No author, no link
		$a_start = '';
		$a_end = '';
	}
	
	// No title for testiomonials, as the excerpt is the testimonial
	$show_title = false;
	
	// Never show the excerpt for testimonials, the content comes from the testimonial method
	$show_excerpt = false;

	// No terms for Testimonial
	$show_terms = false;	
}
else if (get_post_type($post) == 'ac_portfolio') {
	
	// Different image ratios for tile-masonry
	if ($layout == 'tile-masonry') {
	
		// Portfolio item may have different tile image size
		$tile_masonry_size = ac_get_meta('tile_masonry_size');
	
		// Use the col_class to set the tile shape
		$cols_class = $tile_masonry_size;
		if (! $cols_class) {
			$cols_class = 'standard';
		}
		$cols_class = 'ac-tm-'.$cols_class.'-'.$column_count;
		
		// Default image dimensions to square
		$img_height_style = AC_IMAGE_RATIO_SQUARE;  // Square		
		
		switch ($tile_masonry_size) {
			case 'large' :
				$img_cols = $img_cols*2;
				break;
			case 'landscape' :
				$img_cols = $img_cols*2;
				$img_height_style = AC_IMAGE_RATIO_1BY2;				
				break;			
			case 'tall' :
				$img_height_style = AC_IMAGE_RATIO_2BY1;
				break;						
		}
		
	}
	
}
else if (get_post_type($post) == 'attachment') {
	// For image use lightbox
	$img = ac_resize_image_for_columns( array('image_id' => $post->ID, 'columns' => 12, 'ratio' => ac_get_height_style_for_post($post->ID)));
	
	// Don't include the pretty photo data in the text link
  $a_start = '<a class="prettyphoto" href="'.esc_url($img['url']).'" rel="prettyPhoto[rel-'.ac_get_prettyphoto_rel().']">';
}

// Image
if ( ac_has_post_thumbnail($post->ID)) {
	$img_args = array( 
		'image_id' => ac_get_post_thumbnail_id($post->ID), 
		'columns' => $img_cols, 
		'ratio' => $img_height_style,
	);
 	$image = ac_resize_image_for_grid( $img_args );
}

// Excerpt
if ($show_excerpt) {
  // Sanitise some values
	$excerpt_length = false;
	$excerpt = ac_get_excerpt($post, $excerpt_length, false, true);
}

			
// Get terms slugs for Isotope filtering
$terms = ' all ';
$post_terms = get_the_terms( $post->ID, $post_category );
if(!empty($post_terms)){
	foreach($post_terms as $post_term){
		$terms .= ' ' . $post_term->slug . ' ';
	}
}
?>			

<div class='ac-tile-col <?php echo esc_attr($cols_class) . esc_attr($terms) .esc_attr(ac_get_hide_until_fade_class()); ?>'>	

	<?php // Link around all of the content ?>
	<?php echo $a_start; ?>

		<?php // Image ?>
		<?php if ( $image ) : ?>
		<div class='image'>
			<?php echo $image; ?>
		</div>
		<?php endif; ?>

		<?php // Text ?>	
		<div class='text'>

			<div class="text-inner">

				<?php if ($show_title): ?><h3 class='ac-tile-title '><?php echo get_the_title($post->ID); ?></h3><?php endif; ?>
				
			  <?php echo ac_person_get_position(); ?>			
					 
				<?php if ($show_excerpt): ?><?php echo $excerpt; ?><?php endif; ?>		 
				
				<?php if (get_post_type($post) == 'ac_testimonial') : ?>
					<?php echo ac_testimonial_render($post->ID, false, 250); ?>
				<?php endif; ?>			

			</div>
			
		</div>	  		  
		
	<?php // End the link ?>	
	<?php echo $a_end; ?>

	<?php // Footer: Terms or Social ?>		
	<?php if (get_post_type($post) == 'ac_person') : ?>
		<div class='ac-tile-footer'>
			<?php echo ac_person_get_all_social_icons(); ?>
		</div>
	<?php else : ?>
		<?php if ($show_terms) : ?>
			<div class='ac-tile-footer'><?php echo ac_get_the_term_list($post->ID, $post_category, '', ', ', ''); ?></div>
		<?php endif; ?>
	<?php endif; ?>		
	
</div>