<?php
/********************************/
/**** Alleycat Mobile Detect ****/
/********************************/

// Detect whether this is a mobile device, etc and store global variables for use later within PHP

// Include the script
require_once 'Mobile_Detect.php';

// Setup
$detect = new Mobile_Detect;

// Use global variables to allow other parts of PHP to access the values.  This avoids the use of sessions
global $ac_is_mobile;
global $ac_is_tablet;
global $ac_mobile_grade;
global $ac_touch_device;

// Get the values from the object
$ac_is_mobile = $detect->isMobile();
$ac_is_tablet = $detect->isTablet();
$ac_mobile_grade = $detect->mobileGrade();
$ac_touch_device = ($ac_is_mobile || $ac_is_tablet);

// Returns css classes based on device
function ac_get_device_classes() {
	global $ac_is_mobile,
		$ac_is_tablet,
		$ac_touch_device;
		
	$return = '';
	
	if ($ac_is_mobile) {
		$return.= ' ac-mobile ';
	}
	if ($ac_is_tablet) {
		$return.= ' ac-tablet ';
	}
	if ($ac_touch_device) {
		$return.= ' ac-touch-device ';
	}
	
	// Bit of a temporary solution
	if(preg_match('/(?i)msie [6-8]/',$_SERVER['HTTP_USER_AGENT'])) {
		$return .= ' ie8 ';
	}	
	
	return $return;
}