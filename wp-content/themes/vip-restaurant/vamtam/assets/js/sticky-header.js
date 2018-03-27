(function($, undefined) {
	"use strict";

	$(function() {
		var win = $(window),
			win_width,
			body = $('body'),
			hbox,
			hbox_filler,
			header,
			single_row_header,
			type_over,
			type_half_over,
			main,
			second_row,
			admin_bar_fix = body.hasClass('admin-bar') ? 32 : 0,
			logo_wrapper,
			logo_wrapper_height = 0,
			top_nav,
			top_nav_height = 0,
			explorer = /MSIE (\d+)/.exec(navigator.userAgent),
			loaded = false,
			interval,
			reset_bottom_edge;

		var setup_vars = function() {
			hbox = $('.fixed-header-box');
			header = $('header.main-header');
			single_row_header = header.hasClass('layout-logo-menu');
			type_over = body.hasClass('sticky-header-type-over');
			type_half_over = ( header.hasClass('layout-standard') || header.hasClass('layout-logo-text-menu') ) && body.hasClass('sticky-header-type-half-over');
			main = $('#main');
			second_row = hbox.find('.second-row');
			logo_wrapper = hbox.find('.logo-wrapper');
			top_nav = $('.top-nav');
		};

		var ok_to_load = function() {
			return ! loaded &&
				( body.hasClass( 'sticky-header' ) || body.hasClass( 'had-sticky-header' ) ) &&
				! ( explorer && parseInt( explorer[1], 10 ) === 8 ) &&
				! $.VAMTAM.MEDIA.is_mobile() &&
				! $.VAMTAM.MEDIA.layout["layout-below-max"] &&
				hbox.length && second_row.length;
		};

		var init = function() {
			setup_vars();

			if ( ! ok_to_load() ) {
				if ( body.hasClass( 'sticky-header' ) ) {
					body.removeClass( 'sticky-header' ).addClass( 'had-sticky-header' );

					if ( hbox.css( 'height' ) === '0px' ) {
						hbox.css( 'height', 'auto' );
					}
				}
				return;
			}

			win_width = win.width();

			hbox_filler = hbox.clone().html('').css({
				'z-index': 1,
				height: type_over ? top_nav.outerHeight() : ( type_half_over ? logo_wrapper.outerHeight() : hbox.outerHeight() )
			}).addClass( 'hbox-filler' ).insertAfter(hbox);

			hbox.css({
				position: 'absolute',
				top: 0,
				left: body.hasClass( 'boxed' ) ? 0 : hbox.offset().left,
				width: hbox.outerWidth(),
				'will-change': 'transform'
			});

			reset_bottom_edge = hbox.outerHeight() + hbox_filler.offset().top;

			logo_wrapper_height = logo_wrapper.removeClass('scrolled').outerHeight();
			top_nav_height = top_nav.show().outerHeight();

			if ( top_nav_height > 0 ) {
				hbox_filler.html(
					$( '<div id="top-nav-wrapper-filler"></div>' ).css( {
						height: top_nav_height,
						background: top_nav.parent().css( 'background' )
					} )
				);
			}

			logo_wrapper.addClass('loaded');

			interval = setInterval( reposition, 41 );

			loaded = true;

			win.scroll();
		};

		var destroy = function() {
			if ( ! loaded ) {
				return;
			}

			if ( hbox_filler && hbox_filler.length > 0 ) {
				hbox_filler.remove();
			}

			hbox.removeClass('static-absolute fixed').css({
				position: '',
				top: '',
				left: '',
				width: '',
				'will-change': ''
			});

			logo_wrapper.removeClass('scrolled loaded');

			body.addClass( 'sticky-header' ).removeClass( 'had-sticky-header' );

			clearInterval(interval);

			loaded = false;
		};

		var prev_cpos = -1,
			scrolling_down = true,
			scrolling_up = false,
			start_scrolling_up,
			start_scrolling_down;

		var single_row_header_reset = function( animation ) {
			animation = animation || 'fast';

			if ( hbox.hasClass( 'sticky-header-state-reset' ) ) {
				return;
			}

			hbox.addClass( 'sticky-header-state-reset' ).removeClass( 'sticky-header-state-stuck' );

			var true_reset = function() {
				hbox.removeClass( 'fixed' );
				logo_wrapper.removeClass('scrolled');

				vamtamgs.TweenLite.to( hbox, 0, {
					opacity: 1,
					position: 'absolute',
					top: 0,
					left: 0,
					width: hbox.outerWidth(),
					y: 0
				} );
			};

			window.vamtam_greensock_wait( function() {
				top_nav.show();

				vamtamgs.TweenLite.killTweensOf( hbox );

				if ( animation === 'fast' ) {
					true_reset();
				} else if ( animation === 'slow' ) {
					vamtamgs.TweenLite.to( hbox, 0.15, {
						y: - hbox.height(),
						ease: vamtamgs.Power4.easeOut,
						onComplete: true_reset()
					} );
				}

			} );
		};

		var single_row_header_stick = function() {
			if ( hbox.hasClass( 'sticky-header-state-stuck' ) ) {
				return;
			}

			hbox.addClass( 'sticky-header-state-stuck' ).removeClass( 'sticky-header-state-reset' );

			window.vamtam_greensock_wait( function() {
				logo_wrapper.addClass('scrolled');

				top_nav.hide();

				vamtamgs.TweenLite.killTweensOf( hbox );

				vamtamgs.TweenLite.to( hbox, 0, {
					position: 'fixed',
					top: hbox_filler.offset().top,
					left: hbox_filler.offset().left,
					width: hbox.outerWidth(),
					y: - hbox.height()
				} );

				hbox.addClass( 'fixed' );

				vamtamgs.TweenLite.to( hbox, 0.2, {
					y: 0,
					ease: vamtamgs.Power4.easeOut
				} );
			} );
		};

		win.bind( 'vamtam-single-row-header-reset', single_row_header_reset );
		win.bind( 'vamtam-single-row-header-stick', single_row_header_stick );

		var reposition = function() {
			if ( ! loaded ) {
				return;
			}

			var cpos = win.scrollTop();

			body.toggleClass('vamtam-scrolled', cpos > 0).toggleClass('vamtam-not-scrolled', cpos === 0);

			if ( single_row_header ) {
				if(!('blockStickyHeaderAnimation' in $.VAMTAM) || !$.VAMTAM.blockStickyHeaderAnimation) {
					scrolling_down = prev_cpos < cpos;
					scrolling_up = prev_cpos > cpos;

					if ( scrolling_up && start_scrolling_up === undefined ) {
						start_scrolling_up = cpos;
					} else if ( scrolling_down ) {
						start_scrolling_up = undefined;
					}

					if ( scrolling_down && start_scrolling_down === undefined ) {
						start_scrolling_down = cpos;
					} else if ( scrolling_up ) {
						start_scrolling_down = undefined;
					}

					prev_cpos = cpos;
				}

				// needs simplification! - remove one of scrolling_down/scrolling_up
				if ( ! body.hasClass( 'no-sticky-header-animation' ) && ! body.hasClass( 'no-sticky-header-animation-tmp' ) ) {
					if ( cpos < reset_bottom_edge + 200 ) {
						// at the top

						single_row_header_reset( 'fast' );
					} else if ( scrolling_down && ( Math.abs( cpos - start_scrolling_down ) > 30 || cpos < reset_bottom_edge * 2 ) ) {
						// reset header position to absolute scrolling down

						single_row_header_reset( 'slow' );
					} else if ( scrolling_up && ( Math.abs( start_scrolling_up - cpos ) > 30 || cpos < reset_bottom_edge * 2 ) ) {
						// scrolling up - show header

						single_row_header_stick();
					}
				} else if ( body.hasClass( 'no-sticky-header-animation' ) ) {
					// the header should always be in its "scrolled up" state
					logo_wrapper.addClass('scrolled');
					hbox_filler.css( 'height', type_over ? top_nav.outerHeight() : ( type_half_over ? logo_wrapper.outerHeight() : hbox.outerHeight() ) );

					hbox.css( {
						position: 'fixed',
						top: hbox_filler.offset().top,
						left: hbox_filler.offset().left,
						width: hbox.outerWidth()
					} );

					hbox.toggleClass( 'sticky-header-state-stuck', cpos > 0 ).toggleClass( 'sticky-header-state-reset', cpos === 0 );
				}
			} else {
				// double row header

				hbox.toggleClass( 'sticky-header-state-stuck', cpos > 0 ).toggleClass( 'sticky-header-state-reset', cpos === 0 );

				var header_height = header.outerHeight();
				var second_row_height = second_row.height();

				var mcpos = main.offset().top - admin_bar_fix; // top of main content adjusted for the admin bar

				if ( mcpos === 0 ) {
					// used for pages where the header is sticky and transparent,
					// but there is no header slider, header featured area or page title

					mcpos = $('.page-content > .row:nth(1)').offset().top - admin_bar_fix;
				}

				if ( mcpos <= cpos + header_height ) { // top of main content above bottom of header
					if ( mcpos >= cpos + second_row_height ) { // bottom of menu above top of main content
						hbox.css({
							position: 'absolute',
							top: mcpos - header_height,
							left: 0
						}).addClass('static-absolute').removeClass('fixed second-stage-active');
					} else {
						hbox.css({
							position: 'fixed',
							top: admin_bar_fix + ( mcpos === 0 ? 0 : second_row_height - header_height ),
							left: hbox_filler.offset().left,
							width: hbox.outerWidth()
						}).addClass('second-stage-active');
					}
				} else {
					hbox.removeClass('static-absolute second-stage-active').css({
						position: 'fixed',
						top: hbox_filler.offset().top,
						left: hbox_filler.offset().left,
						width: hbox_filler.outerWidth()
					});
				}
			}
		};

		win.bind( 'scroll touchmove', reposition ).smartresize(function() {
			if(win.width() !== win_width) {
				destroy();
				init();
			}
		});

		init();

		win.bind( 'vamtam-rebuild-sticky-header', function() {
			destroy();
			init();
		} );

		// selective refresh support

		var hasSelectiveRefresh = (
			'undefined' !== typeof wp &&
			wp.customize &&
			wp.customize.selectiveRefresh
		);

		if ( hasSelectiveRefresh ) {
			wp.customize.selectiveRefresh.bind( 'partial-content-rendered', function( placement ) {
				if ( placement.partial.id && placement.partial.id === 'header-layout-selective' ) {
					destroy();

					setTimeout( function() {
						init();
					}, 100 );
				}
			} );
		}
	});
})(jQuery);