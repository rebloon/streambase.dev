<?php
/*************************/
/**** LESS Variables  ****/ 
/*************************/
// Theme LESS Varialbles that are included by the Shoestrap LESS compiler

// Prepares a background colour as a LESS variable
// Values shouldn't be blank as the LESS compiler expects something
// Default backgrounds to inherit
// $color = the hex value, can include #
function ac_prepare_bg_colour_for_less($colour) {
	
	if ($colour) {
		// Ensure we have a colour #
		return '#' . str_replace( '#', '', $colour );		
	}
	else {
		// Dont use inherit as mixins fall over
		// Get the page bg colour
		$page_bg = shoestrap_getVariable( 'html_color_bg' );
		// Backup, just in case
		if (!$page_bg) {
			$page_bg = '#ffffff';
		}
		
		return $page_bg;
	}

}

// Prepares a text colour as a LESS variable
// Values shouldn't be blank as the LESS compiler expects something
// Default texts to black
function ac_prepare_text_colour_for_less($colour) {
	
	if ($colour) {
		// Ensure we have a colour #
		return '#' . str_replace( '#', '', $colour );		
	}
	else {
		// We dont have a value, so return a default
		return "#000000";
	}

}