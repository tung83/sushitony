(function($, undefined) {
	'use strict';

	var transDuration = 700,
		body = $('body'),
		easeOutQuint = function (x, t, b, c, d) {
			return -c * ((t=t/d-1)*t*t*t - 1) + b;
		};

	var doClose = function() {
		if($(this).hasClass('state-closed'))
			return;

		body.unbind('touchstart.portfolio-overlay-close'+$(this).data('id'));

		$(this).addClass('state-closed').removeClass('state-open');

		$('.thumbnail-overlay', this).fadeOut({
			opacity: 0
		}, {
			duration: transDuration,
			easing: easeOutQuint
		});
	};

	var doOpen = function() {
		var self = $(this);
		if(self.hasClass('state-open'))
			return;

		self.addClass('state-open').removeClass('state-closed');

		$('.thumbnail-overlay', this).stop(true, true).fadeIn({
			duration: transDuration,
			easing: 'easeOutQuint'
		});

		if(Modernizr.touchevents) {
			var bodyEvent = 'touchstart.portfolio-overlay-close'+self.data('id');
			body.bind(bodyEvent, function() {
				// console.log('event 2');
				body.unbind(bodyEvent);
				doClose.call(self);
			});
		} else {
			$(this).bind('mouseleave.portfolio-overlay-close', function() {
				// console.log('event 3');
				$(this).unbind('mouseleave.portfolio-overlay-close');
				doClose.call(this);
			});
		}
	};

	$(function() {
		var portfolios = $('.portfolios');

		if(Modernizr.touchevents) {
			var last_touch = 0;

			portfolios.on('click.portfolio-overlay', '.vamtam-project', function() {
				// console.log('event 4');
				doOpen.call(this);
			});

			portfolios.on('click', '.vamtam-project a', function(e) {
				if ( + ( new Date() ) - last_touch < 1000 ) {
					var self = $(this).closest('.portfolios .vamtam-project');

					// console.log('event 5');
					if ( $( self ).hasClass( 'state-closed' ) ) {
						e.preventDefault();
					} else if ( ! ( $( this ).hasClass( 'cbp-lightbox' ) ) ) {
						e.stopPropagation();
					}
				}
			});

			portfolios.on('touchstart', '.vamtam-project a', function(e) {
				var self = $(this).closest('.portfolios .vamtam-project');

				last_touch = + ( new Date() );

				// console.log('event 5.1');
				if(!$(self).hasClass('state-closed')) {
					e.stopPropagation();
				}
			});
		} else {
			portfolios.on('mouseenter', '.vamtam-project', function() {
				// console.log('event 6');
				doOpen.call(this);
			});
		}
	});
})(jQuery);