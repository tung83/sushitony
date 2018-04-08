(function($, undefined) {
	"use strict";

	var picker, selected, fbt;

	var init = function() {

		picker = $('<div id="vamtam-colorpicker"></div>').hide();

		$('body').append(picker);
		fbt = $.farbtastic('#vamtam-colorpicker');

		picker.append(function() {
			return $('<a class="transparent">transparent</a>').click(function() {
				if (selected) {
					$(selected).val('transparent').css({
						background: 'white'
					});
					picker.fadeOut();
				}
			});
		});
	};

	$.fn.vamtamColorPicker = function() {
		var self = this;

		if(!picker)
			init();

		$('[type=color], .vamtam-color-input', self).not('.vamtam-colorpicker').each(function() {
			$(this).prop('type', 'text').addClass('vamtam-colorpicker');
			fbt.linkTo(this);
		}).on('focus', null, function() {
			if (selected) $(selected).removeClass('colorwell-selected');

			var self = this;
			fbt.linkTo(function(color) {
				$(self).val(color).change();
			});

			picker.css({
				position: 'absolute',
				left: $(this).offset().left + $(this).outerWidth(),
				top: $(this).offset().top
			}).fadeIn();
			$(selected = this).addClass('colorwell-selected');
		}).on('blur', null, function() {
			picker.fadeOut();
		}).on('change keyup', null, function() {
			$(this).css({
				'background-color': $(this).val()
			});
		});

		return this;
	};
})(jQuery);
(function($, undefined) {
	"use strict";

	$.ajax({
		type: 'POST',
		url: ajaxurl,
		data: {
			action: 'vamtam-get-icon-list'
		},
		success: function(icons) {
			window.VamtamIconsCache = icons;

			$(document).trigger('vamtam-icons-loaded');
		}
	});

	$.fn.vamtamIconsSelector = function(atts) {
		var all_icons = $('.vamtam-config-icons-selector', this);

		(function() {
			var browser = /MSIE (\d+)/.exec(navigator.userAgent);
			if(browser && browser[1] !== 8) return;

			var refresh = function() {
				all_icons.find(':radio.checked').removeClass('checked');
				all_icons.find(':checked').addClass('checked');
			};

			all_icons.find(':radio').unbind('change.vamtamicons').bind('change.vamtamicons', refresh);
			refresh();
		})();

		(function() {
			var init = function(self, icons) {
				var initial = self.find(':checked'),
					checked = initial.val(),
					id = initial.prop('name') || (new Date().getTime()).toString(16),
					wrapper = self.find('.icons-wrapper');

				initial.remove();

				var single_icon = function(key, icon) {
					var radio = $('<input type="radio" />').attr('name', id).attr('id', id+key).val(key),
						label = $('<label class="single-icon" />').attr('for', id+key).html(icon);

					if(key === checked) {
						radio.prop('checked', true);
					}

					return radio.add(label);
				};

				for(var key in icons) {
					wrapper.append(single_icon(key, icons[key]));
				}

				wrapper.removeClass('spinner');

				self.addClass('icons-loaded')
					.find('.icons-filter').bind('change paste keydown keyup search', function() {
					var search = $(this).val().toLowerCase();
					self.find('label:has(span[title])').show().each(function() {
						if(!$(this).find('span').attr('title').toLowerCase().match(search))
							$(this).hide();
					});
				});

				setTimeout(function() {
					scrollIcons(self);
				}, 100);
			};

			var scrollIcons = function(self) {
				self.each(function() {
					$(this).find('.icons-wrapper').scrollTop(0); // reset the inital position
					$(this).find('.icons-wrapper').scrollTop($(this).find(':checked + label').offset().top - $(this).find('.icons-wrapper').offset().top);
				});
			};

			all_icons.filter(':not(.icons-loaded)').each(function() {
				var self = $(this);

				if(window.VamtamIconsCache) {
					init(self, window.VamtamIconsCache);
				} else {
					$(document).one('vamtam-icons-loaded', function() {
						init(self, window.VamtamIconsCache);
					});
				}
			});

			all_icons.filter('.icons-loaded').each(function() {
				var self = $(this);

				if(typeof atts === 'string') {
					switch(atts) {
						case 'scroll':
							scrollIcons(self);
						break;
					}
				}
			});
		})();

		return this;
	};
})(jQuery);
(function($, undefined) {
	"use strict";

	$.fn.vamtamBackgroundOption = function() {
		$(this).find('.vamtam-config-row.background:not(.vamtambg-loaded)').each(function() {
			var row = $(this).addClass('vamtambg-loaded'),
				size = row.find('.bg-block.bg-size'),
				repeat = row.find('.bg-block.bg-repeat'),
				position = row.find('.bg-block.bg-position');

			size.find('input').bind('change', function() {
				repeat.add(position).show();

				if($(':checked', size).val() === 'cover')
					repeat.add(position).hide();
			}).change();

		});
		return this;
	};
})(jQuery);
(function($, undefined) {
	'use strict';

	$.VAMTAM = $.VAMTAM || {};

	$.VAMTAM.upload = {
		init: function() {
			var file_frame;

			$(document).on('click', '.vamtam-upload-button', function(e) {
				var field_id = $(this).attr('data-target');

				file_frame = wp.media.frames.file_frame = wp.media({
					multiple: false,
					library: {
						type: $(this).hasClass('vamtam-video-upload') ? 'video' : 'image'
					}
				});

				file_frame.on( 'select', function() {
					var attachment = file_frame.state().get('selection').first();
					$.VAMTAM.upload.fill(field_id, attachment.attributes.url);
				});

				file_frame.open();
				e.preventDefault();
			});

			$(document).on('click', '.vamtam-upload-clear', function(e) {
				$.VAMTAM.upload.remove($(this).attr('data-target'));
				e.preventDefault();
			});

			$(document).on('click', '.vamtam-upload-undo', function(e) {
				$.VAMTAM.upload.undo($(this).attr('data-target'));
				e.preventDefault();
			});
		},

		fill: function(id, str) {
			if (/^\s*$/.test(str)) {
				$.VAMTAM.upload.remove(id);
				return;
			}

			var target = $('#' + id);
			target.data('undo', target.val());
			target.val(str);
			target.siblings('.vamtam-upload-clear, .vamtam-upload-undo').css({
				display: 'inline-block'
			});
			$.VAMTAM.upload.preview(id, str);
		},

		preview: function(id, str) {
			$('#' + id + '_preview').parents('.upload-basic-wrapper').addClass('active');
			$('#' + id + '_preview').find('img').attr('src', str).css({
				display: 'inline-block'
			});
		},

		remove: function(id) {
			var inp = $('#' + id);
			$('#' + id + '_preview').find('img').attr('src', '').hide();
			$('#' + id + '_preview').parents('.upload-basic-wrapper').removeClass('active');
			inp.data('undo', inp.val()).val('')
				.siblings('.vamtam-upload-undo').css({
				display: 'inline-block'
			})
				.siblings('.vamtam-upload-clear').hide();
		},
		undo: function(id) {
			var inp = $('#' + id);
			this.preview(id, inp.data('undo'));
			inp.val(inp.data('undo'));
			inp.data('undo', '').siblings('.vamtam-upload-undo').hide();
			var remove = inp.siblings('.vamtam-upload-clear');
			if (inp.val().length === 0 && remove.is(':visible')) {
				remove.hide();
			} else if (inp.val().length > 0 && remove.is(':hidden')) {
				remove.css({
					display: 'inline-block'
				});
			}
		}
	};
})(jQuery);
(function($, undefined) {
	'use strict';

	$.VAMTAM = $.VAMTAM || {};

	$.VAMTAM.icon_manager = {
		init: function() {
			var file_frame,
				selected_zip;

			$(document).on('click', '.vamtam-upload-icon-font', function( e ) {
				file_frame = wp.media.frames.file_frame = wp.media({
					multiple: false,
					library: {
						type: 'application/zip'
					}
				});

				file_frame.on( 'select', function() {
					var attachment = file_frame.state().get('selection').first();
					selected_zip = attachment.id;


					$( '.vamtam-icon-font-setup .step-1 .step-in-progress' ).text( attachment.attributes.filename ).show();
					$( '.vamtam-icon-font-setup .postbox-container.step-2' ).removeClass( 'inactive' );
				});

				file_frame.open();
				e.preventDefault();
			});

			$(document).on('click', '.vamtam-process-icon-font', function( e ) {
				e.preventDefault();

				var self = $(this);

				self.siblings( '.step-in-progress' ).show();

				$.ajax({
					type: 'POST',
					url: ajaxurl,
					data: {
						action: 'vamtam-process-icon-font',
						selected: selected_zip,
						_ajax_nonce: $(this).data('nonce')
					},
					dataType: 'json',
					success: function(data) {
						self.siblings( '.step-in-progress' ).hide();

						var result = '';

						if ( 'error' in data ) {
							result = data.error;
						} else {
							for ( var name in data ) {
								result += 'custom-' + name + ': <svg width="32" height="32" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg">';

								for( var i = 0; i < data[name].length; i++ ) {
									result += '<path d="' + data[name][i] + '" fill="#666"/>';
								}

								result += '</svg><br>';
							}
						}

						// $( '.vamtam-icon-font-setup .postbox-container' ).addClass( 'inactive' );
						$( '.vamtam-icon-font-setup .postbox-container.step-3' ).removeClass( 'inactive' ).find( '.result-generated' ).html( result ).parent().show();
					}
				});
			});
		},
	};

	$.VAMTAM.icon_manager.init();

})(jQuery);
(function($, undefined) {
	'use strict';

	$.VAMTAM = $.VAMTAM || {};

	$.VAMTAM.horizontal_blocks = {
		init: function() {
			$('.horizontal_blocks .vamtam-range-input').change(function() {
				$.VAMTAM.horizontal_blocks.set_active($(this).val(), $(this).attr('id'));
			});

			$('.horizontal_blocks select').change(function() {
				$.VAMTAM.horizontal_blocks.resize($(this).parents('.block').parent(), $(this).val());
			});

			$('.horizontal_blocks [name*="last"]').change(function() {
				var block = $(this).parents('.block').parent();

				if (block.is('.last') !== $(this).is(':checked')) {
					$.VAMTAM.horizontal_blocks.toggle_last(block);
				}
			});
		},
		set_active: function(number, group) {
			$('[rel="' + group + '"]').removeClass('active');
			$('[rel="' + group + '"]:lt(' + number + ')').addClass('active');
		},
		resize: function(block, new_width) {
			block.removeClass(block.attr('data-width')).addClass(new_width).attr('data-width', new_width);
			if (new_width === 'full') {
				block.find('label').hide();
			} else {
				block.find('label').show();
			}
		},
		toggle_last: function(block) {
			if (block.is('.last')) {
				block.removeClass('last').next().remove();
			} else {
				block.addClass('last').after('<div class="clearboth"></div>');
			}
		}
	};
})(jQuery);
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
(function($, undefined) {
	"use strict";

	$(function() {
		var groups = [{
			options: '#vamtam-post-format-options',
			select: '#post-formats-select'
		}, {
			options: '#vamtam-portfolio-format-options',
			select: '#vamtam-portfolio-formats-select'
		}];

		_.each(groups, function(group) {
			var post_formats = $(group.options);
			if(post_formats.length) {
				var pf_tabs = post_formats.find('.vamtam-meta-tabs').hide(),
					pf_select = $(group.select);

				pf_select.find(':radio').change(function() {
					var checked = pf_select.find(':checked'),
						format_name = checked.prop('id') || 'post-format-'+checked.val(),
						tab = pf_tabs.find('li.vamtam-'+ format_name + ' a');

					tab.click();

					pf_tabs.parent().find('.vamtam-config-row.vamtam-all-formats').appendTo($(tab.attr('href')));
				}).change();

				post_formats.insertBefore($('#postdivrich')).addClass( 'vamtam-repositioned' );
			}
		});
	});
})(jQuery);