(function($, undefined) {
	"use strict";

	var use3d = Modernizr.csstransforms3d;

	var logError = function( message ) {
		if ( 'console' in window ) {
			console.error( message );
		}
	};

	jQuery.easing.vamtamsin = function(p, n, firstNum, diff) {
		return Math.sin(p * Math.PI / 2) * diff + firstNum;
	};

	jQuery.easing.vamtamcos = function(p, n, firstNum, diff) {
		return firstNum + diff - Math.cos(p * Math.PI / 2) * diff;
	};


	$.VAMTAM.expandable = function(el, options) {
		el = $(el);

		var self = this,
			open = el.find('>.open'),
			closed = el.find('>.closed');

		var getOheight = function( open ) {
			var oheight = open.outerHeight();

			if ( ! oheight ) {
				open.css( { height: 'auto' } );
				oheight = open.outerHeight();
				open.css( { height: 0 } );
			}

			return oheight;
		};

		var getDuration = function( oheight ) {
			var duration = $.VAMTAM.MEDIA.layout['layout-below-max'] ? Math.max(options.duration, 0.5) : options.duration;

			return Math.max( duration, oheight / 200 * duration );
		};

		self.doOpen = function() {
			el.css( { height: el.outerHeight() } );

			var oheight  = getOheight( open );
			var duration = getDuration( oheight );

			vamtamgs.TweenLite.killTweensOf( closed );
			vamtamgs.TweenLite.killTweensOf( open );

			el.addClass('state-hover');

			var paddingTop = 20;
			var moveTop = - oheight - paddingTop;

			vamtamgs.TweenLite.to( closed, duration, {
				y: moveTop,
				paddingTop: paddingTop,
				ease: vamtamgs.Power3.easeOut,
				onComplete: function() {
					el.removeClass('state-closed').addClass('state-open');
				}
			} );

			if ( use3d ) {
				vamtamgs.TweenLite.to( open, duration, {
					y: moveTop,
					perspective: options.perspective,
					rotationX: 0,
					ease: vamtamgs.Power3.easeOut
				} );
			} else {
				vamtamgs.TweenLite.to( open, duration, {
					y: moveTop,
					height: oheight,
					ease: vamtamgs.Power3.easeOut
				} );
			}
		};

		self.doClose = function() {
			var oheight  = getOheight( open );
			var duration = getDuration( oheight );

			vamtamgs.TweenLite.killTweensOf( closed );
			vamtamgs.TweenLite.killTweensOf( open );

			el.removeClass('state-hover');

			vamtamgs.TweenLite.to( closed, duration, {
				y: 0,
				paddingTop: 0,
				ease: vamtamgs.Power3.easeOut,
				onComplete: function() {
					el.removeClass('state-open').addClass('state-closed');
					el.css( { height: '' } );
				}
			} );

			if ( use3d ) {
				vamtamgs.TweenLite.to( open, duration, {
					y: 0,
					perspective: options.perspective,
					rotationX: -90,
					ease: vamtamgs.Power3.easeOut
				} );
			} else {
				vamtamgs.TweenLite.to( open, duration, {
					y: 0,
					height: 0,
					ease: vamtamgs.Power3.easeOut
				} );
			}
		};

		self.init = function() {
			el.addClass('state-closed');

			el.addClass(use3d ? 'expandable-animation-3d' : 'expandable-animation-2d');

			if ( ! Modernizr.touchevents ) {
				el.bind('mouseenter.expandable', self.doOpen)
				  .bind('mouseleave.expandable', self.doClose);

				el.find('a').bind('click', function(e) {
					if(el.hasClass('state-closed'))
						e.preventDefault();
				});
			}
		};

		var defaults = {
			duration: 0.5,
			perspective: '10000px'
		};
		options = $.extend({}, defaults, options);

		this.init();
	};

	$.fn.vamtam_expandable = function(options, callback){
		if ( typeof options === 'string' ) {
			// call method
			var args = Array.prototype.slice.call( arguments, 1 );

			this.each(function() {
				var instance = $.data( this, 'vamtam_expandable' );
				if ( !instance ) {
					logError( "cannot call methods on expandable prior to initialization; attempted to call method '" + options + "'" );
					return;
				}
				if ( !$.isFunction( instance[options] ) || options.charAt(0) === "_" ) {
					logError( "no such method '" + options + "' for expandable instance" );
					return;
				}

				// apply method
				$.VAMTAM.expandable[ options ].apply( instance, args );
			});
		} else {
			this.each(function() {
				var instance = $.data( this, 'vamtam_expandable' );
				if ( instance ) {
					// apply options & init
					instance.option( options );
					instance._init( callback );
				} else {
					// initialize new instance
					$.data( this, 'vamtam_expandable', new $.VAMTAM.expandable( this, options, callback ) );
				}
			});
		}

		return this;
	};

	$( window ).one( 'vamtam-greensock-loaded', function() {
		$('.services.has-more').vamtam_expandable();
	} );
})(jQuery);