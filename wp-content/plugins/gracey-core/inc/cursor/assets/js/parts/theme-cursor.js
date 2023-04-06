(function ($) {
	'use strict';
	
	$(document).ready(function () {
		qodefThemeCursor().init();
	});
	
	function qodefThemeCursor() {
		var cursorEnabled = qodef.body.hasClass('qodef-theme-cursor'),
			cursor = $('#qodef-theme-cursor'),
			cursorCross = cursor.find('.qodef-cursor-cross'),
			cursorSquare = cursor.find('.qodef-cursor-square'),
			lastX = 0,
			lastY = 0,
			dotDuration = 0,
			dotEase = 'none';
		// function for linear interpolation of values
		// const lerp = (a, b, n) => {
		// 	return (1 - n) * a + n * b;
		// };
		
		var moveCursor = function () {
			var transformCursor = function (x, y) {
				cursorCross.css({
					'transform': 'translate3d(' + x + 'px, ' + y + 'px, 0)'
				});
				
				cursorSquare.css({
					'transform': 'translate3d(' + x + 'px, ' + y + 'px, 0)'
				});
				
				// if (!cursor.hasClass('qodef-separate')){
				//     cursorSquare.css({
				//         'transform': 'translate3d(' + x + 'px, ' + y + 'px, 0)'
				//     });
				// } else {
				//     lastX = lerp(lastX, x, 1);
				//     lastY = lerp(lastY, y, 1);
				//
				//     gsap.to(cursorSquare,{
				//         x: lastX,
				//         y: lastY,
				//     })
				// }
				
				// if (!cursor.hasClass('qodef-separate')) {
				//     dotDuration = 0;
				//     dotEase = 'none';
				// } else {
				
				
				//     dotDuration = .5;
				//     dotEase = 'power2.out';
				// }
				//
				// gsap.to(cursorSquare,{
				//     x: x,
				//     y: y,
				//     duration: dotDuration,
				//     ease: 'none',
				// })
			}
			
			var handleMove = function (e) {
				var x = e.clientX - cursor.width() / 2,
					y = e.clientY - cursor.height() / 2;
				
				requestAnimationFrame(function () {
					transformCursor(x, y);
				});
			}
			
			$(window).on('mousemove', handleMove);
		}
		
		var hoverClass = function () {
			var items = 'a, button, .tp-bullet, .tp-withaction, button, .qodef-pl-filter, .ui-slider-handle, .swiper-pagination-clickable .swiper-pagination-bullet, .swiper-button-next, .swiper-button-prev, .tp-leftarrow, .tp-rightarrow,.qodef--custom-mouse-icon, .qodef-woo-single-image img';
			var addCSSClass = function () {
				!cursor.hasClass('qodef-hovering') && cursor.addClass('qodef-hovering');
			}
			
			var removeCSSClass = function () {
				cursor.hasClass('qodef-hovering') && cursor.removeClass('qodef-hovering');
			}
			
			$(document).on('mouseenter', items, addCSSClass);
			$(document).on('mouseleave', items, removeCSSClass);
		}
		
		var separateClass = function () {
			var items = '.qodef-portfolio-list:not(.qodef-swiper-container):not(.qodef-hover-animation--follow) .qodef-e-image, .qodef-portfolio-list.qodef-swiper-container, .qodef-portfolio-list.qodef-hover-animation--follow, ' +
				'.qodef-blog-item .qodef-e-media-image,#qodef-woo-page.qodef--single .qodef-woo-single-image .zoomImg, .qodef-woo-product-list .qodef-woo-product-image, .qodef-video-button, .qodef-landing-image-with-text,' +
				'.qodef-image-gallery.qodef-swiper-container, .qodef-cards-gallery .qodef-m-card, .qodef-portfolio-vertical-slider .qodef-e-image'
			
			var addCSSClass = function () {
				!cursor.hasClass('qodef-separate') && cursor.addClass('qodef-separate');
			}
			
			var removeCSSClass = function () {
				cursor.hasClass('qodef-separate') && cursor.removeClass('qodef-separate');
			}
			
			$(document).on('mouseenter', items, addCSSClass);
			$(document).on('mouseleave', items, removeCSSClass);
		}
		
		var showCursor = function () {
			!cursor.hasClass('qodef-visible') && cursor.addClass('qodef-visible');
		}
		
		var hideCursor = function () {
			cursor.hasClass('qodef-visible') && cursor.removeClass('qodef-visible qodef-hovering');
		}
		
		var overrideCursor = function () {
			cursor.toggleClass('qodef-override');
		}
		
		
		var changeCursor = function () {
			var instances = [
					{
						type: 'light',
						triggers: '.qodef-interactive-link-showcase.qodef-skin--light, #qodef-page-header-inner.qodef-skin--light'
					},
					{
						type: 'dark',
						triggers: '.qodef-portfolio-list.qodef--disabled-info-follow-bg.qodef-item-layout--info-follow'
					},
					// {
					//     type: 'preloader',
					//     triggers: '#qodef-page-spinner'
					// },
				],
				triggers = '',
				hides = 'iframe',
				overrides = '#qodef-fullscreen-area, .qodef-fullscreen-menu-opener .qodef--close';
			
			var setCursor = function (type) {
				cursor.addClass('qodef-' + type);
			}
			
			var resetCursor = function () {
				instances.forEach(function (instance) {
					cursor.removeClass('qodef-' + instance.type);
				});
			}
			
			instances.forEach(function (instance, i) {
				triggers += instance.triggers;
				if (i + 1 < instances.length) triggers += ', ';
				
				$(document).on('mouseenter', instance.triggers, function () {
					setCursor(instance.type);
				});
			});
			
			$(document).on('mouseleave', triggers, resetCursor);
			
			$(document).on('mouseenter mouseleave', overrides, function () {
				overrideCursor();
			});
			$(document).on('mousemove', hides, function () {
				hideCursor();
			});
			$(document).on('mouseleave', hides, function () {
				showCursor();
			});
			$(document).on('mouseleave', hideCursor);
			$(document).on('mouseenter', showCursor);
		}
		
		var blinkClass = function () {
			$(document).on('click', 'a:not(.qodef-popup-item)', function (e) {
				var a = $(this);
				if (
					e.which === 1 &&
					a.attr('href').indexOf(window.location.host) >= 0 &&
					(typeof a.attr('target') === 'undefined' || a.attr('target') === '_self') && // check if the link opens in the same window
					(a.attr('href').split('#')[0] !== window.location.href.split('#')[0])
				) {
					cursor
						/*.removeClass()*/
						.addClass('qodef-blink');
				}
			})
		}
		
		var isIE = function () {
			
			var ua = window.navigator.userAgent;
			var msie = ua.indexOf("MSIE ");
			var isIE = false;
			
			if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./))  // If Internet Explorer
			{
				isIE = true;
				
				if (cursorEnabled) {
					qodef.body.removeClass('qodef-theme-cursor');
				}
			} else  // If another browser
			{
				isIE = false;
			}
			
			return isIE;
		}
		
		var init = function () {
			$(document).one('mousemove', function () {
				showCursor();
			});
			moveCursor();
			hoverClass();
			separateClass();
			changeCursor();
			blinkClass();
		}
		
		return {
			init: function () {
				!Modernizr.touch && cursorEnabled && !isIE() && init();
			}
		}
	}
})(jQuery);