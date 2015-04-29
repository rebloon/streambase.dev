/*********************************/
/**** Alleycat Framework JS  ****/ 
/*********************************/
var acIsTouchDevice = 'ontouchstart' in document.documentElement; // Is this a touch device?
var acTopNavbarHadTrans = null;

// Usefull JS
(function( $ ){
	"use strict";
				
	// AC FUNCTIONS
	//=======================================================		
	function ac_framework_resize() {
	
		// -- Centre vertically --
		$( ".ac-center-vertically" ).each( function () {
			
			// Make the parent div relative
			if ( $(this).parent('div').css('position') == 'static') {
				$(this).parent('div').css('position', 'relative');				
			}

			// Set the text top based on parent div
			var top = ( $(this).parents('div').height() / 2 ) - ( $(this).height() / 2 );
			$(this).css('top', top);

		});

		// -- Centre horizontally --
		$( ".ac-centre-horizontally" ).each( function () {
			
			// Center the element based on its position type
			var left;

			if ( $(this).css("position") == "absolute" ) {

				// If absolute position with left
				left = ( $(this).parent().width() / 2 ) - ( $(this).width() / 2 );
				// Ensure left is not negative
				if (left < 0) {
					left = 0;
				}
				$(this).css('left', left);
				
			}

		});
		
		// -- Full width rows --
		// Don't apply for boxed or if sidebars are present
		if ( !$('body').hasClass('boxed-style') && $('body main.main').hasClass('no-sidebar') ) { 

			$( ".ac-full-width-row" ).each( function () {
			
				// -- Add margins to extend the row past it's box --		
				var $row = $(this); // This is the element we will adjust.
				
				// If it's a wpb (VC) element we need to get a parent element as the row
				if ( $(this).hasClass('wpb_content_element') )
				{
					// Get the row and set it's width
					$row = $(this).parents('.wpb_row');					
				}
								
				var extra_width = ( $(window).width() - $row.parent().width() ) / 2;
				$row.css('margin-left', -extra_width);
				$row.css('margin-right', -extra_width);
				$row.css('width', $(window).width());
						
			});						
		}
		
		
		// -- Isotope --
		// reLayout Isotope grids
		if ($.fn.isotope) {
			var $ac_grid_posts = $('.ac-grid-posts');
			if ($ac_grid_posts.length && $ac_grid_posts.hasClass('isotope')) {
				$ac_grid_posts.isotope("layout");			
			}
			var $ac_tile_posts = $('.ac-tile-posts');
			if ($ac_tile_posts.length && $ac_tile_posts.hasClass('isotope')) {
				$ac_tile_posts.isotope("layout");				
			}
			
			// Isotope grid filter
			$('.ac-category-filters span').on('click', 'a', function(e) {
				e.preventDefault();
				$(this).parent().parent().find('span').removeClass('selected');
				$(this).parent().addClass('selected');
				var selector = $(this).data('filter');
				var $isotope = $(this).parent().parent().parent().parent().find('.ac-filter-target');
				$isotope.isotope({ filter: selector });	
				return false;
			});
			
			// Masonry Tiles
			$('.ac-tile-masonry').each( function () {
				// Get the cols
				var cols = $(this).data('cols');
				if (!cols) { // fallback
					cols = 4;
				}
				// Calc the cold width // todo, check this
//				var colWidth = Math.floor($(this).width() / cols);
				$(this).isotope({
					layoutMode: 'packery',
/*
					packery: {
						columnWidth: colWidth
					},
*/
					itemSelector: '.ac-tile-col'
				});
				$(this).isotope("layout");						
			});

		}
		
		// -- RoyalSlider --
		// Set slider height for Gallery page to fill gap
		// Slider and header should fill the page.  Footer should be just off page
		var height = $(window).outerHeight(false) - $('header').outerHeight(false) + 1;
		$('.single-ac_gallery .ac-royalSlider, .single-ac_gallery .royalSlider').css('height', height);
		
		// -- VC Controls --
		// Check for pie chart width
		$( ".vc_pie_chart" ).each( function () {
		
			// Reduce font-size if chart too small
			if ($(this).width() < 100) {
				$('.vc_pie_chart_value', this).css('font-size', '120%');
			}			
			else if ($(this).width() < 151) {
				$('.vc_pie_chart_value', this).css('font-size', '140%');
			}
					
		});
		
		// Parallax Footer
		if ( $('.no-touch body').hasClass('footer-parallax') ) {
			// Add the footer height to the body
			$('body').css('padding-bottom', $('body > footer').height() );
		}
		
		ac_resize_mobile_menu(false);		
		
	}	// End - Resize
	
	// Chage the size of the mobile menu
	function ac_resize_mobile_menu(force) {
		// If the mobile menu is visible
		if ( $('.topnavbar').hasClass('mobile-open') || (force === true) ) {

				// Mobile menu height is viewport height - navbar-header
				var menuHeight = ( $(window).height() - $('.navbar-header').height() );
				$('.topnavbar .nav-main .navbar-nav').css('height', menuHeight);
			
		}		
	}	
	
	// AC VC COMPONENTS	
	//=======================================================
	function ac_initiate_isotope() {
			
		// Check Isotope exists
		if ($.fn.isotope) {	
		
			// -- Grid posts --
			var $ac_grid_posts = $('.ac-grid-posts');

			// Check we have some
			if ($ac_grid_posts.length) {
		
				// Process each one
				$ac_grid_posts.each(function( index ) {
		
					var layout_mode = 'masonry'; // Default
		
					// Check for fitRows
					if ( $(this).hasClass('ac-grid-fit-rows')) {
						layout_mode = 'fitRows';
					}
					$(this).isotope({
						itemSelector: '.ac-grid-col',
						layoutMode : layout_mode
					});
	
				});
				
			}
				
			// -- Tile posts --
			var $ac_tile_posts = $('.ac-tile-posts.ac-tile');				
			// Check we have some
			if ($ac_tile_posts.length) {
	
				// Process each one
				$ac_tile_posts.each(function( index ) {
							
					$(this).isotope({
						itemSelector: '.ac-tile-col'
					});
	
				});
			}
			
			// -- Masonry Tile posts --
			$ac_tile_posts = $('.ac-tile-posts.ac-tile-masonry');				
			// Check we have some
			if ($ac_tile_posts.length) {
	
				// Process each one
				$ac_tile_posts.each(function( index ) {				
		
					$(this).isotope({
						itemSelector: '.ac-tile-col',
						layoutMode : 'packery'
					});
	
				});
			}			
			
		}
	}

	
	// AC ROYAL SLIDER
	//=======================================================	
	
	// Setup each of the Royal Sliders
	function ac_intiate_royal_sliders() {
		
		// Intiate each royal slider
		$('.ac-royalSlider .royalSlider').each(function( index ) {
		
			var ac_slider = this; // Save this for later
			
			// Get data values.  These are data values attached to the RS
			var slider_size = $(ac_slider).parent().data('slider-size');
			var transition_speed = 1000;
			var autoplay_enabled = $(ac_slider).parent().data('autoplay');
			var autoplay_delay = $(ac_slider).parent().data('delay');
			var slides_orientation = 'horizontal';
			var transition = $(ac_slider).parent().data('transition');
			var auto_height = $(ac_slider).parent().data('auto-height');
			var autoHeight = false; // default to false for most modes
			var is_nearby = false;
			if (auto_height === true) {
				autoHeight = true; 
			}
			var autoScaleSlider = true;		
			// Shall we use split nav (AC) or navigateByClick (RS)
			var	navigateByClick = true;			
			var splitNav = $(ac_slider).parent().data('split-nav');
			if (splitNav) {
				navigateByClick = false;
				// hookup nav further down
			}
			
			// Setup transition values
			// Fade
			var transition_type = 'fade';			
			if (transition == 'slide') {
				transition_type = 'move';
			}
						
			// Setup display values based on display size
			var autoScaleSliderWidth = 800;
			var autoScaleSliderHeight = 300;
			if (slider_size == '3by2') {
				// Use standards above
			}
			if (slider_size == 'auto-height') {
				// For non-image driven content
				autoScaleSliderWidth = null;
				autoScaleSliderHeight = null;
				autoHeight = true;
				autoScaleSlider = false;
			}			
			else if (slider_size == 'letterbox') {
				autoHeight = false;
				autoScaleSliderWidth = 1920;
				autoScaleSliderHeight = 500;
			}
			else if (slider_size == 'ratio') {
				autoScaleSliderWidth = 1920;
				autoScaleSliderHeight = 1200;
			}			
			else if (slider_size == 'square') {
				autoScaleSliderWidth = 1920;
				autoScaleSliderHeight = 1920;
			}						
			else if (slider_size == 'fullscreen') {
				autoScaleSliderWidth = 1920;
				autoScaleSliderHeight = 1920;
				autoScaleSlider = false;
				autoHeight = false;
			}			
			else if (slider_size == 'nearby') {
				is_nearby = true;
				autoScaleSliderWidth = null;
				autoScaleSliderHeight = null;
				autoScaleSlider = true;
				autoHeight = false;
			}			
							
			// Settings
			$(this).royalSlider({
				autoScaleSliderWidth: autoScaleSliderWidth,
				autoScaleSliderHeight: autoScaleSliderHeight,
				arrowsNav: true,
				loop: true,
				keyboardNavEnabled: true,
				controlsInside: false,
 				imageScaleMode: 'fill',
				arrowsNavAutoHide: false,
				autoScaleSlider: autoScaleSlider, 
				slidesSpacing: 0,
				autoHeight: autoHeight,
				startSlideId: 0,
				globalCaption: false,
				controlNavigation: 'none',
				numImagesToPreload: 3,
				/* cp settings */
				transitionSpeed: transition_speed,
				autoPlay: {
					enabled: autoplay_enabled,
					pauseOnHover: true,
					delay: autoplay_delay
				},
				transitionType: transition_type,
				slidesOrientation: slides_orientation,
				navigateByClick: navigateByClick,
				visibleNearby: {
					enabled: is_nearby,
					centerArea: 0.5,
					center: true,
					breakpoint: 650,
					breakpointCenterArea: 0.64,
					navigateByCenterClick: true
				}								
			});

			// Get the slider
			var slider = $(this).data('royalSlider');

			// Set the details after the first tab is set			
			slider.slides[0].holder.on('rsAfterContentSet', function() {
				ac_update_royal_slider_controls(slider, ac_slider);
			});			

			// Set the details when a slide changes
			slider.ev.on('rsBeforeAnimStart', function(event) {
				ac_update_royal_slider_controls(slider, ac_slider);				
			});
			
			// Split nav
			if (splitNav) {

				// Back and forward clicks on slideshow
				jQuery(this).find('.rsOverflow').click(function(e) {
				
					// get the target first class
					var $firstClass = e.target.className.split(" ")[0];
				
					// only click when rsImg (as other elements already fire the next/prev)
					if ($firstClass == 'rsImg') {
				
						var offset = jQuery(this).offset();
						var relativeX = e.pageX - offset.left;
				
						// if the click is in the right half of the slideshow
						if (relativeX > (jQuery('.rsOverflow').width() / 2) ) {
							slider.next();
						} else {
							slider.prev();
						}
						
					}
						
				});		
			}
							
		});
	}	
	
	// Updates all of the controls in a Royal Slider to show the current slides data
	function ac_update_royal_slider_controls(slider, ac_slider) {

		// Get data settings
		var show_title = $(ac_slider).parent().data('show-title');
		var show_excerpt = $(ac_slider).parent().data('show-excerpt');
	
		// Get the display wrapper
		var $wrapper = $(ac_slider).parent().find('.ac-rs-controls-wrapper');
	
		// Fade out all of the text
		$($wrapper).fadeTo( 1000 , 0, function() {
			// Animation complete.
	
			// Get some values
			var currentSlideId = slider.currSlideId;
			var $slideH = slider.slidesJQ[currentSlideId];
			var caption = $($slideH).find('.caption').html();
			var description = $($slideH).find('.description').html();
									
			// Update the text
			if (show_title !== false) {
			
				if (caption) {
					$('.slidecaption', $wrapper).html('<h2>' + caption + '</h2>');					
				}
				else {
					$('.slidecaption', $wrapper).html('');					
				}
			}

			if (show_excerpt !== false) {
				$('.slidedescription', $wrapper).html(description);					
			}			
						
		});			
		
		// Fade in all of the text
		$($wrapper).fadeTo( 1000 , 1, function() {
			// Animation complete.
		});				
		

	}
	
	// Hookup the search controls
	function ac_hookup_search_controls() {
		// Show
		$('#nav-search-open').click(function() {
		
			// Show then animate.  Must be hidden to disable interaction
			$('.navbar-search-form-container').show( 0, function() {
				// Animation complete.
				$('.navbar-search-form-container').css('opacity', 1);
			});
			// Focus on the input
			$('.navbar-search-form-container #s-nav').focus();
			
			return false;
		});
		
		// Close
		$('#nav-search-close').click(function() {
			ac_close_navbar_search();
		});		
	}
	function ac_close_navbar_search() {
	
		// Animate then hide
		$('.navbar-search-form-container').animate({
				opacity: '0'
			}, {
				duration: 0,
				complete: function() {
					$('.navbar-search-form-container').hide();
				}
		});
	
	}
	
	// Fade elements in
	function ac_fade_in_elements_on_ready() {
		// Remove the hidden class using a slight delay to give effect		
		var delay = 0;
		$( ".ac-hide-until-ready" ).each(function( index ) {

			// Increment delay to add sweeping effect
			delay = (index * 100);
			
			var $control = this;
			
			setTimeout(function() {
				$($control).removeClass('ac-hidden-until-ready');
			}, delay);
			
		});
	}
	
	// TRANSPARENT NAVBAR
	//=======================================================	
	function ac_setup_transparent_header() {
		
		if ($('body').hasClass('ac-transparent-navbar-body')) {

			// Header fade on scroll
			$(window).scroll(function (event) {
				var threshold = 2;			
	
				var scroll = $(window).scrollTop();			
				if (scroll >= threshold) {
					$('.navbar-fixed-top').removeClass('ac-transparent-navbar');
				}
				else if (scroll < threshold) {
					$('.navbar-fixed-top').addClass('ac-transparent-navbar');
				}
			});
			
			// Remove trans header when menu hovered
			$( ".topnavbar" ).hover(
				function() {
					if ( $( this ).hasClass('ac-transparent-navbar') ) {
						$( this ).removeClass('ac-transparent-navbar');
						acTopNavbarHadTrans = true;
					}
				}, function() {
					if (acTopNavbarHadTrans === true) {
						$( this ).addClass('ac-transparent-navbar');
						acTopNavbarHadTrans = null;			
					}
				}
			);
			
		}
		
		
		
	}

	
	// 3RD PARTY
	//=======================================================	

	// EVENTS
	//=======================================================	
	
	// On ready...
	$(document).ready(function() {

		// Touch device specifics
		if (acIsTouchDevice) {
			// Remove wpb_animate_when_almost_visible to prevent animations
			$('*').removeClass('wpb_animate_when_almost_visible');		
		}
		else {
			// Setup parallax object, not for touch devices			
			$('.parallax_image_speed-fast').parallax("50%", 0.7);
			$('.parallax_image_speed-medium').parallax("50%", 0.4);
			$('.parallax_image_speed-slow').parallax("50%", 0.1);
			$('.parallax_image_speed-full').parallax("50%", 1);			
		}
						
		ac_intiate_royal_sliders();

		ac_hookup_search_controls();
		
		// PrettyPhoto
		if ( $.isFunction($.fn.prettyPhoto) ) {
			$("a[rel^='prettyPhoto']").prettyPhoto();
		}
		
		// Close things when the body is clicked
		$('body').click(function(e) {
			// Don't close if the navbar search is clicked
			if (e.target.id != "s-nav") {
				ac_close_navbar_search();
			}
		});
		
		// -- Dropdown Menus --
		// Ensure the menu items are not offscreen
		$('.topnavbar li.dropdown').hover(function() {
			
			if (! $('.topnavbar').hasClass('mobile-open') ) { // Revisit, this is a performance issue?			
		
			var buffer = 20; // Extra to avoid close-to-edge menus
			var menus = $(this).find('ul'); // Get all of the children menus
			
			// Iterate each menu
			$( menus ).each(function( index ) {			
				
				var menu = $(this);
				var menupos = $(menu).offset();
		
				// If dropdown is offscreen, or the parent menu has been forced left
				if ((menupos.left + menu.width() + buffer > $(window).width()) || $(menu).hasClass('pushed-left')) {
					var newpos = -$(menu).width();
					// Move left
					$(menu).css({ left: newpos });
					// Add a class to define that this menu has been forced left
					menus.addClass('pushed-left');
				}
				});
				
			}				
		});	
		
		// Responsive menu toggle
		$('.navbar-toggle').click(function(e) {
			
			$('.topnavbar').toggleClass('mobile-open');
			
			ac_resize_mobile_menu(true);

		});				
		
		// One Pager
		if ( $('body').hasClass('one-page') ) {
			// Add scroll to menu items
			$('.nav-main a').addClass('smoothScroll');
		}
		
		// Side Tab
		$('.ac_side_tab').each( function () {		
			var $tab = this;
			// Because of rotation height becomes width
			// Move offscreen			
			$( $tab ).animate({
					left: -$($tab).outerHeight()
				}, 500, function() {
					// Animation complete.
					$( $tab ).show();
					$( $tab ).animate({
							left: 0
						}, 0, function() {
						// Animation complete.
					});		
			});		
		});
				
		// Fade in page elements
		ac_fade_in_elements_on_ready();
		
		ac_setup_transparent_header();
		
		// Call a resize on ready.  THIS SHOULD ALWAYS BE LAST
		ac_framework_resize();
		
		// EVENTS
		// On resize...
		$( window ).resize(function() {
	
			ac_framework_resize();
				
		});			

	});
	
	// On load...
	$(window).load(function(){
	
		ac_initiate_isotope();
		
		// Show the Parallax Footer, which will be hidden
		$('.footer-parallax footer').fadeIn('slow');
			
		// Call resize once to setup things.  Needed after load as image sizes are not known until load
		$(window).trigger('resize');
										
	});
	
})( jQuery );