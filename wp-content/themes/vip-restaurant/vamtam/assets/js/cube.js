( function( $, undefined ) {
	'use strict';

	$(function() {
		var win = $(window);

		var cube_single_page = {
			portfolio: function( url ) {
				var t = this;

				$.ajax({
					url: url,
					type: 'GET',
					dataType: 'html'
				})
				.done(function(result) {
					t.updateSinglePage(result);

					$( document ).trigger( 'vamtam-attempt-cube-load' );

					$( document ).trigger( 'vamtam-single-page-project-loaded' );
				})
				.fail(function() {
					t.updateSinglePage('AJAX Error! Please refresh the page!');
				});
			}
		};

		var cube_narrow = function( el ) {
			var inner = el.find( '.cbp-wrapper' );
			var outer = el.find( '.cbp-wrapper-outer' );

			if ( inner.width() <= outer.width() ) {
				el.addClass( 'vamtam-cube-narrow' );
			} else {
				el.removeClass( 'vamtam-cube-narrow' );
			}
		};

		$( document ).bind( 'vamtam-attempt-cube-load', function() {
			$( '.vamtam-cubeportfolio[data-options]:not(.vamtam-cube-loaded)' ).each( function() {
				var self    = $( this );
				var options = self.data( 'options' );

				if ( 'singlePageCallback' in options ) {
					options.singlePageCallback = cube_single_page[ options.singlePageCallback ];
				}

				self.bind( 'initComplete.cbp', function() {
					if ( 'slider' === options.layoutMode ) {
						cube_narrow( self );

						win.bind( 'resize.vamtamcube', function() {
							cube_narrow( self );
						} );
					}
				} );

				self.addClass( 'vamtam-cube-loaded' ).cubeportfolio( options );

				self.on( 'vamtam-video-resized', 'iframe, object, embed, video', function() {
					self.data('cubeportfolio').layoutAndAdjustment();
				} );
			} );
		} );

		$( document ).trigger( 'vamtam-attempt-cube-load' );
	});
} )( jQuery );