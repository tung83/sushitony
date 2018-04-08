/* jshint esnext:true */

import { toggle } from './helpers';

var layout = ( api, $ ) => {
	'use strict';

	api( 'vamtam_theme[full-width-header]', value => {
		value.bind( to => {
			$( '.header-maybe-limit-wrapper' ).toggleClass( 'limit-wrapper', to );
		} );
	} );

	api( 'vamtam_theme[sticky-header]', value => {
		value.bind( to => {
			$( 'body' ).removeClass( 'had-sticky-header' ).toggleClass( 'sticky-header', +to );

			setTimeout( () => {
				$( window ).triggerHandler( 'vamtam-rebuild-sticky-header' );
			}, 50 );
		} );
	} );

	api( 'vamtam_theme[enable-header-search]', value => {
		value.bind( to => {
			toggle( $( 'header.main-header .search-wrapper' ), + to );
		} );
	} );

	{
		let widget_areas = VAMTAM_CUSTOMIZE_PREVIEW.hf_sidebars;
		let all_classes = 'full cell-1-1 cell-1-2 cell-1-3 cell-1-4 cell-1-5 cell-1-6 cell-2-3 cell-3-4 cell-2-5 cell-3-5 cell-4-5 cell-5-6';

		let resize_widget_areas = ( wrapper, location ) => {
			let old_rows = wrapper.find( '> .row' );

			let areas = wrapper.find( 'aside' );

			let current_row = $( '<div class="row"></div>' );

			wrapper.append( current_row );

			let row_width = 0;

			areas.each( ( i, area ) => {
				area = $( area );

				let id = + ( area.data( 'id' ) );

				area.removeClass( all_classes ).addClass( widget_areas[ location ][ id ] );

				let width_num = widget_areas[ location ][ id ].split( '-' );
				width_num = width_num[1] / width_num[2];

				row_width += width_num;

				if ( row_width > 1 ) {
					current_row = $( '<div class="row"></div>' );

					wrapper.append( current_row );

					row_width = width_num;
				}

				area.appendTo( current_row );
			} );

			old_rows.remove();

			setTimeout( () => {
				$( window ).triggerHandler( 'resize.vamtam-equal-heights-full' );
			}, 50 );
		};

		for ( let i = 1; i <= 8; i++ ) {
			api( 'vamtam_theme[header-sidebars-' + i + '-width]', value => {
				value.bind( to => {
					widget_areas.header[i] = to;

					resize_widget_areas( $( '#header-sidebars' ), 'header' );
				} );
			} );

			api( 'vamtam_theme[footer-sidebars-' + i + '-width]', value => {
				value.bind( to => {
					widget_areas.footer[i] = to;

					resize_widget_areas( $( '#footer-sidebars' ), 'footer' );
				} );
			} );
		}
	}

	api( 'vamtam_theme[one-page-footer]', value => {
		value.bind( to => {
			toggle( $( '.footer-wrapper' ), to );

			setTimeout( function() {
				$( window ).triggerHandler( 'resize.vamtam-footer' );
			}, 50 );
		} );
	} );

	api( 'vamtam_theme[page-title-layout]', value => {
		value.bind( to => {
			var header = $( 'header.page-header' );
			var line   = header.find( '.page-header-line' );

			header
				.removeClass( 'layout-centered layout-one-row-left layout-one-row-right layout-left-align layout-right-align' )
				.addClass( 'layout-' + to );

			if ( to.match( /one-row-/ ) ) {
				line.appendTo( header.find( 'h1' ) );
			} else {
				line.appendTo( header );
			}
		} );
	} );

	api( 'vamtam_theme[sticky-footer]', value => {
		value.bind( to => {
			$( 'body' ).toggleClass( 'sticky-footer', +to );

			setTimeout( () => {
				$( window ).triggerHandler( 'resize.vamtam-footer' );
			}, 50 );
		} );
	} );

	api( 'vamtam_theme[full-width-footer]', value => {
		value.bind( to => {
			$( 'footer.main-footer > div' ).toggleClass( 'limit-wrapper', to );
		} );
	} );

	api( 'vamtam_theme[full-width-subfooter]', value => {
		value.bind( to => {
			$( '.vamtam-subfooter > div' ).toggleClass( 'limit-wrapper', to );
		} );
	} );
};

export default layout;
