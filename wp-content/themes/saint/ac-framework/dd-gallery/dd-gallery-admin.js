/********************************************/
/**** Alleycat Drag and Drop Gallery JS ****/
/********************************************/

// Wordpress global variables
//var plupload = plupload; // This must be commented out for IE8
var ac_templateDir; 
var ac_plupload;
var ajaxurl;

/************
	Variables
*************/
var acGalleryFadeSpeed = 350;
var acGalleryEditingImageId = null;
var acIsTouchDevice = 'ontouchstart' in document.documentElement; // Is this a touch device?

(function( $ ){
  "use strict";

	/*****************
		Image Functions
	******************/
	
	// Returns the image object for the given image id
	function acGalleryGetImage(imageId) {
		return jQuery("#imageContainer-"+imageId);
	}
	
	// Returns the next image object.  Returns null if there is no next object
	function acGalleryGetImageNext(imageId) {
		
		// Get the current image object
		var $current = acGalleryGetImage(imageId);
	
		// Get the next set
		var $next = jQuery($current).next('.img-container');
		
		// Return the next object, if we have one
		if (($next).length === 0)
			return null;
		else
			return jQuery($next).get(0);
			
	}
	
	// Returns the previous image object.  Returns null if there is no prev object
	function acGalleryGetImagePrev(imageId) {
		
		// Get the current image object
		var $current = acGalleryGetImage(imageId);
	
		// Get the prev object
		var $prev = jQuery($current).prev('.img-container');
		
		// Return the object, if we have one
		if (($prev).length === 0)
			return null;
		else
			return jQuery($prev).get(0);	
	
	}
	
	// Return the id of the image (e.g. 124) from the id string (e.g. imageContainer-124)
	function acGalleryGetImageIdFromString(imageIdStr) {
		
		var imageId = imageIdStr.replace('imageContainer-','');
		return imageId;
	}
		
	// Sets the hover states for images
	function acGallerySetImageHoverStates() {
	
		var imageHoverSpeed = 100;
	
		// Ignore trash for now, to keep it hidden
		jQuery(".gallery:not(.trash) .img-container").hover(
			function() {
	
				jQuery(".title", this).fadeIn(imageHoverSpeed);
				jQuery(".edit", this).fadeIn(imageHoverSpeed);
	
			}, function() {
	
				jQuery(".title", this).fadeOut(imageHoverSpeed);
				jQuery(".edit", this).fadeOut(imageHoverSpeed);
	
			}
		);
			
	}
	
	// Hookup the image edit controls
	function acGallerySetImageEditControls() {
	
		// Attach the image edit buttnn.  Use on() method to ensure late binding
		$( 'body' ).on( "click", ".img-container .edit", function() {
		
			// Get the Image id
			var image_id = $(this).parent().data('image-id');
					
			// Edit the image
			acGalleryEditImage(image_id);
		});		
	
	}
	
	/*******************
		Gallery Functions
	********************/
	
	// Return the id of the gallery (e.g. 124) from the id string (e.g. gallery-124)
	function acGalleryGetIdFromString(galleryIdStr) {
		
		var galleryId = galleryIdStr.replace('gallery-','');
		return galleryId;
	}
	
	// Returns the image object
	function acGalleryGetGalleryFromId(galleryId) {
		
		return jQuery("#gallery-"+galleryId);
	}
	
	// Returns the trash gallery object
	function acGalleryGetTrashGallery() {
	
		return jQuery("div.gallery.trash");	
	}
	
	// Return the id of the trash gallery (e.g. 124)
	function acGalleryGetTrashGalleryId() {
		
		// get the object 
		var gallery = acGalleryGetTrashGallery();
			
		// extract the number from the string (.e.g get 124 from gallery-124)
		if (gallery)
		{
			var galleryStr = jQuery(gallery).attr('id');
			
			var galleryId = galleryStr.replace('gallery-','');
			
			return galleryId;
		}
		
	}
	
	
	/*******************
		Upload Functions
	********************/
	
	// Get the plupload JSON array with the galleryID added
	function acGalleryGetPlUploadBase(gallery_id) {
	
		// Get the plupload data, copy the object to ensure a new version each time
		var plupload_code = jQuery.extend(true, {}, ac_plupload);
		
		// Add the gallery ID to the values
		plupload_code.browse_button = plupload_code.browse_button+'_'+gallery_id;
		plupload_code.container = plupload_code.container+'-'+gallery_id;
		
		return plupload_code;
		
	}
	
	// - Create and bind uploader scripts -
	function acGalleryAddPlupload(gallery_id) {
	
		var plup_code = acGalleryGetPlUploadBase(gallery_id);
				
		// Create the uploader and pass the config from above
		var uploader = new plupload.Uploader(plup_code);
	
		// Checks if browser supports drag and drop upload, makes some css adjustments if necessary
		uploader.bind('Init', function(up){
			var uploaddiv = $('#plupload-upload-ui-'+gallery_id);
	
			if(up.features.dragdrop){
				uploaddiv.addClass('drag-drop');
				$('#drag-drop-area')
					.bind('dragover.wp-uploader', function(){ uploaddiv.addClass('drag-over'); })
					.bind('dragleave.wp-uploader, drop.wp-uploader', function(){ uploaddiv.removeClass('drag-over'); });
	
			} else {
				uploaddiv.removeClass('drag-drop');
				$('#drag-drop-area').unbind('.wp-uploader');
			}
		});
	
		uploader.init();
	
		// A file was added in the queue
		uploader.bind('FilesAdded', function(up, files) {
			var hundredmb = 100 * 1024 * 1024, max = parseInt(up.settings.max_file_size, 10);
	
			plupload.each(files, function(file) {
				if (max > hundredmb && file.size > hundredmb && up.runtime != 'html5'){
					// file size error?
	
				} else {	
								
					// Add the uploader square and graphic									
					jQuery('#gallery-'+gallery_id+' .images').append(
						"\n<div class='img-container uploading' id='uploadingContainer-"+file.id+"' >"+
						"\n  <div class='inner'><img src='" + ac_templateDir + "/ac-framework/dd-gallery/images/status_icon.gif' /></div>"+
						"\n</div>"
					);
				}
			});
	
			up.refresh();
			up.start();
		});
	
		// A file was uploaded 
		uploader.bind('FileUploaded', function(up, file, response) {
	
			// File is uploaded so add it to the UI

			// Break open the response
			var returns = response.response.split(',');
			
			// Remove the uploading square and graphic
			jQuery("#uploadingContainer-"+file.id).remove();

			// Add the new image to the gallery
			jQuery('#gallery-'+gallery_id+' .images').append(
				"\n<div class='img-container' id='imageContainer-"+returns[1]+"' data-image-id='"+returns[1]+"' >"+
				"\n  <img id='image_"+returns[1]+"' src='"+returns[2]+"' width='" +returns[3]+ "' height='" +returns[4]+ "' />"+
				"\n  <div class='title' id='imageTitle-"+returns[1]+"'>"+""+"</div>"+
				"\n  <div class='edit' title='Edit Image'></div>"+
				"\n</div>"
			);
	
			// Set the image gallery via ajax
			var data = {
				action: 'ac_gallery_set_post_parent',			
				postId: returns[1],
				parentId: gallery_id
			};			
			jQuery.post(ajaxurl, data, function(response) {
				// No response required
			});																	
						
			// Set the image to be the last in the gallery
			// Use the sort code to achieve this
			// Get the gallery
			var gallery = acGalleryGetGalleryFromId(gallery_id);
			
			// Update the data via ajax
			data = {
				action: 'ac_gallery_update_image_order',
				order: jQuery('.images', gallery).sortable("serialize")
			};
			
			jQuery.post(ajaxurl, data, function(response) {
				// Response not required
			});				
			
			// Set the title from the WP object
			// Use Ajax
			var imgData = {
				action: 'ac_gallery_get_image_data',
				imageId: returns[1]
			};
		
			// Issue an Ajax command to get the data	
			jQuery.ajax({
				type: "post",
				dataType: 'json',
				url : ajaxurl,
				data: imgData,
				success: function (response) { 
		
					// We need to set the values here as they are only valid in this context
					jQuery('#imageTitle-' + returns[1]).html(response.title);
			
				}
			});				
					
			// Set the hover state for the newly uploaded image
			acGallerySetImageHoverStates();
				
		});

	}
	
	/*************************
		Image Editor Functions
	**************************/
	
	// Show the image editor
	function acGalleryEditImage(imageId) {
			
		// Setup the image editor window
		acGalleryGetImageData(imageId);	
		
		// Show the editor
		jQuery('#image-editor-overlay').fadeIn(200);
	
		// Add editing class to body (for no-scroll, etc)
		jQuery('body').addClass('editing-image');
		
		// Set the save button to disabled
		acGalleryResetImageControls();
	}
	
	// Close the image editor
	function acGalleryCloseImageEditor() {
	
		// Close the editor
		jQuery('#image-editor-overlay').fadeOut(200);
	
		// Add editing class to body (for no-scroll, etc)
		jQuery('body').removeClass('editing-image');
		
		// Reset the image 
		acGalleryResetImageEditing();
	}	
	
	// Edit the next image
	function acGalleryImageEditorNext() {
	
		// Save the current images data
		acGallerySaveImageData();
		
		// Set the save button to disabled
		acGalleryResetImageControls();	
	
		// Get the next image
		var $next = acGalleryGetImageNext(acGalleryEditingImageId);
		
		// Check we have an image
		if ($next) {
			// Get the image id
			var $nextImageId = acGalleryGetImageIdFromString( jQuery($next).attr("id") );			
			// Edit the image
			acGalleryGetImageData($nextImageId);
		}
		
	}
	
	// Edit the prev image
	function acGalleryImageEditorPrev() {
	
		// Save the current images data
		acGallerySaveImageData();
		
		// Set the save button to disabled
		acGalleryResetImageControls	();	
		
		// Get the prev image
		var $prev = acGalleryGetImagePrev(acGalleryEditingImageId);
		
		// Check we have an image
		if ($prev) {
			// Get the image id
			var $prevImageId = acGalleryGetImageIdFromString( jQuery($prev).attr("id") );			
			// Edit the image
			acGalleryGetImageData($prevImageId);
		}
		
	}
	
	// Focus the image title field
	function acGalleryImageEditorFocusInput() {
		
		jQuery("#editor-title").focus();
		jQuery("#editor-title").select();
	}
	
	// Puts an image in the trash
	function acGalleryTrashImage(imageId) {
			
		// move to the trash folder
		acGalleryMoveImageToGallery( imageId, acGalleryGetTrashGalleryId() );
	}
	
	// Removes an image from the current gallery
	function acGalleryRemoveImage(imageId) {
		// Remove the DOM object (as the method below doesn't do it for gallery 0)
		acGalleryGetImage(imageId).remove();
		// Set the parent gallery to 0
		acGalleryMoveImageToGallery( imageId, 0 );  
	}
	
	// Returns the data for an image
	function acGalleryGetImageData(imageId) {
		
		// Format the request
		var imgData = {
			action: 'ac_gallery_get_image_data',
			imageId: imageId
		};
	
		// Issue an Ajax command to get the data	
		jQuery.ajax({
			type: "post",
			dataType: 'json',
			url : ajaxurl,
			data: imgData,
			success: function (response) { 
	
				// We need to set the values here as they are only valid in this context
				jQuery('#editor-image').attr("src", response.img);
				jQuery('#editor-title').val(response.title);
				jQuery('#editor-description').val(response.body);
				jQuery('#editor-status').prop('checked', (response.status == 'private') );				
				
				acGalleryImageEditorFocusInput();
				
				// Store the image we are editing
				acGalleryEditingImageId = imageId;
				
				acGallerySetImageEditorControlsState();
		
			}
		});	
	
	}
	
	// Saves the data for an image
	function acGallerySaveImageData() {
	
		// Don't pass or return any details, do everything in this function
		var status;
		
		// Get the publish status
		var $checked = jQuery('#editor-status').prop('checked');
		// convert to status
		if ($checked) {
			status = 'private';
		}
		else {
			status = 'inherit';
		}
		
		// Get the tile for this image in the UI
		var $image = acGalleryGetImage(acGalleryEditingImageId);
		
		// Update the title on the tile in the UI
		jQuery('.title', $image).html( jQuery('#editor-title').val() );
		
		// Format the request to save the data
		var imgData = {
			action: 'ac_gallery_save_image_data',
			imageId: acGalleryEditingImageId,
			title: jQuery('#editor-title').val(),
			description: jQuery('#editor-description').val(),
			status: status
		};
	
		// Issue an Ajax command to save the data	
		jQuery.ajax({
			type: "post",
			dataType: 'json',
			url : ajaxurl,
			data: imgData,
			success: function (response) {
				// done
			}
		});		
	}
	
	// Trash the currently editing image
	function acGalleryTrashCurrentEditingImage() {
	
		// Note, this currently doesn't trash but removes from the gallery
	
		// Don't pass or return any details, do everything in this function
	
		// 1.  Store the current image id
		var currentImageId = acGalleryEditingImageId;
				
		// 2.  See if we have a next or prev image for the user	
	
		// If there is a next image use that as the new current
		var $next = acGalleryGetImageNext(acGalleryEditingImageId);
		if ($next) {
			acGalleryEditingImageId = acGalleryGetImageIdFromString( jQuery($next).attr("id") );
		}
		else {
			// Get the prev image
			var $prev = acGalleryGetImagePrev(acGalleryEditingImageId);
			
			// check we have a prev image
			if ($prev) {
				acGalleryEditingImageId = acGalleryGetImageIdFromString( jQuery($prev).attr("id") );			
			}
			else {
				// If we're here we don't have a next or previous image.
				// Close the editing window
				acGalleryCloseImageEditor();	
			}
			
		}
		
		// 3.  Delete the current image
		//acGalleryTrashImage(currentImageId);
		acGalleryRemoveImage(currentImageId);
		
		// 4. If we have a new image ID, display it and update the controls
		if (acGalleryEditingImageId) {
			acGalleryGetImageData(acGalleryEditingImageId);
			
			// Set the save button to disabled
			acGalleryResetImageControls();				
		}
		
		//acGallerySetTrashEmptyButtonState();
	
	}
	
	// Reset the image controls.  This happends after an image is loaded or saved, so that 
	function acGalleryResetImageControls() {
	
		// Set the button non-edited state
		jQuery('#editor-save').addClass('disabled');
		
		// Disable the button
		jQuery('#editor-save').prop('disabled', true);
	
	}
	
	// Set the save button to active
	function acGallerySetImageControlsChanged() {
	
		// Set the button non-edited state
		jQuery('#editor-save').removeClass('disabled');
		
		// Disable the button
		jQuery('#editor-save').prop('disabled', false);
		
	}
	
	// Reset the image details.  We need to remove the previous image so that it doesn't show when loading a new image
	function acGalleryResetImageEditing() {
		
		jQuery('#editor-image').attr("src", "");
		jQuery('#editor-title').val('');
		jQuery('#editor-description').val('');		
		
		acGalleryEditingImageId = null;		
	}
	
	// Sets the state of the image editor controls
	function acGallerySetImageEditorControlsState() {
	
		if (acGalleryEditingImageId)
		{
		
			// Get next and previous galleries
			var $next = acGalleryGetImageNext(acGalleryEditingImageId);		
			var $prev = acGalleryGetImagePrev(acGalleryEditingImageId);
			
			// Disable buttons if no next or prev		
			if ($next) {
				jQuery("#next-button").addClass('enabled');
				jQuery("#next-button").removeClass('disabled');			
			}
			else {
				jQuery("#next-button").addClass('disabled');
				jQuery("#next-button").removeClass('enabled');						
			}		
			
			// Disable buttons if no next or prev		
			if ($prev) {
				jQuery("#prev-button").addClass('enabled');
				jQuery("#prev-button").removeClass('disabled');			
			}
			else {
				jQuery("#prev-button").addClass('disabled');
				jQuery("#prev-button").removeClass('enabled');						
			}		
					
		}

	}
	
	// Moves an image to a new gallery
	function acGalleryMoveImageToGallery(imageId, newGalleryId) {
		
		// get the image container
		var imgContainer = acGalleryGetImage(imageId);
		
		// get the target gallery
		var gallery = acGalleryGetGalleryFromId(newGalleryId);
		
		// change the parent html container
		jQuery('.images', gallery).append( jQuery(imgContainer) );
		
		// // update the db vis ajax
		var data = {
			action: 'ac_gallery_set_post_parent',			
			postId: imageId,
			parentId: newGalleryId
		};			
		jQuery.post(ajaxurl, data, function(response) {
			// No response required
		});																	
		
	}
	
	// Sets a gallery's edit controls state
	function acGalleryControlsChanged(input) {
	
		// get the save button
		var $saveButton = jQuery(input).parents('.gallery').find('.gallery-save');
		// enable the button
		$saveButton.prop('disabled', false);
		// set colour to clickable
		$saveButton.css('background-color', '#333333');
		$saveButton.css('cursor', 'pointer');
		
	}
	
	// Saves a gallery's data
	function acGallerySaveData(input) {
	
		// get the data
		var $galleryId = acGalleryGetIdFromString( jQuery(input).parents('.gallery').attr("id") );
		var $title = jQuery(input).parents('.header').find('.title').val();
		var $desc = jQuery(input).parents('.header').find('.description').val();
		var $hideGallery = jQuery(input).parents('.header').find('.hide-gallery').prop('checked');
		var $hideTitles = jQuery(input).parents('.header').find('.hide-titles').prop('checked');
		
		// Calculate the gallery post status
		var status = 'publish';
		if ($hideGallery) {
			status = 'private';
		}
		
		// update the data via ajax
		var data = {
			action: 'ac_gallery_update_data',
			galleryId: $galleryId,
			title: $title,
			desc: $desc,
			status: status,
			hideTitles: $hideTitles
		};
		jQuery.post(ajaxurl, data, function(response) {
			// we dont need the response
		});	
		
		// get the save button
		var $saveButton = jQuery(input).parents('.gallery').find('.gallery-save');		
		
		// disable the save button
		$saveButton.prop('disabled', true);		
		// set colour to disabled
		$saveButton.css('background-color', '#e3e3e3');
		$saveButton.css('cursor', 'auto');		
		
	}
	
	// Moves a gallery up
	function acGalleryMoveGalleryUp(input) {
	
		// -- Move the html up in the stack --
		// get this gallery element
		var $gallery = jQuery(input).parents('.gallery');
		
		// get the gallery above element
		var $galleryAbove = jQuery($gallery).prev('.gallery');
		
		// fade them both out quickly for nice effect
		$gallery.fadeOut(acGalleryFadeSpeed);
		$galleryAbove.fadeOut(acGalleryFadeSpeed, function() {
			// Animation complete.

			// Hide the new bottom gallery via opacity
			$galleryAbove.fadeTo(0, 0);  

			// now swap the two galleries around
			jQuery($galleryAbove).before( jQuery($gallery) );
			
			// now that the html is in the correct order we need to update the DB
			acGalleryDoUpdateGalleryOrder();			
		
			// fade back in	
			$gallery.fadeIn(acGalleryFadeSpeed);
			$galleryAbove.fadeIn(acGalleryFadeSpeed);
			
			// Hide the new bottom gallery via opacity
			$galleryAbove.delay(200).fadeTo(200, 1);			
			
			// ensure the gallery controls are up to date
			acGallerySetGalleryEditStates();		

		});
			
	}
	
	// Moves a gallery down
	function acGalleryMoveGalleryDown(input) {
	
		// -- Move the html down in the stack --
		// get this gallery element
		var $gallery = jQuery(input).parents('.gallery');
		
		// get the gallery above element
		var $galleryBelow = jQuery($gallery).next('.gallery');
		
		// fade them both out quickly for nice effect
		$gallery.fadeOut(acGalleryFadeSpeed);
		$galleryBelow.fadeOut(acGalleryFadeSpeed, function() {
			// Animation complete.

			// Hide the new bottom gallery via opacity
			$gallery.fadeTo(0, 0);

			// now swap the two galleries around
			jQuery($galleryBelow).after( jQuery($gallery) );
			
			// now that the html is in the correct order we need to update the DB
			acGalleryDoUpdateGalleryOrder();				
		
			// fade back in	
			$gallery.fadeIn(acGalleryFadeSpeed);
			$galleryBelow.fadeIn(acGalleryFadeSpeed);
			
			// Hide the new bottom gallery via opacity
			$gallery.delay(200).fadeTo(200, 1);		
			
			// ensure the gallery controls are up to date
			acGallerySetGalleryEditStates();

		});
		
	}
	
	// Sets the states of the controls that allow gallery editing
	function acGallerySetGalleryEditStates() {
		
		// Get the draggable galleries (not homepage or trash)
		var $galleries = jQuery('.gallery.draggable');
	
		// get the count
		var $galleryCount = $galleries.length;
		
		// iterate each of the galleries
		$galleries.each(function( index ) {
		
			// don't allow the first gallery to go up
			if (index === 0) {
				jQuery(this).find('.button-gallery-up').removeClass('enabled');
				jQuery(this).find('.button-gallery-up').addClass('disabled');
				
				// Allow to go down if there are other galleries
				if ($galleryCount > 1) {
					jQuery(this).find('.button-gallery-down').removeClass('disabled');
					jQuery(this).find('.button-gallery-down').addClass('enabled');				
				}
				else {
					jQuery(this).find('.button-gallery-down').removeClass('enabled');
					jQuery(this).find('.button-gallery-down').addClass('disabled');				
				}
			}
			// don't allow the last gallery to go down
			else if (index == ($galleryCount -1)) {
				jQuery(this).find('.button-gallery-down').removeClass('enabled');
				jQuery(this).find('.button-gallery-down').addClass('disabled');
				
				// Allow to go up if there are other galleries
				if ($galleryCount > 1) {
					jQuery(this).find('.button-gallery-up').removeClass('disabled');
					jQuery(this).find('.button-gallery-up').addClass('enabled');
				}
				
			}
			// for all other galleries allow up and down
			else {
				jQuery(this).find('.button-gallery-up').removeClass('disabled');
				jQuery(this).find('.button-gallery-up').addClass('enabled');
				jQuery(this).find('.button-gallery-down').removeClass('disabled');
				jQuery(this).find('.button-gallery-down').addClass('enabled');
			}
	
		});
	}
	
	
	// Sets the order of the galleries via Ajax.  Use after a gallery's position is changed
	function acGalleryDoUpdateGalleryOrder() {
		
		// get the galleries as a list.  User sortable to make a seralised list
		jQuery('.galleries').sortable();
		var newOrder = jQuery('.galleries').sortable("serialize");
		jQuery('.galleries').sortable( "disable" );
		
		// now we've got the order issue an Ajax command to update the WP back end
		var data = {
			action: 'ac_gallery_update_gallery_order',
			order: newOrder
		};
	
		jQuery.post(ajaxurl, data, function(response) {
			// we dont need the response
		});	
		
	}
	
	// Moves a gallery up
	function acGalleryDeleteGallery(input) {
		
		// get the data
		var $galleryId = acGalleryGetIdFromString( jQuery(input).parents('.gallery').attr("id") );		
		
		// 1.  Delete from within WP.  Do this by issuing an Ajax command
		var data = {
			action: 'ac_gallery_delete_gallery',
			galleryId: $galleryId
		};
	
		jQuery.post(ajaxurl, data, function(response) {	
			// we dont need the response
		});	
		
		// 2.  Get and delete the HTML gallery
		var $gallery = jQuery(input).parents('.gallery');
		jQuery($gallery).fadeOut(acGalleryFadeSpeed, function() {
			// Animation complete.
			jQuery($gallery).remove();
		});
		
	}
	
	// Set the Trash button state
	function acGallerySetTrashEmptyButtonState() {
			
		// Only activate the button if there are images in the trash
		// Get the trash gallery
		var $trashGallery = acGalleryGetTrashGallery();
		
		// How many items are in Trash?
		var trashItems = jQuery('.img-container', $trashGallery).length;
		
		if (trashItems === 0) {
			
			jQuery('#empty-trash').addClass('disabled');	
			// Disable the button
			jQuery('#empty-trash').prop('disabled', true);
			
		}
		else {
	
			jQuery('#empty-trash').removeClass('disabled');	
			// Disable the button
			jQuery('#empty-trash').prop('disabled', false);
			
		}
		
		
	}
	
	// Empty the trash
	function acGalleryEmptyTheTrash() {
		
		// Loop all of the images in the trash gallery and delete them
		// Get the trash gallery
		var $trashGallery = acGalleryGetTrashGallery();
		
		// loop all of the images
		jQuery('.img-container', $trashGallery).each(function( index ) {
		
			// Get the image id
			var imageId = acGalleryGetImageIdFromString( jQuery(this).attr("id") );
			
			// Delete the image from WP
			var data = {
				action: 'ac_gallery_delete_image',
				imageId: imageId
			};
		
			jQuery.post(ajaxurl, data, function(response) {	
				// we dont need the response
			});			
			
			// Now remove the UI
			jQuery(this).remove();
							
		});
		
		acGallerySetTrashEmptyButtonState();
		
	}
	
	// Hookup the controls for all galleries.
	function acGallerySetGalleriesEditControls() {
	
		// -- Gallery Edit --
		// When we edit a gallery input we enable the save button
				
		// Bind multiple events
		jQuery(document).on('change keydown', '.gallery .title, .gallery .description, .gallery .gallery-visibility',  function() {	
		
			acGalleryControlsChanged(this);
		
		});	
		
		// -- Gallery Save --
		// Use .on() for late binding
		jQuery('body').on( "click", 'button.gallery-save', function() {
			acGallerySaveData(this);
		});	
		
		// -- Gallery Move Up --
		// ReBind Save button
		jQuery('body').on( "click", '.button-gallery-up', function() {
			// only do something if enabled
			if (jQuery(this).hasClass('enabled')) {
				acGalleryMoveGalleryUp(this);	
			}	
		});	
		
		// -- Gallery Move Down --	
		jQuery('body').on( "click", '.button-gallery-down', function() {
			if (jQuery(this).hasClass('enabled')) {
				acGalleryMoveGalleryDown(this);
			}
		});	
		
		// -- Gallery Delete --
		jQuery('body').on( "click", '.button-gallery-trash', function() {
		
			var $gallery = this;
		
			// Show the Trash dialog
			jQuery( "#dialog-trash-gallery-confirm" ).dialog({
				dialogClass: "no-titlebar",
				resizable: false,
				modal: true,
				buttons: {
					"Delete Gallery": function() {
						// Delete the gallery
						acGalleryDeleteGallery($gallery);
	
						jQuery( this ).dialog( "close" );
					},
					Cancel: function() {
						// Nothing to do
						jQuery( this ).dialog( "close" );
					}
				}
			});
		});	
	
	}
	
	// Resize has happended
	function acGalleryResize() {
		
		/* -- Image Editor -- */
		// Centre the editor
		jQuery("#image-editor-overlay #image-editor").css('top', (jQuery(window).height() / 2) - ( jQuery("#image-editor-overlay #image-editor").height() / 2 ) );
		jQuery("#image-editor-overlay #image-editor").css('left', (jQuery(window).width() / 2) - ( jQuery("#image-editor-overlay #image-editor").width() / 2 ) );
	
	}
	
	// Setup Drag and drop
	function acGallerySetupDragAndDrop() {
	
		// -- Image Dragging --   
		// Setup the images drag and drop
		jQuery(function() {
			
			jQuery(".images").sortable({ 
				opacity: 0.6, 
				cursor: 'move', 
				connectWith: ".images", 
				items: ".img-container",
				placeholder: "sortable-placeholder",
				dropOnEmpty: true,			
				revert: true,
				update: function() {
				
					var data = {
						action: 'ac_gallery_update_image_order',
						order: jQuery(this).sortable("serialize")
					};
					
					jQuery.post(ajaxurl, data, function(response) {
						// Response not required
					});		
							
				},
				receive: function(event, ui) { 
					// get the gallery
					var galleryId = acGalleryGetIdFromString( jQuery(this).parent().attr("id") );
							
					// get the image id
					var imageId = acGalleryGetImageIdFromString( jQuery(ui.item).attr("id") );
					
					// Set the image gallery via ajax
					var data = {
						action: 'ac_gallery_set_post_parent',			
						postId: imageId,
						parentId: galleryId
					};
					
					jQuery.post(ajaxurl, data, function(response) {
						// No response required
					});						
					
					// Update trash state in case of drag to trash
					acGallerySetTrashEmptyButtonState();											
									
				}
			});
			
			jQuery( ".images" ).disableSelection();		
		});
		
	}
	
	function acGalleryAddNewGallery() {
		
		// Setup the Ajax request to create the new gallery, and get it's HTML to display in the form
		var data = {
			action: 'ac_gallery_add_gallery'
		};
		
		jQuery.ajax({
				type: "post",
				dataType: 'json',
				url : ajaxurl,
				data: data,
				success: function (response) {
	
			// The response contains the HTML for the gallery.  Add it before the Trash gallery
			jQuery('.gallery.homepage').after(response.html);
					
			// Get the new gallery jQuery object
			var $newGallery = acGalleryGetGalleryFromId(response.galleryId);
			
			// Focus the title
			jQuery("input.title", $newGallery).select();
	
			// Now scroll the window to the new gallery			
			jQuery('html, body').animate({
				scrollTop: ( jQuery($newGallery).position().top )
			}, 600);
						
			// Send the new gallery order to the DB
			acGalleryDoUpdateGalleryOrder();
			
			// Hookup the plupload controls
			acGalleryAddPlupload(response.galleryId);
			}
		});	
		
	}
	
	
	// Setups each of the galleries
	function acGallerySetupGalleries() {
		
		// Iterate each gallery
		$(".gallery").each(function( index ) {
			
			// Get the gallery id
			var gallery_id = $(this).data('gallery-id');
										
			// Attach the plupload to the gallery
			acGalleryAddPlupload(gallery_id);
		});
		
	}	
	
	// On page ready
	jQuery(document).ready(function($) {
		
		// Fade in notices
		if (acIsTouchDevice) {
			jQuery('.touch-only').fadeIn(400);
		}
		
		// Setup the galleries
		acGallerySetupGalleries();
		
		// Hookup the Drag and Drop
		acGallerySetupDragAndDrop();
			
		// Hover states
		acGallerySetImageHoverStates();
		
		// Hookup all of the gallery controls
		acGallerySetGalleriesEditControls();
		
		// New Gallery
		jQuery('button#add-new-gallery').click(function() {	
			acGalleryAddNewGallery();
		});
		
		// Empty Trash
		jQuery('button#empty-trash').click(function() {		
			
			// Show the Emptry Trash dialog
			jQuery( "#empty-trash-confirm" ).dialog({
				dialogClass: "no-titlebar",
				resizable: false,
				modal: true,
				buttons: {
					"Empty Trash": function() {
						// Delete the gallery
						acGalleryEmptyTheTrash();
	
						jQuery( this ).dialog( "close" );
					},
					Cancel: function() {
						// Nothing to do
						jQuery( this ).dialog( "close" );
					}
				}
			});
			
		});
		
		// Setup the image controls
		acGallerySetImageEditControls();
		
		// -- Keys --
		jQuery(document).keydown(function(e) {
	
			// Escape
			if (e.keyCode == 27) {
				// Close the editor window
				acGalleryCloseImageEditor();
			} 
	
			// Right arrow
			if ( (e.altKey === true) && (e.keyCode == 39) ) {
				// Next in the image editor
				acGalleryImageEditorNext();
			} 
	
			// Left arrow
			if ( (e.altKey === true) && (e.keyCode == 37) ) {
				// Prev in the image editor
				acGalleryImageEditorPrev();
			} 
	
	
		});
		
		// -- Image Editor --
		// Save button
		jQuery('#editor-save').click(function() {
			acGallerySaveImageData();
			acGalleryResetImageControls();	
		});
		
		// Delete button
		jQuery('#editor-delete').click(function() {
			acGalleryTrashCurrentEditingImage();
			acGalleryResetImageControls();	
		});	
	
		// Close button
		jQuery('#close-button').click(function() {
			acGalleryCloseImageEditor();
		});
	
		// When clicking the black overlay background
		jQuery('#image-editor-overlay').click(function(e) {
		
			if (e.target.id == 'image-editor-overlay')
				acGalleryCloseImageEditor();		
		});
	
		// Next button
		jQuery('#next-button').click(function() {
		
			// Edit the next image
			acGalleryImageEditorNext();
			
		});	
		
		// Prev button
		jQuery('#prev-button').click(function() {
		
			// Edit the prev image
			acGalleryImageEditorPrev();
		
		});		
		
		// On image data change enable the save button
		jQuery('#editor-title, #editor-description').keydown(function(e) {
			acGallerySetImageControlsChanged();
		});
		jQuery('#editor-status').change(function() {
			acGallerySetImageControlsChanged();
		});
		
		// -- End / Image Editor --
		
		// Set the intial state of the edit states
		acGallerySetGalleryEditStates();	
		
		// Set the trash empty button state
		acGallerySetTrashEmptyButtonState();
		
		// Hookup the resize
		jQuery(window).resize(function() {
			acGalleryResize();
		});	
		
		// Ensure the image editor background is initialised
		acGalleryResetImageEditing();
		
		// Set the editors controls
		acGallerySetImageEditorControlsState();
		
		// Call resize for positions
		acGalleryResize();
		
	});	
	
})( jQuery );