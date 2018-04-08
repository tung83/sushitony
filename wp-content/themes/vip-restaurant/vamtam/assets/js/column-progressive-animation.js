( function( $, undefined ) {
	'use strict';

	var win = $( window );
	var win_height = win.height();

	var cpos = -1;
	var prev_scroll;

	var columns = $( '[data-progressive-animation]' );

	var blocked = false;

	var build_timeline = function( type, target ) {
		var timeline = new vamtamgs.TimelineLite( { paused: true } );

		if ( type === 'fade-top' ) {
			timeline.fromTo( target, 1, { y: 0, opacity: 1 }, { y: -20, opacity: 0 }, '0' );
		} else if ( type === 'fade-bottom' ) {
			timeline.fromTo( target, 1, { y: 0, opacity: 1 }, { y: 500, opacity: 0 }, '0' );
		} else if ( type === 'page-title' ) {
			var line = target.find( '.page-header-line' );

			timeline.fromTo( target.find( 'h1' ), 1, { y: 0, opacity: 1 }, { y: -10, opacity: 0, ease: vamtamgs.Quad.easeIn }, '0.1' );
			timeline.fromTo( target.find( '.desc' ), 1, { y: 0, opacity: 1 }, { y: 30, opacity: 0, ease: vamtamgs.Quad.easeIn }, '0' );
			timeline.fromTo( target.closest( '#sub-header' ).find( '.text-shadow' ), 1, { opacity: 0.3 }, { opacity: 0.7, ease: vamtamgs.Quad.easeIn }, '0' );
			timeline.to( line, 1, { width: 0, y: 30, opacity: 0, ease: vamtamgs.Quad.easeIn }, '0' );
		} else if ( type === 'custom' ) {
			timeline.to( target, 1, { className: target.data( 'progressive-animation-custom' ) }, '0' );
		}

		return timeline;
	};

	var repaint = function() {
		blocked = true;

		columns.each( function() {
			var col = $( this );

			var data = col.data( 'progressive-timeline' );

			var from = data.top + data.height / 2;

			var progress = 1 - ( ( from - cpos ) / Math.min( win_height / 2, from ) );

			progress = Math.min( 1, Math.max( 0, progress ) ); // clip

			data.timeline.progress( progress );
		} );

		blocked = false;
	};

	var reposition = function() {
		cpos = window.pageYOffset;

		if ( cpos !== prev_scroll ) {
			repaint();

			prev_scroll = cpos;
		}
	};

	if ( columns.length ) {
		vamtam_greensock_wait( function() {
			columns.each( function() {
				var col = $( this );

				col.data( 'progressive-timeline', {
					timeline: build_timeline( col.data( 'progressive-animation' ), col ),
					top: col.offset().top,
					height: col.height()
				} );
			} );

			var maybe_reposition = _.throttle( function() {
				if ( ! blocked ) {
					requestAnimationFrame( reposition );
				}
			}, 16 );

			win.scroll( maybe_reposition );

			maybe_reposition();

			win.smartresize( function() {
				win_height = win.height();

				columns.each( function() {
					var col = $( this );

					var data = col.data( 'progressive-timeline' );

					if ( data ) {
						data.timeline.progress( 0 );

						var modified_data = {
							timeline: data.timeline,
							top: col.offset().top,
							height: col.height()
						};

						col.data( 'progressive-timeline', modified_data );
					}
				} );

				requestAnimationFrame( repaint );
			} );
		} );
	}

} )( jQuery );