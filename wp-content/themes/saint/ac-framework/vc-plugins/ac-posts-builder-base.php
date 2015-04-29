<?php
/**************************************/
/**** Alleycat Posts Builder Base  ****/ 
/**************************************/

// Base class for other posts builder to inherit from

abstract class WPBakeryShortCode_ac_posts_builders_base extends AC_VC_Base {

  protected $post_type = ''; // Post Type
  protected $post_category = ''; // Post Type Taxonomy Category
  protected $link_to_lightbox = false; // Do the tiles link to a lightbox of the image rather than the post?

  protected function content($atts, $content = null) {
    
		$this->content_has_container = false;

		// Get the shortcode atrributes
		extract(shortcode_atts(array(
			'title' => '',		
			'layout' => 'posts', // posts, grid, masonry, carousel, slider, showcase, tile, tile-masonry
			'cat' => '',
			'posts_per_page' => 6,
			'column_count' => 3,
			'column_count_tile' => 3,
			'ac_order' => 'order_date_desc', // order_title_asc, order_title_desc, order_date_desc, order_date_asc
			'order' => '',
			'orderby' => '',
			'show_title' => true,
			'show_excerpt' => true,
			'excerpt_length' => '',
			'autoplay' => 'false',
			'post__in' => '',
			'offset' => '',
			'show_cat_filter' => '',
			'css_animation' => '',
			'css' => '',
			'show_read_more' => true,
	  ), $atts));
	  
	  // Ensure all data is in the correct format, as there might be differences between Visual Composer and WP Query
	  // $post__in needs to be an array
	  $post__in = trim($post__in);
	  if ( $post__in && ( !is_array($post__in) ) ) {
		  $post__in = explode(',', $post__in);
			$atts['post__in'] = $post__in;
	  }
	  	  
	  // Merge in any plugin attributes.  This gives us a single portable set of options
  	$args = array(
			'post_type' => $this->post_type,
			'post_category' => $this->post_category,
			'link_to_lightbox' => $this->link_to_lightbox,
			'post_status' => 'publish',		
  	);
  	 	
  	// Expand the order by.  Don't do this if post ids have been provided
  	if ( $ac_order && (empty($post__in)) ) {
  	
			// Order.  Convert AC into WP
			$order = ac_convert_ac_order($ac_order);
			$atts['order'] = $order['order'];
			$atts['orderby'] = $order['orderby'];
  				
  	}
  	 	
		// Merge the atrributes into the grid builder args
		$args = wp_parse_args( $atts, $args );

		// Prepare args
		ac_prepare_args_for_get_posts($args);
				
  	// Apple a filter based on the type
  	$args = $this->filter_posts($args);		

		// CSS
	  $css_class = $this->build_outer_css($atts, $content);
	  
		// Build the content
	  $control = '';

	  // Standard - Posts
	  if ($layout == 'posts') {	  
		  	  	
			$control = ac_posts_list( $args );	  
		  
		}	  
	  // Grid
	  elseif ( ($layout == 'grid') || ($layout == 'masonry') ) { 
			
			$control = ac_posts_grid( $args );

	  }
	  // Carousel
	  elseif ($layout == 'carousel') { 
			
			$control = $this->get_carousel( $args );

	  }
	  // Slider
	  elseif ($layout == 'slider') {

		  if (! isset($args['slider_size'])) {
		  	$args['slider_size'] = '3by2'; // Default for image driver sliders		  			  
		  }
	    	  
	  	// Different style for some post types
	  	if ($this->post_type == 'attachment') {	  	
	  		$args['slider_style'] = 'slider-gallery';
	  	}
	  	elseif ($this->post_type == 'ac_testimonial') {	  	
	  		$args['slider_style'] = 'no-caption';
				$args['slider_size'] = 'auto-height';
	  		// Clear meta_key, which we normally set for sliders to _thumbnail_id to ensure only sliders with featured images are shown
	  		$args['meta_key'] = null; 
	  		$args['auto_height'] = true; // auto height as this is content lead and not image led
	  	}	  	
	  	else {
	  		$args['slider_style'] = 'slider-post';
	  	}	  	
	  	  	

			$control = ac_render_posts_slideshow( $args );		  		  	

	  }	  
	  // Showcase
	  elseif ($layout == 'showcase') {
			
			$control = $this->get_showcase( $args );

	  }	  
	  // Tile
	  elseif ( ($layout == 'tile') || ($layout == 'tile-masonry') ) {
	  			
			// Change the column count param
			$args['column_count'] = $args['column_count_tile'];
			$control = ac_posts_tile( $args );
			
	  }	  
	  
		// Build the output
		$output  = "\n\t".'<div class="'.esc_attr($css_class).' ac-'.$layout.'-wrapper">';
		$output .= "\n\t".$this->get_title($title);		
		$output .= "\n\t\t".'<div class="wpb_wrapper">';
		$output .= "\n\t\t\t".$control;
		$output .= "\n\t\t".'</div> '.$this->endBlockComment('.wpb_wrapper');
		$output .= "\n\t".'</div> '.$this->endBlockComment($this->settings['base']);
	  
	  return $output;

  }
  
