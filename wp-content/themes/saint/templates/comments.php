<?php
/***************************/
/**** Comments Template ****/ 
/***************************/

if (post_password_required()) {
  return;
}

if (have_comments()) : ?>
  <section id="comments">
   	<div class='comments-header'>
   		<h3>Comments</h3>
	   	<div class='comment-counter'><?php echo get_comments_number(); ?></div>
   	</div>
   	<div class='clearfix'></div>

    <ul class="media-list">
      <?php wp_list_comments(array('walker' => new Roots_Walker_Comment)); ?>
    </ul>

    <?php if (get_comment_pages_count() > 1 && get_option('page_comments')) : ?>
    <nav>
      <ul class="pager">
        <?php if (get_previous_comments_link()) : ?>
          <li class="previous"><?php previous_comments_link(__('&larr; Older comments', 'roots')); ?></li>
        <?php endif; ?>
        <?php if (get_next_comments_link()) : ?>
          <li class="next"><?php next_comments_link(__('Newer comments &rarr;', 'roots')); ?></li>
        <?php endif; ?>
      </ul>
    </nav>
    <?php endif; ?>

    <?php if (!comments_open() && !is_page() && post_type_supports(get_post_type(), 'comments')) : ?>
    <div class="alert alert-warning">
      <?php _e('Comments are closed.', 'roots'); ?>
    </div>
    <?php endif; ?>
  </section><!-- /#comments -->
<?php endif; ?>

<?php if (comments_open()) : ?>

  <!-- comment form start -->
  <?php
  
		$req = get_option( 'require_name_email' );
		$aria_req = ( $req ? " aria-required='true'" : '' );  
  
  	$comment_args = array(
		  'id_form'           => 'commentform',
		  'id_submit'         => 'submit',
		  'title_reply'       => __( 'Something to Say?', 'alleycat' ),
		  'title_reply_to'    => __( 'Something to Say?', 'alleycat' ),
		  'cancel_reply_link' => __( 'Cancel Reply', 'alleycat' ),
		  'label_submit'      => __( 'Post Comment', 'alleycat' ),
		  
		  'comment_field' =>  '
		  	<div class="form-group">
          <textarea name="comment" id="comment" class="form-control" rows="5" aria-required="true" placeholder="Comment"></textarea>
        </div>
			',
			
		  'comment_notes_before' => 
		  	'<p class="comment-notes">' .
		    	__( 'Your email address will not be published.', 'roots') .
		    '</p>',
			
		  'comment_notes_after' => '',
		  
		  'fields' => apply_filters( 'comment_form_default_fields', array(
		
				'<div class="row">',
		    'author' =>
		      '<div class="form-group col-sm-4">
            <input type="text" class="form-control" name="author" id="author" value="'. esc_attr($comment_author). '" size="22" '. $aria_req .' placeholder="Name">
          </div>',
		
		    'email' =>
		      '<div class="form-group col-sm-4">
            <input type="email" class="form-control" name="email" id="email" value="'. esc_attr($comment_author_email). '" size="22" '. $aria_req .' placeholder="Email">
          </div>',
		
		    'url' =>
		      '<div class="form-group col-sm-4">
            <input type="url" class="form-control" name="url" id="url" value="'.  esc_attr($comment_author_url). '" size="22" placeholder="Website">
          </div>',
          '</div>'
		    )
		  ),		  
		  
		);

  ?>
	<?php comment_form($comment_args); ?>    
  <!-- comment form end -->
  
<?php endif;
