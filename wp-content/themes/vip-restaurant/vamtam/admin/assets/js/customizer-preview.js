(function e(t,n,r){function s(o,u){if(!n[o]){if(!t[o]){var a=typeof require=="function"&&require;if(!u&&a)return a(o,!0);if(i)return i(o,!0);var f=new Error("Cannot find module '"+o+"'");throw f.code="MODULE_NOT_FOUND",f}var l=n[o]={exports:{}};t[o][0].call(l.exports,function(e){var n=t[o][1][e];return s(n?n:e)},l,l.exports,e,t,n,r)}return n[o].exports}var i=typeof require=="function"&&require;for(var o=0;o<r.length;o++)s(r[o]);return s})({1:[function(require,module,exports){
'use strict';

Object.defineProperty(exports, "__esModule", {
	value: true
});

var _helpers = require('./helpers');

var general = function general(api, $) {
	'use strict';

	api('vamtam_theme[show-splash-screen]', function (value) {
		value.bind(function (to) {
			if (+to) {
				$('body').triggerHandler('vamtam-preview-splash-screen');
			}
		});
	});

	api('vamtam_theme[splash-screen-logo]', function (value) {
		value.bind(function (to) {
			var wrapper = $('.vamtam-splash-screen-progress-wrapper');
			var current_image = wrapper.find('> img');

			if (current_image.length === 0) {
				current_image = $('<img />');
				wrapper.prepend(current_image);
			}

			current_image.attr('src', to);

			$('body').triggerHandler('vamtam-preview-splash-screen');
		});
	});

	api('vamtam_theme[show-scroll-to-top]', function (value) {
		value.bind(function (to) {
			(0, _helpers.toggle)($('#scroll-to-top'), to);
		});
	});

	api('vamtam_theme[show-related-posts]', function (value) {
		value.bind(function (to) {
			(0, _helpers.toggle)($('.vamtam-related-content.related-posts'), to);
		});
	});

	api('vamtam_theme[related-posts-title]', function (value) {
		value.bind(function (to) {
			$('.related-posts .related-content-title').html(to);
		});
	});

	api('vamtam_theme[show-single-post-image]', function (value) {
		value.bind(function (to) {
			(0, _helpers.toggle)($('.single-post > .post-media-image'), to);
		});
	});

	api('vamtam_theme[post-meta]', function (value) {
		value.bind(function (to) {
			for (var type in to) {
				(0, _helpers.toggle)($('.vamtam-meta-' + type), +to[type]);
			}
		});
	});

	api('vamtam_theme[show-related-portfolios]', function (value) {
		value.bind(function (to) {
			(0, _helpers.toggle)($('.vamtam-related-content.related-portfolios'), to);
		});
	});

	api('vamtam_theme[related-portfolios-title]', function (value) {
		value.bind(function (to) {
			$('.related-portfolios .related-content-title').html(to);
		});
	});
}; /* jshint esnext:true */

exports.default = general;

},{"./helpers":2}],2:[function(require,module,exports){
'use strict';

Object.defineProperty(exports, "__esModule", {
	value: true
});
/* jshint esnext:true */

var toggle = function toggle(el, visibility) {
	'use strict';

	if (+visibility) {
		el.show();
	} else {
		el.hide();
	}
};

exports.toggle = toggle;

},{}],3:[function(require,module,exports){
'use strict';

Object.defineProperty(exports, "__esModule", {
	value: true
});

var _helpers = require('./helpers');

var layout = function layout(api, $) {
	'use strict';

	api('vamtam_theme[full-width-header]', function (value) {
		value.bind(function (to) {
			$('.header-maybe-limit-wrapper').toggleClass('limit-wrapper', to);
		});
	});

	api('vamtam_theme[sticky-header]', function (value) {
		value.bind(function (to) {
			$('body').removeClass('had-sticky-header').toggleClass('sticky-header', +to);

			setTimeout(function () {
				$(window).triggerHandler('vamtam-rebuild-sticky-header');
			}, 50);
		});
	});

	api('vamtam_theme[enable-header-search]', function (value) {
		value.bind(function (to) {
			(0, _helpers.toggle)($('header.main-header .search-wrapper'), +to);
		});
	});

	{
		(function () {
			var widget_areas = VAMTAM_CUSTOMIZE_PREVIEW.hf_sidebars;
			var all_classes = 'full cell-1-1 cell-1-2 cell-1-3 cell-1-4 cell-1-5 cell-1-6 cell-2-3 cell-3-4 cell-2-5 cell-3-5 cell-4-5 cell-5-6';

			var resize_widget_areas = function resize_widget_areas(wrapper, location) {
				var old_rows = wrapper.find('> .row');

				var areas = wrapper.find('aside');

				var current_row = $('<div class="row"></div>');

				wrapper.append(current_row);

				var row_width = 0;

				areas.each(function (i, area) {
					area = $(area);

					var id = +area.data('id');

					area.removeClass(all_classes).addClass(widget_areas[location][id]);

					var width_num = widget_areas[location][id].split('-');
					width_num = width_num[1] / width_num[2];

					row_width += width_num;

					if (row_width > 1) {
						current_row = $('<div class="row"></div>');

						wrapper.append(current_row);

						row_width = width_num;
					}

					area.appendTo(current_row);
				});

				old_rows.remove();

				setTimeout(function () {
					$(window).triggerHandler('resize.vamtam-equal-heights-full');
				}, 50);
			};

			var _loop = function _loop(i) {
				api('vamtam_theme[header-sidebars-' + i + '-width]', function (value) {
					value.bind(function (to) {
						widget_areas.header[i] = to;

						resize_widget_areas($('#header-sidebars'), 'header');
					});
				});

				api('vamtam_theme[footer-sidebars-' + i + '-width]', function (value) {
					value.bind(function (to) {
						widget_areas.footer[i] = to;

						resize_widget_areas($('#footer-sidebars'), 'footer');
					});
				});
			};

			for (var i = 1; i <= 8; i++) {
				_loop(i);
			}
		})();
	}

	api('vamtam_theme[one-page-footer]', function (value) {
		value.bind(function (to) {
			(0, _helpers.toggle)($('.footer-wrapper'), to);

			setTimeout(function () {
				$(window).triggerHandler('resize.vamtam-footer');
			}, 50);
		});
	});

	api('vamtam_theme[page-title-layout]', function (value) {
		value.bind(function (to) {
			var header = $('header.page-header');
			var line = header.find('.page-header-line');

			header.removeClass('layout-centered layout-one-row-left layout-one-row-right layout-left-align layout-right-align').addClass('layout-' + to);

			if (to.match(/one-row-/)) {
				line.appendTo(header.find('h1'));
			} else {
				line.appendTo(header);
			}
		});
	});

	api('vamtam_theme[sticky-footer]', function (value) {
		value.bind(function (to) {
			$('body').toggleClass('sticky-footer', +to);

			setTimeout(function () {
				$(window).triggerHandler('resize.vamtam-footer');
			}, 50);
		});
	});

	api('vamtam_theme[full-width-footer]', function (value) {
		value.bind(function (to) {
			$('footer.main-footer > div').toggleClass('limit-wrapper', to);
		});
	});

	api('vamtam_theme[full-width-subfooter]', function (value) {
		value.bind(function (to) {
			$('.vamtam-subfooter > div').toggleClass('limit-wrapper', to);
		});
	});
}; /* jshint esnext:true */

exports.default = layout;

},{"./helpers":2}],4:[function(require,module,exports){
'use strict';

var _general = require('./general');

var _general2 = _interopRequireDefault(_general);

var _layout = require('./layout');

var _layout2 = _interopRequireDefault(_layout);

var _styles = require('./styles');

var _styles2 = _interopRequireDefault(_styles);

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { default: obj }; }

(function ($, undefined) {
	'use strict';

	(0, _general2.default)(wp.customize, $);
	(0, _layout2.default)(wp.customize, $);
	(0, _styles2.default)(wp.customize, $);
})(jQuery); /* jshint esnext:true */

},{"./general":1,"./layout":3,"./styles":5}],5:[function(require,module,exports){
'use strict';

Object.defineProperty(exports, "__esModule", {
	value: true
});
/* jshint esnext:true */

var styles = function styles(api, $) {
	'use strict';

	var prepare_background = function prepare_background(to) {
		if (to['background-image'] !== '') {
			to['background-image'] = 'url(' + to['background-image'] + ')';
		}

		return to;
	};

	api('vamtam_theme[top-nav-background]', function (value) {
		value.bind(function (to) {
			$('#top-nav-wrapper, #top-nav-wrapper-filler').css(prepare_background(to));
		});
	});

	{
		var compiler_options = VAMTAM_CUSTOMIZE_PREVIEW.compiler_options;

		for (var i = 0; i < compiler_options.length; i++) {
			api(compiler_options[i], function (value) {
				value.bind(function () {
					$('body').addClass('customize-partial-refreshing');
				});
			});
		}
	}

	api('vamtam_theme[page-title-background-hide-lowres]', function (value) {
		value.bind(function (to) {
			$('header.page-header').toggleClass('vamtam-hide-bg-lowres', to);
		});
	});

	api('vamtam_theme[main-background-hide-lowres]', function (value) {
		value.bind(function (to) {
			$('.vamtam-main').toggleClass('vamtam-hide-bg-lowres', to);
		});
	});

	api('vamtam_theme[footer-background-hide-lowres]', function (value) {
		value.bind(function (to) {
			$('footer.main-footer, .vamtam-subfooter').toggleClass('vamtam-hide-bg-lowres', to);
		});
	});

	api('vamtam_theme[subfooter-background]', function (value) {
		value.bind(function (to) {
			$('.vamtam-subfooter').css(prepare_background(to));
		});
	});

	api('vamtam_theme[footer-background]', function (value) {
		value.bind(function (to) {
			$('footer.main-footer').css(prepare_background(to));
		});
	});

	var compile_local_css = function compile_local_css(el, source, accents) {
		$.ajax({
			type: 'POST',
			url: VAMTAM_CUSTOMIZE_PREVIEW.ajaxurl,
			data: {
				action: 'vamtam-compile-local-css',
				source: source,
				accents: accents
			},
			success: function success(result) {
				$(el).replaceWith(result);
			}
		});
	};

	api('vamtam_theme[accent-color]', function (value) {
		value.bind(function (to) {
			$('[data-vamtam-less-source]').each(function (i, el) {
				compile_local_css(el, el.dataset.vamtamLessSource, to);
			});
		});
	});
};

exports.default = styles;

},{}]},{},[4]);
