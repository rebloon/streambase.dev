<?php


if ( !function_exists( 'shoestrap_variables' ) ) :
/*
 * The content below is a copy of bootstrap's variables.less file.
 *
 * Some options are user-configurable and stored as theme mods.
 * We try to minimize the options and simplify the user environment.
 * In order to do that, we 'll have to provide a minimum amount of options
 * and calculate the rest based on the user's selections.
 *
 */
function shoestrap_variables() {

  $site_style = shoestrap_getVariable( 'site_style' );

	$html_color_bg = ac_prepare_bg_colour_for_less(shoestrap_getVariable( 'html_color_bg', true ) );
//	$body_bg_raw = ac_prepare_bg_colour_for_less(shoestrap_getVariable( 'color_body_bg', true ) );
	$body_bg_raw = $html_color_bg; // Content bg is body bg for Saint
	// We need a value for other purposes, even if set to blank
	if ($body_bg_raw) {
		// We have a value so use for both
	  $body_bg        = $body_bg_raw;
	  $body_bg_actual = $body_bg;
	}
	else {
		// No value
	  $body_bg          = '#ffffff';
	  $body_bg_actual		= '#ffffff';
	}
//  $content_opacity  = shoestrap_getVariable( 'color_body_bg_opacity' );	
  $content_opacity  = 100; // 100 for Saint
  

  $brand_primary    = ac_prepare_text_colour_for_less(shoestrap_getVariable( 'color_brand_primary', true ) );
  $brand_success    = '#5cb85c'; //'#' . str_replace( '#', '', shoestrap_getVariable( 'color_brand_success', true ) );
  $brand_warning    = '#f0ad4e'; //'#' . str_replace( '#', '', shoestrap_getVariable( 'color_brand_warning', true ) );
  $brand_danger     = '#d9534f'; //'#' . str_replace( '#', '', shoestrap_getVariable( 'color_brand_danger', true ) );
  $brand_info       = '#09040a'; //'#' . str_replace( '#', '', shoestrap_getVariable( 'color_brand_info', true ) );

  $font_base              = shoestrap_process_font( shoestrap_getVariable( 'font_base', true ) );
  $font_navbar            = shoestrap_process_font( shoestrap_getVariable( 'font_navbar', true ) );
  $font_brand             = shoestrap_process_font( shoestrap_getVariable( 'font_brand', true ) );
  $font_jumbotron         = shoestrap_process_font( shoestrap_getVariable( 'font_jumbotron', true ) );
  $font_heading           = shoestrap_process_font( shoestrap_getVariable( 'font_heading', true ) );  

  $font_h1 = shoestrap_process_font( shoestrap_getVariable( 'font_h1', true ) );
  $font_h2 = shoestrap_process_font( shoestrap_getVariable( 'font_h2', true ) );
  $font_h3 = shoestrap_process_font( shoestrap_getVariable( 'font_h3', true ) );
  $font_h4 = shoestrap_process_font( shoestrap_getVariable( 'font_h4', true ) );
  $font_h5 = shoestrap_process_font( shoestrap_getVariable( 'font_h5', true ) );
  $font_h6 = shoestrap_process_font( shoestrap_getVariable( 'font_h6', true ) );

  $font_h1_face   = $font_h1['font-family'];
  $font_h1_size   = ( ( filter_var( $font_h1['font-size'], FILTER_SANITIZE_NUMBER_INT ) ) / 100 );
  $font_h1_weight = $font_h1['font-weight'];
  $font_h1_style  = $font_h1['font-style'];
  $font_h1_height = $font_h1['line-height'];
  $font_h1_color  = ac_prepare_text_colour_for_less($font_h1['color']);

  $font_h2_face   = $font_h2['font-family'];
  $font_h2_size   = ( ( filter_var( $font_h2['font-size'], FILTER_SANITIZE_NUMBER_INT ) ) / 100 );
  $font_h2_weight = $font_h2['font-weight'];
  $font_h2_style  = $font_h2['font-style'];
  $font_h2_height = $font_h2['line-height'];
  $font_h2_color  = ac_prepare_text_colour_for_less($font_h2['color']);

  $font_h3_face   = $font_h3['font-family'];
  $font_h3_size   = ( ( filter_var( $font_h3['font-size'], FILTER_SANITIZE_NUMBER_INT ) ) / 100 );
  $font_h3_weight = $font_h3['font-weight'];
  $font_h3_style  = $font_h3['font-style'];
  $font_h3_height = $font_h3['line-height'];
  $font_h3_color  = ac_prepare_text_colour_for_less($font_h3['color']);

  $font_h4_face   = $font_h4['font-family'];
  $font_h4_size   = ( ( filter_var( $font_h4['font-size'], FILTER_SANITIZE_NUMBER_INT ) ) / 100 );
  $font_h4_weight = $font_h4['font-weight'];
  $font_h4_style  = $font_h4['font-style'];
  $font_h4_height = $font_h4['line-height'];
  $font_h4_color  = ac_prepare_text_colour_for_less($font_h4['color']);

  $font_h5_face   = $font_h5['font-family'];
  $font_h5_size   = ( ( filter_var( $font_h5['font-size'], FILTER_SANITIZE_NUMBER_INT ) ) / 100 );
  $font_h5_weight = $font_h5['font-weight'];
  $font_h5_style  = $font_h5['font-style'];
  $font_h5_height = $font_h5['line-height'];
  $font_h5_color  = ac_prepare_text_colour_for_less($font_h5['color']);

  $font_h6_face   = $font_h6['font-family'];
  $font_h6_size   = ( ( filter_var( $font_h6['font-size'], FILTER_SANITIZE_NUMBER_INT ) ) / 100 );
  $font_h6_weight = $font_h6['font-weight'];
  $font_h6_style  = $font_h6['font-style'];
  $font_h6_height = $font_h6['line-height'];
  $font_h6_color  = ac_prepare_text_colour_for_less($font_h6['color']);

  if ( shoestrap_getVariable( 'font_heading_custom', true ) != 1 ) {

    $font_h1_face   = '@font-family-base';
    $font_h1_weight = '@headings-font-weight';
    $font_h1_style  = 'inherit';
    $font_h2_height = '@heading-h1-height';
    $font_h1_color  = '@font_h1_color';

    $font_h2_face   = '@font-family-base';
    $font_h2_weight = '@headings-font-weight';
    $font_h2_style  = 'inherit';
    $font_h2_height = '@heading-h2-height';
    $font_h2_color  = '@font_h2_color';

    $font_h3_face   = '@font-family-base';
    $font_h3_weight = '@headings-font-weight';
    $font_h3_style  = 'inherit';
    $font_h2_height = '@heading-h3-height';
    $font_h3_color  = '@font_h3_color';

    $font_h4_face   = '@font-family-base';
    $font_h4_weight = '@headings-font-weight';
    $font_h4_style  = 'inherit';
    $font_h2_height = '@heading-h4-height';
    $font_h4_color  = '@font_h4_color';

    $font_h5_face   = '@font-family-base';
    $font_h5_weight = '@headings-font-weight';
    $font_h5_style  = 'inherit';
    $font_h2_height = '@heading-h5-height';
    $font_h5_color  = '@font_h5_color';

    $font_h6_face   = '@font-family-base';
    $font_h6_weight = '@headings-font-weight';
    $font_h6_style  = 'inherit';
    $font_h2_height = '@heading-h6-height';
    $font_h6_color  = '@font_h6_color';

  }

  $text_color     			  = ac_prepare_text_colour_for_less($font_base['color'] );
  $font_size_base  				= $font_base['font-size'];
  $font_line_height_base 	= $font_base['line-height'];
  $font_style_base  			= $font_base['font-style'];
  $font_weight_base 			= $font_base['font-weight'];
  $sans_serif       			= $font_base['font-family'];

  $border_radius    = filter_var( shoestrap_getVariable( 'general_border_radius', true ), FILTER_SANITIZE_NUMBER_INT );
  $border_radius    = ( strlen( $border_radius ) < 1 ) ? 0 : $border_radius;

  $padding_base     = intval( shoestrap_getVariable( 'padding_base', true ) );
  $navbar_bg        = ac_prepare_bg_colour_for_less( shoestrap_getVariable( 'navbar_bg', true ) );
  $jumbotron_bg     = ac_prepare_bg_colour_for_less( shoestrap_getVariable( 'jumbotron_bg', true ) );

  $screen_sm = filter_var( shoestrap_getVariable( 'screen_tablet', true ), FILTER_SANITIZE_NUMBER_INT );
  $screen_md = filter_var( shoestrap_getVariable( 'screen_desktop', true ), FILTER_SANITIZE_NUMBER_INT );
  $screen_lg = filter_var( shoestrap_getVariable( 'screen_large_desktop', true ), FILTER_SANITIZE_NUMBER_INT );
  $gutter    = filter_var( shoestrap_getVariable( 'layout_gutter', true ), FILTER_SANITIZE_NUMBER_INT );
  $gutter    = ( $gutter < 2 ) ? 2 : $gutter;

  $screen_xs = ( $site_style == 'static' ) ? '50px' : '480px';
  $screen_sm = ( $site_style == 'static' ) ? '50px' : $screen_sm;
  $screen_md = ( $site_style == 'static' ) ? '50px' : $screen_md;

  $navbar_height    = filter_var( shoestrap_getVariable( 'navbar_height', true ), FILTER_SANITIZE_NUMBER_INT );
  $navbar_text_color       = ac_prepare_text_colour_for_less($font_navbar['color'] );
  $navbar_transparent_starting_text_colour = ac_prepare_text_colour_for_less(shoestrap_getVariable( 'navbar_transparent_starting_text_colour' ));
  // Fallback to navbar colour
  if (!$navbar_transparent_starting_text_colour) {
	  $navbar_transparent_starting_text_colour = $navbar_text_color;
  }

  $brand_text_color       = ac_prepare_text_colour_for_less($font_brand['color'] );
  $jumbotron_text_color   = 'inherit'; //'#' . str_replace( '#', '', $font_jumbotron['color'] );
  
  // AC set some jumbo values to allow LESS compiling
	$font_jumbotron_headers['font-family'] = 'inherit';
  $font_jumbotron_headers['font-weight'] = 'inherit';
  $font_jumbotron_headers['font-style'] = 'inherit';
  $font_jumbotron_headers['font-size'] = 'inherit';
	$font_jumbotron['font-family'] = 'inherit';
  $font_jumbotron['font-weight'] = 'inherit';
  $font_jumbotron['font-style'] = 'inherit';
  $font_jumbotron['font-size'] = 'inherit';
  $jumbotron_bg = 'inherit';
  $jumbotron_text_color = 'inherit';

  if ( shoestrap_getVariable( 'font_jumbotron_heading_custom', true ) == 1 ) {

    $font_jumbotron_headers = shoestrap_process_font( shoestrap_getVariable( 'font_jumbotron_headers', true ) );

    $font_jumbotron_headers_face   = $font_jumbotron_headers['font-family'];
    $font_jumbotron_headers_weight = $font_jumbotron_headers['font-weight'];
    $font_jumbotron_headers_style  = $font_jumbotron_headers['font-style'];
    $jumbotron_headers_text_color  = ac_prepare_text_colour_for_less($font_jumbotron_headers['color'] );

  } else {

    $font_jumbotron_headers_face   = $font_jumbotron['font-family'];
    $font_jumbotron_headers_weight = $font_jumbotron['font-weight'];
    $font_jumbotron_headers_style  = $font_jumbotron['font-style'];
    $jumbotron_headers_text_color  = $jumbotron_text_color;
  }

  // Calculate the gray shadows based on the body background.
  // We basically create 2 "presets": light and dark.
  if ( shoestrap_get_brightness( $body_bg ) > 80 ) {
    $gray_darker  = 'lighten(#000, 13.5%)';
    $gray_dark    = 'lighten(#000, 20%)';
    $gray         = 'lighten(#000, 33.5%)';
    $gray_light   = 'lighten(#000, 60%)';
    $gray_lighter = 'lighten(#000, 93.5%)';
  } else {
    $gray_darker  = 'darken(#fff, 13.5%)';
    $gray_dark    = 'darken(#fff, 20%)';
    $gray         = 'darken(#fff, 33.5%)';
    $gray_light   = 'darken(#fff, 60%)';
    $gray_lighter = 'darken(#fff, 93.5%)';
  }

  $link_hover_color = ( shoestrap_get_brightness( $brand_primary ) > 50 ) ? 'darken(@link-color, 15%)' : 'lighten(@link-color, 15%)';

  if ( shoestrap_get_brightness( $brand_primary ) > 50 ) {
    $table_bg_accent      = 'darken(@body-bg, 2.5%)';
    $table_bg_hover       = 'darken(@body-bg, 4%)';
    $table_border_color   = 'darken(@body-bg, 13.35%)';
    $input_border         = 'darken(@body-bg, 20%)';
    $dropdown_divider_top = 'darken(@body-bg, 10.2%)';
  } else {
    $table_bg_accent      = 'lighten(@body-bg, 2.5%)';
    $table_bg_hover       = 'lighten(@body-bg, 4%)';
    $table_border_color   = 'lighten(@body-bg, 13.35%)';
    $input_border         = 'lighten(@body-bg, 20%)';
    $dropdown_divider_top = 'lighten(@body-bg, 10.2%)';
  }

  if ( shoestrap_get_brightness( $navbar_bg ) > 80 ) {
    $navbar_link_hover_color    = 'darken(@navbar-default-color, 26.5%)';
    $navbar_link_active_bg      = 'darken(@navbar-default-bg, 6.5%)';
    $navbar_link_disabled_color = 'darken(@navbar-default-bg, 6.5%)';
    $navbar_brand_hover_color   = 'darken(@navbar-default-brand-color, 10%)';
  } else {
    $navbar_link_hover_color    = 'lighten(@navbar-default-color, 26.5%)';
    $navbar_link_active_bg      = 'lighten(@navbar-default-bg, 6.5%)';
    $navbar_link_disabled_color = 'lighten(@navbar-default-bg, 6.5%)';
    $navbar_brand_hover_color   = 'lighten(@navbar-default-brand-color, 10%)';
  }

  if ( shoestrap_get_brightness( $brand_primary ) > 80 ) {
    $btn_primary_color  = '#fff';
    $btn_primary_border = 'darken(@btn-primary-bg, 5%)';
  } else {
    $btn_primary_color  = '#333';
    $btn_primary_border = 'lighten(@btn-primary-bg, 5%)';
  }

  if ( shoestrap_get_brightness( $brand_success ) > 80 ) {
    $btn_success_color  = '#fff';
    $btn_success_border = 'darken(@btn-success-bg, 5%)';
  } else {
    $btn_success_color  = '#333';
    $btn_success_border = 'lighten(@btn-success-bg, 5%)';
  }

  if ( shoestrap_get_brightness( $brand_warning ) > 80 ) {
    $btn_warning_color  = '#fff';
    $btn_warning_border = 'darken(@btn-warning-bg, 5%)';
  } else {
    $btn_warning_color  = '#333';
    $btn_warning_border = 'lighten(@btn-warning-bg, 5%)';
  }

  if ( shoestrap_get_brightness( $brand_danger ) > 80 ) {
    $btn_danger_color  = '#fff';
    $btn_danger_border = 'darken(@btn-danger-bg, 5%)';
  } else {
    $btn_danger_color  = '#333';
    $btn_danger_border = 'lighten(@btn-danger-bg, 5%)';
  }

  if ( shoestrap_get_brightness( $brand_info ) > 80 ) {
    $btn_info_color  = '#fff';
    $btn_info_border = 'darken(@btn-info-bg, 5%)';
  } else {
    $btn_info_color  = '#333';
    $btn_info_border = 'lighten(@btn-info-bg, 5%)';
  }

  $input_border_focus = ( shoestrap_get_brightness( $brand_primary ) < 100 ) ? 'lighten(@brand-primary, 10%);' : 'darken(@brand-primary, 10%);';
  $navbar_border      = ( shoestrap_get_brightness( $brand_primary ) < 50 ) ? 'lighten(@navbar-default-bg, 6.5%)' : 'darken(@navbar-default-bg, 6.5%)';
  
	// AC Variables
	$page_title_bg_color = ac_prepare_bg_colour_for_less(shoestrap_getVariable( 'page_title_bg_color', true ) );
	$page_title_padding = filter_var( shoestrap_getVariable( 'page_title_padding', true ), FILTER_SANITIZE_NUMBER_INT );
	$custom_page_title_padding = filter_var( shoestrap_getVariable( 'custom_page_title_padding', true ), FILTER_SANITIZE_NUMBER_INT );
	$button_bg_color = ac_prepare_bg_colour_for_less(shoestrap_getVariable( 'color_button', true ) );	
	$footer_color = ac_prepare_text_colour_for_less(shoestrap_getVariable( 'footer_color', true ) );
	$footer_background = ac_prepare_bg_colour_for_less(shoestrap_getVariable( 'footer_background', true ));	
	$aeis_slideshow_height	= shoestrap_getVariable( 'aeis_slideshow_height');	  
	$post_excerpt_link_text	= shoestrap_getVariable( 'post_excerpt_link_text');	  

	// AC Side Tab	
	$side_tab_top = shoestrap_getVariable( 'side_tab_top');
	// Ensure we have a values
	if (!$side_tab_top) {
		$side_tab_top = 0;
	}
	$side_tab_bg_colour = ac_prepare_bg_colour_for_less(shoestrap_getVariable( 'side_tab_bg_colour', true ));
	$side_tab_text_colour = ac_prepare_bg_colour_for_less(shoestrap_getVariable( 'side_tab_text_colour', true ));
	


$variables = '
//
// Variables
// --------------------------------------------------

// Global values
// --------------------------------------------------

// Grays
// -------------------------

@gray-darker:            ' . $gray_darker . ';
@gray-dark:              ' . $gray_dark . ';
@gray:                   ' . $gray . ';
@gray-light:             ' . $gray_light . ';
@gray-lighter:           ' . $gray_lighter . ';
@ccc: mix(@gray-light, @gray-lighter);

// Brand colors
// -------------------------

@brand-primary:         ' . $brand_primary . ';
@brand-success:         ' . $brand_success . ';
@brand-warning:         ' . $brand_warning . ';
@brand-danger:         	' . $brand_danger . ';
@brand-info:            ' . $brand_info . ';

// Scaffolding
// -------------------------


@html_color_bg: ' 				. $html_color_bg . ';
@body-bg: ' 							. $body_bg . ';
@body-bg-actual: ' 				. $body_bg_actual . ';
@text-color: ' 						. $text_color . ';

// Links
// -------------------------

@link-color:            @brand-primary;
@link-hover-color:      ' . $link_hover_color . ';

// Typography
// -------------------------

@font-family-sans-serif:  ' . $sans_serif . ';
@font-family-serif:       Palatino, "Times New Roman", Times, serif;
@font-family-monospace:   Monaco, Menlo, Consolas, "Courier New", monospace;
@font-family-base:        @font-family-sans-serif;

@font-size-base:          ' . $font_size_base . 'px;
@font-line-height-base:   ' . $font_line_height_base . ';
@font-size-large:         ceil(@font-size-base * 1.25); // ~18px
@font-size-small:         ceil(@font-size-base * 0.85); // ~12px

@font-weight-base:				'. $font_base['font-weight'] .';

@line-height-base:        1.428571429; // 20/14
@line-height-computed:    floor(@font-size-base * @line-height-base); // ~20px

@headings-font-family:    @font-family-base;
@headings-font-weight:    500;
@headings-line-height:    1.1;
@headings-color:          inherit;

// Iconography
// -------------------------

@icon-font-path:          "../fonts/";
@icon-font-name:          "glyphicons-halflings-regular";

// Components
// -------------------------
// Based on 14px font-size and 1.428 line-height (~20px to start)

@padding-base-vertical:          ' . round( $padding_base * 1.33 ) . 'px;
@padding-base-horizontal:        ' . round( $padding_base * 1.5 ) . 'px;

@padding-large-vertical:         ' . round( $padding_base * 1.25 ) . 'px;
@padding-large-horizontal:       ' . ( $padding_base * 2 ) . 'px;

@padding-small-vertical:         ' . round( $padding_base * 0.625 ) . 'px;
@padding-small-horizontal:       @padding-large-vertical;

@padding-xs-vertical:            ' . round( $padding_base * 0.125 ) . 'px;
@padding-xs-horizontal:          @padding-small-vertical;

@line-height-large:              1.33;
@line-height-small:              1.5;

@border-radius-base:             ' . $border_radius . 'px;
@border-radius-large:            ceil(@border-radius-base * 1.5);
@border-radius-small:            floor(@border-radius-base * 0.75);

@component-active-color:         @body-bg;
@component-active-bg:            @brand-primary;

@caret-width-base:               ceil(@font-size-small / 3 ); // ~4px
@caret-width-large:              ceil(@caret-width-base * (5/4) ); // ~5px

// Tables
// -------------------------

@table-cell-padding:                 ceil((@font-size-small * 2) / 3 ); // ~8px;
@table-condensed-cell-padding:       ceil(((@font-size-small / 3 ) * 5) / 4); // ~5px

@table-bg:                           transparent; // overall background-color
@table-bg-accent:                    ' . $table_bg_accent . '; // for striping
@table-bg-hover:                     ' . $table_bg_hover . '; // for hover
@table-bg-active:                    @table-bg-hover;

@table-border-color:                 ' . $table_border_color . '; // table and cell border


// Buttons
// -------------------------

@btn-font-weight:                normal;

@btn-default-color:              @gray-dark;
@btn-default-bg:                 @body-bg;
@btn-default-border:             @ccc;

@btn-primary-color:              ' . $btn_primary_color . ';
@btn-primary-bg:                 @brand-primary;
@btn-primary-border:             ' . $btn_primary_border . ';

@btn-success-color:              ' . $btn_success_color . ';
@btn-success-bg:                 @brand-success;
@btn-success-border:             ' . $btn_success_border . ';

@btn-warning-color:              ' . $btn_warning_color . ';
@btn-warning-bg:                 @brand-warning;
@btn-warning-border:             ' . $btn_warning_border . ';

@btn-danger-color:               ' . $btn_danger_color . ';
@btn-danger-bg:                  @brand-danger;
@btn-danger-border:              ' . $btn_danger_border . ';

@btn-info-color:                 ' . $btn_info_color . ';
@btn-info-bg:                    @brand-info;
@btn-info-border:                ' . $btn_info_border . ';

@btn-link-disabled-color:        @gray-light;


// Forms
// -------------------------

@input-bg:                       @body-bg;
@input-bg-disabled:              @gray-lighter;

@input-color:                    @gray;
@input-border:                   @ccc;
@input-border-radius:            @border-radius-base;
@input-border-focus:             ' . $input_border_focus . ';

@input-color-placeholder:        @gray-light;

@input-height-base:              (@line-height-computed + (@padding-base-vertical * 2) + 2);
@input-height-large:             (floor(@font-size-large * @line-height-large) + (@padding-large-vertical * 2) + 2);
@input-height-small:             (floor(@font-size-small * @line-height-small) + (@padding-small-vertical * 2) + 2);

@legend-color:                   @gray-dark;
@legend-border-color:            @gray-lighter;

@input-group-addon-bg:           @gray-lighter;
@input-group-addon-border-color: @input-border;


// Dropdowns
// -------------------------

@dropdown-bg:                    ' . $body_bg . ';
@dropdown-border:                rgba(0,0,0,.15);
@dropdown-fallback-border:       @input-border;
@dropdown-divider-bg:            @legend-border-color;

@dropdown-link-color:            @gray-dark;
@dropdown-link-hover-color:      darken(@gray-dark, 5%);
@dropdown-link-hover-bg:         @table-bg-hover;

@dropdown-link-active-color:     @component-active-color;
@dropdown-link-active-bg:        @component-active-bg;

@dropdown-link-disabled-color:   @gray-light;

@dropdown-header-color:          @gray-light;


// COMPONENT VARIABLES
// --------------------------------------------------


// Z-index master list
// -------------------------
// Used for a birds eye view of components dependent on the z-axis
// Try to avoid customizing these :)

@zindex-navbar:            1000;
@zindex-dropdown:          1000;
@zindex-popover:           1010;
@zindex-tooltip:           1030;
@zindex-navbar-fixed:      1030;
@zindex-modal-background:  1040;
@zindex-modal:             1050;

// Media queries breakpoints
// --------------------------------------------------

// Extra small screen / phone
// Note: Deprecated @screen-xs and @screen-phone as of v3.0.1
@screen-xs:                  480px;
@screen-xs-min:              @screen-xs;
@screen-phone:               @screen-xs-min;

// Small screen / tablet
// Note: Deprecated @screen-sm and @screen-tablet as of v3.0.1
@screen-sm:                  ' . $screen_sm . 'px;
@screen-sm-min:              @screen-sm;
@screen-tablet:              @screen-sm-min;

// Medium screen / desktop
// Note: Deprecated @screen-md and @screen-desktop as of v3.0.1
@screen-md:                  ' . $screen_md . 'px;
@screen-md-min:              @screen-md;
@screen-desktop:             @screen-md-min;

// Large screen / wide desktop
// Note: Deprecated @screen-lg and @screen-lg-desktop as of v3.0.1
@screen-lg:                  ' . $screen_lg . 'px;
@screen-lg-min:              @screen-lg;
@screen-lg-desktop:          @screen-lg-min;

// So media queries dont overlap when required, provide a maximum
@screen-xs-max:              (@screen-sm-min - 1);
@screen-sm-max:              (@screen-md-min - 1);
@screen-md-max:              (@screen-lg-min - 1);


// Grid system
// --------------------------------------------------

// Number of columns in the grid system
@grid-columns:              12;
// Padding, to be divided by two and applied to the left and right of all columns
@grid-gutter-width:         ' . $gutter . 'px;

// Navbar collapse

// Point at which the navbar becomes uncollapsed
@grid-float-breakpoint:     @screen-md-min;
// Point at which the navbar begins collapsing
@grid-float-breakpoint-max: (@grid-float-breakpoint - 1); // AC Fix


// Navbar
// -------------------------

// Basics of a navbar
@navbar-height:                    ' . $navbar_height . 'px;
@navbar-margin-bottom:             @line-height-computed;
@navbar-border-radius:             @border-radius-base;
@navbar-padding-horizontal:        floor(@grid-gutter-width / 2);
@navbar-padding-vertical:          ((@navbar-height - @line-height-computed) / 2);

@navbar-default-color:             ' . $navbar_text_color . ';
@navbar-default-bg:                ' . $navbar_bg . ';
@navbar-default-border:            ' . $navbar_border . ';

@navbar-transparent-starting-text-colour: ' .  $navbar_transparent_starting_text_colour .';

// Navbar links
@navbar-default-link-color:                @navbar-default-color;
@navbar-default-link-hover-color:          ' . $navbar_link_hover_color . ';
@navbar-default-link-hover-bg:             transparent;
@navbar-default-link-active-color:         mix(@navbar-default-color, @navbar-default-link-hover-color, 50%);
@navbar-default-link-active-bg:            ' . $navbar_link_active_bg . ';
@navbar-default-link-disabled-color:       ' . $navbar_link_disabled_color . ';
@navbar-default-link-disabled-bg:          transparent;

// Navbar brand label
@navbar-default-brand-color:               @navbar-default-link-color;
@navbar-default-brand-hover-color:         ' . $navbar_brand_hover_color . ';
@navbar-default-brand-hover-bg:            transparent;

// Navbar toggle
@navbar-default-toggle-hover-bg:           @table-border-color;
@navbar-default-toggle-icon-bar-bg:        @ccc;
@navbar-default-toggle-border-color:       @table-border-color;


// Inverted navbar
//
// Reset inverted navbar basics
@navbar-inverse-color:                      @gray-light;
@navbar-inverse-bg:                         #222;
@navbar-inverse-border:                     darken(@navbar-inverse-bg, 10%);

// Inverted navbar links
@navbar-inverse-link-color:                 @gray-light;
@navbar-inverse-link-hover-color:           #fff;
@navbar-inverse-link-hover-bg:              transparent;
@navbar-inverse-link-active-color:          @navbar-inverse-link-hover-color;
@navbar-inverse-link-active-bg:             darken(@navbar-inverse-bg, 10%);
@navbar-inverse-link-disabled-color:        #444;
@navbar-inverse-link-disabled-bg:           transparent;

// Inverted navbar brand label
@navbar-inverse-brand-color:                @navbar-inverse-link-color;
@navbar-inverse-brand-hover-color:          #fff;
@navbar-inverse-brand-hover-bg:             transparent;

// Inverted navbar toggle
@navbar-inverse-toggle-hover-bg:            #333;
@navbar-inverse-toggle-icon-bar-bg:         #fff;
@navbar-inverse-toggle-border-color:        #333;


// Navs
// -------------------------

@nav-link-padding:                          10px 15px;
@nav-link-hover-bg:                         @gray-lighter;

@nav-disabled-link-color:                   @gray-light;
@nav-disabled-link-hover-color:             @gray-light;

@nav-open-link-hover-color:                 @body-bg;

// Tabs
@nav-tabs-border-color:                     @table-border-color;

@nav-tabs-link-hover-border-color:          @gray-lighter;

@nav-tabs-active-link-hover-bg:             @body-bg;
@nav-tabs-active-link-hover-color:          @gray;
@nav-tabs-active-link-hover-border-color:   @table-border-color;

@nav-tabs-justified-link-border-color:            @table-border-color;
@nav-tabs-justified-active-link-border-color:     @body-bg;

// Pills
@nav-pills-border-radius:                   @border-radius-base;
@nav-pills-active-link-hover-bg:            @component-active-bg;
@nav-pills-active-link-hover-color:         @component-active-color;


// Pagination
// -------------------------

@pagination-bg:                        ' . $body_bg . ';
@pagination-border:                    ' . $table_border_color . ';

@pagination-hover-bg:                  @gray-lighter;

@pagination-active-bg:                 @brand-primary;
@pagination-active-color:              @body-bg;

@pagination-disabled-color:            @gray-light;


// Pager
// -------------------------

@pager-border-radius:                  @navbar-padding-horizontal;
@pager-disabled-color:                 @gray-light;


// Jumbotron
// -------------------------

@jumbotron-padding:              (@border-radius-large * 5);
@jumbotron-color:                ' . $jumbotron_text_color . ';
@jumbotron-bg:                   ' . $jumbotron_bg . ';
@jumbotron-heading-color:        ' . $jumbotron_headers_text_color . ';
@jumbotron-font-size:            ' . $font_jumbotron['font-size'] . 'px;


// Form states and alerts
// -------------------------

@state-success-text:             #3c763d;
@state-success-bg:               #dff0d8;
@state-success-border:           darken(spin(@state-success-bg, -10), 5%);

@state-info-text:                #31708f;
@state-info-bg:                  #d9edf7;
@state-info-border:              darken(spin(@state-info-bg, -10), 7%);

@state-warning-text:             #8a6d3b;
@state-warning-bg:               #fcf8e3;
@state-warning-border:           darken(spin(@state-warning-bg, -10), 5%);

@state-danger-text:              #a94442;
@state-danger-bg:                #f2dede;
@state-danger-border:            darken(spin(@state-danger-bg, -10), 5%);


// Tooltips
// -------------------------
@tooltip-max-width:           200px;
@tooltip-color:               @body-bg;
@tooltip-bg:                  darken(@gray-darker, 15%);

@tooltip-arrow-width:         @padding-small-vertical;
@tooltip-arrow-color:         @tooltip-bg;


// Popovers
// -------------------------
@popover-bg:                          @body-bg;
@popover-max-width:                   276px;
@popover-border-color:                rgba(0,0,0,.2);
@popover-fallback-border-color:       @ccc;

@popover-title-bg:                    darken(@popover-bg, 3%);

@popover-arrow-width:                 (@tooltip-arrow-width * 2);
@popover-arrow-color:                 @body-bg;

@popover-arrow-outer-width:           (@popover-arrow-width + 1);
@popover-arrow-outer-color:           rgba(0,0,0,.25);
@popover-arrow-outer-fallback-color:  @gray-light;


// Labels
// -------------------------

@label-default-bg:            @gray-light;
@label-primary-bg:            @brand-primary;
@label-success-bg:            @brand-success;
@label-info-bg:               @brand-info;
@label-warning-bg:            @brand-warning;
@label-danger-bg:             @brand-danger;

@label-color:                 @body-bg;
@label-link-hover-color:      @body-bg;


// Modals
// -------------------------
@modal-inner-padding:         @line-height-computed;

@modal-title-padding:         ceil(@modal-inner-padding * (4/3)); // ~15px
@modal-title-line-height:     @line-height-base;

@modal-content-bg:                             @body-bg;
@modal-content-border-color:                   rgba(0,0,0,.2);
@modal-content-fallback-border-color:          @gray-light;

@modal-backdrop-bg:           darken(@gray-darker, 15%);
@modal-header-border-color:   lighten(@gray-lighter, 12%);
@modal-footer-border-color:   @modal-header-border-color;


// Alerts
// -------------------------
@alert-padding:               15px;
@alert-border-radius:         @border-radius-base;
@alert-link-font-weight:      bold;

@alert-success-bg:            @state-success-bg;
@alert-success-text:          @state-success-text;
@alert-success-border:        @state-success-border;

@alert-info-bg:               @state-info-bg;
@alert-info-text:             @state-info-text;
@alert-info-border:           @state-info-border;

@alert-warning-bg:            @state-warning-bg;
@alert-warning-text:          @state-warning-text;
@alert-warning-border:        @state-warning-border;

@alert-danger-bg:             @state-danger-bg;
@alert-danger-text:           @state-danger-text;
@alert-danger-border:         @state-danger-border;


// Progress bars
// -------------------------
@progress-bg:                 ' . $table_bg_hover . ';
@progress-bar-color:          ' . $body_bg . ';

@progress-bar-bg:             @brand-primary;
@progress-bar-success-bg:     @brand-success;
@progress-bar-warning-bg:     @brand-warning;
@progress-bar-danger-bg:      @brand-danger;
@progress-bar-info-bg:        @brand-info;


// List group
// -------------------------
@list-group-bg:               ' . $body_bg . ';
@list-group-border:           ' . $table_border_color . ';
@list-group-border-radius:    @border-radius-base;

@list-group-hover-bg:         ' . $table_bg_hover . ';
@list-group-active-color:     @component-active-color;
@list-group-active-bg:        @component-active-bg;
@list-group-active-border:    @list-group-active-bg;

@list-group-link-color:          @gray;
@list-group-link-heading-color:  @gray-dark;


// Panels
// -------------------------
@panel-bg:                    ' . $body_bg . ';
@panel-inner-border:          @list-group-border;
@panel-border-radius:         @border-radius-base;
@panel-footer-bg:             @list-group-hover-bg;

@panel-default-text:          @gray-dark;
@panel-default-border:        @table-border-color;
@panel-default-heading-bg:    @panel-footer-bg;

@panel-primary-text:          ' . $body_bg . ';
@panel-primary-border:        @brand-primary;
@panel-primary-heading-bg:    @brand-primary;

@panel-success-text:          @state-success-text;
@panel-success-border:        @state-success-border;
@panel-success-heading-bg:    @state-success-bg;

@panel-warning-text:          @state-warning-text;
@panel-warning-border:        @state-warning-border;
@panel-warning-heading-bg:    @state-warning-bg;

@panel-danger-text:           @state-danger-text;
@panel-danger-border:         @state-danger-border;
@panel-danger-heading-bg:     @state-danger-bg;

@panel-info-text:             @state-info-text;
@panel-info-border:           @state-info-border;
@panel-info-heading-bg:       @state-info-bg;


// Thumbnails
// -------------------------
@thumbnail-padding:           ceil(@table-cell-padding / 2 );
@thumbnail-bg:                @body-bg;
@thumbnail-border:            @list-group-border;
@thumbnail-border-radius:     @border-radius-base;

@thumbnail-caption-color:     @text-color;
@thumbnail-caption-padding:   @table-cell-padding;


// Wells
// -------------------------
@well-bg:                     @table-bg-hover;


// Badges
// -------------------------
@badge-color:                 @body-bg;
@badge-link-hover-color:      @body-bg;
@badge-bg:                    @gray-light;

@badge-active-color:          @link-color;
@badge-active-bg:             @body-bg;

@badge-font-weight:           bold;
@badge-line-height:           1;
@badge-border-radius:         10px;


// Breadcrumbs
// -------------------------
@breadcrumb-bg:               @table-bg-hover;
@breadcrumb-color:            @ccc;
@breadcrumb-active-color:     @gray-light;
@breadcrumb-separator:        "/";

// Carousel
// ------------------------

@carousel-text-shadow:                        0 1px 2px rgba(0,0,0,.6);

@carousel-control-color:                      @body-bg;
@carousel-control-width:                      15%;
@carousel-control-opacity:                    .5;
@carousel-control-font-size:                  @line-height-computed;

@carousel-indicator-active-bg:                @body-bg;
@carousel-indicator-border-color:             @body-bg;

@carousel-caption-color:                      @body-bg;


// Close
// ------------------------
@close-font-weight:           bold;
@close-color:                 darken(@gray-darker, 15%);
@close-text-shadow:           0 1px 0 @body-bg;


// Code
// ------------------------
@code-color:                  #c7254e;
@code-bg:                     #f9f2f4;

@pre-bg:                      #f5f5f5;
@pre-color:                   @gray-dark;
@pre-border-color:            #ccc;
@pre-scrollable-max-height:   340px;

// Type
// ------------------------
@text-muted:                  @gray-light;
@abbr-border-color:           @gray-light;
@headings-small-color:        @gray-light;
@blockquote-small-color:      @gray-light;
@blockquote-border-color:     @gray-lighter;
@page-header-border-color:    @gray-lighter;

// Miscellaneous
// -------------------------

// Hr border color
@hr-border:                   @gray-lighter;

// Horizontal forms & lists
@component-offset-horizontal: 180px;


// Container sizes
// --------------------------------------------------

// Small screen / tablet
@container-tablet:           ' . ( $screen_sm - ( $gutter / 2 ) ). 'px;
@container-sm:               @container-tablet;

// Medium screen / desktop
@container-desktop:          ' . ( $screen_md - ( $gutter / 2 ) ). 'px;
@container-md:               @container-desktop;

// Large screen / wide desktop
@container-large-desktop:    ' . ( $screen_lg - $gutter ). 'px;
@container-lg:                 @container-large-desktop;


// Shoestrap-specific variables
// --------------------------------------------------

@navbar-font-size:        ' . $font_navbar['font-size'] . 'px;
@navbar-font-weight:      ' . $font_navbar['font-weight'] . ';
@navbar-font-style:       ' . $font_navbar['font-style'] . ';
@navbar-font-family:      ' . $font_navbar['font-family'] . ';
@navbar-font-color:       ' . $navbar_text_color . ';

@brand-font-size:         ' . $font_brand['font-size'] . 'px;
@brand-font-weight:       ' . $font_brand['font-weight'] . ';
@brand-font-style:        ' . $font_brand['font-style'] . ';
@brand-font-family:       ' . $font_brand['font-family'] . ';
@brand-font-color:        ' . $brand_text_color . ';

@jumbotron-font-weight:       ' . $font_jumbotron['font-weight'] . ';
@jumbotron-font-style:        ' . $font_jumbotron['font-style'] . ';
@jumbotron-font-family:       ' . $font_jumbotron['font-family'] . ';

@jumbotron-headers-font-weight:       ' . $font_jumbotron_headers_weight . ';
@jumbotron-headers-font-style:        ' . $font_jumbotron_headers_style . ';
@jumbotron-headers-font-family:       ' . $font_jumbotron_headers_face . ';

// H1
@heading-h1-face:         ' . $font_h1_face . ';
@heading-h1-weight:       ' . $font_h1_weight . ';
@heading-h1-style:        ' . $font_h1_style . ';
@heading-h1-height:       ' . $font_h1_height . ';
@heading-h1-color:        ' . $font_h1_color . ';
@font-size-h1:            floor(@font-size-base * ' . $font_h1_size . '); // ~36px

// H2
@heading-h2-face:         ' . $font_h2_face . ';
@heading-h2-weight:       ' . $font_h2_weight . ';
@heading-h2-style:        ' . $font_h2_style . ';
@heading-h2-height:       ' . $font_h2_height . ';
@heading-h2-color:        ' . $font_h2_color . ';
@font-size-h2:            floor(@font-size-base * ' . $font_h2_size . '); // ~30px

// H3
@heading-h3-face:         ' . $font_h3_face . ';
@heading-h3-weight:       ' . $font_h3_weight . ';
@heading-h3-style:        ' . $font_h3_style . ';
@heading-h3-height:       ' . $font_h3_height . ';
@heading-h3-color:        ' . $font_h3_color . ';
@font-size-h3:            ceil(@font-size-base * ' . $font_h3_size . '); // ~24px

// H4
@heading-h4-face:         ' . $font_h4_face . ';
@heading-h4-weight:       ' . $font_h4_weight . ';
@heading-h4-style:        ' . $font_h4_style . ';
@heading-h4-height:       ' . $font_h4_height . ';
@heading-h4-color:        ' . $font_h4_color . ';
@font-size-h4:            ceil(@font-size-base * ' . $font_h4_size . '); // ~18px

// H5
@heading-h5-face:         ' . $font_h5_face . ';
@heading-h5-weight:       ' . $font_h5_weight . ';
@heading-h5-style:        ' . $font_h5_style . ';
@heading-h5-height:       ' . $font_h5_height . ';
@heading-h5-color:        ' . $font_h5_color . ';
@font-size-h5:            ceil(@font-size-base * ' . $font_h5_size . '); // ~18px

// H6
@heading-h6-face:         ' . $font_h6_face . ';
@heading-h6-weight:       ' . $font_h6_weight . ';
@heading-h6-style:        ' . $font_h6_style . ';
@heading-h6-height:       ' . $font_h6_height . ';
@heading-h6-color:        ' . $font_h6_color . ';
@font-size-h6:            ceil(@font-size-base * ' . $font_h6_size . '); // ~12px

@navbar-margin-top:       ' . shoestrap_getVariable( 'navbar_margin_top' ) . 'px;





// AC Variables
// --------------------------------------------------

// Letter spacing
@ac-letter-spacing:							0.4em;
@ac-letter-spacing-sm:					0.25em;


// Text styles
@ac-text-transform:							uppercase;

// Border styles
@muted-text-color:						  lighten(@text-color, 40%); // lighten body color


// Border styles
@sidebar-text-color:						lighten(@text-color, 20%); // lighten body color


// Border styles
@sidebar-border:								2px lighten(@text-color, 70%) solid;
@sidebar-border-color:					lighten(@text-color, 70%);


// Border styles
@light-body-bg:								  lighten(@body-bg, 30%);

// Transition styles
@ac-transition:								  all .2s ease-in-out;
@ac-transparent-header-transition:	all .5s ease-in-out;

// Social Colours
@social-blogger:								#fc4f08;
@social-deviantart:							#4e6252;
@social-digg:										#d9d9d9;
@social-dribbble:								#ea4c89;
@social-facebook:								#3b5998;
@social-flickr:									#ff0084;
@social-github:									#d9d9d9;
@social-googleplus:							#dd4b39;
@social-instagram:							#517fa4;
@social-linkedin:								#0e76a8;
@social-myspace:								#008DDE;
@social-pinterest:							#c8232c;
@social-reddit:									#ff4500;
@social-rss:										#ee802f;
@social-skype:									#00aff0;
@social-soundcloud:							#ff7700;
@social-tumblr:									#34526f;
@social-twitter:								#00acee;
@social-vimeo:									#44bbff;
@social-youtube:								#c4302b;

@page-title-bg-color:         ' . $page_title_bg_color . ';
@page-title-padding:         	' . $page_title_padding . 'px;
@custom-page-title-padding:  	' . $custom_page_title_padding . 'px;
@button-bg-color:				 			' . $button_bg_color . ';	
@footer-color:				 				' . $footer_color . ';	
@footer-background:				 		' . $footer_background . ';	
@button-bg-text:             	lighten(@button-bg-color, 100%);
@comment-author-bg-color:			darken(@body-bg, 5%);
@aeis-slideshow-height:				' . $aeis_slideshow_height . "px;	
@post_excerpt_link_text:			'" . $post_excerpt_link_text . "';

@side_tab_top:								".$side_tab_top."%;
@side_tab_bg_colour:					".$side_tab_bg_colour.";
@side_tab_text_colour:				".$side_tab_text_colour.";

";

if ( $site_style == 'static' ):
// disable responsiveness
  $variables .= '
    @grid-float-breakpoint: 0 !important;
    @screen-xs-max: 0 !important; 
    .container { max-width: none !important; width: @container-large-desktop; }
    html { overflow-x: auto !important; }
  ';
endif;


  return $variables;
}
endif;
