<?php
/**********************************/
/**** Portfolio Page Template  ****/ 
/**********************************/

$lightbox_images = ac_get_meta('open_in_lightbox');

while (have_posts()) : the_post(); ?>
	<?php
		// -- Get Portfolio values --
		$template_type = ac_get_meta("template_type");
		$aside_cols = 3;
		
		if ($template_type == 'side-images') {
			// aside is bigger for side images template
			$aside_cols = 4;
		}
	?>
  <article <?php post_class($template_type); ?>>
    <div class="entry-content row">
      <div class='col-sm-8 ac-page-left-side'>
      	<?php 
		    	// Show the correct content
		    	if ($template_type == 'top-images') {
							the_content(); 					
		    	} 
		    	else {
		    		// Images
		    		$images = ac_get_images_for_post( get_the_ID(), ac_get_meta('include_featured_image') );
		    		if ( count($images) ) : 
			    		?> <div class='post-images'> <?php
				    		foreach( $images as $image_id ) {
					    		$a_start = '';
					    		$a_end = '';
					    		if ($lightbox_images) {
						    		$img = ac_resize_image_for_columns( array('image_id'=>$image_id, 'columns'=>12, 'ratio' => AC_IMAGE_RATIO_PRESERVE) );
										$a_start = '<a class="prettyphoto" href="'.esc_url($img['url']).'" rel="prettyPhoto[rel-'.ac_get_prettyphoto_rel().']"><div>';
						    		$a_end = '</div></a>';
					    		}
				    			echo $a_start;
				    			echo ac_render_image_for_columns( array('image_id' => $image_id, 'columns' => 7, 'ratio' => AC_IMAGE_RATIO_PRESERVE) );
				    			echo $a_end;				    			
				    		}
			    		?> </div> <?php			    		
			    	endif;
		    	}
	    	?>
      </div>
      <section class='side-meta col-xs-12 col-sm-<?php echo $aside_cols; ?> ac-page-right-side'>
      	<?php 
      	
		    	if ($template_type == 'side-images') {  ?>
		    		<div class='content'> <?php		    	
							the_content(); ?>
		    		</div> <?php		
		    	} 
      	
      		get_template_part('templates/page-side-meta', 'portfolio');
      		
      	?>
			</section>      
      <div class="clearfix"></div>
      <?php do_action( 'shoestrap_single_after_content' ); ?>
    </div>
    <footer>
			<?php ac_social_sharing(); ?>    
	    <?php get_template_part('templates/related-projects', 'portfolio'); ?>
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
<?php endwhile; ?>