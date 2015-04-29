<?php
/******************************/
/**** AC Carousel Template ****/ 
/******************************/

// Template to style a single Carousel entry

global $post;

// Get some values
$item_title = get_the_title($post->ID);
$thumb = ac_resize_image_for_columns( array('image_id' => ac_get_post_thumbnail_id($post->ID), 'columns' => $column_count) );
$a_start = "<a href='".get_permalink($post->ID)."' >";
$a_end = "</a>";

?>
<li <?php post_class( ' ac-carousel-content ' ); ?>>

	<?php do_action( 'woocommerce_before_shop_loop_item' ); ?>

	<a href="<?php the_permalink(); ?>">

		<?php
			/**
			 * woocommerce_before_shop_loop_item_title hook
			 *
			 * @hooked woocommerce_show_product_loop_sale_flash - 10
			 * @hooked woocommerce_template_loop_product_thumbnail - 10
			 */
			do_action( 'woocommerce_before_shop_loop_item_title' );
		?>

		<h3><?php the_title(); ?></h3>

		<?php
			/**
			 * woocommerce_after_shop_loop_item_title hook
			 *
			 * @hooked woocommerce_template_loop_rating - 5
			 * @hooked woocommerce_template_loop_price - 10
			 */
			do_action( 'woocommerce_after_shop_loop_item_title' );
		?>

	</a>

	<?php do_action( 'woocommerce_after_shop_loop_item' ); ?>

</li>