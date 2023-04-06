(function ($) {
	'use strict';
	
	qodefCore.shortcodes.gracey_core_portfolio_vertical_slider = {};
	
	$(document).ready(function () {
		qodefPortfolioVerticalSlider.init();
		qodefPortfolioVerticalSlider.addBodyClass();
	});
	
	var qodefPortfolioVerticalSlider = {
		
		init: function () {
			var holder = $('.qodef-portfolio-vertical-slider');
			
			if (holder.length) {
				
				qodef.html.addClass('qodef-overflow');
				
				holder.each(function () {
					var thisHolder = $(this),
						slider = thisHolder.find('.swiper-container'),
						hasDistortEffect = thisHolder.hasClass('qodef--custom-distort-animation-list'),
						isSafari = qodefCore.body.hasClass('qodef-browser--safari'),
						disabledDistortEffectSafari = isSafari && thisHolder.hasClass('qodef--distort-animation-disabled-on-safari');
					
					thisHolder.css('height', qodef.windowHeight - thisHolder.offset().top);
					
					var addFixedContent = function () {
						
						var fixedContent = thisHolder.find('.qodef-pvs-fixed-content'),
							content = thisHolder.find('article:not(.swiper-slide-duplicate) .qodef-e-content');
						
						content.each(function (i) {
							var c = $(this).html();
							fixedContent.append('<div class="qodef-pvs-fixed-item" data-index="' + i + '"><div>' + c + '</div></div>');
						});
						fixedContent.find('.qodef-pvs-fixed-item > div').children().each(function () {
							if ($(this).hasClass('qodef-e-excerpt')) {
								$(this).wrap("<div class='qodef-mask qodef-excerpt-mask' />");
							} else {
								$(this).wrap("<div class='qodef-mask' />");
							}
							$(this).parent().after("<div class='qodef-separate'></div>");
						});
					}
					
					var changeFixedContent = function () {
						var activeIndex = slider.find('article.swiper-slide-active').data('swiper-slide-index'),
							items = thisHolder.find('.qodef-pvs-fixed-item');
						
						var activeItem = items
							.removeClass('qodef-show')
							.filter(function () {
								return $(this).data('index') == activeIndex;
							})
							.addClass('qodef-show');
						
						var masks = activeItem.find('.qodef-mask');
						masks.each(function (i) {
							var c = $(this).children();
							
							gsap.fromTo(c, {
								y: '0%',
								x: '120%',
								// skewY: '6deg',
								autoAlpha: 0,
							}, {
								y: '0%',
								x: '0',
								skewY: '0deg',
								autoAlpha: 1,
								ease: 'power4.out',
								delay: i * .2,
								duration: .9
							});
						})
						
					}
					
					qodef.windowWidth >= 768 && addFixedContent();
					
					var sliderOptions = typeof slider.data('options') !== 'undefined' ? slider.data('options') : {},
						spaceBetween = sliderOptions.spaceBetween !== undefined && sliderOptions.spaceBetween !== '' ? sliderOptions.spaceBetween : 0,
						slidesPerView = qodef.windowWidth > 680 ? 1.6 : 1;
					
					new Swiper(slider, {
						direction: 'vertical',
						loop: true,
						autoplay: false,
						slidesPerView: slidesPerView,
						spaceBetween: spaceBetween,
						centeredSlides: true,
						speed: 700,
						on: {
							init: function () {
								thisHolder.addClass('qodef-init');
							},
							slideChangeTransitionStart: function () {
								qodef.windowWidth >= 768 && changeFixedContent();
								var activeItem = slider.find('.swiper-slide-active'),
									bgColor = activeItem.data('slide-bg-color');
								
								if (bgColor !== false && bgColor !== undefined) {
									TweenLite.to(thisHolder, 1, {
										backgroundColor: bgColor
									})
								}
							}
						}
					});
					
					var scrollStart = false;
					qodefCore.html.on('wheel', function (e) {
						// e.preventDefault();
						if (!scrollStart) {
							scrollStart = true;
							var delta = e.originalEvent.deltaY;
							if (delta > 0) {
								slider[0].swiper.slideNext();
							} else {
								slider[0].swiper.slidePrev();
							}
							setTimeout(function () {
								scrollStart = false;
							}, 1000);
						}
					});
					
					if (hasDistortEffect && !disabledDistortEffectSafari) {
						qodefPortfolioVerticalSlider.addDistortEffect(thisHolder);
					}
				});
			}
		},
		addBodyClass: function () {
			var slider = qodef.body.find('.qodef-portfolio-vertical-slider');
			if (slider.length) {
				qodef.body.addClass('qodef-portfolio-vertical-slider-initialized');
			}
		},
		addDistortEffect: function (item) {
			var svg = item.find('.qodef-svg-distort-filter'),
				filter = svg.find('filter'),
				filterId = filter.attr("id"),
				displacementMap = filter.find('feDisplacementMap')[0],
				displacementMapScale = {val: 0},
				itemFilterHolder = item.find('.swiper-slide-active .qodef-e-media-image'),
				animationRepeat = 1,
				animationYoyo = true,
				animationDuration = .4,
				animationEase = 'power1.out',
				yoyoEase = true,
				slider = item.find('.swiper-container');
			
			item.timeline = gsap.timeline({
				paused: true,
				defaults: {
					duration: animationDuration,
					ease: animationEase,
					repeat: animationRepeat,
					yoyo: animationYoyo,
					yoyoEase: yoyoEase,
				},
				onStart: () => {
					itemFilterHolder = item.find('.swiper-slide-active .qodef-e-media-image img')[0];
					
					gsap.set(itemFilterHolder, {
						filter: 'url(#' + filterId + ')',
					});
				},
				onComplete: () => {
					gsap.set(itemFilterHolder, {
						filter: 'none',
					});
				},
				onUpdate: () => {
					displacementMap.setAttribute('scale', displacementMapScale.val);
				}
			});
			
			item.timeline.to(displacementMapScale, {
				startAt: {
					val: 0
				},
				val: 50,
			}, 0);
			
			// slider[0].swiper.on('slideChangeTransitionStart imagesReady', function () {
			// 	item.timeline.restart();
			// })
			slider[0].swiper.on('slideChangeTransitionStart imagesReady', function () {
				item.timeline.restart();
			})
		}
	}
	
	qodefCore.shortcodes.gracey_core_portfolio_vertical_slider.qodefPortfolioVerticalSlider = qodefPortfolioVerticalSlider;
	
})(jQuery);
