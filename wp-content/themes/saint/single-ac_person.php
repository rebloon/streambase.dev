<?php
/*******************************/
/**** Person Page Template  ****/ 
/*******************************/

$aside_cols = 4;		

while (have_posts()) : the_post(); ?>
  <article <?php post_class(); ?>>

    <div class="entry-content row">
    
      <section class='side-meta col-xs-12 col-sm-<?php echo $aside_cols; ?> ac-page-right-side'>
				<?php echo ac_render_image_for_columns( array('image_id' => get_post_thumbnail_id(), 'columns' => $aside_cols) ); ?>
      	<?php get_template_part('templates/page-side-meta', 'person'); ?>
			</section>          

      <div class='col-sm-8 ac-page-left-side'>
      	<?php      
				$position = ac_get_meta('position');
				if ($position) : ?>
					<h2 class="position"><?php echo $position;?></h2> <?php 
				endif; 
				
				the_content(); 
				?>
      </div>

      <div class="clearfix"></div>
      <?php do_action( 'shoestrap_single_after_content' ); ?>
    </div>
    <footer class='container row'>
			<?php ac_social_sharing(); ?>    
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
<?php endwhile;