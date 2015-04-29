<?php
/*****************/
/****  Posts  ****/ 
/*****************/

// Does this WP page has a big page title header?
if (!function_exists('ac_page_has_page_title_header')) {
	function ac_page_has_page_title_header() {
	
		global $post_types_with_no_archive_header;
	
		// Check for post types without page headers
		if (is_post_type_archive( $post_types_with_no_archive_header )) {
			return false;
		}
	
		if ( is_single() ) {
			switch (get_post_type(ac_get_post_id())) {
			    case 'post' : 
			    case 'ac_gallery' : 
			    case 'ac_testimonial' : 
			        return false;
			        break;
			    default:
			    	return true;
			}		
			
		}
		elseif ( is_single() || ( is_home() && !is_front_page() ) || is_page() || is_archive() || ac_is_bbpress() || is_search() ) {
			return true;	
		}
		else {
			return false;		
		}
		
	}
}

// Return the page title for the post.
// Observerves whether the title might be hidden when in a VC loop
// $args = array of options
function ac_get_post_title( $post = 0, $args = array() ) {

	global $ac_show_title;
	
	// Define the defaults
	$defaults = array(
		'heading_tag' => 'h2',
		'class' => '',
	);
	
	// Merge in the options
	$args = wp_parse_args( $args, $defaults );
	
	// Params to variables
	extract($args);	

	$post = get_post( $post );	
	
	if ( isset($ac_show_title) && ($ac_show_title == false) ) {
		return '';
	}
	else {
		return '<'.$heading_tag.' class="entry-title '.$class.'"><strong><a href="'. get_permalink($post->ID). '">'. get_the_title($post->ID) .'</a></strong></'.$heading_tag.'>';			

	}

}

// Returns the best excerpt for a given post
// $append_html = HTML to add after the excerpt and before the Continue link
function ac_get_excerpt( $post = 0, $char_limit = false, $show_read_more = true, $wrap = true, $append_html = '' ) {

	global $ac_show_excerpt,
		$ac_show_read_more;
			
	// Check for global override of Show Excerpt
	if ( isset($ac_show_excerpt) && ($ac_show_excerpt == false) ) {	
		return '';
	}
	
	// Check for global override of Show Read More	
	if ( isset($ac_show_read_more) && ($ac_show_read_more == false) ) {	
		$show_read_more = $ac_show_read_more;
	}

	$excerpt = '';
	
	$post = get_post( $post );
	
	// Check for show all post as excerpt
	if ($char_limit == -1) {
		// Use the entire post as the excerpt, for testimonials, etc.
		$excerpt = $post->post_content;
		
		// Remove shortcodes
		$excerpt = strip_shortcodes($excerpt);			
		
		// Strip all HTML before adding paragragh tags
		$excerpt = wp_strip_all_tags($excerpt);
		$excerpt = ac_format_post_content($excerpt);
		
	}
	else {
		// Observe char limits, WP standards

		// 1.  Is there a WP Excerpt?
		$excerpt = $post->post_excerpt;	
	
		// Remove shortcodes
		$excerpt = strip_shortcodes($excerpt);	
		
		// 2.  Content before the <!--more--> tag
		if (! $excerpt) {
	
			// Get the full content
			$content = $post->post_content;
	
			// Split the content
			if ( preg_match( '/<!--more(.*?)?-->/', $content, $matches ) ) {
				$content = explode( $matches[0], $content, 2 );
				if ( ! empty( $matches[1] ) && ! empty( $more_link_text ) )
					$more_link_text = strip_tags( wp_kses_no_null( trim( $matches[1] ) ) );	
			}
	
			// Return the first split if good
			if ( isset($content) && ( count($content) > 1 ) ) {
				$excerpt = $content[0];			
				$excerpt = strip_shortcodes($excerpt);
			}
					
		}
		
		// 3.  Truncate the content
		if (! $excerpt) {
		
			// Get the truncated excerpt from the content
			$excerpt = ac_truncate_string(strip_shortcodes($post->post_content), shoestrap_excerpt_length(0), '.', '.', '');	
			
		}
		
		// If a char limit has been supplied then truncate to that
		if ($char_limit) {
		
			$excerpt = ac_truncate_string($excerpt, $char_limit, ' ', '...', '');
					
		}		
		
		// Strip html
		$excerpt = wp_strip_all_tags($excerpt);
		
	}		
	
	// Format
	if ($wrap && $excerpt) {
		$excerpt = "<p class='excerpt'>".$excerpt."</p>";		
	}
	
	// Apend
	if ($append_html) {
		$excerpt = $excerpt.$append_html;
	}
	
	if ($show_read_more) {
		$excerpt = $excerpt.ac_get_read_more_text($post);
	}

	return $excerpt;
	
}

