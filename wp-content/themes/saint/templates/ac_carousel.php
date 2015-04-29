<?php
/******************************/
/**** AC Carousel Template ****/ 
/******************************/

global $post;
	
// Template to style a single Carousel entry

// Get some values
$item_title = get_the_title($post->ID);

// Get the thumbnail
$img_height = AC_IMAGE_RATIO_3BY2;
$img_crop = true;
if (get_post_type($post) == 'ac_client') { // todo
	$img_height = AC_IMAGE_RATIO_SQUARE;
	$img_crop = false;
}
$args = array(
	'image_id' => ac_get_post_thumbnail_id($post->ID), 
	'columns' => $column_count, 
	'ratio' => $img_height,
	'crop' => $img_crop,
	'use_placeholder' => true 
);
$thumb = ac_resize_image_for_columns( $args );

// Build links
$a_start = '';
$a_end = '';
if (get_permalink($post->ID)) {
	$a_start = "<a href='".get_permalink($post->ID)."' >";
	$a_end = "</a>";
}

$text_class = '';

// For attachment type (AC Gallery) use a lightbox
if (get_post_type($post) == 'attachment') {
	// For image use lightbox
	$img = ac_resize_image_for_columns( array('image_id' => $post->ID, 'columns' => 12));
	
	// Don't include the pretty photo data in the text link
  $a_start = '<a class="prettyphoto" href="'.esc_url($img['url']).'" rel="prettyPhoto[rel-'.ac_get_prettyphoto_rel().']">';
}

// Post type specifics
// Add hover title class for some posts
if (in_array($post_type, array('ac_portfolio', 'ac_gallery', 'attachment'))) {
	$text_class = ' title-hover ';	
}

?>
<div class="ac-carousel-content <?php echo $text_class; ?>">

	<?php	if ($thumb) : ?>
		<?php echo $a_start; ?><img src="<?php echo esc_url($thumb['url']); ?>" width="<?php echo $thumb['width']; ?>" height="<?php echo $thumb['height']; ?>" alt="<?php echo esc_attr($item_title); ?>" /><?php echo $a_end; ?>
	<?php endif; ?>
	
	<?php	if ($show_title) : ?>
		<?php echo $a_start; ?>
			<div class='text <?php echo esc_attr($text_class); ?>'>
				<h3><?php echo $item_title; ?></h3>
			</div>
		<?php echo $a_end; ?>
	<?php endif; ?>
	
  <?php echo ac_person_get_position(); ?>
  
	<?php echo ac_person_get_all_social_icons(); ?>

</div>