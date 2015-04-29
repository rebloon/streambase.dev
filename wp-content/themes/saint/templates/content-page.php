<?php
/*******************************/
/**** Page Content Template ****/ 
/*******************************/
?>
<article <?php post_class(); ?>>
  <div class="entry-content">
    <?php the_content(); ?>
    <div class="clearfix"></div>
    <?php do_action( 'shoestrap_single_after_content' ); ?>
  </div>
	<div class="clearfix"></div>
	
	<?php 
		// Add nextpage links		
		wp_link_pages( array( 
			'before' => '<nav class="post-bottom-nav">',
			'after' => '</nav>', 
			'next_or_number' => 'next',     
			'previouspagelink' => __('<span class="prev"><span class="entypo-icon-left-open"></span>Prev</span>'),
	    'nextpagelink' => __('<span class="next">Next<span class="next entypo-icon-right-open"></span></span>'),
		)); ?>

	<?php ac_social_sharing('page'); ?>
		
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