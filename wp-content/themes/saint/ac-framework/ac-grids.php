<?php
/************************/
/**** Alleycat Grids ****/ 
/************************/

// Render a grid of posts
// $posts = option array of posts
function ac_posts_grid( $args, $posts = null ) {
	
	// Define the defaults
	$defaults = array(
		'post_type' => 'post',
		'posts_per_page' => 10,
		'column_count' => 3,
		'cat' => '',
		'ac_order' => 'order_date_desc', // order_title_asc, order_title_desc, order_date_asc, order_date_desc
		'show_title' => true,
		'show_excerpt' => true,
		'excerpt_length' => '',
		'layout' => 'grid', /* grid, masonry */
		'show_cat_filter' => false,
		'post_category' => '',
		'show_read_more' => true,		
	);
		
	// Merge in the options
	$args = wp_parse_args( $args, $defaults );
	
	// Prepare args	
	ac_prepare_args_for_get_posts($args);
		
	// Params to variables
	extract($args);
	
	// Generate our posts if not passed in
	if ($posts == null) {
						
		// Get our posts
		$posts = get_posts($args);
		
	}
		
	// Calculate the span of each column for desktop
	if ($column_count != 0) {
		$cols = (12 / $column_count);
	}
	else {
		$cols = 12;
	}

	// Lets set the columns.  Ensure the small screens don't have more columns than the larger screens
	$cols_class  = ' col-lg-'.$cols;
	$cols_class .= ' col-md-'.max($cols, 4);
	$cols_class .= ' col-sm-'.max($cols, 6);
	$cols_class .= ' col-xs-'.max($cols, 12);
	
	// Grid classes
	$grid_css = '';
	
	// Layout specifics
	if ($layout == 'grid') {
		$grid_css = 'ac-grid-fit-rows';		
	}
	
	// Clean up the bool values.  Might be "true"
	$show_title = filter_var($show_title, FILTER_VALIDATE_BOOLEAN);
	$show_excerpt = filter_var($show_excerpt, FILTER_VALIDATE_BOOLEAN);
	$show_cat_filter = filter_var($show_cat_filter, FILTER_VALIDATE_BOOLEAN);
	$show_read_more = filter_var($show_read_more, FILTER_VALIDATE_BOOLEAN);

	// Render the output
	ob_start();		

	// Get the terms for these posts
	// Get all od the term ids for these posts
	$term_ids = ac_get_terms_for_posts( $posts, $post_category );
	if ( $post_category && ($show_cat_filter) ) {
		echo ac_grids_get_category_filter( $post_category, $term_ids );
	}
?>

	<div class='ac-grid-posts ac-filter-target row <?php echo $grid_css; ?>'>
	
	<?php
	
		global $post;	
	
		// Pass some values to the template
		$template_params = compact('show_title', 'show_excerpt', 'column_count', 'post_category', 'cols_class', 'cols', 'excerpt_length', 'post_type', 'show_read_more');
				
		// Loop each of the posts
		foreach($posts as $post) {
		
			setup_postdata($post);
						
			// Load the template
			ac_load_component_content('ac_grid', $template_params);				
			
		} // end loop		
		wp_reset_postdata();
		?>			
	</div>	
<?php		

	$output = ob_get_contents();
	ob_end_clean();
	
	return $output;
}

