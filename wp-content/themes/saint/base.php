<?php
/***********************/
/**** Base Template ****/ 
/***********************/
// Determines the HTML page stucture

$site_style               = shoestrap_getVariable( 'site_style' );
$navbar_toggle            = shoestrap_getVariable( 'navbar_toggle' );
?>
<?php get_template_part('templates/head'); ?>
<body <?php body_class(); ?> <?php ac_body_data(); ?>>
	
	<div id="outer-wrap">	
		
	  <?php do_action( 'get_header' ); ?>
	
	  <?php do_action( 'shoestrap_pre_navbar' ); ?>
	  <?php if ( !has_action( 'shoestrap_header_top_navbar_override' ) ) : ?>
	    <?php get_template_part( 'templates/header-top-navbar' ); ?>
	  <?php else : ?>
	    <?php do_action( 'shoestrap_header_top_navbar_override' ); ?>
	  <?php endif; ?>
	  <?php do_action( 'shoestrap_post_navbar' ); ?>
	
	  <?php if ( has_action( 'shoestrap_below_top_navbar' ) ) : ?>
	    <div class="before-main-wrapper">
	      <?php do_action('shoestrap_below_top_navbar'); ?>
	    </div>
	  <?php endif; ?>
	
	  <?php do_action('shoestrap_pre_wrap'); ?>
	
	  <?php do_action('shoestrap_header_media'); ?>
	   
		<?php get_template_part('templates/post-header', ''); ?>  

	  <div class="wrap main-section <?php echo esc_attr(shoestrap_container_class('main')); ?>" role="document">
	
	    <?php do_action('shoestrap_pre_content'); ?>
	
	    <div class="content">
	      <div class="row bg">
	        <?php do_action('shoestrap_pre_main'); ?>
	
	        <?php if ( shoestrap_section_class( 'wrap' ) ) : ?>
	          <div class="mp_wrap <?php echo esc_attr(shoestrap_section_class( 'wrapper' )); ?>">
	            <div class="row">
	        <?php endif; ?>
	
	        <main class="main <?php echo esc_attr(ac_get_sidebar_class()); ?> <?php echo esc_attr(shoestrap_section_class( 'main' )); ?>" <?php if (is_home()){ echo 'id="home-blog"';} ?> role="main">
	          <?php include roots_template_path(); ?>
	        </main><!-- /.main -->
	
	        <?php do_action('shoestrap_after_main'); ?> 
	
	        <?php if ( ac_get_left_sidebar() ) : ?>
	          <aside class="sidebar primary <?php echo esc_attr(ac_get_sidebar_class()); ?> <?php echo esc_attr(shoestrap_section_class( 'primary' )); ?> <?php echo esc_attr(ac_get_hide_until_fade_class()); ?>" role="complementary">
	            <?php include new Roots_Wrapping('templates/sidebar.php'); ?>
	          </aside><!-- /.sidebar -->
	        <?php endif; ?>
	
	        <?php if ( shoestrap_section_class( 'wrap' ) ) : ?>
	            </div>
	          </div>
	        <?php endif; ?>
	
	        <?php if ( ac_get_right_sidebar() ) : ?> 
	          <aside class="sidebar secondary <?php echo esc_attr(ac_get_sidebar_class()); ?> <?php echo esc_attr(shoestrap_section_class( 'secondary' )); ?> <?php echo esc_attr(ac_get_hide_until_fade_class()); ?>" role="complementary">
	            <?php include new Roots_Wrapping('templates/sidebar-secondary.php'); ?>
	          </aside><!-- /.sidebar -->
	        <?php endif; ?>
	      </div>
	    </div><!-- /.content -->
	    <?php do_action('shoestrap_after_content'); ?>
	  </div><!-- /.wrap -->
    <?php do_action('shoestrap_after_wrap'); ?>
	</div><!-- /.outer-wrap -->
  <?php do_action('shoestrap_after_outer_wrap'); ?>
  
  <?php do_action('shoestrap_pre_footer'); ?>
  <?php if ( !has_action( 'shoestrap_footer_override' ) ) : ?>
    <?php get_template_part('templates/footer'); ?>
  <?php else : ?>
    <?php do_action( 'shoestrap_footer_override' ); ?>
  <?php endif; ?>

  <?php do_action('shoestrap_after_footer'); ?>

  <?php wp_footer(); ?>
</body>
</html>