// Preview
jQuery(document).ready(function($) {
	var custom_styles = {},
		$all_inputs = $('#attrib-styles').find('input, textarea, select'),
		$custom_colors = $all_inputs.filter('.minicolors'),
		current_fonts = current_fontnames = [];

	custom_styles.baseUrl = window.site_root_url;
	custom_styles.previewMode = true;

	// update style for each item
	var get_val = function ($style) {
		var name = $style.attr('name').match(/\[([^\]]*)\]$/);
		if (name) {
			var val = $style.val();
			custom_styles[name[1]] = val;
		}		
	};

	// apply style
	var apply_style = function () {
		var custom_style = window.custom_style_tpl;

		// replace condition pattern
		var arr = custom_style.split(/\/\* \?([^\s]+) \*\//gm);
		var i = 0,
			chucks = [];
		chucks.push (arr[0]);
		while (i < arr.length-2) {
			// first chuck, no precess
		  	var tmp = arr[++i].split(':'),		  		
		  		checkVar = tmp[0],
		  		checkValue = tmp.length > 1 ? tmp[1] : null,
		      	checkArr = arr[++i].split('/* /' + checkVar + ' */'),
		      	checkStr = checkArr.length > 1 ? checkArr[0] : null;
		  	if (checkStr) {
		  		// check if match with value then add, else ignore the block
		  		if ((checkValue !== null && custom_styles[checkVar] == checkValue) || (checkValue == null && custom_styles[checkVar])) {
		  			checkStr = checkStr.replace (/\{?__([0-9a-zA-Z_]+)\}?/g, function (match, contents) {
						return custom_styles[contents] != undefined ? custom_styles[contents] : 'inherit';
					});	
					chucks.push (checkStr);
		  		}
		  		// push no process style
		  		if (checkArr.length > 1) chucks.push (checkArr[1]);
		  	} else {
		  		// wrong pattern, just ignore the separator
		  		chucks.push (arr[i]);
		  	}
		}
		if (chucks.length > 1) custom_style = chucks.join('');

		// replace variables
		custom_style = custom_style.replace (/\{?__([0-9a-zA-Z_]+)\}?/g, function (match, contents) {
			return custom_styles[contents] != undefined ? custom_styles[contents] : 'inherit';
		});		

		var $preview_doc = $('#custom-style-preview > iframe').contents(),
			$preview_style = $preview_doc.find('#custom-style-css');
		if ($preview_style.length) {
			// replace content
			$preview_style.replaceWith('<style id="custom-style-css">' + custom_style + '</style>');
		} else {
			$preview_doc.find('head').append ('<style id="custom-style-css">' + custom_style + '</style>');
		}
	}

	var update_fonts = function ($elem) {
		var $font_options = $('#attrib-styles select.google-font');

		var fonts = $elem.val().replace(/\+/g, ' ').split('\n').filter(function(font){return font.trim() ? true : false}),
			fontnames = fonts.map(function(font){
				return font.split(':')[0];
			});
		// merge with current fonts
		var removed_fonts = $(current_fontnames).not(fontnames).get(),
			added_fontnames = $(fontnames).not(current_fontnames).get(),
			added_fonts = $(fonts).not(current_fonts).get();
		// remove fonts
		if (removed_fonts.length) 
			$font_options.find('option').filter(function(){
				return $.inArray(this.value, removed_fonts) > -1 ? true: false}).remove();

		if (added_fontnames.length) {
			added_fontnames.each(function(font){
				$('<option>', {value: font, text: font}).appendTo ($font_options);
			});
		}

		if (added_fonts.length) {
			// load added fonts
			var $preview_doc = $('#custom-style-preview > iframe').contents();
			added_fonts.each(function(font){			
				$preview_doc.find('head').append(
					'<link href="https://fonts.googleapis.com/css?family=' + encodeURIComponent(font) + '" rel="stylesheet" type="text/css">'
					);
			});
		}

		// update selected for first time
		if (!current_fonts.length) {
			$font_options.each (function() {
				var $elem = $(this);
				$elem.val ($elem.data('value'));
			})
		}

		current_fonts = fonts;
		current_fontnames = fontnames;

		// update for chosen select
		$font_options.trigger('liszt:updated');
	}


	setTimeout (function() {
		
		$custom_colors.minicolors('settings', {
	  		change: function(value){	
	  			// get_val ($(this));
				// apply_style();
				$(this).trigger('change');
	  		}
	  	}).prop ('maxlength', 0).prop ('maxlength', 7);


	  	$all_inputs.on('change', function () {
	  		var $this = $(this);
	  		if ($this.is('.google-fonts')) {
	  			update_fonts($this);
	  		}
			get_val ($this);
			apply_style();
		});
	}, 500);
	
	// apply current style
	$('#custom-style-preview iframe').on('load', function(){
		current_fonts = [];
		update_fonts($('#attrib-styles .google-fonts'));
		// get all custom setting
		$all_inputs.each (function(){
			get_val ($(this));
		});
		// apply current style		
		apply_style();

		// mouse hover on modules in preview - show module id
		var $preview_doc = $('#custom-style-preview > iframe').contents(),
		  	$modules = $preview_doc.find('.module, .module-menu');

		$modules.each(function(){
		  var $module = $(this);
		  $module.popover({
		  	trigger: 'hover', 
		  	title: false,
		  	content: '#' + $module.attr('id')
		  });
		});
		// store last preview link
		if (localStorage) 
			localStorage.setItem('last_preview_link', this.contentWindow.location.href);

	});

	// load last preview link
	var link = null;
	if (localStorage) {
		var link = localStorage.getItem('last_preview_link');
	}
	if (!link || link.indexOf(site_root_url) !== 0) link = site_root_url;
	// lazy load
	$(window).on('load', function(){
		$('#custom-style-preview iframe').prop('src', link);
	});
	// move to top panel parent
	var $preview = $('#custom-style-preview');
	$preview.closest('.control-group').hide();
	$('#tplhelper').closest('.control-group').hide();
	$preview.appendTo ($preview.closest('.tab-pane'));



	// calculate top position of preview
	$(window).load(function(){
		var $preview = $('#custom-style-preview');
		$preview.css('position', 'fixed');
		var update_preview_top = function () {
			var max_top = $preview.closest('.tab-pane').offset().top,
				min_top = 100,
				st = $(window).scrollTop(),
				t = max_top - st;
			if (t < min_top) t = min_top;
			$preview.css('top', t);
		}

		$(window).scroll(function() {
			update_preview_top();
		});

		update_preview_top();

		$('#myTabTabs a[href="#attrib-styles"]').on('click', function () {
			setTimeout(update_preview_top, 50);
		})
	})


	// load preset
	$('.preset-loader').on('change', function () {
		preset = $(this).find(":selected").data('set');
		// fet and update value
		for (var name in preset) {
			var $input = $('[name="jform[params][' + name + ']"]');
			if (!$input.length) $input = $('[name="jform[params][' + name + '][]"]');
			if (!$input.length) continue;

			var value = preset[name].replace ('\\n', '\n'),				
				type = $input.attr('type'),
				tagName = $input.prop('tagName');

			if (type == 'radio') {
				$input.filter(function(){
					return $(this).val() == value;
				}).next().trigger('click');
			} else if ($input.prop('multiple')) {
				// multiple list
				$.each(value.split(","), function(i,e){
				    $input.find("option[value='" + e + "']").prop("selected", true);
				});
				$input.trigger('change').trigger('liszt:updated');
			} else {
				if ($input.val() != value) {
					$input.val(value).trigger('change');
					if ($input.prop('tagName') == 'SELECT') $input.trigger('liszt:updated');
				}
			}
		}
	});


	// reset value for params use default
	$('form[name="adminForm"]').on('submit', function(){
		$('.group-overwrite-default').each(function(){
			var $indicator = $(this),
				isOverwrite = $indicator.find('input:checked').val();

			// do nothing for overwrited params	
			if (isOverwrite == 1) return;

			// use default, set all params in this group to use-default
			var $this_param = $indicator.closest('.control-group'),
				$this_legend = $this_param.data('legend'),
				$other_params = $this_legend.data('params').not($this_param);
			// set value to use-default 
			$other_params.find('input, textarea, select').val('use-default');
		});
		return true;
	});


	// Apply min height for tab-pane
	var minHeightToBottom = function () {
		$('.tab-pane').each(function(){
			var $el = $(this),
				offsetTop = $el.offset().top,
				padding = $el.css('box-sizing') == 'border-box' ? 0 : $el.outerHeight() - $el.height(),
				stateBarHeight = $('#status').outerHeight(),
				marginBottom = parseInt($el.css('margin-bottom')),
				height = $(window).height() - offsetTop - padding - stateBarHeight - marginBottom;
			$el.css('min-height', height);
		});
	}
	// load & resize
	$(window).on('load', function(){
		minHeightToBottom ();
		// when switch tab
		$('#myTabTabs a').on('click', function (e) {
		  	setTimeout(minHeightToBottom, 100);
		});
	});

	// hide tplhelper
	$('.tplhelper').closest('.control-group').hide();
});



