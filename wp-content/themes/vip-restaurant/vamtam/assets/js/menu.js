(function($, undefined) {
	"use strict";

	var win = $(window);

	win.one( 'vamtam-greensock-loaded', function() {
		var mainHeader      = $('header.main-header'),
			main            = $( '#main' ),
			body            = $( 'body' ),
			header_contents = mainHeader.find( '.header-contents' );

		var menu_toggle     = document.getElementById( 'vamtam-megamenu-main-menu-toggle' );
		var original_toggle = document.querySelector( '#main-menu > .mega-menu-wrap > .mega-menu-toggle' );

		// main menu custom toggle

		menu_toggle.addEventListener( 'click', function( e ) {
			e.preventDefault();

			requestAnimationFrame( function() {
				var is_open = original_toggle.classList.contains( 'mega-menu-open' );

				menu_toggle.classList.toggle( 'mega-menu-open', ! is_open );
				original_toggle.classList.toggle( 'mega-menu-open', ! is_open );
			} );
		} );

		// add left/right classes to submenus depending on resolution

		var allSubMenus = $( '#main-menu .sub-menu, #top-nav-wrapper .sub-menu' );

		win.bind( 'smartresize.vamtam-menu-classes', function() {
			var winWidth = win.width();

			allSubMenus.show().removeClass( 'invert-position' ).each( function() {
				if ( $( this ).offset().left + $( this ).width() > winWidth ) {
					$( this ).addClass( 'invert-position' );
				}
			} );
			allSubMenus.css( 'display', '' );
		} );

		// scrolling below

		var adminbar = ($('#wpadminbar') ? $('#wpadminbar').height() : 0);

		var scrollToEl = function( el ) {
			var el_offset = el.offset().top;

			$.VAMTAM.blockStickyHeaderAnimation = true;

			// measure header height
			var header_height = 0;

			if ( mainHeader.hasClass( 'layout-standard' ) || mainHeader.hasClass( 'logo-text-menu' ) ) {
				if ( el_offset >= main.offset().top ) {
					header_height = mainHeader.find( '.second-row-columns' ).height();
				} else {
					header_height = mainHeader.height();
				}
			} else {
				if ( body.hasClass( 'no-sticky-header-animation' ) ) {
					// single line header with a special page template

					header_height = mainHeader.height();
				} else {
					header_height = header_contents.height();

					// in this case stick the header,
					// we'd like the menu to be visible after scrolling
					win.trigger( 'vamtam-single-row-header-stick' );
					body.addClass( 'no-sticky-header-animation-tmp' );
				}
			}

			var scroll_position = el_offset - adminbar - header_height;

			vamtamgs.TweenLite.to( window, 1, {
				scrollTo: scroll_position,
				autoKill: false,
				ease: vamtamgs.Power4.easeOut,
				onComplete: function() {
					$.VAMTAM.blockStickyHeaderAnimation = false;

					setTimeout( function() {
						body.removeClass( 'no-sticky-header-animation-tmp' );
					}, 50 );
				}
			} );
		};

		$(document.body).on('click', '.vamtam-animated-page-scroll[href], .vamtam-animated-page-scroll [href], .vamtam-animated-page-scroll [data-href], .mega-vamtam-animated-page-scroll[href], .mega-vamtam-animated-page-scroll [href], .mega-vamtam-animated-page-scroll [data-href]', function(e) {
			var href = $( this ).prop( 'href' ) || $( this ).data( 'href' );
			var el   = $( '#' + ( href ).split( "#" )[1] );

			var l  = document.createElement('a');
			l.href = href;

			if(el.length && l.pathname === window.location.pathname) {
				scrollToEl(el);
				e.preventDefault();
			}
		});

		if ( window.location.hash !== "" &&
			(
				$( '.vamtam-animated-page-scroll[href*="' + window.location.hash + '"]' ).length ||
				$( '.vamtam-animated-page-scroll [href*="' + window.location.hash + '"]').length ||
				$( '.vamtam-animated-page-scroll [data-href*="'+window.location.hash+'"]' ).length ||
				$( '.mega-vamtam-animated-page-scroll[href*="' + window.location.hash + '"]' ).length ||
				$( '.mega-vamtam-animated-page-scroll [href*="' + window.location.hash + '"]').length ||
				$( '.mega-vamtam-animated-page-scroll [data-href*="'+window.location.hash+'"]' ).length ||
				$( '.vamtam-tabs [href*="' + window.location.hash + '"]').length
			)
		) {
			var el = $( window.location.hash );

			if ( $( '.vamtam-tabs [href*="' + window.location.hash + '"]').length ) {
				el = el.closest( '.vamtam-tabs' );
			}

			if ( el.length > 0 ) {
				$( window ).add( 'html, body, #page' ).scrollTop( 0 );
			}

			setTimeout( function() {
				scrollToEl( el );
			}, 400 );
		}

		// adds .current-menu-item classes

		var hashes = [
			// ['top', $('<div></div>'), $('#top')]
		];

		var add_current_menu_item = function( hash ) {
			for ( var i = 0; i < hashes.length; i++ ) {
				if ( hashes[i][0] === hash ) {
					hashes[i][1].addClass('mega-current-menu-item current-menu-item');
				}
			}
		};

		$('#main-menu').find('.mega-menu, .menu').find('.maybe-current-menu-item, .mega-current-menu-item, .current-menu-item').each(function() {
			var link = $('> a', this);

			if(link.prop('href').indexOf('#') > -1) {
				var link_hash = link.prop('href').split('#')[1];

				if('#'+link_hash !== window.location.hash) {
					$(this).removeClass('mega-current-menu-item current-menu-item');
				}

				hashes.push([link_hash, $(this), $('#'+link_hash)]);
			}
		});

		var scroll_snap = $('.vamtam-scroll-snap');

		if ( scroll_snap.length ) {
			body.addClass( 'with-scroll-snap' );

			var scroll_snap_nav = $( '<nav id="vamtam-scroll-snap-nav"></nav>' );
			var scroll_snap_nav_by_id = {};

			scroll_snap_nav.attr( 'aria-hidden', 'true' ); // hide for screen readers only, this nav is redundant and should not be read aloud twice

			body.append( scroll_snap_nav );

			scroll_snap.each(function() {
				var col = $( this );

				scroll_snap_nav.append( function() {
					var id   = col.attr('id');
					var link = $('<a />');

					link.attr( 'href', '#' + id );
					link.addClass('vamtam-animated-page-scroll');

					scroll_snap_nav_by_id[ id ] = link;

					hashes.push( [ id, link, col ] );

					return link;
				} );
			} );

			scroll_snap_nav.css( 'margin-top', - scroll_snap_nav.outerHeight() / 2 );

			$(window).on('wheel mousewheel', function( e ) {
				var direction = e.originalEvent.deltaY || e.originalEvent.wheelDelta;

				if ( direction !== 0 ) {
					var visible_top    = $( window ).scrollTop() + mainHeader.outerHeight() + adminbar; // top of visible area
					var visible_bottom = $( window ).scrollTop() + $( window ).height(); // bottom of visible area

					var to_el;

					scroll_snap.each( function() {
						var col = $(this);

						// top edge of snap if scrolling down, bottom edge if scrolling up
						var line = Math.floor( direction > 0 ? col.offset().top : col.offset().top + col.outerHeight() );

						if ( line > visible_top + 10 && line < visible_bottom - 10 ) { // line is visible, allow a few px buffer on each side erring towards "invisible"
							to_el = col;

							return;
						}
					} );

					if ( to_el ) {
						e.preventDefault();

						scrollToEl( to_el );
					} else {
						if ( ! $.VAMTAM.blockStickyHeaderAnimation ) {
							$.VAMTAM.blockStickyHeaderAnimation = true;

							setTimeout( function() {
								$.VAMTAM.blockStickyHeaderAnimation = false;
							}, 1000 );
						}
					}
				}
			} );
		}

		if ( hashes.length ) {
			var winHeight = 0;
			var documentHeight = 0;

			var prev_upmost_data = null;

			win.scroll(function() {
				winHeight = win.height();
				documentHeight = $(document).height();

				var cpos = win.scrollTop();
				var upmost = Infinity;
				var upmost_data = null;

				for ( var i = 0; i < hashes.length; i++ ) {
					var el = hashes[i][2];

					if ( el.length ) {
						var top = el.offset().top + 10;

						if ( top > cpos && top < upmost && ( top < cpos + winHeight / 2 || ( top < cpos + winHeight && cpos + winHeight === documentHeight ) ) ) {
							upmost_data = hashes[i];
							upmost = top;
						}

						hashes[i][1].removeClass('mega-current-menu-item current-menu-item');
					}
				}

				if ( upmost_data ) {
					add_current_menu_item( upmost_data[0] );

					if('history' in window && (prev_upmost_data !== null ? prev_upmost_data[0] : '') !== upmost_data[0]) {
						window.history.pushState(upmost_data[0], $('> a', upmost_data[1]).text(), (cpos !== 0 ? '#'+upmost_data[0] : location.href.replace(location.hash, '')));
						prev_upmost_data = $.extend({}, upmost_data);
					}
				} else if( upmost_data === null && prev_upmost_data !== null) {
					add_current_menu_item( prev_upmost_data[0] );
				}
			});
		}
	});
})(jQuery);