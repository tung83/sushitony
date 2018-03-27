(function( $, undefined ) {
	"use strict";

	$( function() {
		if ( VAMTAM_HIDDEN_WIDGETS !== undefined && VAMTAM_HIDDEN_WIDGETS.length > 0 ) {
			var width = -1;
			var win = $( window );

			win.smartresize( function() {
				if ( width !== win.width() ) {
					width = win.width();

					for ( var i = 0; i < VAMTAM_HIDDEN_WIDGETS.length; i++ ) {
						$( '#' + VAMTAM_HIDDEN_WIDGETS[i] ).toggleClass( 'hidden', $.VAMTAM.MEDIA.layout["layout-below-max"] );
					}
				}
			} );
		}
	} );
} )( jQuery );