  // Adjust the posts args based on the post type
  protected function filter_posts($args) {
	  
	  // VC doesn't allow 'cats'.  Rename
	  if (isset($args['ac_cat'])) {
		  $args['cat'] = $args['ac_cat'];
	  }

	  return $args;
  }

	// Returns the rendered carousel for this post type
  protected function get_carousel($atts) {
  
  	global $ac_carousel_id, $post;
  	  		
  	// Get our Unique counter
  	if ($ac_carousel_id == "") {
	  	$ac_carousel_id = 1;
  	}
  	else {
	  	$ac_carousel_id++;
  	}
		
		// Merge in the options
		$defaults = array(
		);
		$args = wp_parse_args( $atts, $defaults );
		
		// Prepare args	
		ac_prepare_args_for_get_posts($args);		
				
		extract($args);
		
		// Variables
		$column_count = 4;
		$responsive_min_width = 360;
		
		// Setup based on post type
		if ( $post_type == 'ac_testimonial' ) {
			$column_count = 2;
			$responsive_min_width = 768;
		}
				
		// Clean up the bool values.  Might be "true"			
		$show_title = filter_var($show_title, FILTER_VALIDATE_BOOLEAN);

		// Pass some values to the template
		$template_params = compact('show_title', 'column_count', 'link_to_lightbox');
		
		// Get the posts
		$posts = get_posts($args);
		
		$items = '';
			
		// Post type specifics
		if ($post_type == 'product') {
			$items .= '<div class="woocommerce ac_carousel">';
			$items .='<ul class="products" id="ac-carousel-'.$ac_carousel_id.'">';
		}
		else {
			$items .= '<div class="ac_carousel">';
			$items .='<div id="ac-carousel-'.$ac_carousel_id.'">';
		}
		
		// Render the items
		foreach ( $posts as $post )  {
		
			setup_postdata($post);

			// We need to return the content so buffer			
			ob_start();
			ac_load_component_content('ac_carousel', $template_params);
			$items .= ob_get_contents();
			ob_end_clean();

		}
		
		wp_reset_postdata();		
		
		// Post type specifics		
		if ($post_type == 'product') {
			$items .= '</ul>';		
		}		
		else {
					$items.='</div>';
		}

		
		$items.='<div class="clearfix"></div>';
		$items.='<a class="ac-arrows ac-carousel-prev ac-prev" id="ac_carousel_prev-'.$ac_carousel_id.'" href="#"><span>prev</span></a>';
		$items.='<a class="ac-arrows ac-carousel-next ac-next" id="ac_carousel_next-'.$ac_carousel_id.'" href="#"><span>next</span></a>';
		$items.='</div>';
			
		$items.= '
			<script>
			jQuery(function() {
				jQuery("#ac-carousel-'.$ac_carousel_id.'").carouFredSel({
					circular: true,
					responsive: true,
					height: "variable",
					infinite: true,
					auto 	: '.$autoplay.',
					prev	: {	
						button	: "#ac_carousel_prev-'.$ac_carousel_id.'",
						key		: "left"
					},
					next	: { 
						button	: "#ac_carousel_next-'.$ac_carousel_id.'",
						key		: "right"
					},
					pagination	: "#ac_carousel_pag",
						items: {
							height: "variable",
							width: '.$responsive_min_width.',
										visible: {
											min: 1,
											max: '.$column_count.'
										}
									}
				});
				
			});
			</script>
		';
		
		return $items;
	
	}
	
	// Returns the rendered showcase for this post type
  protected function get_showcase($atts) {
  
		global $post, $product;
    	
		// Merge in the options
		$defaults = array(
			'posts_per_page' => 4,
			'meta_key' => '_thumbnail_id', // only show posts with thumbnails
		);
		$args = wp_parse_args( $atts, $defaults );
		
		// Showcase is always 4
		$args['posts_per_page'] = 4;
		
		// Prepare args	
		ac_prepare_args_for_get_posts($args);		

		// Extract the args		
		extract($args);		
		
		// Clean up the bool values.  Might be "true"			
		$show_title = filter_var($show_title, FILTER_VALIDATE_BOOLEAN);
				
		// Calc item width, avoid div by zero
		if ($column_count == 0) {
			$item_width = '100%';
		}
		else {
			$item_width = floor(100 / $posts_per_page);
			$item_width = $item_width."%;";
		}
		
		// Pass some values to the template
		$template_params = compact('item_width', 'show_title', 'column_count');
		
		// Get the posts
		$posts = get_posts($args);

		// Post type specifics
		if ($post_type == 'product') {
			$items = '<div class="woocommerce ac-showcase">';
			$items = '<ul class="products">';
		}
		else {
			$items = '<div class="ac-showcase">';			
		}

		// Render the items
		foreach ( $posts as $post )  {
		
			setup_postdata($post);

			// We need to return the content so buffer			
			ob_start();
			ac_load_component_content('ac_showcase', $template_params);
			$items .= ob_get_contents();
			ob_end_clean();
				
		}
						
		wp_reset_postdata();					

		if ($post_type == 'product') {
			$items .= '</ul>';
		}
		$items .= '</div>';					
		
		return $items;
	
	}
	

}