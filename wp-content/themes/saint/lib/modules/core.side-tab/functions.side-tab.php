<?php
/******************************/
/****  Side Tab Functions  ****/ 
/******************************/

add_action( 'shoestrap_after_wrap', 'ac_sidetab_render' );
// Render the sidetab html
function ac_sidetab_render() {

	$active = shoestrap_getVariable( 'side_tab_active' );
	if ($active) {
		$text = shoestrap_getVariable( 'side_tab_text' );
		$url = shoestrap_getVariable( 'side_tab_url' );
		$new_window = shoestrap_getVariable( 'side_tab_new_window' );
		$position = 'left';//shoestrap_getVariable( 'side_tab_position' );
		$class = " ac_side_tab_$position ";
		
		$new_window_out = '';
		if ($new_window == '1') {
			$new_window_out = ' target="_blank" ';
		}
		
		// Check we have everything
		if ($text && $url) {		
			?>
			<div class='ac_side_tab <?php echo esc_attr($class); ?>'>
		  	<a href="<?php echo esc_url( $url ); ?>" <?php echo $new_window_out; ?> class='' ><?php echo esc_html( $text ); ?></a>
			</div>
			<?php
		}			
	}
}