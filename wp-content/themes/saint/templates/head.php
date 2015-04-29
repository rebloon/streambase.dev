<!DOCTYPE html>
<html class="ac-theme-html no-js <?php echo esc_attr(ac_get_html_class()); ?> <?php echo esc_attr(ac_get_device_classes()); ?>" <?php language_attributes(); ?> >
<head>
  <meta charset="utf-8">
  <?php
  	// Add IE compability
  	if (isset($_SERVER['HTTP_USER_AGENT']) && (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false)) {
			?><meta http-equiv="X-UA-Compatible" content="IE=edge"><?php
  	}
	?>
  <title><?php wp_title('|', true, 'right'); ?></title>
<?php if ( shoestrap_getVariable( 'site_style' ) != 'static' ): ?>
  <meta name="viewport" content="width=device-width, initial-scale=1">
<?php endif; ?>


  <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
  	<script src="<?php echo get_template_directory_uri(); ?>/assets/js/vendor/html5shiv.js"></script>
  	<script src="<?php echo get_template_directory_uri(); ?>/assets/js/vendor/respond.min.js"></script>
	<![endif]-->
	
  <link rel="alternate" type="application/rss+xml" title="<?php echo get_bloginfo('name'); ?> Feed" href="<?php echo home_url(); ?>/feed/">
  	
  <?php wp_head(); ?>	
</head>