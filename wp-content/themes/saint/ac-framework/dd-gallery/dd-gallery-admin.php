<?php

/***************************************************/
/**** Alleycat Drag and Drop Gallery - Back end ****/
/***************************************************/

/************
	Notes
*************/
 
/* 
	Homepage 	- album post is defined by post_title = 'Homepage'.  This can't be changed by the end user
	Trash 		- album post is defined by post_title = 'Trash'.  This can't be changed by the end user
*/

/* 	Menu items
------------------------------------------------------------------- */
// Side menu
add_action( 'admin_menu', 'dd_gallery_menu' );
function dd_gallery_menu() {		

	$admin_page = add_menu_page( __( 'Galleries', 'alleycat' ), __( 'Galleries', 'alleycat' ), 'edit_posts', 'ac_gallery_manager', 'ac_gallery_admin_display', 'dashicons-format-gallery', 55 );

}


/************
	Constants
*************/

define('AC_GALLERY_THUMB_WIDTH', 145);
define('AC_GALLERY_THUMB_HEIGHT', 145);
define('AC_NEW_GALLERY_TITLE', 'New Gallery');

/************
	Functions
*************/

// Setup the gallery in the theme
function ac_gallery_theme_setup() {

	// Check to see if setup has run before
	$ac_gallery_theme_setup = get_option( 'ac_gallery_theme_setup' );
	
	// If the theme has not yet been used we want to run our default settings.
	if ( $ac_gallery_theme_setup !== '1' ) {
		
		// -- Galleries --
		// Homepage gallery
		$homepage_gallery = array(
			'post_title' => 'Homepage',
			'post_content' => '',
			'post_excerpt' => '',
			'post_status' => 'publish',
			'post_type' => 'ac_gallery',
			'menu_order' => '0',
		);
		$hp_id  = wp_insert_post( $homepage_gallery );

		// Starter gallery
		$homepage_gallery = array(
			'post_title' => 'New Gallery',
			'post_content' => '',
			'post_excerpt' => '',
			'post_status' => 'publish',
			'post_type' => 'ac_gallery',
			'menu_order' => '1',
		);
		$starter_id  = wp_insert_post( $homepage_gallery );

		// Trash gallery
		$trash_gallery = array(
			'post_title' => 'Trash',
			'post_content' => '',
			'post_excerpt' => '', // generate on the fly
			'post_status' => 'publish',
			'post_type' => 'ac_gallery',
			'menu_order' => '2',
		);
		$trash_id  = wp_insert_post( $trash_gallery );		
	
		// Once done, we register our setting to make sure we don't duplicate everytime we activate.
		update_option( 'ac_gallery_theme_setup', '1' );		
	
	}
	
}
// Hookup the setup
add_action( 'after_switch_theme', 'ac_gallery_theme_setup' );

// Include our scripts
add_action('admin_enqueue_scripts', 'ac_gallery_load_admin_scripts');
function ac_gallery_load_admin_scripts($hook) {

	if ($hook == 'toplevel_page_ac_gallery_manager')
	{
		// Include jQuery UI Dialog, for Gallery Delete dialog box
	  wp_enqueue_style('jquery-ui', AC_GALLERY_URI.'/jquery-ui.css');	// For dialog
	  wp_enqueue_script( 'jquery-ui-dialog' ); 
	  wp_enqueue_script( 'jquery-ui-sortable' ); 
	
		// Plupload for multi file upload
		wp_enqueue_script('plupload');
	  wp_enqueue_script('plupload-all');

	  // DragnDrop files
		wp_enqueue_script( 'dd-gallery', AC_GALLERY_URI.'/dd-gallery-admin.js' );  
	  wp_enqueue_style( 'dd-gallery', AC_GALLERY_URI.'/dd-gallery-admin.css' );

	}
};

