(function($, undefined) {
	"use strict";

	$(function() {
		var win        = $(window),
			win_height = 0,
			cpos       = 0,
			singlecpos = 0;

		var mobileSafari = navigator.userAgent.match(/(iPod|iPhone|iPad)/) && navigator.userAgent.match(/AppleWebKit/);

		var init = function() {
			$( '.vamtam-progress.pie:not(.started)' ).off( 'vamtam-progress-visible' ).one( 'vamtam-progress-visible', function() {
				$(this).addClass('started').easyPieChart({
					animate: 1000,
					scaleLength: 0,
					lineWidth: 3,
					size: 130,
					lineCap: 'square',
					onStep: function(from, to, value) {
						$(this.el).find('span:not(.icon):first').text(~~value);
					}
				});
			});

			$( '.vamtam-progress.number:not(.started)' ).each(function() {
				$(this).off( 'vamtam-progress-visible' ).one( 'vamtam-progress-visible', function() {
					$(this).addClass('started').vamtamAnimateNumber({
						onStep: function(from, to, value) {
							$(this).find('span:not(.icon):first').text(~~value);
						}
					});
				});
			});
		};

		var activate = function( single, pos ) {
			win_height = win.height();

			var all_in = single ? win_height : pos + win_height;

			$('.vamtam-progress:not(.started)').each(function() {
				var el_height = $(this).outerHeight();
				var visible   = all_in > $(this).offset().top + el_height * ( el_height > 100 ? 0.3 : 0.6 );

				if ( visible || mobileSafari ) {
					$(this).trigger('vamtam-progress-visible');
				}
			});
		};

		var maybe_activate = function() {
			var single = $( '.cbp-popup-singlePage' );
			var new_cpos;

			if ( single.length ) {
				new_cpos = single.scrollTop();

				if ( new_cpos !== singlecpos ) {
					singlecpos = new_cpos;

					activate( true, singlecpos );
				}
			} else {
				new_cpos = win.scrollTop();

				if ( new_cpos !== cpos ) {
					cpos = new_cpos;

					activate( false, cpos );
				}
			}

			requestAnimationFrame( maybe_activate );
		};

		init();

		win.imagesLoaded(function() {
			setTimeout(function() {
				if ( $( '.vamtam-progress' ).length > 0 ) {
					requestAnimationFrame( maybe_activate );
				}
			}, 1000);
		});

		$( document ).bind( 'vamtam-single-page-project-loaded', function() {
			singlecpos = 0;

			setTimeout( function() {
				init();

				if ( $( '.vamtam-progress' ).length > 0 ) {
					requestAnimationFrame( maybe_activate );

					requestAnimationFrame( function() {
						activate( true, $( '.cbp-popup-singlePage' ).scrollTop() );
					} );
				}
			}, 500 );
		} );
	});

})(jQuery);