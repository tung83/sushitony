(function($, undefined) {
	"use strict";

	var win = $(window),
		win_height = win.height(),
		columns;

	var cpos = window.pageYOffset;
	var prev_scroll = -1;

	var new_pos = function(method, top, inertia, height) {
		if ( 'to-centre' === method ) {
			return ( top + height / 2 - cpos - win_height / 2 ) * inertia;
		}

		if ( 'fixed' === method ) {
			return (cpos - top) * inertia;
		}
	};

	var measure_columns = function() {
		columns.each(function() {
			var t = $(this);

			$(this).data( 'parallax-column-top', t.offset().top );
			$(this).data( 'parallax-column-height', t.outerHeight() );
		});
	};

	var blocked = false;

	var repaint_parallax = function() {
		blocked = true;

		var all_visible = cpos + win_height;
		var move = [];

		// measure
		columns.each(function() {
			var column = $(this);

			var top    = column.data( 'parallax-column-top' ),
				height = column.data( 'parallax-column-height' ),
				fakebg = column.data( 'parallax-img' );

			if ( top + height < cpos || top > all_visible || ! fakebg.length ) {
				return;
			}

			var inertia = column.data('parallax-inertia');
			var method  = column.data('parallax-method');
			var new_y   = new_pos(method, top, inertia, height);

			move.push( [ fakebg, new_y ] );
		});

		var ml = move.length;

		// then mutate
		if ( ml > 0 ) {
			for ( var i = 0; i < ml; i++ ) {
				vamtamgs.TweenLite.to( move[i][0], 0, { y: move[i][1] } );
			}
		}

		blocked = false;
	};

	win.bind( 'vamtam-force-parallax-repaint', repaint_parallax );

	var reposition = function() {
		if ( cpos !== prev_scroll ) {
			repaint_parallax( cpos );

			prev_scroll = cpos;
		}

		// requestAnimationFrame( reposition );
	};

	var bgprops = 'position image color size attachment'.split(' ');

	$(function() {
		$('.vamtam-grid.parallax-bg:not(.parallax-loaded)').each(function() {
			var self = $(this);

			var local_bgprops = {};
			$.each(bgprops, function(i, p) {
				local_bgprops['background-'+p] = self.css('background-'+p);
			});

			local_bgprops['background-repeat'] = 'no-repeat';

			self.addClass('parallax-loaded').wrapInner(function() {
				return $('<div></div>').addClass('vamtam-parallax-bg-content');
			}).prepend(function() {
				var outer_div = $( '<div></div>' ).addClass( 'vamtam-parallax-bg-wrapper' ).append( function() {
					var div = $('<div></div>')
						.addClass('vamtam-parallax-bg-img')
						.css(local_bgprops);

					self.data( 'parallax-img', div );

					return div;
				} );

				return outer_div;
			}).css('background', '');
		});

		columns = $( '.vamtam-grid.parallax-bg' );

		if ( columns.length > 0 ) {
			win.smartresize( measure_columns );

			measure_columns();

			vamtam_greensock_wait( function() {
				var maybe_reposition = _.throttle( function() {
					cpos = window.pageYOffset;

					if ( ! blocked ) {
						requestAnimationFrame( reposition );
					}
				}, 16 );

				win.scroll( maybe_reposition );

				maybe_reposition();

				win.smartresize(function() {
					win_height = win.height();

					if (
						! Modernizr.csscalc ||
						! ( 'requestAnimationFrame' in window ) ||
						$.VAMTAM.MEDIA.is_mobile() ||
						$.VAMTAM.MEDIA.layout["layout-below-max"]
					) {
						$('.vamtam-grid.parallax-bg').removeClass('parallax-bg').addClass('parallax-bg-suspended');
						$('.vamtam-parallax-bg-img').css({
							'background-position': '50% 50%'
						});
					} else {
						$('.vamtam-grid.parallax-bg-suspended').removeClass('parallax-bg-suspended').addClass('parallax-bg');
					}
				});
			} );
		}
	});

})(jQuery);