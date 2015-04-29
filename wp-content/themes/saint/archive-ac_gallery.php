<?php
/***********************************/
/**** Gallery Archive Template  ****/ 
/***********************************/

// Show the galleries as tiles
$args = array(
	'post_type' => 'ac_gallery',
	'posts_per_page' => -1,
	'column_count' => 4,
	'layout' => 'tile',
	'meta_key' => null, // remove thumbnaul requirement as Galleries don't have featured image
	'post__not_in' => ac_gallery_get_posts_to_ignore(),
);
echo ac_posts_tile( $args );