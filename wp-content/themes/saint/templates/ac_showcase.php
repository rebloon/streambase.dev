<?php
/******************************/
/**** AC Showcase Template ****/ 
/******************************/

global $post;

// Template to style a single Showcase entry

// Get some values
$item_title = get_the_title($post->ID);
$thumb = ac_resize_image_for_columns( array('image_id' => ac_get_post_thumbnail_id($post->ID), 'columns' => $column_count ));

$a_start = "<a href='".get_permalink($post->ID)."' >";
$a_end = "</a>";

// Hide read more link on some post types
$show_read_more = true;
if ($post_type == 'ac_gallery') {
  $show_read_more = false;
}
elseif ($post_type == 'ac_person') {
  $show_read_more = false;
}
?>

<div class="ac-showcase-item" style="width:<?php echo $item_width; ?>">
	<figure class='ac-hover-touch'>

		<?php // Thumbnail ?>
		<?php if ($thumb) : ?>
			<?php echo $a_start; ?><img src="<?php echo esc_url($thumb['url']); ?>" width="<?php echo $thumb['width']; ?>" height="<?php echo $thumb['height']; ?>" alt="<?php echo esc_attr($item_title); ?>" /><?php echo $a_end; ?>
		<?php endif; ?>
	
	<?php // Post title, Post Description, Post read more ?>
	<?php if ($show_title) : ?>
		<figcaption>
			<h3 class="ac-ellipsis"><?php echo $a_start.$item_title.$a_end; ?></h3>
		  <?php echo ac_person_get_position(); ?>
			<?php if ($show_read_more) : ?>			
				<h5><?php echo $a_start.__("Read more", 'alleycat').$a_end; ?></h5>
			<?php endif; ?>
		</figcaption>
	<?php else : ?>
		<figcaption>
		  <?php echo ac_person_get_position(); ?>
			<?php if ($show_read_more) : ?>			
				<h5><?php echo $a_start.__("Read more", 'alleycat').$a_end; ?></h5>
			<?php endif; ?>		
		</figcaption>
	<?php endif; ?>

	</figure>
</div>