// Returns the category filter for a grid
// $term_ids = array of term ids that should only be shown
function ac_grids_get_category_filter( $post_category, $term_ids ) {
	
	$cat_filter = '';

	// Build the args
	$args = array(
		'taxonomy' => $post_category
	);

	// Check for term ids
	if ($term_ids) {
		$term_ids = implode(',', $term_ids);
		$args['include'] = $term_ids;
	}
	
	// Build the filter links
	$categories = get_categories($args);
		
	// Only build the content if we have filters 			
	if ( count($categories) ) {
	
	  $cat_filter .= "<div class='ac-category-filters-wrapper'>";
		  $cat_filter .= "<div class='ac-category-filters clearfix'>";
		  
		  // All
			$cat_filter .= "<span class='ac-category-filter selected'><a href='#' class='all' data-filter='.all'>".__('All', "alleycat")."</a></span>";		  
	  		
			// Build an array for the dropdown from the list
			foreach($categories as $this_category) {
				// Dont include uncategorized
				if ($this_category->term_id != 1) {
					$cat_filter .= "<span class='ac-category-filter'><a href='#' class='item' data-filter='.".$this_category->slug."'>".__($this_category->name, "alleycat")."</a></span>";					
				}
			}			  
		  
		  $cat_filter .= "</div>";				
	  $cat_filter .= "</div>";				
		
	}	
	
	return $cat_filter;
	
}

// Render a grid of posts tiles
// $posts = option array of posts
function ac_posts_tile( $args, $posts = null ) {

	// Define the defaults
	$defaults = array(
		'post_type' => 'post',
		'posts_per_page' => 12,
		'column_count' => 4,
		'cat' => '',
		'ac_order' => 'order_date_desc', // order_title_asc, order_title_desc, order_date_asc, order_date_desc
		'show_title' => true,
		'show_excerpt' => true,
		'excerpt_length' => '',
		'meta_key' => '_thumbnail_id', // only show posts with thumbnails
		'link_to_lightbox' => false, // should tiles link to lightbox
		'show_cat_filter' => false,
		'post_category' => '',
		'layout' => 'posts',
	);
			
	// Merge in the options
	$args = wp_parse_args( $args, $defaults );

	// Prepare args	
	ac_prepare_args_for_get_posts($args);	
	
	// Params to variables
	extract($args);
	
	// Generate our posts if not passed in
	if ($posts == null) {
		
		// Get our posts
		$posts = get_posts($args);
				
	}
	
	// Calculate the span of each column for desktop
	if ($column_count != 0) {
		$cols = (12 / $column_count);
	}
	else {
		$cols = 12;
	}

	// Lets set the columns.  Ensure the small screens don't have more columns than the larger screens
	$cols_class =  ' col-lg-'.$cols;
	$cols_class .= ' col-md-'.max($cols, 3);
	$cols_class .= ' col-sm-'.max($cols, 4);
	$cols_class .= ' col-xs-'.max($cols, 12);
		
	// Grid classes
	$grid_css = " ac-$layout ";
		
	// Terms
	$show_terms = true;
		
	// Clean up the bool values.  Might be "true"
	$show_title = filter_var($show_title, FILTER_VALIDATE_BOOLEAN);
	$show_excerpt = filter_var($show_excerpt, FILTER_VALIDATE_BOOLEAN);
	$show_cat_filter = filter_var($show_cat_filter, FILTER_VALIDATE_BOOLEAN);	

	// Render the output
	ob_start();

	// Get the terms for these posts
	// Get all od the term ids for these posts
	$term_ids = ac_get_terms_for_posts( $posts, $post_category );
	if ( $post_category && ($show_cat_filter) ) {
		echo ac_grids_get_category_filter( $post_category, $term_ids );
	}
	
?>

	<?php // NOTE;  Bootstrap row not required as tile cols don't have padding ?>
	<div class='ac-tile-posts ac-filter-target <?php echo $grid_css; ?>' data-cols='<?php echo $column_count; ?>'>
	
		<?php
		
		global $post;		
		
		// Pass some values to the template
		$template_params = compact('show_title', 'show_excerpt', 'post_category', 'cols_class', 'cols', 'column_count', 'show_terms', 'layout');
		
		foreach($posts as $post) {

			setup_postdata($post);
			
			// Load the template
			ac_load_component_content('ac_tile', $template_params);

		}
		wp_reset_postdata();
		?>
			
	</div>	
<?php		

	$output = ob_get_contents();
	ob_end_clean();
	
	return $output;

}