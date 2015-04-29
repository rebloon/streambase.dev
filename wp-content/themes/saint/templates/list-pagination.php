<?php
/**********************************/
/**** List Pagination Template ****/ 
/**********************************/

// Pagination
$pagination = shoestrap_getVariable( 'pagination' );
if ( $pagination == 'pager' ) :
  if ($wp_query->max_num_pages > 1) : ?>
    <nav class="post-nav">
      <ul class="pager">
        <li class="previous"><?php next_posts_link(__('&larr; Older posts', 'roots')); ?></li>
        <li class="next"><?php previous_posts_link(__('Newer posts &rarr;', 'roots')); ?></li>
      </ul>
    </nav>
  <?php
  endif;
else :
  //Use this function to create pagingation links that are styleable with Bootstrap 3 default pagination
  //Thanks to @sloped (https://gist.github.com/sloped/2117898)
  global $wp_query;
  
  // Get the curret page URL
  $page_url = ac_get_current_url();
    
  $total_pages = $wp_query->max_num_pages;
   
  if ($total_pages > 1){
    $current_page = max(1, get_query_var('paged'));
    $count = 0;
    $previous_page = $current_page - 1;
    $next_page = $current_page + 1;
    echo '<ul class="pagination">';
    if($total_pages > 3) { 
      if($current_page > 1) echo '<li class="last"><a href="' . $page_url . 'page/1/"><<</a></li>' ;
      if($current_page > 1) echo '<li class="previous"><a href="' . $page_url . 'page/' . $previous_page . '/"><</i></a></li>' ;
    }
    while($count < $total_pages) {
      $count = $count + 1;  
      
      if($count == $current_page) echo '<li class="active"><a href="' . $page_url . 'page/' . $count . '/">' . $count . '</a></li>' ;
      else echo '<li class="inactive"><a href="' . $page_url . 'page/' . $count . '/">' . $count . '</a></li>' ;
    }
    if($total_pages > 3) {
      if($current_page < $total_pages) echo '<li class="next"><a href="' . $page_url . 'page/' . $next_page . '">></i></a></li>' ;
      if($current_page < $total_pages) echo '<li class="last"><a href="' . $page_url . 'page/' . $total_pages . '">>></a></li>' ;
    }
    ?>
    </ul>
    <?php
    }
endif;