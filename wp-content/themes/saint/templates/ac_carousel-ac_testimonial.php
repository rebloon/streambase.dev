<?php
/******************************************/
/**** AC Carousel Testimonial Template ****/ 
/******************************************/
global $post;

// Template to style a single Carousel Testimonial entry
?>
<div class="ac-carousel-content">
<?php
	// Simply render a testimonial
	echo ac_testimonial_render($post->ID);
?>
</div>