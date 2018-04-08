(function($, undefined) {
	"use strict";

	$.VAMTAM = $.VAMTAM || {};

	$(function() {
		$('body').vamtamColorPicker().vamtamIconsSelector().vamtamBackgroundOption();
		$('.vamtam-range-input').uirange();

		$.VAMTAM.horizontal_blocks.init();
		$.VAMTAM.upload.init();

		$(document).on('change select', '[data-field-filter]', function() {
			var prefix = $(this).attr('data-field-filter');
			var selected = $(':checked', this).val();

			var others = $(this).closest('.vamtam-config-group').find('.' + prefix).filter(':not(.hidden)');
			others.show().filter(':not(.' + prefix + '-' + selected + ')').hide();
		});

		$('[data-field-filter]').change();

		$('body').on('click', '.vamtam-icon-selector-trigger', function(e) {
			var selector = $('#wpwrap > .vamtam-config-icons-selector'),
				self = $(this);

			$.magnificPopup.open({
				type: 'inline',
				items: {
					src: selector
				},
				closeOnBgClick: false,
				callbacks: {
					open: function() {
						selector.show();
					},
					close: function() {
						selector.hide();
					}
				}
			});

			selector.find('[value="'+$(this).data('icon-name')+'"]').prop('checked', true).change();

			selector.parent().vamtamIconsSelector('scroll');

			selector.find(':radio').bind('change.vamtam-icons-selector', function() {
				var checked = selector.find(':checked'),
					checked_icon = checked.val();

				$.magnificPopup.close();

				self.data('icon-name', checked_icon);

				var container = self.find('+ input');
				if(container) {
					container.val(checked_icon);
				}

				self.html(checked.next().find('span').html());

				self.removeClass('theme no-icon');

				if(checked_icon.match(/^theme-/)) {
					self.addClass('theme');
				} else if (checked_icon.match(/^\s*$/)) {
					self.addClass('no-icon').html('');
				}

				selector.find(':radio').unbind('change.vamtam-icons-selector');

				try {
					$.VAMTAMED.saveHTML();
				} catch(e) {}
			});


			e.preventDefault();
		});

		$(document).on('change', '.social_icon_select_sites', function() {
			var wrap = $(this).closest('p').siblings('.social_icon_wrap');
			wrap.children('p').hide();
			$('option:selected', this).each(function() {
				wrap.find('.social_icon_' + $(this).val()).show();
			});
		});

		$(document).on('change', '.num_shown', function() {
			var wrap = $(this).closest('p').siblings('.hidden_wrap');
			wrap.children('div').hide();
			$('.hidden_el:lt(' + $(this).val() + ')', wrap).show();
		});

		$('.metabox').each(function() {
			var meta_tabs = $('<ul>').addClass('vamtam-meta-tabs');

			$('.config-separator:first', this).before(meta_tabs);
			$('.config-separator', this).each(function() {
				var id = $(this).text().replace(/[\s\n]+/g, '').toLowerCase();
				$(this).nextUntil('.config-separator').wrapAll('<div class="vamtam-meta-part" id="tab-' + id + '"></div>');
				$(this).css('cursor', 'pointer');
				if ($(this).next().is('.vamtam-meta-part')) {
					meta_tabs.append('<li class="vamtam-meta-tab '+$(this).attr('data-tab-class')+'"><a href="#tab-' + id + '" title="">' + $(this).text() + '</a></li>');
				}
				$(this).remove();
			});

			if(meta_tabs.children().length > 1) {
				meta_tabs.closest('.metabox').tabs();
			} else {
				meta_tabs.hide();
			}
		});

		$('#vamtam-config').tabs({
			activate: function(event, ui) {
				var hash = ui.newTab.context.hash;
				var element = $(hash);
				element.attr('id', '');
				window.location.hash = hash;
				element.attr('id', hash.replace('#', ''));

				$('.save-vamtam-config').show();
				if (ui.newTab.hasClass('nosave')) $('.save-vamtam-config').hide();
			},
			create: function(event, ui) {
				if (ui.tab.hasClass('nosave')) $('.save-vamtam-config').hide();
			}
		});

		$('body').on('click', '.info-wrapper > a', function(e) {
			var other = $(this).attr('data-other');
			$(this).attr('data-other', $(this).text()).text(other);
			$(this).siblings('.desc').slideToggle(200);
			e.preventDefault();
		});

		$('body').on('click', '.vamtam-autofill', function() {
			$(this).addClass('selected').siblings().removeClass('selected');

			var fields = $.parseJSON($(this).attr('data-fields'));
			var group = $(this).closest('.vamtam-config-group');

			for(var i in fields) {
				var field = group.find('[name="' + i + '"]');

				if (field.is(':checkbox')) {
					if (fields[i] === 1) {
						field.attr('checked', 'checked');
					} else {
						field.attr('checked', false);
					}
				} else {
					field.val(fields[i]);
					if (field.is('.image-upload')) {
						$.VAMTAM.upload.fill(field.attr('id'), fields[i]);
					}
				}

				field.change();
			}

			return false;
		});

		function autofill_test(autofill) {
			var fields = $.parseJSON($(autofill).attr('data-fields'));

			var selected = true;

			for(var i in fields) {
				var field = $('[name="' + i + '"]');

				if (field.is(':checkbox')) {
					var new_val = !!(fields[i]),
						curr_val = field.is(':checked');
					if(new_val !== curr_val) {
						selected = false;
						break;
					}
				} else if ( !(field.val()) || !(fields[i]) || field.val().toString() !== fields[i].toString()) {
					selected = false;
					break;
				}
			}

			if (selected) {
				$(autofill).addClass('selected');
			}
		}

		$('.vamtam-autofill').each(function() {
			autofill_test(this);
			var autofill = this;

			var fields = $.parseJSON($(autofill).attr('data-fields'));

			var doAutofill = function() {
				$(autofill).removeClass('selected');
				autofill_test(autofill);
			};

			for(var i in fields) {
				$('#' + i).change(doAutofill);
			}
		});

		$('.vamtam-config-row.body-layout label').click(function() {
			$(this).addClass('selected');
			$(this).parent().siblings().find('label').removeClass('selected');
		});
		$('.vamtam-config-row.body-layout input').change(function() {
			if ($(this).is(':checked')) {
				$('label[for="' + $(this).attr('id') + '"]').click();
			}
		});

		// images in label ie fix
		$(document).on('click', 'label img', function() {
			$('#' + $(this).parents('label').attr('for')).click();
		});

		function updateFontProps(input) {
			var container = $(input).closest(".vamtam-config-row.font");
			var preview = container.find('.font-preview');

			var loadFont = function() {
				var link = document.createElement('LINK');
				link.rel = "stylesheet";
				link.type = "text/css";
				container.find('.font-styles').html("")[0].appendChild(link);
				$.ajax({
					type: 'POST',
					url: ajaxurl,
					data: {
						action: 'vamtam-font-preview',
						face: container.find('.face').val(),
						weight: container.find('.weight').val()
					},
					//async : false,
					success: function(data) {
						link.href = data;
						preview.css({
							'font': font,
							'color': container.find('.vamtam-color-input').val()
						});
					}
				});
			};

			if ($(input).is('.vamtam-color-input')) {
				preview.css('color', container.find('.vamtam-color-input').val());
			} else {
				var font = container.find('.weight').val() + ' ' + container.find('.size').val() + 'px/' + container.find('.lheight').val() + 'px ' + '"' + container.find('.face').val() + '"';

				if( $(input).hasClass('face') ) {
					var weight = container.find('.weight');
					var prevWeight = weight.val();

					weight.empty();
					$(VAMTAM_ADMIN.fonts[$(input).val()].weights).each(function(i, opt) {
						weight.append('<option>'+opt+'</option>');
					});

					weight.val(prevWeight);

					loadFont();
				} else if( $(input).hasClass('weight') ) {
					loadFont();
				} else {
					preview.css({
						'font': font,
						'color': container.find('.vamtam-color-input').val()
					});
				}
			}
		}

		$('.vamtam-config-row.font input, .vamtam-config-row.font select').bind("change", function() {
			updateFontProps(this);
		});

		setTimeout(function() {
			$(".vamtam-config-row.font").each(function() {
				updateFontProps($(".face", this)[0]);
			});
		}, 0);
	});
})(jQuery);