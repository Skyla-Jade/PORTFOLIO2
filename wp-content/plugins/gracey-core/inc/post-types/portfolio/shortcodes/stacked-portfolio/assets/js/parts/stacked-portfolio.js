(function ( $ ) {
	'use strict';
	
	var shortcode = 'gracey_core_stacked_portfolio';

	qodefCore.shortcodes[shortcode] = {};
	

	$(document).ready(function () {
		qodefStackedPortfolio.init();
	});

	var qodefStackedPortfolio = {

		init: function () {
			var holder = $('.qodef-stacked-portfolio');

			if (holder.length) {
				qodef.html.addClass('qodef-overflow');
				//items
				holder.items = holder.find('.qodef-sp-item');
				holder.total = holder.items.length;
				holder.textItems = holder.find('.qodef-sp-text-item');
				holder.imgs = holder.find('img');
				holder.endOfScrollVisible = false;
				holder.endOfScroll = holder.find('.qodef-sp-end-of-scroll');
				//state
				holder.activeIndex = 0;
				holder.activeText = holder.textItems.first();
				holder.direction = null;
				//move
				holder.deltaY = 0;
				//tilt
				holder.tilt = 17;
				holder.tX = 0;
				holder.tY = 0;
				//item move
				holder.items.each(function () {
					$(this).data('move', 0);
					$(this).data('buffer', 0);
				});
			}

			var setIndexes = function () {
				holder.items.each(function () {
					var item = $(this);

					item.css({
						'z-index': holder.total - item.data('index')
					});
				})
			}

			var setWidth = function () {
				var c = 1;
				if (qodef.windowWidth <= 1440 && qodef.windowWidth > 1024) c = 0.65;
				if (qodef.windowWidth <= 1024 && qodef.windowWidth > 768) c = 0.6;
				if (qodef.windowWidth <= 768 && qodef.windowWidth > 414) c = 0.55;
				if (qodef.windowWidth <= 414 && qodef.windowWidth > 320) c = 0.45;
				if (qodef.windowWidth <= 320) c = .2;

				holder.items.each(function () {
					var el = $(this),
						w = (el.find('img')[0].naturalWidth / Math.min(qodef.windowWidth, 1920) * 100).toFixed(2),
						h = (el.find('img')[0].naturalHeight / Math.min(qodef.windowHeight, 1080) * 100).toFixed(2);

					var css = {
						'width': w * c + '%',
						'height': h * c + '%'
					};
					el.css(css);
				})
			};

			var positionItems = function () {
				holder.items.each(function () {
					var item = $(this),
						inner = item.find('.qodef-sp-item-inner'),
						x = parseInt(item.data('x')),
						y = qodef.windowWidth > 1024 ? parseInt(item.data('y')) : undefined;

					if (qodef.windowWidth <= 1024 && qodef.windowWidth > 768) x = parseInt(item.data('x')) * .95;
					if (qodef.windowWidth <= 768 && qodef.windowWidth > 480) x = parseInt(item.data('x')) * .88;
					if (qodef.windowWidth <= 480) x = parseInt(item.data('x')) * .52;

					if (qodef.windowWidth <= 1024 && qodef.windowWidth > 680) y = parseInt(item.data('y')) + 2;

					var offsets = {
						'top': (y || 50) + '%',
						'left': (x || 50) + '%',
					}

					item.css(offsets);
					inner.css('transform', 'translateX(' + parseInt(isNaN(x) ? -50 : 0) + '%) translateY(' + parseInt(isNaN(y) ? -50 : 0) + '%)');
				});
			};

			var offScreen = function (item) {
				return item.offset().top <= -item.height() * 0.97
			}

			var showEndOfScroll = function () {
				holder.endOfScrollVisible = true;
				holder.endOfScroll.addClass('qodef-visible');
				holder.addClass('qodef-eos');
			};

			var hideEndOfScroll = function () {
				holder.endOfScrollVisible = false;
				holder.endOfScroll.removeClass('qodef-visible');
				holder.removeClass('qodef-eos');
			};

			var getActiveItem = function () {
				holder.items.removeClass('qodef-active');
				return holder.items.filter(function () {
					return $(this).data('index') == holder.activeIndex
				});
			};

			var setActiveText = function () {
				holder.textItems.removeClass('qodef-active');
				holder.activeText = holder.textItems.filter(function () {
					return $(this).data('index') == holder.activeIndex
				}).addClass('qodef-active');
			};

			var movement = function () {
				var activeItem = holder.items.filter(function () {
					return $(this).data('index') == holder.activeIndex
				});

				if (holder.direction == 'next' && offScreen(activeItem.find('img'))) {
					holder.activeIndex++;
					if (holder.activeIndex == holder.total) holder.deltaY = 0;
					holder.activeIndex = Math.min(holder.activeIndex, holder.total - 1);
					activeItem = getActiveItem();
				} else if (holder.direction == 'prev') {
					if (activeItem.data('move') == 0) {
						holder.endOfScrollVisible && hideEndOfScroll();
						holder.activeIndex--;
						holder.activeIndex = Math.max(holder.activeIndex, 0);
						activeItem = getActiveItem();
					}
				}

				!holder.endOfScrollVisible &&
				holder.direction == 'next' &&
				holder.activeIndex == holder.total - 1 &&
				Math.abs(activeItem.data('move')) > activeItem.find('img').height() * 0.3 &&
				showEndOfScroll();

				holder.activeText.data('index') !== holder.activeIndex && setActiveText();

				activeItem
					.addClass('qodef-active')
					.data('move', Math.min(activeItem.data('move') + holder.deltaY, 0))
					.css('transform', 'translate3d(0,' + Math.round(activeItem.data('move') - activeItem.data('buffer') * 0.2) + 'px,0)')
					.data('buffer', Math.abs(activeItem.data('move')));

				var lastItem = holder.items.last(),
					lastItemTopOffset = lastItem.offset().top,
					textItems = holder.find('.qodef-sp-text-items');

				if( lastItemTopOffset < 0 ) {
					textItems.css('display', 'none');
				} else {
					textItems.css('display', 'block');
				}
			};

			var tiltImages = function () {
				holder.items.each(function (i) {
					var img = $(this).find('img'),
						valX = Math.round(holder.tX * holder.tilt * ( i + 1)),
						valY = Math.round(holder.tY * holder.tilt * ( i + 1));

					// img.css('transform', 'translateX(' + valX + 'px) translateY(' + valY + 'px)');
					
					gsap.to(img, {
						x: valX + 5 * i ,
						y: valY ,
					})
				});
			};

			var mouseWheel = function (e) {
				holder.direction = -e.deltaY < 0 ? 'next' : 'prev';
				holder.deltaY = -e.deltaY;
				if (Math.abs(holder.deltaY) == 3) holder.deltaY = holder.deltaY * 10; //ffox
				requestAnimationFrame(movement);
			};

			var mouseMove = function (e) {
				holder.tX = 0.5 - e.screenX / qodef.windowWidth;
				holder.tY = 0.5 - e.screenY / qodef.windowHeight;
				requestAnimationFrame(tiltImages);
			};

			var touchStart = function (e) {
				holder.data('y-start', parseInt(e.changedTouches[0].clientY));
			};

			var touchMove = function (e) {
				holder.data('y-end', parseInt(e.changedTouches[0].clientY));
				holder.deltaY = holder.data('y-end') - holder.data('y-start');
				holder.direction = holder.deltaY < 0 ? 'next' : 'prev';
				holder.deltaY = Math.min(Math.max(holder.deltaY, -20), 100);
				requestAnimationFrame(movement);
			};

			if (holder.length) {
				qodef.html.addClass('qodef-overflow');
				holder.items.first().addClass('qodef-active');
				holder.textItems.first().addClass('qodef-active');
				setWidth();
				positionItems();
				setIndexes();

				holder.waitForImages(function () {
					holder.addClass('qodef-loaded');
					//scroll support
					if (!$('html').hasClass('touchevents')) {
						document.body.addEventListener('wheel', mouseWheel);
						document.body.addEventListener('mousemove', mouseMove);
					}
					//touch support
					if ($('html').hasClass('touchevents')) {
						holder[0].addEventListener('touchstart', touchStart);
						holder[0].addEventListener('touchmove', touchMove);
					}
				})
			}
		}
	}
	qodefCore.shortcodes[shortcode].qodefStackedPortfolio  =  qodefStackedPortfolio;

})( jQuery );
