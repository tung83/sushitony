(function($, undefined) {
	"use strict";

	tinymce.PluginManager.add('vamtam_shortcodes', function(editor) {
		var open_shortcode = function(slug) {
			if ($('#shortcodes').length === 0) {
				$('body').append('<div id="shortcodes">');
			}

			$('body').attr('data-vamtamshortcode', slug);

			$.get(ajaxurl, {
				action: 'vamtam-shortcode-generator',
				slug: slug,
				nocache: +(new Date())
			}, function(data) {
				$('#shortcodes').html(data);

				$(window).trigger('vamtam_shortcodes_loaded');

				$.magnificPopup.open({
					type: 'inline',
					items: {
						src: '#' + $('#shortcodes > div').attr('id'),
						titleSrc: VamtamTmceShortcodes.title
					},
					closeOnBgClick: false
				});
			});
		};

		var menu_items = [];

		var create_menu_item = function(shortcode) {
			return {
				text: shortcode.title,
				onclick: function() {
					open_shortcode(shortcode.slug);
				}
			};
		};

		for(var i = 0; i < VamtamTmceShortcodes.shortcodes.length; ++i) {
			menu_items.push( create_menu_item( VamtamTmceShortcodes.shortcodes[i] ) );
		}

		editor.addButton('vamtam_shortcodes', {
			type: 'menubutton',
			text: '',
			tooltip: VamtamTmceShortcodes.title,
			icon: VamtamTmceShortcodes.button,
			classes: 'widget btn vamtam_shortcodes',
			menu: menu_items
		});
	});
})(jQuery);