<?php
/**************************/
/**** Comment Template ****/ 
/**************************/
?>
<div class='comment-comment'>
	<?php echo get_avatar($comment, $size = '75'); ?>
	<div class="media-body">
	  <h4 class="media-heading"><?php echo get_comment_author_link(); ?></h4>
	  <time datetime="<?php echo comment_date('c'); ?>"><a href="<?php echo htmlspecialchars(get_comment_link($comment->comment_ID)); ?>"><?php echo ac_comment_date_time(); ?></a></time>
	  <?php edit_comment_link(__('(Edit)', 'roots'), '', ''); ?>
	
	  <?php if ($comment->comment_approved == '0') : ?>
	    <div class="alert alert-info">
	      <?php _e('Your comment is awaiting moderation.', 'roots'); ?>
	    </div>
	  <?php endif; ?>
	
	  <div class='comment-text'><?php comment_text(); ?></div>
	  <?php comment_reply_link(array_merge($args, array('depth' => $depth, 'max_depth' => $args['max_depth']))); ?>  
	</div>
</div>