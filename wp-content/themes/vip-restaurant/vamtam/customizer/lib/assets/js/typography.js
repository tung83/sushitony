/* global VAMTAM_ALL_FONTS */
(function( $, undefined ) {
	'use strict';

	wp.customize.controlConstructor['vamtam-typography'] = wp.customize.Control.extend({
		ready: function() {
			var control               = this,
			    fontFamilySelector    = control.selector + ' .font-family select',
			    variantSelector       = control.selector + ' .variant select',
			    value = {},
			    picker;

			// Make sure everything we're going to need exists.
			_.each( control.params['default'], function( defaultParamValue, param ) {
				if ( false !== defaultParamValue ) {
					value[ param ] = defaultParamValue;
					if ( undefined !== control.setting._value[ param ] ) {
						value[ param ] = control.setting._value[ param ];
					}
				}
			});

			_.each( control.setting._value, function( subValue, param ) {
				if ( undefined === value[ param ] || 'undefined' === typeof value[ param ] ) {
					value[ param ] = subValue;
				}
			});

			// Renders and refreshes selectize sub-controls.
			var renderVariants = function( fontFamily, exactValue ) {
				var subEl = $( variantSelector );

				var prev_value = exactValue || subEl.val();

				subEl.empty();

				// Get all items in the sub-list for the active font-family.
				_.each( VAMTAM_ALL_FONTS, function( font ) {
					// Find the font-family we've selected in the global array of fonts.
					if ( fontFamily === font.family ) {
						for ( var weight in font.weights ) {
							var option = $( '<option>' );

							option.text( font.weights[ weight ] );

							subEl.append( option );
						}
					}
				});

				subEl.val( prev_value || 'normal' );
			};

			$( fontFamilySelector ).val( control.setting._value['font-family'] );

			// Render the variants
			// Please note that when the value of font-family changes,
			// this will be destroyed and re-created.
			renderVariants( value['font-family'], value.variant );

			this.container.on( 'change', '.font-family select', function() {
				// Add the value to the array and set the setting's value
				value['font-family'] = jQuery( this ).val();
				control.saveValue( value );

				// Trigger changes to variants
				renderVariants( jQuery( this ).val(), null );
			});

			this.container.on( 'change', '.variant select', function() {
				// Add the value to the array and set the setting's value
				value.variant = jQuery( this ).val();
				control.saveValue( value );
			});

			this.container.on( 'change keyup paste', '.font-size input', function() {
				// Add the value to the array and set the setting's value
				value['font-size'] = jQuery( this ).val() + control.params.unit;
				control.saveValue( value );
			});

			this.container.on( 'change keyup paste', '.line-height input', function() {
				// Add the value to the array and set the setting's value

				value['line-height'] = jQuery( this ).val() + control.params.unit;
				control.saveValue( value );
			});

			picker = this.container.find( '.kirki-color-control' );

			// Change color
			picker.wpColorPicker({
				change: function() {
					setTimeout( function() {
						// Add the value to the array and set the setting's value
						value.color = picker.val();
						control.saveValue( value );
					}, 100 );
				}
			});

		},

		/**
		 * Saves the value.
		 */
		saveValue: function( value ) {
			var control  = this,
			    newValue = {};

			_.each( value, function( newSubValue, i ) {
				newValue[ i ] = newSubValue;
			});

			control.setting.set( newValue );
		}

	});
})(jQuery);