// Returns the upload JSON data for attachment to a gallery
function ac_gallery_get_upload_meta_data() {

  $plupload_init = array(
    'runtimes'            => 'html5,silverlight,flash,html4',
    'browse_button'       => 'plupload-browse-button',
    'container'           => 'plupload-upload-ui',
    'drop_element'        => 'drag-drop-area',
    'file_data_name'      => 'async-upload',
    'multiple_queues'     => true,
    'max_file_size'       => wp_max_upload_size().'b',
    'url'                 => admin_url('admin-ajax.php'),
    'flash_swf_url'       => includes_url('js/plupload/plupload.flash.swf'),
    'silverlight_xap_url' => includes_url('js/plupload/plupload.silverlight.xap'),
    'filters'             => array(array('title' => __('Allowed Files', 'alleycat'), 'extensions' => '*')),
    'multipart'           => true,
    'urlstream_upload'    => true,

    // additional post data to send to our ajax hook
    'multipart_params'    => array(
      '_ajax_nonce' => wp_create_nonce('photo-upload'),
      'action'      => 'photo_gallery_upload',            // the ajax action name
    ),
  );

	// Get the data values
  $plupload_init = apply_filters('plupload_init', $plupload_init); 
  
  return $plupload_init;
  
}


// Write put the media upload box
// Most of the code comes from media.php and handlers.js
function ac_gallery_upload_meta_box($galleryId) { 
?>

	<div class="upload-dropzone">
	   <div id="plupload-upload-ui-<?php print $galleryId; ?>" class="hide-if-no-js plupload-upload">
		 	<button id="plupload-browse-button_<?php print $galleryId; ?>" class='upload'>Upload</button>	
	  </div>
	</div>

  <?php
}


// Handle uploaded file here
// Echo results are displayed in the [results] variable in the acGalleryAddPlupload method in dd-gallery.js
add_action('wp_ajax_photo_gallery_upload', 'ac_gallery_ajax_photo_upload' );
function ac_gallery_ajax_photo_upload() {

  check_ajax_referer('photo-upload');
  
	$wp_upload_dir = wp_upload_dir();  

  // We can use WP's wp_handle_upload() function:
  $file = $_FILES['async-upload'];
  $status = wp_handle_upload($file, array('test_form'=>false, 'action' => 'photo_gallery_upload'));
  
  // And output the results
  // Url
  echo $status['url'] .","; // returns[0]

  // Add file as attachment to WordPress
  $attachmentId =  wp_insert_attachment( array(
		   'guid' => $wp_upload_dir['baseurl'] .'/'. _wp_relative_upload_path( $status['file'] ),   
	     'post_mime_type' => $status['type'],
	     'post_title' => preg_replace('/\.[^.]+$/', '', basename($file['name'])),
	     'post_content' => '',
	     'post_status' => 'inherit'
	  ), $status['file']
  );
  echo $attachmentId.","; // returns[1]
  
  // Generate the meta data
  $data = wp_generate_attachment_metadata( $attachmentId, $status['file'] ); 
  
  wp_update_attachment_metadata( $attachmentId, $data );
  
  // Return the thumbnail filename
  echo $wp_upload_dir['url'] .'/'. $data["sizes"]["thumbnail"]["file"].","; // results[2]
    
 // Return the thumbnail file sizes
  echo AC_GALLERY_THUMB_WIDTH.","; // results[3]
	echo AC_GALLERY_THUMB_HEIGHT; // results[4]  

  exit;
};

