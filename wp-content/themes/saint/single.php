<?php
/*******************************/
/**** Single Post Template  ****/ 
/*******************************/

// This template is used for blog posts, and any other post type that doesn't have a single-{post-type}.php file

while (have_posts()) : the_post(); ?>

	<?php	ac_load_post_content(); ?>

<?php endwhile; ?>