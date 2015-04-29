<?php
/***********************************************/
/**** AC Block Quote & Testimonial Template ****/ 
/***********************************************/

// Template to style a single Block Quote or Testimonial

// Image alignment
// $img_align_class = 'pull-'.$img_align;

// Text alignment
$main_align = 'left';
if ($img_align == 'left') {
	$main_align = 'right';
}

// BG colours
$article_bg_color = '';
$image_caption_bg_color = '';
if ($bg_color) {
  $article_bg_color = " style='background-color: ".esc_attr($bg_color)."' ";
  $image_caption_bg_color = " style='background-color: ".esc_attr($bg_color)."' ";
}

// Author
// If there is not author name use the link as the name
if (! $author) {
  $author = $author_url;
}

?>
<article <?php post_class('ac-quote'); ?> <?php echo $article_bg_color; ?>>

	<?php 
	// We have an image so setup the columns and the image
	if ( $image_id ) : ?>
		<div class='quote-image-wrapper'>
		  <div class='quote-image'>
				<?php if ($author_url) : ?><a href="<?php echo esc_url($author_url); ?>" target="_blank"><?php endif; ?>							  
			  <?php echo ac_render_image_for_columns( array(
					  	'image_id' => $image_id, 
					  	'columns' => '4', 
					  	'class' => 
					  	$img_border_shape.' ac-quote-image', 
					  	'height' => AC_IMAGE_RATIO_SQUARE
					  	)
				  	); ?>
				<?php if ($author_url) : ?></a><?php endif; ?>				  
			  
				<?php // Image caption ?>
				<?php if ($image_caption) : ?>
						<span class='ac-img-caption' <?php echo $image_caption_bg_color; ?> ><?php echo __($image_caption, 'alleycat'); ?></span>
				<?php endif; ?>			  
		  </div>
		</div>				  
	<?php endif; // image_id ?>

  <div class="entry-summary col-sm-12">
    <blockquote>
	    <div class='ac-quote-text'>
		    <?php echo __($excerpt, 'alleycat'); ?>
	    </div>
 			<div class='ac-quote-author'>
				<?php if ($author || $author_url ) : ?>
					<?php if ($author_url) : ?><a href="<?php echo esc_url($author_url); ?>" target="_blank"><?php endif; ?>				
					<?php echo __($author, 'alleycat'); ?>
					<?php if ($author_url) : ?></a><?php endif; ?>
				<?php endif; ?>
			</div>
	  </blockquote>

  </div>	
	  	
</article>
<div class="clearfix"></div>