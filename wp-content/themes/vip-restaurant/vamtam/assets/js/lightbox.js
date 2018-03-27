(function($, undefined) {
	"use strict";

	$(function() {
		var lightbox = $( '#vamtam-overlay-search' );
		var inside   = lightbox.find( '> *' ).hide();

		$('.vamtam-overlay-search-trigger').click(function(e) {
			e.preventDefault();

			lightbox.addClass( 'vamtam-animated vamtam-fadein' ).show();

			setTimeout( function() {
				inside.show().css( 'animation-duration', '300ms' ).addClass( 'vamtam-animated vamtam-zoomin' );

				lightbox.find( 'input[type=search]' ).focus();
			}, 200 );
		});

		$('#vamtam-overlay-search-close').click( function(e) {
			e.preventDefault();

			lightbox.removeClass( 'vamtam-animated vamtam-fadein' ).addClass( 'vamtam-animated vamtam-fadeout' );
			inside.removeClass( 'vamtam-animated vamtam-zoomin' ).addClass( 'vamtam-animated vamtam-zoomout' );

			lightbox.one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function() {
				lightbox.hide().removeClass( 'vamtam-animated vamtam-fadeout' );
				inside.hide().removeClass( 'vamtam-animated vamtam-zoomout' );
			} );
		} );
	});
})(jQuery);