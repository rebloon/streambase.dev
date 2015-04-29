<?php
/**********************/
/**** 404 Template ****/ 
/**********************/
?>

<div class="contents">
	<h1><?php _e("404", 'alleycat'); ?></h1>
	<h3><?php _e("That page can't be found!", 'alleycat'); ?></h3>
	<p><a href="<?php echo home_url(); ?>"><?php _e("Go back to the start", 'alleycat')?></a> <?php _e("or try searching for what you were looking for.", 'alleycat'); ?></p>
	<?php get_search_form(); ?>
</div>