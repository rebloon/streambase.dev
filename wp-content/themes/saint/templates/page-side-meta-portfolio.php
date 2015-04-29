<?php
/*******************/
/**** Side Meta ****/ 
/*******************/
?>
<ul class='meta-data'> 
	<li class='date'><i class='entypo smaller icon-calendar-1'></i><?php the_date(); ?></li> 
	<?php
	// Check for external URL
	$url = ac_get_meta('url');
	if ( $url ) : ?>
		<li class='portolio-link' ><i class='entypo smaller icon-forward-1'></i><a id="portfolio-link" href='<?php echo esc_url($url); ?>' target='_blank'>View Project</a></li> <?php
	endif; 
	?>
	<?php echo get_the_term_list($post->ID, 'portfolio-category', '<li><i class="entypo smaller icon-plus-circled-1"></i>', '</li><li><i class="entypo smaller icon-plus-circled-1"></i>', '</li>'); ?>
</ul>

<?php
	$show_sidebar = ac_get_meta("show_portfolio_sidebar");
	if ($show_sidebar) : 
?>
	<section class='sidemeta-sidebar'>
		<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('sidebar-portfolio') ) :  endif; ?>
	</section>
<?php
	endif;
?>