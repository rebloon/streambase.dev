<?php
/***********************/
/**** Post Template ****/ 
/***********************/

// For Posts preview, in the loop.  For single and any post type that doesn't have it's own template

?>
<article <?php post_class(); ?>>

  <?php shoestrap_featured_image(); ?> 

  <header>
		<?php shoestrap_meta_custom_render(); ?>    
    <?php echo ac_get_post_title(); ?>
  </header>
  
  <div class="entry-summary ">
    <?php echo ac_get_excerpt(); ?>
    <div class="clearfix"></div>
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