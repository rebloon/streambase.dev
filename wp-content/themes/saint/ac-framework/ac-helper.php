<?php

/****************************************/
/**** Wordpress helper functions  ****/ 
/****************************************/

// Returns a PHP array in JS format
function ac_php_array_to_js($array, $base = "") {

	$js = '';
	
	// Iterate each elements
	foreach ($array as $key=>$val) {
	    if (is_array($val)) {
	        $js .= ac_php_array_to_js($val, $base.(is_numeric($key) ? '['.$key.']' : "['".addslashes($key)."']"));
	    } else {
	        $js .= $base;
	        $js .= is_numeric($key) ? '['.$key.']' : "['".addslashes($key)."']";
	        $js .= ' = ';
	        $js .= is_numeric($val) ? ''.$val.'' : "'".addslashes($val)."'";
	        $js .= ";\n";
	    }
	}
	
	return $base." = new Array();\n".$js;
}


// Converts a Hex colour value to RGB
function ac_hex2rgb($hex) {

	// Remove the #		
	$hex = str_replace("#", "", $hex);
	
	// Check for 3 char colour 
	if(strlen($hex) == 3) {
	  $r = hexdec(substr($hex,0,1).substr($hex,0,1));
	  $g = hexdec(substr($hex,1,1).substr($hex,1,1));
	  $b = hexdec(substr($hex,2,1).substr($hex,2,1));
	} else {
	// 6 char colour
	  $r = hexdec(substr($hex,0,2));
	  $g = hexdec(substr($hex,2,2));
	  $b = hexdec(substr($hex,4,2));
	}
	
	// Convert to RGB
	$rgb = array($r, $g, $b);
	return $rgb; 
}

// Returns a Hex for as RGB for us in css class
function ac_hex2rgb_for_css($hex) {
	$rgb = ac_hex2rgb($hex);
	return implode(",", $rgb); 
}

// Returns browser information
function ac_get_browser() 
{ 
    $u_agent = $_SERVER['HTTP_USER_AGENT']; 
    $bname = 'Unknown';
    $platform = 'Unknown';
    $version= "";
    $ub = "";

    // Get the platform
    if (preg_match('/linux/i', $u_agent)) {
        $platform = 'linux';
    }
    elseif (preg_match('/iPod|iPhone|iPad/i', $u_agent)) {
        $platform = 'ios';
    }    
    elseif (preg_match('/Android/i', $u_agent)) {
        $platform = 'android';
    }    
    elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
        $platform = 'mac';
    }
    elseif (preg_match('/windows|win32/i', $u_agent)) {
        $platform = 'windows';
    }
    
    // Get the browser
    if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent)) 
    { 
        $bname = 'Internet Explorer'; 
        $ub = "MSIE"; 
    } 
    elseif(preg_match('/Firefox/i',$u_agent)) 
    { 
        $bname = 'Mozilla Firefox'; 
        $ub = "Firefox"; 
    } 
    elseif(preg_match('/Chrome/i',$u_agent)) 
    { 
        $bname = 'Google Chrome'; 
        $ub = "Chrome"; 
    } 
    elseif(preg_match('/Safari/i',$u_agent)) 
    { 
        $bname = 'Apple Safari'; 
        $ub = "Safari"; 
    } 
    elseif(preg_match('/Opera/i',$u_agent)) 
    { 
        $bname = 'Opera'; 
        $ub = "Opera"; 
    } 
    elseif(preg_match('/Netscape/i',$u_agent)) 
    { 
        $bname = 'Netscape'; 
        $ub = "Netscape"; 
    } 
    
    // Get the version
    $known = array('Version', $ub, 'other');
    $pattern = '#(?<browser>' . join('|', $known) .
    ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
    if (!preg_match_all($pattern, $u_agent, $matches)) {
        // we have no matching number just continue
    }
    
    // Check if we have more than one
    $i = count($matches['browser']);
    if ($i != 1) {
        //we will have two since we are not using 'other' argument yet
        //see if version is before or after the name
        if (strripos($u_agent,"Version") < strripos($u_agent,$ub)){
            $version= $matches['version'][0];
        }
        else {
            $version= $matches['version'][1];
        }
    }
    else {
        $version= $matches['version'][0];
    }
    
    // Check for version number
    if ($version==null || $version=="") {$version="?";}
    
    // Reduce version to single digit
    $versionParts = explode('.', $version);
    if ( count($version) > 0 )
    {
	    $version = $versionParts[0];
    }
    
    return array(
        'userAgent' => $u_agent,
        'name'      => strtolower($ub),
        'version'   => strtolower($version),
        'platform'  => strtolower($platform),
/*         'pattern'    => $pattern */
    );
} 

// Returns a class for the <html> tag with the browser type.
function ac_get_html_class() {

	// Get the data	
	$data = ac_get_browser();
	
	$platform = $data['platform'];
	$browser = $data['name'];
	$version = $data['version'];
	
	// Print it out
	return " $platform $browser v$version ";
}

// Add http to url if missing
function ac_ensure_http($url) {
	if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
	    $url = "http://" . $url;
	}
	return $url;
}

// Truncates a string, finding the break closest to the limit
function ac_truncate_string($string, $limit, $break=".", $pad="...", $readMoreText = "")
{

  // Return with no change if string is shorter than $limit
  if(strlen($string) <= $limit) 
  {
  	return $string;	  
  }

  // Is $break present between $limit and the end of the string?
  if ( false !== ($breakpoint = strpos($string, $break, $limit) ) ) {
    if($breakpoint < strlen($string) - 1) {
      $string = substr($string, 0, $breakpoint) . $pad;
    }
  }
  
  return $string;
}

// Format the comment date (x ago, etc..)
function ac_comment_date_time()
{
	$time = get_comment_time('U');
  $time_diff = time() - $time;

  if( $time_diff > 0 && $time_diff < 24*60*60 )
      $display = sprintf( __('%s ago', 'alleycat'), human_time_diff( $time ) );
  else
      $display = get_comment_date() ." at ". get_comment_time();

  return $display;
}

// Returns a bool value as a string.  Useful for PHP to JS functions
function ac_bool_to_string($bool) {
	if ($bool == true) {
		return "true";
	}
	else {
		return "false";
	}
}

// Ensures the given number is even
function ac_ensure_number_even($number) {

	// Is the number even?
	if ($number % 2 == 0) {

		// Number is already even
		return $number;
		
	}
	else {
	
		// Number is odd, so make even
		// Default to add 1 to round up
		$number = $number + 1;
		
		return $number;
	
	}
	
}