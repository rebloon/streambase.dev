<?php
/**************************/
/****  Admin Function  ****/ 
/**************************/


/* 		USERS
================= */

// User Bio WYSIWYG
function ac_admin_setup_user_bio() {
	if ( function_exists('wp_editor') ) { // Avoid WP < 3.3
	
		// Add the WP_Editor
		add_action( 'show_user_profile', 'ac_user_bio_visual_editor' );
		add_action( 'edit_user_profile', 'ac_user_bio_visual_editor' );
		
		// Don't sanitize the data for display in a textarea
		add_action( 'admin_init', 'ac_user_bio_save_filters' );
	
		// Load required JS
		add_action( 'admin_enqueue_scripts', 'ac_user_bio_load_javascript', 100, 1 );
		
		// Add content filters to the output of the description
		add_filter( 'get_the_author_description', 'wptexturize' );
		add_filter( 'get_the_author_description', 'convert_chars' );
		add_filter( 'get_the_author_description', 'wpautop' );
	}
}
add_action( 'admin_init', 'ac_admin_setup_user_bio' );

// Adjust the on page elements
function ac_user_bio_visual_editor( $user ) {
	
	// Contributor level user or higher required
	if ( !current_user_can('edit_posts') )
		return;
	?>
	<table class="form-table">
		<tr>
			<th><label for="description"><?php _e('Biographical Info', 'alleycat'); ?></label></th>
			<td>
				<?php 
				$description = get_user_meta( $user->ID, 'description', true);
				wp_editor( $description, 'description' ); 
				?>
				<p class="description"><?php _e('Share a little biographical information to fill out your profile. This may be shown publicly.', 'alleycat'); ?></p>
			</td>
		</tr>
	</table>
	<?php
}

// Add the class for the JS to pickup
function ac_user_bio_load_javascript( $hook ) {
	
	// Contributor level user or higher required
	if ( !current_user_can('edit_posts') )
		return;
	
	// Load JavaScript only on the profile and user edit pages 
	if ( $hook == 'profile.php' || $hook == 'user-edit.php' ) {
		add_filter( 'admin_body_class', 'ac_admin_setup_user_bio_admin_body_class' );
	}
}


function ac_user_bio_save_filters() {
	
	// Contributor level user or higher required
	if ( !current_user_can('edit_posts') )
		return;
		
	remove_all_filters('pre_user_description');
}

function ac_admin_setup_user_bio_admin_body_class( $classes ) {
	$classes .= ' ac_author_bio_wysiwyg ';
	return $classes;
}