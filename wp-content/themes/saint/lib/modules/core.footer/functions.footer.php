<?php

if ( !function_exists( 'shoestrap_footer_css' ) ) :
function shoestrap_footer_css() {
  $bg         = shoestrap_getVariable( 'footer_background' );
  $cl         = shoestrap_getVariable( 'footer_color' );
  $cl_brand   = shoestrap_getVariable( 'color_brand_primary' );
  $opacity = 1; // AC override due to feature removal
  $rgb        = shoestrap_get_rgb( $bg, true );
  $border     = shoestrap_getVariable( 'footer_border' );
  $top_margin = shoestrap_getVariable( 'footer_top_margin' );


  $style = 'footer.content-info {';

    $style .= ( $opacity != 1 && $opacity != "" ) ? 'background: rgba(' . $rgb . ',' . $opacity . ');' : 'background:' . $bg . ';';
    $style .= ( !empty($border) && $border['border-top'] > 0 && !empty($border['border-color']) ) ? 'border-top:' . $border['border-top'] . ' ' . $border['border-style'] . ' ' . $border['border-color'] . ';' : '';
    $style .= ( !empty($top_margin) ) ? 'margin-top:'. $top_margin .'px;' : '';
  $style .= '}';

  $style .= '#copyright-bar { line-height: 30px; }';
  $style .= '#footer_social_bar { line-height: 30px; font-size: 16px; text-align: right; }';
  $style .= '#footer_social_bar a { margin-left: 9px; padding: 3px; color:' . $cl . '; }';

  wp_add_inline_style( 'shoestrap_css', $style );
}
endif;


if ( !function_exists( 'shoestrap_footer_icon' ) ) :
/*
 * Creates the customizer icon on the bottom-left corner of our site
 * (visible only by admins)
 */
function shoestrap_footer_icon() {
  global $wp_customize;

  if ( current_user_can( 'edit_theme_options' ) && !isset( $wp_customize ) ) : ?>
    <div id="shoestrap_icon" class="visible-lg">
      <a href="<?php echo admin_url( 'themes.php?page=shoestrap' ); ?>"><i class="icon el-icon-cogs"></i></a>
    </div>
  <?php endif; 
}
endif;
add_action( 'shoestrap_after_footer', 'shoestrap_footer_icon' );

if ( !function_exists( 'shoestrap_footer_html' ) ) :
function shoestrap_footer_html() {
  $blog_name  = get_bloginfo( 'name', 'display' );
  $ftext      = shoestrap_getVariable( 'footer_text' );

  $ftext = ( $ftext == '' ) ? '&copy; [year] [sitename]' : $ftext;

  $ftext = str_replace( '[year]', date( 'Y' ), $ftext );
  $ftext = str_replace( '[sitename]', $blog_name, $ftext );

  $social = shoestrap_getVariable( 'footer_social_toggle' );
  $social_width = shoestrap_getVariable( 'footer_social_width' );

  $width = 12;

  // Social is enabled, we're modifying the width!
  $width = ( intval( $social_width ) > 0 && $social ) ? $width - intval( $social_width ) : $width;

  $social_blank = shoestrap_getVariable( 'footer_social_new_window_toggle' );

  $blank = ( $social_blank == 1 ) ? ' target="_blank"' : '';

  $networks = shoestrap_get_social_links();

  do_action( 'shoestrap_footer_before_copyright' );
  ?>

  <div id="footer-copyright">
    <article class="<?php echo shoestrap_container_class('footer-copyright'); ?>">
    	<div class='row'>
	      <div id="copyright-bar" class="col-md-<?php echo $width; ?> col-lg-<?php echo $width; ?>"><?php echo $ftext; ?></div>
	      <?php if ( $social && count( $networks ) > 0 ) : ?>
	        <div id="footer_social_bar" class="col-md-<?php echo $social_width; ?> col-lg-<?php echo $social_width; ?>">
	          <?php foreach ( $networks as $network ) : ?>
	            <?php if ( $network['url'] == '' ) continue; ?>
	            <a href="<?php echo $network['url']; ?>"<?php echo $blank;?> title="<?php echo $network['icon']; ?>">
	              <span class="icon el-icon-<?php echo $network['icon']; ?>"></span>
	            </a>
	          <?php endforeach; ?>
	        </div>
	      <?php endif; ?>
    	</div>
    </article>
  </div>
  <?php
}
endif;

function shoestrap_footer_content() {
  // Finding the number of active widget sidebars
  $num_of_sidebars = 0;
  $base_class = 'col-md-';

  for ( $i=0; $i<5 ; $i++ ) {
    $sidebar = 'sidebar-footer-'.$i.'';
    if ( is_active_sidebar( $sidebar ) )
      $num_of_sidebars++;
  }

  // Showing the active sidebars
  for ( $i=0; $i<5 ; $i++ ) {
    $sidebar = 'sidebar-footer-' . $i;

    if ( is_active_sidebar( $sidebar ) ) {
      // Setting each column width accordingly
      $col_class = 12 / $num_of_sidebars;
    
      echo '<div class="' . $base_class . $col_class . '">';
      dynamic_sidebar( $sidebar );
      echo '</div>';
    }
  }

  // Showing extra features from /lib/modules/core.footer/functions.footer.php
  do_action( 'shoestrap_footer_pre_override' );
}
