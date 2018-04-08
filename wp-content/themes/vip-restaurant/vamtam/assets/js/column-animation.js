( function( $, undefined ) {
	'use strict';

	var win = $( window ),
		win_height = 0;

	var explorer = /MSIE (\d+)/.exec( navigator.userAgent ),
		mobileSafari = navigator.userAgent.match( /(iPod|iPhone|iPad)/ ) && navigator.userAgent.match( /AppleWebKit/ );

	win.resize(function() {
		win_height = win.height();

		if (
			( explorer && parseInt( explorer[1], 10 ) === 8 ) ||
			mobileSafari ||
			$.VAMTAM.MEDIA.layout['layout-below-max']
		) {
			$( '.vamtam-grid.animated-active' ).removeClass( 'animated-active' ).addClass( 'animated-suspended' );
		} else {
			$( '.vamtam-grid.animated-suspended' ).removeClass( 'animated-suspended' ).addClass( 'animated-active' );
		}
	}).resize();

	var maybe_activate = _.throttle( function() {
		var win_height = win.height();
		var all_in = $(window).scrollTop() + win_height;

		$( '.vamtam-grid.animated-active:not(.animation-ended)' ).each( function() {
			var el = $( this );
			var el_height = el.outerHeight();
			var visible   = all_in > el.offset().top + el_height * ( el_height > 100 ? 0.3 : 0.6 );

			if ( visible || mobileSafari ) {
				el.addClass( 'animation-ended' );
			} else {
				return false;
			}
		} );
	}, 100 );

	win.bind( 'scroll touchmove load', maybe_activate );

	maybe_activate();
} )( jQuery );