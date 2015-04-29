<?php
/**
 * Enqueue scripts (was styles also)
 *
 * Enqueue scripts in the following order:
 * 1. jquery-1.10.2.min.js via Google CDN
 * 2. /theme/assets/js/vendor/modernizr-2.7.0.min.js
 * 3. /theme/assets/js/plugins.js (in footer)
 * 4. /theme/assets/js/main.js    (in footer)
 */
function roots_scripts() {

  if (is_single() && comments_open() && get_option('thread_comments')) {
    wp_enqueue_script('comment-reply');
  }

  wp_register_script('modernizr', get_template_directory_uri() . '/assets/js/vendor/modernizr-2.7.0.min.js', false, null, false);
  wp_register_script('roots_plugins', get_template_directory_uri() . '/assets/js/bootstrap.min.js', false, null, true);
  wp_register_script('roots_main', get_template_directory_uri() . '/assets/js/main.js', false, null, true);
  wp_enqueue_script('jquery');
  wp_enqueue_script('modernizr');
  wp_enqueue_script('roots_plugins');
  wp_enqueue_script('roots_main');

  if ( shoestrap_getVariable( 'retina_toggle' ) == 1 ) {
    wp_register_script('retinajs', get_template_directory_uri() . '/assets/js/vendor/retina.js', false, null, true);
    wp_enqueue_script('retinajs');
  }
  wp_register_script('fitvids', get_template_directory_uri() . '/assets/js/vendor/jquery.fitvids.js', false, null, true);
  wp_enqueue_script('fitvids');
}

// Insert GA into page
function roots_google_analytics() { 
	
	$aid = trim(shoestrap_getVariable('analytics_id'));

	// Only show if we have GA and this is not an admin user
	if ( $aid && !current_user_can('manage_options')) {
	?>
		<script>
		  (function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
		  function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
		  e=o.createElement(i);r=o.getElementsByTagName(i)[0];
		  e.src='//www.google-analytics.com/analytics.js';
		  r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
		  ga('create','<?php echo $aid; ?>');ga('send','pageview');
		</script>
	<?php 
	}
}