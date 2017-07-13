jQuery(document).ready(function($){
	var html = `
		<div class="layout-preview">
			<div data-name="header" class="section">
				<span class="section-title">Header</span>
				<div class="container" data-role="container">
					<div class="row-fluid" data-role="row">
						<div data-name="header_left" class="col span4">
							<div class="section-info">
								<span class="info-name">Header Left</span>
							</div>
						</div>
						<div data-name="header_right" class="col span8">
							<div class="section-info">
								<span class="info-name">Header Right</span>
								<span class="info-pos"></span>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div data-name="nav" class="section">
				<span class="section-title">Navigation</span>
				<div class="container" data-role="container">
					<div class="row-fluid" data-role="row">
						<div data-name="nav_left" class="col span4">
							<div class="section-info">
								<span class="info-name">Navigation Left</span>
								<span class="info-pos"></span>
							</div>
						</div>
						<div data-name="nav_right" class="col span8">
							<div class="section-info">
								<span class="info-name">Navigation Right</span>
								<span class="info-pos"></span>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div data-name="top_1" />
			<div data-name="top_2" />
			<div data-name="top_3" />
			<div data-name="top_4" />

			<div data-name="content" class="section">
				<span class="section-title">Content</span>
				<div class="container" data-role="container">
					<div class="row-fluid" data-role="row">
						<div data-name="main-content" class="col span6" data-role="col">Content</div>
						<div data-name="col_1" class="col span3">
							<div class="section-info">
								<span class="info-name">Sidebar 1</span>
								<span class="info-pos"></span>
							</div>
						</div>
						<div data-name="col_2" class="col span3">
							<div class="section-info">
								<span class="info-name">Sidebar 2</span>
								<span class="info-pos"></span>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div data-name="bot_1" />
			<div data-name="bot_2" />
			<div data-name="bot_3" />
			<div data-name="bot_4" />
			<div data-name="footer" />

		</div>
	`;
	var htmlSpotlight = `
		<div class="section">
			<span class="section-title">Title</span>
			<div class="container" data-role="container">
				<div class="section-info">
					<span class="info-name">bot-4</span>
					<span class="info-pos">position name</span>
				</div>
				<div class="row-fluid" data-role="row" />
			</div>
		</div>	
	`;

	var $layoutPreview = $('<div>').attr('id', 'layout-preview').html(html).prependTo ($('#attrib-layouts'));

	var getLayoutItem = function (name) {
		return $layoutPreview.find('[data-name="' + name + '"]');
	}
	// enabler	
	var toggleEnabler = function (name) {
		var $item = getLayoutItem(name),
			enabled = $('[name="jform[params][layoutEnable_' + name + ']"]:checked').val();
		if ($item.length) {
			$item[enabled == "1" ? 'removeClass' : 'addClass'] ('off');
		}
		// update other col width
		if ($item.is('.col')) {
			updateSplRow ($item.data('name'));
		}
	}

	var renderSpotlight = function (name) {
		var $spotlight = $(htmlSpotlight).attr('data-name', name).data('name', name);
		// find spotlight text
		var title = $('#jform_params_layoutEnable_' + name).closest('.control-group').find('h3 > span').text();
		$spotlight.find('.section-title').html(title);
		// update info
		updateSectionInfo ('Name', $spotlight);
		updateSectionInfo ('Pos', $spotlight);
		// Render content - row/cols
		updateSplRow ($spotlight);
		// Container
		updateSectionContainer ($spotlight);
		// Replace
		getLayoutItem(name).replaceWith($spotlight);
	}

	var updateSectionInfo = function (name, spl) {
		var key, value;
		if ($.type(spl) === 'string') {
			key = spl;
			spl = getLayoutItem(spl);
		} else {
			key = spl.data('name');
		}
		value = $('#jform_params_layout' + name + '_' + key).val();
		spl.find('.info-' + name.toLowerCase()).html(value);
	}

	var updateSectionContainer = function (spl) {
		var key, value;
		if ($.type(spl) === 'string') {
			key = spl;
			spl = getLayoutItem(spl);
		} else {
			key = spl.data('name');
		}
		value = $('[name="jform[params][layoutContainer_' + key + ']"]:checked').val();
		if (value === '') {
			value = $('[name="jform[params][layoutContainer]"]:checked').val();
		}
		spl.find('[data-role="container"]').attr('class', value === "1" ? 'container' : 'no-container');
	}

	var updateSplRow = function (spl) {
		var key, value;
		if ($.type(spl) === 'string') {
			key = spl;
			spl = getLayoutItem(spl);
		} else {
			key = spl.data('name');
		}
		
		if (spl.is('.section')) {
			value = $('[name="jform[params][layoutWidth_' + key + ']"]').val();		
			if (value === '') {
				value = '4:4:4';
			}
			var $cols = value.split(/[:,\- ]+/).map(function (val, idx){
					return $('<div>').addClass('col span' + val).html('Module ' + (idx+1));
				}),
				$row = $('<div data-role="row">').addClass('row-fluid').append ($cols);
			// update Row
			spl.find('[data-role="row"]').replaceWith($row);
		} else {			
			// find and update width for auto column
			var $cols = spl.parent().children(),
				w = 12, $autoWidthCol;
			$cols.each (function () {
				var $col = $(this),
					name = $col.data('name'),
					cw = $('[name="jform[params][layoutWidth_' + name + ']"]').val();
				// ignore disabled col
				if ($col.is('.off')) return;

				if (cw) {
					w -= cw;
					$col.attr('class', 'col span' + cw);
				} else {
					// found auto-width col
					$autoWidthCol = $col;
				}
			});
			if ($autoWidthCol) {
				$autoWidthCol.attr('class', 'col span' + w);
			}
		}
	}

	var updateAllSectionsContainer = function () {
		$layoutPreview.find('.section').each(function(){
			updateSectionContainer ($(this));
		})
	}

	var updateContentPosition = function () {
		var pos = $('[name="jform[params][layoutPosition_content]"]').val(),
			$content = $layoutPreview.find('[data-name="main-content"]');
		$content[pos == 'right' ? 'addClass' : 'removeClass']('pull-right');
	}

	// render spotlight
	for (var i=0; i<4; i++) {
		renderSpotlight ('top_' + (i+1));
		renderSpotlight ('bot_' + (i+1));
	}
	renderSpotlight ('footer');
	// update width for cols
	updateSplRow ('header_left');
	updateSplRow ('nav_left');
	updateSplRow ('main-content');

	// update position name
	updateSectionInfo ('Pos', 'header_right');
	updateSectionInfo ('Pos', 'nav_left');
	updateSectionInfo ('Pos', 'nav_right');
	updateSectionInfo ('Pos', 'col_1');
	updateSectionInfo ('Pos', 'col_2');

	// content position left / right
	updateContentPosition ();

	// toggle enabler
	$('.top-group-enabler, .group-enabler').each (function () {
		var match = this.id.match(/jform_params_layoutEnable_(.*)$/),
			name = match ? match[1] : '';
		if (name) toggleEnabler (name);
	})

	// container
	updateAllSectionsContainer();

	setTimeout(function(){
		// update min-height for parent
		$('#attrib-layouts .top-group').css('min-height', $layoutPreview.height());
	}, 200);

	// tracking change
	$('body').on('change', function (e){
		var $elem = $(e.target),
			name = $elem.attr('name'),
			match = name.match(/jform\[params\]\[layout([^_]*)_([^\]]*)\]/);

		if (match) {
			switch (match[1]) {
				case 'Enable':
					toggleEnabler (match[2]); break;
				case 'Container':
					updateSectionContainer (match[2]); break;
				case 'Width':
					updateSplRow (match[2]); break;
				case 'Position':
					updateContentPosition(); break;
				default:
					updateSectionInfo (match[1], match[2]); break;
			}
		} else if (name == 'jform[params][layoutContainer]') {
			// update all container
			updateAllSectionsContainer();
		} else {
			return;
		}
		// update min-height for parent
		$('#attrib-layouts .top-group').css('min-height', $layoutPreview.height());

	});

	// tracking click on section
	$layoutPreview.find('.section').each(function (){
		var key = $(this).data('name'),
			$legendGroup = $('[name="jform[params][layoutEnable_' + key + ']"]').closest('.control-group').data('legend').closest('.control-group');
		$(this).data('legendGroup', $legendGroup);
	})
	$layoutPreview.find('.section').on('click', function (e){
		$(this).data('legendGroup').trigger('click');
	});

	// active section
	$(document).on('switchLegendGroup', function (e, legendGroup) {
		$layoutPreview.find('.section').removeClass('active').filter(
			function (){
				return $(this).data('legendGroup').is(legendGroup);
			}).addClass('active');			
	})

});




