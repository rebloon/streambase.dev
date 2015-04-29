<?php
/************************************/
/**** Portfolio Preview Template ****/ 
/************************************/

?>
<article <?php post_class('ac-2by2'); ?>>

	<div class='row'>
	
		<div class='col-md-5 image-col pull-right'>
	  	<?php shoestrap_featured_image(false, true, true); ?>
		</div>		

		<div class='col-md-7'>	
		  <header>
				<?php shoestrap_meta_custom_render(); ?>    
		    <?php echo ac_get_post_title(); ?>
		  </header>
		  
		  <div class="entry-summary">
		    <?php echo ac_get_excerpt($post); ?>
		    <div class="clearfix"></div>
		  </div>
		</div>
		 	 
	</div>
	
  <?php
  if ( has_action( 'shoestrap_entry_footer' ) ) :
    echo '<footer class="entry-footer">';
    do_action( 'shoestrap_entry_footer' );
    echo '</footer>';
  endif;
  ?>
  
  <?php do_action( 'shoestrap_in_article_bottom' ); ?>
</article>