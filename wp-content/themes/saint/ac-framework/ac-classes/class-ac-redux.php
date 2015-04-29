<?php
/************************/
/**** Alleycat Redux ****/ 
/************************/

// Redux options helper functions

require_once(dirname(__FILE__) . "/class-ac-base-class.php");

class AC_Redux extends AC_Base_Class
{

	// Returns a drop down with sidebar selections
	public function get_sidebar_options() {
	
	 	$sidebars = array();
	 	
	 	foreach ( $GLOBALS['wp_registered_sidebars'] as $sidebar ) {
	 		$sidebars[ucwords($sidebar['id'])] = $sidebar['name'];
	 	}
	 	return $sidebars;
	}	

}