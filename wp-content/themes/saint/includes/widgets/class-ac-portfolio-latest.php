<?php
/*
Plugin Name: AC Latest Portfolio
Plugin URI: http://alleycatthemes.com/
Description: Displays the latest Portfolio Item in a widget
Author: Alleycat Themes
Version: 1
Author URI: http://alleycatthemes.com/
*/


class AC_Latest_Portfolio extends WP_Widget
{
  function AC_Latest_Portfolio()
  {
    $widget_ops = array(
    	'classname' => 'ac-latest-portfolio', 
    	'description' => 'Displays the latest Portfolio Item' 
    );
    $this->WP_Widget('AC_Latest_Portfolio', 'AC Latest Portfolio Item', $widget_ops);
  }
 
  function form($instance)
  {
    $instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );
    $title = $instance['title'];
		?>
		  <p><label for="<?php echo $this->get_field_id('title'); ?>">Title: <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label>
		 	</p>
		<?php
  }
 
  function update($new_instance, $old_instance)
  {
    $instance = $old_instance;
    $instance['title'] = $new_instance['title'];
    return $instance;
  }
 
  function widget($args, $instance)
  {
	  global $post;
	  
    extract($args, EXTR_SKIP);
 
    echo $before_widget;
    $title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
 
    if (!empty($title))
      echo $before_title . $title . $after_title;;
 
		// Get the latest Portfolio
		$args = array(
			'post_type'					=> 'ac_portfolio',
			'posts_per_page'   	=> 1,
			'orderby'            	=> 'date',
		);
		$posts = get_posts($args);
		
		if (! empty($posts)) {
			
			foreach ( $posts as $post ) : setup_postdata( $post ); 
			
				// Display as a Grid Col

				// Pass some values to the template
				$show_title = true;
				$show_excerpt = true;
				$column_count = 3;
				$post_category = 'portfolio-category';
				$cols_class = ' col-log-3 ';
				$cols = 3;
				$excerpt_length = '';
				$post_type = 'ac_portfolio';
				$show_read_more = true;
				$template_params = compact('show_title', 'show_excerpt', 'column_count', 'post_category', 'cols_class', 'cols', 'excerpt_length', 'post_type', 'show_read_more');

				// Load the template
				ac_load_component_content('ac_grid', $template_params);										
			
			?>
			<?php endforeach; 
			wp_reset_postdata();
			
		}	
 
    echo $after_widget;
  }
 
}
add_action( 'widgets_init', create_function('', 'return register_widget("AC_Latest_Portfolio");') );?>