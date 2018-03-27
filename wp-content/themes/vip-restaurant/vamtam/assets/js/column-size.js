( function( $, undefined ) {
	'use strict';

	$(function() {
		var body = $('body');
		var admin_bar_fix = body.hasClass('admin-bar') ? 32 : 0;
		var win = $(window);

		win.smartresize(function() {
			var header_fix = body.hasClass( 'sticky-header' ) && body.hasClass( 'no-sticky-header-animation' ) ? $( 'header.main-header' ).height() : 0;
			var wheight = win.height() - admin_bar_fix - header_fix;

			// var header_fix = body.hasClass( 'sticky-header' ) ? $( 'header.main-header' ).height() : 0;

			if ( $.VAMTAM.MEDIA.layout["layout-below-max"] ) {
				$('.vamtam-grid[data-padding-top]').each(function() {
					this.style.paddingTop = '100px';
				});

				$('.vamtam-grid[data-padding-bottom]').each(function() {
					this.style.paddingBottom = '100px';
				});
			} else {
				$('.vamtam-grid[data-padding-top]:not([data-padding-bottom])').each(function() {
					var col = $(this);

					col.css('padding-top', 0);
					col.css('padding-top', wheight - col.outerHeight() + parseInt(col.data('padding-top'), 10));
				});

				$('.vamtam-grid[data-padding-bottom]:not([data-padding-top])').each(function() {
					var col = $(this);

					col.css('padding-bottom', 0);
					col.css('padding-bottom', wheight - col.outerHeight() + parseInt(col.data('padding-bottom'), 10));
				});

				$('.vamtam-grid[data-padding-top][data-padding-bottom]').each(function() {
					var col = $(this);

					col.css('padding-top', 0);
					col.css('padding-bottom', 0);

					var new_padding = (wheight - col.outerHeight() + parseInt(col.data('padding-top'), 10))/2;

					col.css({
						'padding-top': new_padding,
						'padding-bottom': new_padding
					});
				});
			}

			requestAnimationFrame( function() {
				body.trigger('vamtam-content-resized');
				win.trigger( 'vamtam-force-parallax-repaint' );
			} );
		});
	});
} )( jQuery );