<?php
/****************************/
/**** Common post header ****/ 
/****************************/

// Only include this header if the bigger header hasn't already been rendered
if ( ! ac_page_has_page_title_header() ) :
?>
<div class="page-header">
  <h1>
    <?php echo roots_title(); ?>
  </h1>
</div>
<?php
	endif;
?>