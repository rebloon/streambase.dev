<?php
/*****************/
/****  Header ****/ 
/*****************/
?>
<header class="banner navbar navbar-default topnavbar <?php echo esc_attr(shoestrap_navbar_class()); ?> <?php echo esc_attr(shoestrap_outer_container_class('header')); ?>" role="banner">
	<?php	do_action( 'shoestrap_inside_header_begin' );	?>
  <div class="<?php echo esc_attr(shoestrap_container_class('header')); ?> navbar-outer">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".nav-main, .nav-extras">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
			<?php do_action( 'shoestrap_pre_navbar_brand' ); ?>      
      <?php
      if ( shoestrap_getVariable( 'navbar_brand' ) != 0 ) :
        echo '<a class="navbar-brand ' . esc_attr(shoestrap_branding_class( false )) . '" href="' . home_url() . '/">';
          shoestrap_logo();
        echo '</a>';
      endif;
      ?>
    </div>
    
		<?php do_action( 'shoestrap_pre_main_nav' ); ?>

    <nav class="nav-main navbar-collapse collapse" role="navigation">
    	<?php if (shoestrap_getVariable( 'navbar_search' ) == 1 ) : ?>
      	<div id="nav-search-open" class="entypo-icon-search"></div>
			<?php endif; ?>
      <?php
        do_action( 'shoestrap_inside_nav_begin' );
      	?><ul class='<?php echo esc_attr(shoestrap_nav_class_pull()); ?>'><?php        

	        if (has_nav_menu('primary_navigation')) {        
	          // Add a search control for the mobile menu
						?>
						<li id="mobile-search">
							<form action="<?php echo home_url(); ?>" method="GET">
					    	<input type="text" name="s" value="" placeholder="<?php _e('Search', 'alleycat'); ?> <?php bloginfo('name'); ?>" /> <button type="submit" id="searchsubmitnav" class="ac-transparent-btn searchsubmit"><i class="entypo-icon-search"></i></button>
							</form> 
						</li>
						<?php
							
						// Does this page have a defined menu?
						$page_menu = ac_get_meta("page_menu");

						// Render the menu				
		        wp_nav_menu( array( 
		        	'theme_location' => 'primary_navigation', 
		        	'menu_class' 	=> shoestrap_nav_class_pull(), 
		        	'container' 	=> '', 
		        	'items_wrap' 	=> '%3$s',
		        	'depth'				=> 10,
		        	'menu'				=> $page_menu,
		        ));

	        }
					else {
						// Inform user
						echo '<li><a href="">Assign a menu</a></li>';
					}
									
				?></ul><?php                
        do_action( 'shoestrap_inside_nav_end' );
      ?>

    </nav>
    <?php do_action( 'shoestrap_post_main_nav' ); ?>
  </div>
	<?php	do_action( 'shoestrap_inside_header_end' );	?>
</header>
<a id="page-top" class='jump-pos'></a>