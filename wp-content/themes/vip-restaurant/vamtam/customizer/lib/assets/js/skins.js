/*
 VamTam Skins
 */

/*global jQuery, document */

(function( $ ) {
	'use strict';

	wp.customize.controlConstructor['vamtam-skins'] = wp.customize.Control.extend({

		decode_html: function( html ) {
			var txt = document.createElement("textarea");
			txt.innerHTML = html;
			return txt.value;
		},

		// handles automatic nonce renewal on each response
		request: function( data, callback ) {
			var control = this;

			data.nonce   = control.params.nonce;
			data.action  = 'vamtam-customizer-control';
			data.control = 'skins';

			$.post(ajaxurl, data, function( result ) {
				if ( $.isNumeric( result ) || ! ( 'nonce' in result ) ) {
					alert( control.decode_html( control.params.l10n.auth_expired ) );
					return;
				}

				if ( 'data' in result ) {
					callback( result.data );
				}

				control.params.nonce = result.nonce;
			});
		},

		load_available: function() {
			var control = this;

			control.request( {
				method: 'available',
				prefix: control.params.prefix
			}, function( data ) {
				$( '#import-config-available', control.container ).html(data);
			} );
		},

		show_spinner: function() {
			var control = this;

			control.spinner = $( '.spinner', control.container ).css({
				display: 'inline-block',
				visibility: 'visible'
			});
		},

		show_result: function( result ) {
			var control = this;

			console.log( control );

			control.load_available();

			control.spinner.hide();

			$( '.result', control.container ).html( result );

			setTimeout(function() {
				$( '.result', control.container ).fadeOut('fast', function() {
					$(this).html('').show();
				});
			}, 3000);
		},

		remove: function( name ) {
			var control = this;

			control.show_spinner();

			control.request( {
				method: 'delete',
				file: name
			}, function( result ) {
				control.show_result( result );
			} );
		},

		save: function( name ) {
			var control = this;

			if (!name.match(/^\s*$/)) {
				control.show_spinner();

				control.request( {
					method: 'save',
					file: name
				}, function( result ) {
					control.show_result( result );
				} );
			}
		},

		load: function( name ) {
			var control = this;

			control.show_spinner();

			$( 'body' ).append( $( '<div></div>').css( {
				position: 'fixed',
				top: 0,
				right: 0,
				bottom: 0,
				left: 0,
				'z-index': 1000000,
				background: 'rgba( 0, 0, 0, 0.2 )'
			} ) );

			control.request( {
				method: 'import',
				file: name
			}, function( result ) {
				control.show_result( result );

				window.onbeforeunload = null;

				setTimeout(function() {
					window.location.reload();
				}, 500);
			} );
		},

		ready: function() {
			var control = this;

			if ( control.container ) {
				control.load_available();

				$( '#export-config', control.container ).click( function() {
					var name = $( '#export-config-name', control.container ).val().replace(/^\s+/, '').replace(/\s+$/, '');

					if ( name.length ) {
						control.save( control.params.prefix + '_' + name );
					}
				} );

				$( '#delete-config', control.container ).click(function() {
					var skin_name = $( '#import-config-available :selected', control.container ).text();

					if ( ! $( '#import-config-available', control.container ).val().match( /^\s+$/ ) && window.confirm( control.decode_html( control.params.l10n.delete_confirm.replace( '%s', skin_name ) ) ) ) {
						control.remove( control.params.prefix + '_' + skin_name );
					}
				});

				$( '#import-config', control.container ).click(function() {
					var skin_name = $( '#import-config-available :selected', control.container ).text();

					if ( window.confirm( control.decode_html( control.params.l10n.import_confirm.replace( '%s', skin_name ) ) ) ) {
						control.load( control.params.prefix + '_' + skin_name );
					}
				});
			}
		}
	});
})( jQuery );