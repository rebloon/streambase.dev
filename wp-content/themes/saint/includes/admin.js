/*******************/
/**** Admin JS  ****/ 
/*******************/

(function( $ ){
	"use strict";
	
	/*  META BOX
	========================================*/

	// Hide sidebar selectors	
	function ac_post_sidebars_select() {

		var ac_layout_override = $('#ac_layout_override').val();
		var $sidebar_layout = $('.sidebar_layout');		
		var $left_sidebar = $('#ac_left_sidebar').parent().parent();
		var $right_sidebar = $('#ac_right_sidebar').parent().parent();
		var layout = $('.rwmb-active img', $sidebar_layout).siblings('input[type=radio]').val();
		
		if ( ac_layout_override == 1 ) {

			$sidebar_layout.css('display', 'block');
			
			// Can't really use arrays due to zeros and negative numbers, to use if statements		
			if ( layout === '-1' ) {
				$left_sidebar.css('display', 'none');
				$right_sidebar.css('display', 'none');			
			}
			else if ( layout === '0' ) {
				$left_sidebar.css('display', 'none');
				$right_sidebar.css('display', 'none');			
			}
			else if ( layout == 1 ) {
				$left_sidebar.css('display', 'none');
				$right_sidebar.css('display', 'block');
			}		
			else if ( layout == 2 ) {
				$left_sidebar.css('display', 'block');
				$right_sidebar.css('display', 'none');
			}		
			else if ( layout == 3 ) {
				$left_sidebar.css('display', 'block');
				$right_sidebar.css('display', 'block');
			}		
			else if ( layout == 4 ) {
				$left_sidebar.css('display', 'block');
				$right_sidebar.css('display', 'block');
			}		
			else if ( layout == 5 ) {
				$left_sidebar.css('display', 'block');
				$right_sidebar.css('display', 'block');
			}		

		}
		else {
			// No override so hide all sidebar controls
			$sidebar_layout.css('display', 'none');
			$left_sidebar.css('display', 'none');
			$right_sidebar.css('display', 'none');			
		}
		
	}
	$('#ac_sidebar .sidebar_layout').click(function() {	
		ac_post_sidebars_select();
	});		
	$('#ac_layout_override').change(function () {
		ac_post_sidebars_select();
	});

  // Hide Page Title Advanced Options
	$('#ac_page_title_type')
  .change(function () {

		var $page_title_advanced = $('.ac_page_title_advanced');
		
		if ( $(this).val() == 'custom' ) {
			$page_title_advanced.css('display', 'block');
		}
		else {
			$page_title_advanced.css('display', 'none');			
		}
  
  })
  .change();
  
  // Portfolio - Open the images in a lightbox, show when the template type = side images
	$('#ac_template_type')
  .change(function () {

		var templateType = $('#ac_template_type').val();
		var $row = $('#ac_open_in_lightbox').parent().parent();

		if ( templateType == 'side-images' ) {
			$row.css('display', 'block');
		}
		else {
			$row.css('display', 'none');			
		}
  
  })
  .change();  
  
  // Set post slideshow type
  function ac_post_slideshow_select() {
		var ac_slideshow_type = $('#ac_slideshow_type').val();
		var $ac_slideshow_images = $('.ac_slideshow_images_row');
		var $ac_revolution_slideshow = $('#ac_revolution_slideshow').parent().parent();
		var $ac_include_featured_image = $('#ac_include_featured_image').parent().parent();
		
		switch (ac_slideshow_type)
		{
			case '' : // None
				$ac_slideshow_images.css('display', 'none');
				$ac_revolution_slideshow.css('display', 'none');
				$ac_include_featured_image.css('display', 'none');
				break;
			case 'ac' :
				$ac_slideshow_images.css('display', 'block');
				$ac_revolution_slideshow.css('display', 'none');
				$ac_include_featured_image.css('display', 'block');				
				break;
			case 'revslider' :
				$ac_slideshow_images.css('display', 'none');
				$ac_revolution_slideshow.css('display', 'block');
				$ac_include_featured_image.css('display', 'none');				
				break;
		}

  }
	$('#ac_slideshow_type').change(function () {
		ac_post_slideshow_select();
	});
	
	// Setups
  ac_post_slideshow_select();
	
	/*  VISUAL COMPOSER
	========================================*/
		
	// Resize VC editor window
	function ac_vc_resize_editor_modal() {
		var $vc_window = $('.wpb_bootstrap_modals .wpb-element-edit-modal.modal');
		if ($vc_window.length) {
			var $vc_body = $('.modal-body', $vc_window);		
			var vc_height = $(window).height() - ($vc_window.position().top * 2 + 150);
			$($vc_body).css('max-height', vc_height);		
		}
	}
	
	// Resize after edit click to resize window
	$('.column_edit').live('click', function() { //.live for late binding
		ac_vc_resize_editor_modal();
	});

	// Resize after add component click
	$('.vc-shortcode-link').live('click', function() { //.live for late binding
		ac_vc_resize_editor_modal();
	});
	
	/*  VISUAL COMPOSER ADDONS
	========================================*/
	// Hide VC UA nag, only have very child class
	$('.uavc-activation-notice').parents('.updated').hide();	
	
			
	/*  EVENTS
	========================================*/

	// Keys	
	$(document).keyup(function(e) {
	
		if (e.keyCode == 27) {
		
			// ESC to close VC windows
			// Component window
			$('.wpb-element-edit-modal .modal-header .close').click();
		
			// Elements window
			$('.wpb-elements-list-modal .modal-header .close').click();
			
		}

	});	
   
	// On ready
	$(document).ready(function(){

		// Check if AC WYSIWYG bio activated
		if ( $('body').hasClass('ac_author_bio_wysiwyg') ) {
			$('#description').parents('tr').remove();					
		}


	});  
  
  // On Load
  $( window ).load(function() {
		ac_post_sidebars_select();
		
		// Fire resize to ensure everything is setup
		$(window).trigger('resize');
		
	});
	
	// On resize
	$( window ).resize(function() {

		ac_vc_resize_editor_modal();
			
	});			
	
})( jQuery );