// Print a gallery to the admin page
function ac_gallery_admin_print_gallery($post, $homepage, $trash)
{

	// Dont allow homepage or trash to be dragged
	if ($homepage || $trash) {
		$draggable = "";
		$notHomeOrTrash = "";		
	}
	else {
		$draggable = " draggable";		
		$notHomeOrTrash = " notHomeOrTrash ";		
	}
		
	if ($homepage)
		$homepage_css = " homepage";
	else
		$homepage_css = "";
		
	if ($trash)
		$trash_css = " trash";
	else
		$trash_css = "";
		
	// Meta fields
	$hide_titles = get_post_meta( $post->ID, 'hide-titles', true );

?>
	<!-- AC Gallery Begin -->
	<div id="gallery-<?php print $post->ID; ?>" class='gallery<?php print $draggable . $homepage_css . $trash_css;?>' data-gallery-id="<?php echo $post->ID; ?>" >
		<div id="galleryEditor-<?php print $post->ID; ?>" class='gallery-editors <?php print $notHomeOrTrash; ?>'>
			<div class='edit'></div>
			<div class='gallery-button button-gallery-up enabled' title='Move Gallery Up'></div>
			<div class='gallery-button button-gallery-down enabled' title='Move Gallery Down'></div>
			<div class='gallery-button button-gallery-trash' title='Delete Gallery'></div>
		</div>
	
		<div class='header'>
			<?php
			// Read only title for Homepage and Trash albums
			if ($homepage || $trash) { 
			?> <h3 id='<?php print $post->ID; ?>' class='title'><?php print get_the_title($post->ID); ?></h3> <?php 
			
				// Empty Trash button for trash album
				if ($trash) { 
				?> <button id="empty-trash">Empty Trash</button> <?php
				}

			
			}
			else { // normal album
			?>
				<div class='inputs'> 
					<input type="text" class='title editor-control' value="<?php print get_the_title($post->ID); ?>"> 
					<textarea class='description editor-control'><?php print $post->post_content; ?></textarea>				
				</div>
				<div class='gallery-edit-panel'>
					<div class='gallery-visibility editor-control'>
						<div class='visibility'>Options</div>
						<label title="When ticked this option hides this gallery in the portfolio"><input class='hide-gallery' name="visible<?php print $post->ID; ?>" value="true" type="checkbox" <?php if ($post->post_status == 'private') { echo 'checked="checked"'; } ?> > Hide Gallery in Portfolio</label>
						<label title="When ticked this option hides the image titles and descriptions in the slideshow"><input class='hide-titles' name="visible<?php print $post->ID; ?>" value="true" type="checkbox" <?php if ($hide_titles == 'true') { echo 'checked="checked"'; } ?>> <div class='label-box'>Hide slideshow image titles</div></label>
					</div>
					<button class='gallery-save'>Save</button>					
				</div>
				
			<?php
			} 
			?>			

		</div>
		
		<?php
		
		// Show the images
		$image_args = array(
			'orderby' 			 => 'menu_order', 
			'order'          => 'ASC',
			'post_type'      => 'attachment',
			'post_parent'    => $post->ID,
			'post_mime_type' => 'image',
			'post_status'    => array( 'inherit', 'private'),
			'numberposts'    => -1,
		);		    	
		
		$attachments = get_posts($image_args);
		?>
		<div class='images'>
			<?php
			if ($attachments) {
				foreach ($attachments as $attachment) {
					$img =  wp_get_attachment_image_src($attachment->ID, 'thumbnail', false);
					print "\n<div class='img-container' id='imageContainer-".$attachment->ID."' data-image-id='".$attachment->ID."' >";
					print "\n  <img id='image_".$attachment->ID."' src='" .$img[0]. "' width='" .$img[1]. "' height='" .$img[2]. "' />";
					print "\n  <div class='title' id='imageTitle-".$attachment->ID."'>". $attachment->post_title ."</div>";
	
					// Show graphic for private
					if ($attachment->post_status == 'private') {
						print "\n  <div class='isHidden'><img src='". AC_GALLERY_URI."images/editor-hide.png' title='Hidden' alt='Hidden' /></div>";					
					}				
					
					print "\n  <div class='edit' title='Edit Image'></div>";
					if (! $trash) {
						print "\n  <div class='trash' title='Trash Image'></div>";						
					}
					print "\n</div>";
				}
			}		
			
			?>
			
		</div>	<!-- images -->		
		
		<?php 
			// Write the upload box/button.  No upload for trash
			if (! $trash) {
				ac_gallery_upload_meta_box($post->ID); ?>
		<?php } ?>
				
	</div>
	<!-- AC Gallery End -->	
<?php
}

