(function($, undefined) {
	'use strict';

	$( function() {
		var elements;

		var group_elements = function() {
			elements = [];

			$( ".row:has(> div.has-background)" ).each( function( i, row_el ) {
				var row = $( row_el ),
					columns = row.find( '> div' );

				if ( columns.length > 1 ) {
					row.addClass( 'has-nomargin-column' );
					elements.push( columns );
				}
			});

			$( ".row:has(> div > .linkarea)" ).each( function( i, row_el ) {
				var row = $( row_el ),
					columns = row.find( '> div > .linkarea' );

				if ( columns.length > 1 ) {
					elements.push( columns );
				}
			});

			$( ".row:has(> div > .services.has-more)" ).each( function( i, row_el ) {
				var row = $( row_el ),
					columns = row.find( '> div > .services.has-more > .closed' );

				if ( columns.length > 1 ) {
					elements.push( columns );
				}

				var open = row.find( '> div > .services.has-more > .open' );

				if ( Modernizr.touchevents && open.length > 1 ) {
					elements.push( open );
				}
			});

			$( '#footer-sidebars .row' ).each( function() {
				elements.push( $(this).find('aside') );
			});
		};

		group_elements();

		var fix_heights = _.throttle( function() {
			var i;
			if ( $.VAMTAM.MEDIA.layout['layout-below-max'] ) {
				for ( i = 0; i < elements.length; ++i ) {
					elements[i].matchHeight( 'remove' );
				}
			} else {
				for ( i = 0; i < elements.length; ++i ) {
					elements[i].matchHeight( {
						byRow: false,
						property: 'min-height'
					} );
				}
			}
		}, 600 );

		$(window).bind( 'resize.vamtam-equal-heights-full', function() {
			group_elements();
			fix_heights();
		} );
		$(window).bind( 'resize.vamtam-equal-heights', fix_heights );

		if ( 'undefined' !== typeof wp && wp.customize && wp.customize.selectiveRefresh  ) {
			wp.customize.selectiveRefresh.bind( 'sidebar-updated', function() {
				fix_heights();
			} );
		}

		// deal with desktop safari's issues
		if ( 'vendor' in navigator && navigator.vendor.match( /Apple Computer, Inc./ ) && ! navigator.userAgent.match( /(iPod|iPhone|iPad)/ ) ) {
			setInterval( function() {
				fix_heights();
			}, 1000 );
		}
	} );
})(jQuery);