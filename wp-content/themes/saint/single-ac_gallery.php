<?php
/**********************************/
/**** Single Gallery Template  ****/ 
/**********************************/

// Print the gallery
$args = array(
	'slider_style'	 => 'slider-gallery',
	'slider_size' 	 => 'fullscreen',
);
ac_gallery_render_bg_royalslider(get_the_ID(), $args);