// Render the manager page
function ac_gallery_admin_display() {
?>		
	<!-- Add some styles here using code -->
	<style>
		.drag-drop #drag-drop-area,
		.drag-drop .drag-drop-inside,
		.gallery .img-container,
		.sortable-placeholder {
			width: <?php echo AC_GALLERY_THUMB_WIDTH ?>px;
			height: <?php echo AC_GALLERY_THUMB_HEIGHT ?>px;			
		}
		.drag-drop .drag-drop-inside {
			margin-top: <?php echo ( (AC_GALLERY_THUMB_HEIGHT / 2 ) -11 ); ?>px !important;
		}		
		.gallery .img-container .title {
			top: <?php echo ( ( AC_GALLERY_THUMB_HEIGHT / 2 ) - 16); ?>px;
		}
		.ui-sortable-placeholder { 
			height: <?php echo AC_GALLERY_THUMB_HEIGHT; ?>px !important;			
			width: <?php echo AC_GALLERY_THUMB_WIDTH; ?>px !important;
		}		
	</style>
	<script>
		var ac_templateDir = "<?php echo AC_TEMPLATE_URI; ?>";
		var ac_plupload = <?php echo json_encode(ac_gallery_get_upload_meta_data()); ?>
	</script>	
	
	<div class="wrap ac_dnd_gallery">
	<div class="icon32" id="icon-options-general"></div>
	<h2><?php echo __( 'Gallery Manager', 'alleycat' ) ?></h2>
	
	<div class='touch-only information hidden'>Touch devices (tablets, phones, etc) do not currently support the drag and drop of images.  
	<br />This functionality is coming soon.
	<br />You can edit image and gallery information.</div>
	
	<div class="galleries">

<?php		
	// Show the galleries	
	$gallery_args = array(
		'post_type' => array('ac_gallery'),
		'orderby' 			 => 'menu_order', 
		'order'          => 'ASC',		
		'numberposts'    => 10,
		'post_status' => array( 'publish', 'private'),
		'posts_per_page' => -1,
	);		    	
	
	$galleries = get_posts( $gallery_args );
	
	foreach($galleries as $gallery) {
			
		// Print the gallery
		ac_gallery_admin_print_gallery($gallery, ($gallery->post_title == 'Homepage'), ($gallery->post_title == 'Trash') );	
	?>		
	
	<?php } ?>
		
	</div> <!-- galleries -->
	
	<?php // Add New Gallery button ?>
	<div class='new-gallery-top'>
		<button id='add-new-gallery'>Add new Gallery</button>
	</div>		
	
	<?php // Delete Gallery Dialog ?>	
	<div id="dialog-trash-gallery-confirm" class='hidden'>
	  <p>Are you sure you want to permanently Delete this Gallery?<br><br>All of the photos in the Gallery will be removed, but will remain in the Media Library.</p>
	</div>	

	<?php // Empty Strah Dialog ?>	
	<div id="empty-trash-confirm" class='hidden'>
	  <p>Are you sure you want to empty the Trash?</p>
	</div>	
	
	<?php // Image Edit Dialog & Overlay ?>
	<div id="image-editor-overlay">
		<div id="image-editor">
			<div id="close-button"></div>
			<div id="prev-button" title="Save and previous (ALT and Left Arrow)"></div>
			<div id="next-button" title="Save and next (ALT and Right Arrow)"></div>
			<div id="editor-image-bg">
				<img id="editor-image" />
			</div>
			<input id="editor-title" class='editor-control' type="text" placeholder="Title" />
			<textarea id="editor-description" class='editor-description' placeholder="Description"></textarea>
			<div id="editor-status-holder">	
				<img src='<?php echo AC_GALLERY_URI ?>/images/editor-hide.png' title='Visible' alt='Visible' />
				<label id='editor-status-label'>
					<input type="checkbox" id="editor-status" class='editor-control' name="publish-status" value="private">Hide Image
				</label>
			</div>
			<button id="editor-save">Save</button>
			<button id="editor-delete">Remove</button>
		</div>		
	</div>

	<div id="contentWrap">	
	</div>
	<?php	

}


/****************
	AJAX Callbacks
****************/

// Update gallery data
function ac_gallery_update_data_callback() {

	// Get the data
	$galleryId = $_POST['galleryId'];
	$title = $_POST['title'];
	$desc = $_POST['desc'];
	$status = $_POST['status'];
	$hide_titles = $_POST['hideTitles'];
	
	// Only update if we have an ID
	if ($galleryId) {
	
	  // Load the post as we need to check the title
	  $gallery = get_post($galleryId);	
	
		// Update post.  We only need to pass the data to be updated
	  $my_post = array();
	  $my_post['ID'] = $galleryId;
	  $my_post['post_title'] = $title; 	
	  $my_post['post_content'] = $desc;
	  $my_post['post_status'] = $status;
	  	  
	  // When setting the project title for the first time, set the slug
	  // First title is set when it's not the default and the existing slug is the default
	  $isNewTitle = ( $title != AC_NEW_GALLERY_TITLE );  // i.e. is not the default
	  $isDefaultSlug = ( stripos($gallery->post_name, sanitize_title(AC_NEW_GALLERY_TITLE)) !== false );
	  if ( $isNewTitle && $isDefaultSlug ) {
		  $my_post['post_name'] = sanitize_title($title);
	  }
		
		// Update the post into the database
	  wp_update_post( $my_post );	
	  
	  // Update extra fields
	  update_post_meta($galleryId, 'hide-titles', $hide_titles);
		
	}
	
	die(); // this is required to return a proper result	
	 
}
add_action('wp_ajax_ac_gallery_update_data', 'ac_gallery_update_data_callback');


