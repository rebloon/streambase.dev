<?php
/*******************************/
/**** Single Post Template  ****/ 
/*******************************/

// This is also used for any post type that doesn't have it's own template

?>
<article <?php post_class(); ?>>
  <header>
	  <h1><strong><?php echo roots_title(); ?></strong></h1>
  	<?php shoestrap_meta_custom_render(); ?>   
  </header>
  <div class="entry-content">
    <?php the_content(); ?>
    <div class="clearfix"></div>
    <?php do_action( 'shoestrap_single_after_content' ); ?>
  </div>
  <footer>
		<?php ac_social_sharing(); ?>  
  	<?php get_template_part('templates/post-bottom-nav', 'single'); ?>
  </footer>

  <?php
  // The comments section loaded when appropriate
  if ( post_type_supports( 'post', 'comments' ) ):
    do_action( 'shoestrap_pre_comments' );
    if ( !has_action( 'shoestrap_comments_override' ) )
      comments_template('/templates/comments.php');
    else
      do_action( 'shoestrap_comments_override' );
    do_action( 'shoestrap_after_comments' );
  endif;
  ?>
  <?php do_action( 'shoestrap_in_article_bottom' ); ?>
</article>