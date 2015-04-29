<?php
/*******************/
/****  BBPress  ****/ 
/*******************/

// Returns whether bbPress is installed
function ac_is_bb_press_installed() {
	return class_exists('bbPress');
}

// Returns whether this is a BBPress page.  Includes whether BBPress is active
function ac_is_bbpress() {
	return class_exists('bbPress') && is_bbpress(); 
}

// Remove info bar on top of BBPress pages
add_filter('bbp_get_single_forum_description', 'ac_bbp_get_single_forum_description');
function ac_bbp_get_single_forum_description() {
	return '';
}