function ac_gallery_add_gallery_callback() {
/* 
	1.  Create new gallery in WP
	2.  Return the HTML structure for display in the editor
	
	response is {galleryId, html}
*/

	// Get the next menu order
	$menu_order = 2; // We don't really need this as the orders get updated by the UI after the redraw

	// Create the new Gallery object
	$my_post = array(
	  'post_title'    => 'New Gallery',
	  'post_content'  => '',
	  'post_status'   => 'publish',
	  'post_type'   => 'ac_gallery',
	  'menu_order'	=> $menu_order,
  );

	// Insert the new post returning the new gallery ID
	$post_id = wp_insert_post( $my_post );
	
	// Load the full post from WP.  This will pick up any new details added by WP
	$post = get_post( $post_id );
	
	// Get the HTML for the new gallery
	ob_start();
	ac_gallery_admin_print_gallery($post, false, false);
	$output = ob_get_contents();
	ob_end_clean();	
	
	$response['galleryId'] = $post_id;
	$response['html'] = $output;

	echo json_encode($response);

	die(); // this is required to return a proper result
}
add_action('wp_ajax_ac_gallery_add_gallery', 'ac_gallery_add_gallery_callback');


// Sets the order of galleries based on the array
function ac_gallery_update_gallery_order_callback() {
	
	// Get the gallery order
	$order = $_POST['order'];

	// Explode into a useful array
	$array = explode("&", $order);
	
	// Iterate the galleries
	$galleryCounter = 1;
	foreach ($array as $galleryId) {
	
		// The galleryId will have the JS encoded values (.e.g gallery[]=114)
		// We need to strip out gallery[]=	
		$galleryIdInt = str_ireplace('gallery[]=', '', $galleryId);
		
		// Update post.  We only need to pass the data to be updated
	  $my_post = array();
	  $my_post['ID'] = $galleryIdInt;
	  $my_post['menu_order'] = $galleryCounter;
		
		// Update the post into the database
	  wp_update_post( $my_post );			
		
		$galleryCounter++;
	}
	
	die(); // this is required to return a proper result	
	 
}
add_action('wp_ajax_ac_gallery_update_gallery_order', 'ac_gallery_update_gallery_order_callback');


// Delete a Gallery from WP
function ac_gallery_delete_gallery_callback() {

	// Get the gallery id
	$galleryId = $_POST['galleryId'];
	
	// Only continue if we have a valid gallery id
	if ($galleryId) {

		// 1.  Remove any photos for the album (child posts)
		// Get the child items
		$args = array( 
		    'post_parent' => $galleryId,
		    'post_type' => 'attachment'
		);
		$posts = get_posts( $args );
		
		if (is_array($posts) && count($posts) > 0) {
		
	    // Remove all the Children
	    foreach($posts as $post){
	    
			  $my_post = array();
			  $my_post['ID'] = $post->ID;
			  $my_post['post_parent'] = 0;
				
				// Update the post into the database
			  wp_update_post( $my_post );	
	
	    }
		
		}
		
		// 2.  Delete the gallery WP object
		wp_delete_post($galleryId, true);
		
	}
	
	die(); // this is required to return a proper result	
	 
}
add_action('wp_ajax_ac_gallery_delete_gallery', 'ac_gallery_delete_gallery_callback');


// Get the data for an image
function ac_gallery_get_image_data() {
	
	// Get the Image Id
	$imageId = $_POST['imageId'];
	
	// Send back all of the data in a single response
	$response = array();

	// Get the img.  It's an array (src, width, height).
	$img_src = wp_get_attachment_image_src( $imageId, 'ac-gallery-edit');
	$response['img'] = $img_src[0]; // [0] is the url part
	
	// Get the post data
	$post = get_post( $imageId );

	$response['title'] = $post->post_title;
	$response['body'] = $post->post_content;
	$response['status'] = $post->post_status;
	
	echo json_encode($response);

	die(); // this is required to return a proper result	
	 
}
add_action('wp_ajax_ac_gallery_get_image_data', 'ac_gallery_get_image_data');