// Get the Read More text
function ac_get_read_more_text( $post = 0 ) {
	
	$post = get_post( $post );	
	
	// Dont return anything if there is no permalink for this post
	if (get_permalink( $post->ID )) {
		
		// Get the option
		$read_more_text = shoestrap_getVariable('post_excerpt_link_text');
		
		// Wrap with anchor
		if ( $read_more_text ) {
			return "<div class='read-more'><a href='".get_permalink( $post->ID )."'>".$read_more_text."</a></div>";
		}
		
	}

}


// Load the correct template based on the post type
// This is the teaser template
// This function requires on the $post being set, i.e. inside the loop
function ac_load_post_content() {
	
	// We are always inside the loop
	$post_type = get_post_type();
	
	// Check for post formats
  $post_format = get_post_format();
  if ($post_format) {
    $post_format = "-".$post_format;
  }
	
	// Ensure require_once param is false to ensure the same template can be loaded multiple times
	// for the same post type (i.e. when in a loop)	
	if ( ! locate_template( '/templates/content-'.$post_type.$post_format.'.php', true, false ) ) {
	
		// Load Single as fallback
		if ( is_single() ) {
			get_template_part('templates/content', 'single');
		}
		else {
			get_template_part('templates/content', '');
		}

	}	
	
}

// Load the correct template base on the component, post type, post format
// This function requires on the $post being set, i.e. inside the loop
// $component_type = ac_grid, ac_showcase, etc.
function ac_load_component_content($component_type, $template_params = array() ) {
	
	// We are always inside the loop
	$post_type = get_post_type();
	
	// Check for post formats
  $post_format = get_post_format();
  
  // Extract the template parameters
  extract($template_params);
	
	// Build the list of templates we want to load
	$templates = array(
		'templates/'.$component_type.'-'.$post_type.'-'.$post_format.'.php',
		'templates/'.$component_type.'-'.$post_type.'.php',
		'templates/'.$component_type.'.php'
	);
	
	// Find the template
	$template = locate_template($templates);
	if ($template) {
		// Found it, so load it
		include($template);
	}
	
}

// Render a list of posts
// $posts = option array of posts
function ac_posts_list( $args, $posts = null ) {

	global $ac_show_title,
		$ac_show_excerpt,
		$ac_show_read_more;

	// Define the defaults
	$defaults = array(
		'post_type' => 'post',
		'posts_per_page' => 10,
		'cat' => '',
		'ac_order' => 'order_date_desc', // order_title_asc, order_title_desc, order_date_asc, order_date_desc
		'show_title' => true,
		'show_excerpt' => true,
		'show_read_more' => true,
	);
		
	// Merge in the options
	$args = wp_parse_args( $args, $defaults );
	
	// Params to variables
	extract($args);
	
	// Generate our posts if not passed in
	if ($posts == null) {
	
		ac_prepare_args_for_get_posts($args);	
		
		// Get our posts
		$posts = get_posts($args);
		
	}
	
	// Clean up the bool values.  Might be "true"
	$ac_show_title = filter_var($show_title, FILTER_VALIDATE_BOOLEAN);
	$ac_show_excerpt = filter_var($show_excerpt, FILTER_VALIDATE_BOOLEAN);
	$ac_show_read_more = filter_var($show_read_more, FILTER_VALIDATE_BOOLEAN);	
	
	// Render the output
	ob_start();
?>

	<div class='list-posts'>	

		<?php
		global $post;
		foreach($posts as $post) { 
			
			// Setup the new post
			setup_postdata($post);
		
			ac_load_post_content();
							
		}
		wp_reset_postdata();
		?>
			
	</div>	
<?php		

	$output = ob_get_contents();
	ob_end_clean();
	
	return $output;
}


