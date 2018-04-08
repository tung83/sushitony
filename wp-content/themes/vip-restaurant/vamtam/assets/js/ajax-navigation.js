(function($, undefined) {
	"use strict";

	$(function() {
		// infinite scrolling
		if($('body').is('.pagination-infinite-scrolling')) {
			var last_auto_load = 0;
			$(window).bind('resize scroll', function(e) {
				var button = $('.lm-btn'),
					now_time = e.timeStamp || (new Date()).getTime();

				if(now_time - last_auto_load > 500 && parseFloat(button.css('opacity'), 10) === 1 && $(window).scrollTop() + $(window).height() >= button.offset().top) {
					last_auto_load = now_time;
					button.click();
				}
			});
		}

		$("body").on("click.pagination", ".load-more", function( e ) {
			e.preventDefault();
			e.stopPropagation(); // customizer support

			var self = $(this);
			var list = self.prev();
			var link = self.find( 'a' );

			if ( self.hasClass( 'loading' ) ) {
				return false;
			}

			self.addClass( 'loading' ).find( '> *' ).animate({opacity: 0});

			$.post( VAMTAM_FRONT.ajaxurl, {
				action: 'vamtam-load-more',
				query: link.data( 'query' ),
				other_vars: link.data( 'other-vars' )
			}, function( result ) {
				var content = $( result.content );

				$( '.wp-audio-shortcode, .wp-video-shortcode', content ).not( '.mejs-container' ).mediaelementplayer();

				var visible = list.find( '.cbp-item:not( .cbp-item-off )' ).length;

				list.cubeportfolio( 'appendItems', content, function() {
					if ( visible === list.find( '.cbp-item:not( .cbp-item-off )' ).length ) {
						var warning = $( '<p />' ).addClass( 'vamtam-load-more-warning' ).text( list.data( 'hidden-by-filters' ) );

						warning.insertAfter( self );

						$( 'body' ).one( 'click', function() {
							warning.remove();
						} );
					}

					self.replaceWith( result.button );

					self.removeClass( 'loading' ).find( '> *' ).animate({opacity: 1});

					$( window ).triggerHandler( 'resize.vamtam-video' );
				} );
			});
		} );
	});
})(jQuery);