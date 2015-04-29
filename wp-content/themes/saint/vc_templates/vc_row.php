<?php  
/***********************************/
/**** Alleycat VC Row Template  ****/ 
/***********************************/

// Add AC extras such as full width row

$output = $el_class = $bg_image = $bg_color = $bg_image_repeat = $font_color = $padding = $margin_bottom = $css = '';
extract(shortcode_atts(array(
    'el_class'        => '',
    'bg_image'        => '',
    'bg_color'        => '',
    'bg_image_repeat' => '',
    'font_color'      => '',
    'padding'         => '',
    'margin_bottom'   => '',
    'ac_row_id'				=> '',
    'css' => '',
    // AC
    'full_width_row' => false,
    'remove_row_padding' => false
), $atts));

$inner_content_start = '';
$inner_content_end = '';

// Enqueue is in Visual Composer original template, so we must emulate
// wp_enqueue_style( 'js_composer_front' );
wp_enqueue_script( 'wpb_composer_front_js' );
// wp_enqueue_style('js_composer_custom_css');

$el_class = $this->getExtraClass($el_class);

$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'vc_row wpb_row '. ( $this->settings('base')==='vc_row_inner' ? 'vc_inner ' : '' ) . get_row_css_class() . $el_class . vc_shortcode_custom_css_class( $css, ' ' ), $this->settings['base'], $atts );

// -- AC --

// Add extra container for full width bg row
// Check for page sidebar, and not add if we have a sidebar, as full widths are not relevant
if ( !ac_has_active_sidebar() ) {
	
	// Full row width
	if ( ($full_width_row == 'bg') || ($full_width_row == 'yes') ) {
		$css_class .= ' ac-full-width-row ';
// todo: delete this:		$css_class .= ' ac-remove-child-container-padding ';		
	}
	
	if ( ($full_width_row == 'bg') ) {
		$inner_content_start .= '<div class="container">';
		$inner_content_end .= '</div>';
	}

}

// ID
if ($ac_row_id) {
	$ac_row_id = ' id="'.$ac_row_id.'" ';
}

$style = $this->buildStyle($bg_image, $bg_color, $bg_image_repeat, $font_color, $padding, $margin_bottom);
$output .= '<div class="'.$css_class.'"'.$style.'>';
$output .= '<div '.$ac_row_id.' class="jump-pos" ></div>';
$output .= $inner_content_start;
$output .= wpb_js_remove_wpautop($content);
$output .= $inner_content_end;
$output .= '</div>'.$this->endBlockComment('row');

echo $output;