(function($, undefined) {
	"use strict";

	window.vamtam_yepnope=function(a,b){function c(){}function d(a){return Object(a)===a}function e(a){return"string"==typeof a}function f(){return"yn_"+q++}function g(){o&&o.parentNode||(o=b.getElementsByTagName("script")[0])}function h(a){return!a||"loaded"==a||"complete"==a||"uninitialized"==a}function i(b,c){c.call(a)}function j(a,j){var k,l,m;e(a)?k=a:d(a)&&(k=a._url||a.src,l=a.attrs,m=a.timeout),j=j||c,l=l||{};var q,r,t=b.createElement("script");m=m||n.errorTimeout,t.src=k,s&&(t.event="onclick",t.id=t.htmlFor=l.id||f());for(r in l)t.setAttribute(r,l[r]);t.onreadystatechange=t.onload=function(){if(!q&&h(t.readyState)){if(q=1,s)try{t.onclick()}catch(a){}i(k,j)}t.onload=t.onreadystatechange=t.onerror=null},t.onerror=function(){q=1,j(new Error("Script Error: "+k))},p(function(){q||(q=1,j(new Error("Timeout: "+k)),t.parentNode.removeChild(t))},m),g(),o.parentNode.insertBefore(t,o)}function k(f,h){var i,j,k={};d(f)?(i=f._url||f.href,k=f.attrs||{}):e(f)&&(i=f);var l=b.createElement("link");h=h||c,l.href=i,l.rel="stylesheet",l.media="only x",l.type="text/css",p(function(){l.media=k.media||"all"});for(j in k)l.setAttribute(j,k[j]);g(),o.parentNode.appendChild(l),p(function(){h.call(a)})}function l(a){var b=a.split("?")[0];return b.substr(b.lastIndexOf(".")+1)}function m(a,b){var c=a,d=[],e=[];for(var f in b)b.hasOwnProperty(f)&&(b[f]?d.push(encodeURIComponent(f)):e.push(encodeURIComponent(f)));return(d.length||e.length)&&(c+="?"),d.length&&(c+="yep="+d.join(",")),e.length&&(c+=(d.length?"&":"")+"nope="+e.join(",")),c}function n(a,b,c){var e;d(a)&&(e=a,a=e.src||e.href),a=n.urlFormatter(a,b),e?e._url=a:e={_url:a};var f=l(a);if("js"===f)j(e,c);else{if("css"!==f)throw new Error("Unable to determine filetype.");k(e,c)}}var o,p=a.setTimeout,q=0,r={}.toString,s=!(!b.attachEvent||a.opera&&"[object Opera]"==r.call(a.opera));return n.errorTimeout=1e4,n.injectJs=j,n.injectCss=k,n.urlFormatter=m,n}(window,document); // jshint ignore:line


	$(function() {
		var scripts = [
			window.VAMTAM_FRONT.jspath + 'plugins/thirdparty/gsap/TweenLite.min.js',
			window.VAMTAM_FRONT.jspath + 'plugins/thirdparty/gsap/TimelineLite.min.js',
			// window.VAMTAM_FRONT.jspath + 'plugins/thirdparty/gsap/jquery.gsap.min.js',
			window.VAMTAM_FRONT.jspath + 'plugins/thirdparty/gsap/plugins/CSSPlugin.min.js',
			window.VAMTAM_FRONT.jspath + 'plugins/thirdparty/gsap/plugins/ScrollToPlugin.min.js',
			window.VAMTAM_FRONT.jspath + 'plugins/thirdparty/gsap/easing/EasePack.min.js',
		];

		var total_ready = 0;
		var maybe_ready = function() {
			if ( ++ total_ready === scripts.length ) {
				window.GreenSockGlobals = window._gsQueue = window._gsDefine = null;

				window.vamtam_greensock_loaded = true;
				$( window ).trigger( 'vamtam-greensock-loaded' );
			}
		};

		window.vamtamgs = window.GreenSockGlobals = {};
		window._gsQueue = window._gsDefine = null;
		window.vamtam_greensock_loaded = false;

		for ( var i = 0; i < scripts.length; i++ ) {
			vamtam_yepnope.injectJs( scripts[i], maybe_ready );
		}
	});

	window.vamtam_greensock_wait = function( callback ) {
		if ( window.vamtam_greensock_loaded ) {
			callback();
		} else {
			$( window ).one( 'vamtam-greensock-loaded', callback );
		}
	};
})(jQuery);