<?php
/********************************/
/**** Search Result Template ****/ 
/********************************/

global $post;

?>
<article <?php post_class(); ?>>
	
	<div class='col-sm-3 search-image pull-right'>
		<?php shoestrap_featured_image(false, true, true); ?>
	</div>

  <div class='col-sm-9 search-summary'>
    <?php echo ac_get_post_title(); ?>
		<?php shoestrap_meta_custom_render(); ?>
	  <div class="entry-summary">
	    
    <?php 
		    
		  $excerpt = ac_get_excerpt($post, false, false);
	    
	    if ($excerpt) {
		    echo $excerpt;
	    }
	    
	  ?>
	  </div>		
  </div>
 
</article>