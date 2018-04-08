/* jshint esnext:true */

var styles = ( api, $ ) => {
	'use strict';

	var prepare_background = to => {
		if ( to['background-image'] !== '' ) {
			to['background-image'] = 'url(' + to['background-image'] + ')';
		}

		return to;
	};

	api( 'vamtam_theme[top-nav-background]', value => {
		value.bind( to => {
			$( '#top-nav-wrapper, #top-nav-wrapper-filler' ).css( prepare_background( to ) );
		} );
	} );

	{
		const compiler_options = VAMTAM_CUSTOMIZE_PREVIEW.compiler_options;

		for ( let i = 0; i < compiler_options.length; i++ ) {
			api( compiler_options[i], value => {
				value.bind( () => {
					$( 'body' ).addClass( 'customize-partial-refreshing' );
				} );
			} );
		}
	}

	api( 'vamtam_theme[page-title-background-hide-lowres]', value => {
		value.bind( to => {
			$( 'header.page-header' ).toggleClass( 'vamtam-hide-bg-lowres', to );
		} );
	} );

	api( 'vamtam_theme[main-background-hide-lowres]', value => {
		value.bind( to => {
			$( '.vamtam-main' ).toggleClass( 'vamtam-hide-bg-lowres', to );
		} );
	} );

	api( 'vamtam_theme[footer-background-hide-lowres]', value => {
		value.bind( to => {
			$( 'footer.main-footer, .vamtam-subfooter' ).toggleClass( 'vamtam-hide-bg-lowres', to );
		} );
	} );

	api( 'vamtam_theme[subfooter-background]', value => {
		value.bind( to => {
			$( '.vamtam-subfooter' ).css( prepare_background( to ) );
		} );
	} );

	api( 'vamtam_theme[footer-background]', value => {
		value.bind( to => {
			$( 'footer.main-footer' ).css( prepare_background( to ) );
		} );
	} );

	var compile_local_css = ( el, source, accents ) => {
		$.ajax({
			type: 'POST',
			url: VAMTAM_CUSTOMIZE_PREVIEW.ajaxurl,
			data: {
				action: 'vamtam-compile-local-css',
				source: source,
				accents: accents
			},
			success: function( result ) {
				$( el ).replaceWith( result );
			}
		});
	};

	api( 'vamtam_theme[accent-color]', value => {
		value.bind( to => {
			$( '[data-vamtam-less-source]' ).each( ( i, el ) => {
				compile_local_css( el, el.dataset.vamtamLessSource, to );
			} );
		} );
	} );
};

export default styles;
