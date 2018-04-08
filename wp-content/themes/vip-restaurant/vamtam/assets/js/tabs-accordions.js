(function($, undefined) {
	"use strict";

	$(function() {

		var has_customize = 'undefined' !== typeof wp && 'customize' in wp;

		if ( 'tabs' in $.fn ) {
			$( '.vamtam-tabs' ).tabs({
				beforeLoad: function() {
					if ( has_customize ) {
						return false;
					}
				},
				activate: function( event, ui ) {
					if ( ! has_customize ) {
						var hash = ui.newTab.context.hash;
						var element = $(hash);
						element.attr('id', '');
						window.location.hash = hash;
						element.attr('id', hash.replace('#', ''));
					}
				},
				heightStyle: 'content'
			});
		}

		if ( 'accordion' in $.fn ) {
			$('.vamtam-accordion').accordion({
				heightStyle: 'content'
			}).each(function() {
				if ( $( this ).attr( 'data-collapsible' ) === 'true' ) {
					$( this ).accordion( 'option', 'collapsible', true ).accordion( 'option', 'active', false );
				}
			});
		}

	});

})(jQuery);
