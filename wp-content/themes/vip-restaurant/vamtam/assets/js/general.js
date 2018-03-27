/* jshint multistr:true */
(function() {
	"use strict";

	jQuery.VAMTAM = jQuery.VAMTAM || {}; // Namespace

	(function ($, undefined) {
		var J_WIN     = $(window);

		$(function () {
			if(top !== window && /vamtam\.com/.test(document.location.href)) {
				var width = 0;

				setInterval(function() {
					if($(window).width() !== width) {
						$(window).resize();
						setTimeout(function() { $(window).resize(); }, 100);
						setTimeout(function() { $(window).resize(); }, 200);
						setTimeout(function() { $(window).resize(); }, 300);
						setTimeout(function() { $(window).resize(); }, 500);
						width = $(window).width();
					}
				}, 200);
			}

			var body = $('body');

			if ( body.is( '.responsive-layout' ) ) {
				J_WIN.triggerHandler('resize.sizeClass');
			}

			(function() {
				var box = $('.boxed-layout'),
					timer;

				$(window).scroll( _.throttle( function(e) {
					clearTimeout(timer);

					if (!box.hasClass('disable-hover') && e.target === document) {
						box.addClass('disable-hover');
					}

					timer = setTimeout(function() {
						box.removeClass('disable-hover');
					}, 500);
				}, 300 ) );
			})();

			J_WIN.bind('resize.vamtam-footer', function() {
				requestAnimationFrame( function() {
					var footer = document.querySelector( '.footer-wrapper' );

					footer.style.bottom = '0px';

					if ( ! document.body.classList.contains( 'boxed' ) && document.body.classList.contains( 'sticky-footer' ) && ! $.VAMTAM.MEDIA.layout["layout-below-max"] ) {
						document.getElementById( 'main-content' ).style['margin-bottom'] = footer.offsetHeight + 'px';
					} else {
						document.getElementById( 'main-content' ).style['margin-bottom'] = '0px';
					}
				} );
			}).triggerHandler("resize.vamtam-footer");

			// Video resizing
			// =====================================================================
			J_WIN.bind('resize.vamtam-video load.vamtam-video', function() {
				$('.portfolio-image-wrapper,\
					.boxed-layout .media-inner,\
					.boxed-layout .loop-wrapper.news .thumbnail,\
					.boxed-layout .portfolio-image .thumbnail,\
					.boxed-layout .vamtam-video-frame').find('iframe, object, embed, video').each(function() {
					var v = $(this);

					if(v.prop('width') === '0' && v.prop('height') === '0') {
						v.css({width: '100%'}).css({height: v.width()*9/16});
					} else {
						v.css({height: v.prop('height')*v.width()/v.prop('width')});
					}

					v.trigger('vamtam-video-resized');
				});

				setTimeout(function() {
					$('.mejs-time-rail').css('width', '-=1px');
				}, 100);
			}).triggerHandler("resize.vamtam-video");

			if('mediaelementplayer' in $.fn) {
				$('.vamtam-background-video').mediaelementplayer({
					videoWidth: '100%',
					videoHeight: '100%',
					loop: true,
					enableAutosize: true,
					features: []
				});
			}

			$('.vamtam-grid.has-video-bg').addClass('video-bg-loaded');

			// Animated buttons
			// =====================================================================
			$(document).on('mouseover focus click', '.animated.flash, .animated.wiggle', function() {
				$(this).removeClass('animated');
			});

			// Tooltip
			// =====================================================================
			var tooltip_animation = 250;
			$('.shortcode-tooltip').hover(function () {
				var tt = $(this).find('.tooltip').fadeIn(tooltip_animation).animate({
					bottom: 25
				}, tooltip_animation);
				tt.css({ marginLeft: -tt.width() / 2 });
			}, function () {
				$(this).find('.tooltip').animate({
					bottom: 35
				}, tooltip_animation).fadeOut(tooltip_animation);
			});

			$('.sitemap li:not(:has(.children))').addClass('single');

			// Scroll to top button
			// =====================================================================

			if ( $('#scroll-to-top').length > 0 ) {
				$(window).bind('resize scroll', _.debounce( function() {
					$('#scroll-to-top').toggleClass("visible", window.pageYOffset > 0);
				}, 500 ) );
			}

			$('#scroll-to-top, .vamtam-scroll-to-top').click(function (e) {
				$('html,body').animate({
					scrollTop: 0
				}, 300);

				e.preventDefault();
			});

		});

		$('#feedback.slideout').click(function(e) {
			$(this).parent().toggleClass("expanded");
			e.preventDefault();
		});

		J_WIN.triggerHandler('resize.sizeClass');

		$(window).bind("load", function() {
			setTimeout(function() {
				$(window).trigger("resize");
			}, 1);
		});

	})(jQuery);

})();