// Save the data for an image
function ac_gallery_save_image_data() {

	// Get the Image Id
	$imageId = $_POST['imageId'];
	
	// Get the attachement data
	$title = $_POST['title'];
	$description = $_POST['description'];
	$status = $_POST['status'];
	
	// Only update if we have an ID
	if ($imageId) {
	
		// Update post.  We only need to pass the data to be updated
	  $my_post = array();
	  $my_post['ID'] = $imageId;
	  $my_post['post_title'] = $title;
	  $my_post['post_content'] = $description;
	  $my_post['post_status'] = $status;
		
		// Update the post into the database
	  wp_update_post( $my_post );	
		
	}
}
add_action('wp_ajax_ac_gallery_save_image_data', 'ac_gallery_save_image_data');



// Save the status for a post.  Used to set a image to published after upload
function ac_gallery_set_post_status() {

	// Get the post data
	$postId = $_POST['postId'];
	$status = $_POST['status'];
	
	// only update if we have a status
	if ($status) {
	
		// Update post.  We only need to pass the data to be updated
	  $my_post = array();
	  $my_post['ID'] = $postId;	  
	  $my_post['post_status'] = 'publish';
		
		// Update the post into the database
	  wp_update_post( $my_post );	
	  		
	}
}
add_action('wp_ajax_ac_gallery_set_post_status', 'ac_gallery_set_post_status');



// Trash an image in WP
function ac_gallery_trash_image_callback() {

	// Get the image id
	$imageId = $_POST['imageId'];

	
	// Only continue if we have a valid  id
	if ($imageId) {
	
		// Send the image to the trash gallery
		ac_image_send_to_trash($imageId);
			
	}
	
	die(); // this is required to return a proper result	
	 
}
add_action('wp_ajax_ac_gallery_trash_image', 'ac_gallery_trash_image_callback');


// Delete an image (from the trash)
function ac_gallery_delete_image_callback() {

	// Get the image id
	$imageId = $_POST['imageId'];
	
	// Only continue if we have a valid id
	if ($imageId) {
	
		// Send the image to the trash gallery
		wp_delete_post($imageId, true);
			
	}
	
	die(); // this is required to return a proper result	
	 
}
add_action('wp_ajax_ac_gallery_delete_image', 'ac_gallery_delete_image_callback');



// Sets the order of images based on the array
function ac_gallery_update_image_order() {
	
	// Get the images as a string
	$order = $_POST['order']; 
	
	// Break the string into an array
	$images = array();
	parse_str($order, $images);

	// Iterate the images
	$imageCounter = 1;
	foreach ($images['imageContainer'] as $imageId) {
	
		// Update post.  We only need to pass the data to be updated
	  $my_post = array();
	  $my_post['ID'] = $imageId;
	  $my_post['menu_order'] = $imageCounter;
		
		// Update the post into the database
	  wp_update_post( $my_post );			
	
		$imageCounter++;
	}
	 
}
add_action('wp_ajax_ac_gallery_update_image_order', 'ac_gallery_update_image_order');


// Sets the parent of a post
function ac_gallery_set_post_parent() {

	// Get the data
	$post_id = $_POST['postId'];
	$parent_id = $_POST['parentId'];

	// Update the post_parent
  $my_post = array();
  $my_post['ID'] = $post_id;
  $my_post['post_parent'] = $parent_id;
	
	// Update the post into the database
  wp_update_post( $my_post );	

};
add_action('wp_ajax_ac_gallery_set_post_parent', 'ac_gallery_set_post_parent');

/* -- End / Ajax Callbacks */



/*****************
	Backend Methods
******************/

// Returns the highest menu_order of the galleries
// The setup script ensuries there is a homepage and trash, so we should always have a 1
function ac_gallery_get_highest_menu_order() {

	// Note:  Although direct DB access is not great, this is much for efficient than stepping through objects
	global $wpdb;
		
	$menu_order = $wpdb->get_var( 
		$wpdb->prepare( 
			"
				SELECT max(menu_order)
				FROM $wpdb->posts
				WHERE post_type = %s
				AND post_title != %s;
			",
			'ac_gallery',
			'Trash'
		) 
	);
	
	return $menu_order;
}


/* -- End / Backend Methods -- */