// Gets the 'order' and 'orderby' for use in the WP Query
// $ac_order = order_title_asc, order_title_desc, order_date_asc, order_date_desc
// Returns an array ( 'order' => '', 'orderby' => '' )
function ac_convert_ac_order( $ac_order ) {

	$output = array(
	);

	// Order.  Convert AC into WP
	switch ($ac_order) {
	    case 'order_title_asc':
	    		$order = 'ASC';
	    		$orderby = 'title';
	        break;
	    case 'order_title_desc':
	    		$order = 'DESC';
	    		$orderby = 'title';
	        break;
	    case 'order_date_asc':
	    		$order = 'ASC';
	    		$orderby = 'date';
	        break;
	    case 'order_date_desc':
	    		$order = 'DESC';
	    		$orderby = 'date';
	        break;	      
	     default : // safety net
	    		$order = 'ASC';
	    		$orderby = 'title';	       
	}	

	$output['order'] = $order;
	$output['orderby'] = $orderby;

	return $output;
		
}


// Returns if this post has a thumbail
// Takes into account Gallery post types, which have a defined thumbnail
function ac_has_post_thumbnail( $post ) {

	$post = get_post( $post );
	$post_type = get_post_type($post);
	
	switch ($post_type) {

	  case 'attachment':
	  	// Post ID is the attachment ID for images, so always true
	  	return true;
	  	break;	
	  	
	  case 'ac_gallery':
	  
	  	$post_id = ac_gallery_get_cover_image_id_for_gallery( $post );
	  	
	  	return ($post_id !== false);
	  	break;
	  	
	  default :
	  	return has_post_thumbnail($post->ID);
	     
	}

}

// Returns the thumbnail ID for the post
// Some posts may use a different thumbnail.  Galleries might use the first image of the gallery
function ac_get_post_thumbnail_id( $post ) {

	$post = get_post( $post );
	$post_type = get_post_type($post);
	
	switch ($post_type) {
	
	  case 'attachment':
	  	// Post ID is the attachment ID for images	  	
	  	return $post->ID;
	
	  case 'ac_gallery':
	  	return ac_gallery_get_cover_image_id_for_gallery( $post );
	  	
	  default :
	  	return get_post_thumbnail_id($post->ID);
	     
	}
	
}

// Prepares args list for get_posts
// Converts UI values into WP values
function ac_prepare_args_for_get_posts(&$args) {

	// Ensure posts_per_page is a useable int value
	// Convert 'all' from UI to -1 for WP
	if ( isset($args['posts_per_page']) && ($args['posts_per_page'] == 'all') ) {
		$args['posts_per_page'] = -1;
	}
	
	// Allow for entire post content in excerpt
	if ( isset($args['excerpt_length']) && ($args['excerpt_length'] == 'all') ) {
		$args['excerpt_length'] = -1;
	}
	
	// Order.  Convert AC into WP
	// Only do this is the $args do not have a WP order_by already set
	if (!isset($args['orderby']) || !isset($args['order']) || ($args['orderby'] == '') || ($args['orderby'] == '')) {
		$order = ac_convert_ac_order($args['ac_order']);
		$args['order'] = $order['order'];
		$args['orderby'] = $order['orderby'];	
	}

	// Cats and Terms	
	if (isset($args['cat']) && $args['cat']) { // If we have a categoy defined
		
		// If we have a category for filtering dont show the category filter control		
		$args['show_cat_filter'] = false;
		
		// Filter custom taxonomy filters
		$args['tax_query'] = array(
			array(
				'taxonomy' => $args['post_category'],
				'field' => 'term_id',
				'terms' => $args['cat']
			)
		);
		// Clear the 'cat' arg for the get_posts	
		$args['cat'] = null;
		unset($args['cat']);
		
	}
	
		
}

// Add hide-until-fade to all posts
add_filter('post_class', 'ac_add_hide_until_ready_to_post_class');
function ac_add_hide_until_ready_to_post_class($classes) {
	$classes[] = ac_get_hide_until_fade_class();
	return $classes;
}

// Returns a class to enable element fade in
function ac_get_hide_until_fade_class() {

	$fade_in = shoestrap_getVariable('ac_fade_in_toggle');
		
	if ($fade_in) {
		return ' ac-hide-until-ready ac-hidden-until-ready ';
	}
	else {
		return '';
	}

}

