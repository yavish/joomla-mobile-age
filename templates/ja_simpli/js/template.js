/**
 * @package   Simpli
 * @copyright Copyright (C) 2005 - 2012 Open Source Matters, Inc. All rights reserved.
 * @license   GNU General Public License version 2 or later; see LICENSE.txt
 */

// make section with class stick-on-top to stick when reach top
jQuery(document).ready(function($) {
	var fixedHeight = 0;
	var make_sticky = function () {
		var $sticky_sections = $('.stick-on-top');
		var offset = 0,
			changes = [];
		$sticky_sections.each(function(){
			var $sticky = $(this),
				$next = $sticky.next(),
				soffset = $sticky.offset().top,
				sheight = $sticky.outerHeight();
			offset += sheight;

			// make this tobe sticky
			if (soffset - fixedHeight > 10) {
				changes.push({
					elem: $sticky,
					type: 'affix',
					offset: soffset - fixedHeight,
					top: fixedHeight,
					margin: -offset
				});
			} else {
				changes.push ({
					elem: $sticky,
					type: 'css',
					props: {
						position: 'fixed',
						top: fixedHeight
					}
				});
			}
			fixedHeight += sheight;
			if (!$next.is('.stick-on-top')) {			
				changes.push({
					elem: $next,
					type: 'css',
					props: {
						'padding-top': offset
					}
				});
				offset = 0;
			}
		});

		// apply change
		$(changes).each(function(){
			if (this.type == 'affix') {
				this.elem.affix({
					offset: {top: this.offset}
				}).css({
					'margin-bottom': this.margin,
					'top': this.top
				});
			} else {
				this.elem.css(this.props);
			}
		});	
	}


	$(window).on('load', make_sticky);

	// smooth scroll, also fix the fixed height padding
	$('body').on('click', function (e){
		var $a = $(e.target);
		if ($a.is('a')) {
			// not handle toggle
			if ($a.data('toggle')) return;
			var href = $a.attr('href');
			if (href[0] != '#' || href == '#') return;
			var target = $(href);
			if (!target.length) target = $('[name=' + href.slice(1) +']');
			
		  	if (target.length) {
		  		// calculate the pixel need move
		  		var duration = Math.abs((target.offset().top - fixedHeight - $('html').scrollTop()) * 0.4);
		  		if (duration > 1000) duration = 1000;
		    	$('html, body').animate({
		      		scrollTop: target.offset().top - fixedHeight
		    	}, duration);
		    	return false;
		  	}
		}
	});

	// scrollspy for float-pos	
	if ($('.float-pos').length) {
		$(window).on('load', function(){
			$('body').scrollspy({
			  target: '.float-pos',
			  offset: fixedHeight + 1
			});
		});
	}

	if ($('[data-toggle="gallery"]').length) {
		// generate image gallery popup
		var $modal = $('<div id="gallery-box" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="gallery-box-title" aria-hidden="true" />'),
			$header = $('<div class="modal-header">'),
			$body = $('<div class="modal-body" style="overflow: auto">');
		$modal.append($header).append($body);
		$header.append('<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>')
				.append('<h3 id="gallery-box-title" class="caption">Image</h3>')
				.append('<div class="modal-nav"><span class="btn-prev btn-gallery-action" data-action="prev"><i class="fa fa-angle-left"></i></span><span class="btn-next btn-gallery-action" data-action="next"><i class="fa fa-angle-right"></i></span></div>');
		$body.append('<img class="image" src="about:blank" />');
		$modal.appendTo('body');

		// after shown, update body height
		$modal.on('shown', function(){
			var $body = $modal.find('.modal-body'),
				p = $body.outerHeight() - $body.height(),
				h = $modal.height() - $modal.find('.modal-header').outerHeight() - p - 10;
			$modal.find('.modal-body').css({
				height: h,
				'max-height': 'none',
				'text-align': 'center'
			});
		})

		// trigger for each gallery item
		$('[data-toggle="gallery"]').each (function(){
			var $thumb = $(this);
			$thumb.on('click', function () {
				$modal.data('current-thumb', $thumb);
				// get size
				var w = $thumb.data('width'),
					h = $thumb.data('height');
				if (!w) w = 800;
				if (!h) h = 800;
				$modal.css({
					width: w,
					height: h,
					'margin-left': 0,
					top: '50%',
					'transform': 'translate(-50%, -50%)'
				});

				var url = $thumb.data('url');
				if (!url) url = $thumb.attr('src');
				$modal.find('.image').attr('src', url);
				$modal.find('.caption').html($thumb.attr('title'));
				$modal.modal();
			})
		});

		// next for the same gallery
		$('.btn-gallery-action').on('click', function(){
			var action = $(this).data('action'),
				$modal = $('#gallery-box');
				$current_thumb = $modal.data('current-thumb'),
				gallery = $current_thumb.data('gallery'),
				$thumbs = $('[data-toggle="gallery"]').filter(function(){
					return $(this).data('gallery') == gallery;
				}),
				thumb_idx = $thumbs.index($current_thumb),
				$thumb = action == 'next' ? (thumb_idx < $thumbs.length - 1 ? $thumbs.eq(thumb_idx+1) : $thumbs.eq(0)) : 
											(thumb_idx > 0 ? $thumbs.eq(thumb_idx-1) : $thumbs.eq($thumbs.length - 1));
			// find next/prev item in gallery
			if ($thumb) {
				$thumb.trigger('click');
			}

		});
	//$('<div />').addClass('.gallery-box').attr('id', 'gallery-box').appendTo ('body');
	}

	// recalculate the auto height of iframe
	iFrameHeight = function(e){
		var wh = $(window).height(),
			bh = $('body').height(),
			$iframe = $('#blockrandom');
		$iframe.height($iframe.height() + wh - bh);
		$(window).off('resize', iFrameHeight).on('resize', iFrameHeight);
	};


	// set max height for collapse menu
	(function () {
		var $mainnav = $('#mainnav'),
			$nav = $mainnav.find('.nav-collapse');
		var navCollapseMaxHeight = function () {
			if ($mainnav.css('position') == 'fixed') {
				if (!$nav.data('maxHeight')) {
					var
						$btn = $mainnav.find('.btn-navbar'),
						top = $mainnav.position().top,
						btnHeight = $btn.outerHeight(),
						wheight = $(window).height(),
						maxHeight = wheight - top - btnHeight - ($nav.outerHeight() - $nav.height()) - 2;

					$nav.css({
						'max-height': maxHeight,
						'overflow': 'auto'
					} ).data('maxHeight', true);
				}
			} else {
				if ($nav.data('maxHeight')) {
					$nav.css({
						'max-height': 'none',
						'overflow': 'auto'
					} ).data('maxHeight', false);
				}
			}
		}
		$nav.off('shown').on('shown', function () {
			navCollapseMaxHeight ($nav);
			// check on scroll
			$(window).on('scroll', navCollapseMaxHeight);
		}).on ('hidden', function () {
			$(window).off('scroll', navCollapseMaxHeight);
			$nav.data('maxHeight', false).css('max-height', 'auto');
		});
	})();

});