// Add inline styles
function ac_add_inline_styles() {

	// Check if this is a real page and only continue if it is
	$page_id = ac_get_post_id();
	if ($page_id) {
	
		// Build the styles
		$main_css = '';
		
		// Padding
		$page_no_top_space = ac_get_meta('page_no_top_space', array(), ac_get_post_id());
		if ($page_no_top_space) {
			$main_css .= "margin-top: 0; ";
		}
		$page_no_bottom_space = ac_get_meta('page_no_bottom_space', array(), ac_get_post_id());
		if ($page_no_bottom_space) {
			$main_css .= "margin-bottom: 0; ";
		}
		
		// If we have styles generate the complete output and add inline
		if ($main_css) {
			$main_css = "
				.main {
					".$main_css."
				}			
			";
      wp_add_inline_style( 'ac-theme', $main_css );
		}
	}

	// Include WooCommerce Inline Styles
	ac_woocommerce_add_inline_styles();
	
}

// Format content for display
function ac_format_post_content($content) {
	$content = apply_filters( 'the_content', $content );
	$content = str_replace( ']]>', ']]&gt;', $content );	

	return $content;
}

// Return the permalink for the post.  Some custom post types have different links
function ac_format_post_type_link( $url, $post, $leavename ) {
	
	if ( $post->post_type == 'ac_client' ) {
		// Return the client link as there is no client page
		return ac_get_meta('client_link');
	}
	return $url;
	
}
add_filter( 'post_type_link', 'ac_format_post_type_link', 10, 3 );

// Render the author biography
function ac_render_author_bio( $post = 0 ) {
	global $post_types_with_author_bio;
	
	// The post
	$post = get_post( $post );
	
	// Render the bio if forced on the post level, or fallback to the theme options
	// Get the post type
	$post_type = get_post_type($post);
	
	// Does this post type have Bio?
	if (in_array($post_type, $post_types_with_author_bio)) {
		
		// Check at post level
		$post_show = ac_get_meta('author_bio_show');

		// Never continue if no show at post level
		if ($post_show == 'false') {
			return;
		}
		
		// Show at Theme Options level
		$theme_show = shoestrap_getVariable('author_bio_show');
		if ($theme_show) { // global setting
			switch ($post_type) { // post type settings
				case 'post' : 
					$theme_show = filter_var(shoestrap_getVariable('author_bio_show_post'), FILTER_VALIDATE_BOOLEAN);
					break;
				case 'page' : 
					$theme_show = filter_var(shoestrap_getVariable('author_bio_show_page'), FILTER_VALIDATE_BOOLEAN);
					break;
			}
		}
		
		if ($post_show || $theme_show) {
			// Get the bio
			$bio = get_the_author_meta( 'description', $post->post_author );
			$author = get_the_author_meta( 'display_name', $post->post_author );
			$authorurl = get_author_posts_url( get_the_author_meta( "ID" ) );
			// Avatar
			$avatar = get_avatar( $post->post_author, 256, '', get_the_author_meta('user_nicename', $post->post_author) );
			$bio_class = '';
			$col1_class = ' ';
			$col2_class = ' col-md-12 ';
			if ($avatar) {
				$bio_class = ' has-avatar ';
				$col1_class = ' col-lg-2 col-md-2 col-sm-12 col-xs-12 ';
				$col2_class = ' col-lg-10 col-md-10 col-sm-12 col-xs-12 ';				
			}
			if ($bio) {
			?>
				<div class='ac-author-bio <?php echo $bio_class;?>'>
					<div class='row'>
						<div class='<?php echo $col1_class; ?>'><?php echo $avatar; ?></div>				
						<div class='<?php echo $col2_class; ?>'>
							<h4><a class="author" href="<?php echo esc_url($authorurl); ?>"><?php echo $author; ?></a></h4>
							<?php echo ac_format_post_content($bio); ?>
						</div>
					</div>
				</div>
			<?php
			}			
		}
		
	} 	
	
}
add_action( 'shoestrap_single_after_content', 'ac_render_author_bio', 10, 1 );

add_filter('protected_title_format', 'ac_protected_title_format');
function ac_protected_title_format($content) {
	$content = str_ireplace("Protected:", "<span>Protected:</span>", $content);
	return $content;
}