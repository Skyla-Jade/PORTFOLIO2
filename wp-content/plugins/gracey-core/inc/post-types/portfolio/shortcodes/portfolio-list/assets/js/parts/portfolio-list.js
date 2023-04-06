(function ($) {
	"use strict";
	
	var shortcode = 'gracey_core_portfolio_list';
	
	qodefCore.shortcodes[shortcode] = {};
	
	if (typeof qodefCore.listShortcodesScripts === 'object') {
		$.each(
			qodefCore.listShortcodesScripts,
			function (key, value) {
				qodefCore.shortcodes[shortcode][key] = value;
			}
		);
	}
	
	$(document).ready(function () {
		qodefCustomHorizontalSlider.calculateHeight();
		qodefCustomHorizontalSlider.init();
		qodefSkewSlider.init();
	});
	
	var qodefSkewSlider = {
		init: function () {
			var holder = $('.qodef-skew-slider-holder.qodef--has-appear');
			
			if (holder.length) {
				holder.each(function () {
					var $thisHolder = $(this);
					qodefSkewSlider.animateElements($thisHolder);
				});
			}
		},
		
		animateElements: function ($holder) {
			var $slider = $holder.find('.qodef-swiper-container'),
				$sliderHolder = $holder.find('.qodef-slider-holder'),
				$marquee = $holder.find('.qodef-text-marquee .qodef-m-content'),
				autoplayEnabled = $slider.data('options').autoplay,
				isSafari = qodefCore.body.hasClass('qodef-browser--safari'),
				labelDelay = $marquee.length ? 1.3 : .15,
				isEditorActive = qodefCore.body.hasClass('elementor-editor-active');
			
			if (!isEditorActive) {
				gsap.set($sliderHolder[0], {
					xPercent: 116,
					yPercent: -14.3,
				})
				
				$slider[0].swiper.autoplay.stop();
				
				
				// if (!isSafari) {
				// 	setTimeout(function () {
				// 		$slider[0].swiper.slideTo(1, 0);
				// 		// $slider[0].swiper.update();
				// 	}, 10);
				// } else {
				// 	setTimeout(function () {
				// 		$slider[0].swiper.slideTo(1, 0);
				// 		// $slider[0].swiper.update();
				// 	}, 10);
				// }
				setTimeout(function () {
					$slider[0].swiper.slideTo(1, 0);
				}, 10);
				
				// setTimeout(function () {
				// 	$slider[0].swiper.update();
				// }, 400);
				// setTimeout(function () {
				// 	$slider[0].swiper.slideTo(1, 0);
				// }, 10);
			}
			
			var tl = gsap.timeline({
					paused: true,
					// smoothChildTiming: true,
					onStart: () => {
						$slider[0].swiper.update();
						// if( isSafari && !isEditorActive) {
						// 	$slider[0].swiper.setTranslate(0);
						// }
						
						// $slider[0].swiper.slideTo(1, 0);
					},
				}
			);
			
			tl.addLabel("skewSliderStart");
			
			if ($marquee.length) {
				tl.to($marquee, {
					x: 0,
					duration: 5.5,
					stagger: .2,
					delay: -.5,
					ease: 'power2.out',
					onStart: () => {
						setTimeout(function(){
							$marquee.parent().removeClass('qodef-marquee-paused');
						}, 3300);
					},
				})
			}
			
			if (!isEditorActive) {
				tl.to($sliderHolder[0], {
					xPercent: 0,
					yPercent: 0,
					duration: 2.5,
					ease: 'power4.out',
					// transformOrigin: '50% 50%',
					// immediateRender: true,
					onStart: () => {
						gsap.to($sliderHolder[0], {
							opacity: 1,
							duration: .15,
						})
					},
					onComplete: () => {
						if (autoplayEnabled) {
							$slider[0].swiper.autoplay.start();
						}
					},
				}, `skewSliderStart+=${labelDelay}`);
			}
			
			qodefCore.qodefIsInViewport.check(
				$holder,
				function () {
					// $slider[0].swiper.slideTo(1, 0);
					tl.play();
				}
			);
		}
	}
	
	var qodefCustomHorizontalSlider = {
		init: function () {
			var holder = $('.qodef-layout--horizontal_slider');
			
			if (holder.length) {
				holder.each(function () {
					var $thisHolder = $(this);
					
					qodefCustomHorizontalSlider.animateSlider($thisHolder);
				});
			}
		},
		animateSlider: function ($thisHolder) {
			var $holderText = $thisHolder.find('.qodef-horizontal-custom-content'),
				$itemsHolder = $thisHolder.find('.qodef-items-holder'),
				$itemsHolderInner = $itemsHolder.find('.qodef-items-holder-inner'),
				$items = $itemsHolder.find('.qodef-e'),
				$itemsHolderWidth = $itemsHolderInner.width(),
				$opacityVal = 1,
				$scrollItemOffset = 50,
				$scrollInitItemOffset = 50;
			
			if (qodef.windowWidth < 769) {
				$scrollItemOffset = (qodef.windowWidth / 2) * -1;
				$scrollInitItemOffset = 350;
			}
			
			$holderText.addClass('qodef--appear');
			
			if (qodef.windowWidth > 680) {
				var $Scrollbar = window.Scrollbar;
				
				$Scrollbar.use(HorizontalScrollPlugin);
				$Scrollbar.use(window.OverscrollPlugin);
				
				var $myScrollbar = $Scrollbar.init(document.querySelector('.qodef-layout--horizontal_slider'),
					{
						damping: 0.05,
						plugins: {
							overscroll: {
								damping: 0.01,
								// maxOverscroll: 100
								maxOverscroll: 50
							}
						}
					}
				);
				
				$itemsHolder.css('width', $itemsHolderWidth);
				
				$itemsHolderInner.each(function ($i) {
					var $thisOffsetLeft = $itemsHolderWidth * ($i + 1);
					
					$(this).attr('data-offset-left', $thisOffsetLeft);
					$(this).data('offset-left', $thisOffsetLeft);
				});
				
				$itemsHolderInner.each(function ($i) {
					var $thisItem = $(this);
					
					if (qodef.windowWidth / 2 + $scrollInitItemOffset > $(this).data('offset-left')) {
						setTimeout(function () {
							$thisItem.addClass('qodef--appear');
						}, $i * 200)
					}
				})
				
				$myScrollbar.addListener(function () {
					var $scrollbarOffset = this.offset.x,
						$windowOffset = qodef.windowWidth / 2 - $scrollItemOffset;
					
					$itemsHolderInner.each(function () {
						if ($scrollbarOffset + $windowOffset > $(this).data('offset-left')) {
							$(this).addClass('qodef--appear');
						}
					});
					
					if ($scrollbarOffset < 100) {
						// $holderText.css('opacity', $opacityVal - $scrollbarOffset / $windowOffset * 3);
						$holderText.find('.qodef-horizontal-custom-content-inner').css('opacity', '1');
					} else {
						$holderText.find('.qodef-horizontal-custom-content-inner').css('opacity', '0');
					}
					
					$holderText.css({
						'transform': 'translate3d(' + $scrollbarOffset + 'px, 0, 0)',
						'transition': 'none'
					});
				});
			} else {
				$items.each(function () {
					var $thisItem = $(this);
					
					// $thisItem.appear(function () {
					// 	$thisItem.addClass('qodef--appear');
					// }, {accX: 0, accY: -100});
					
					$thisItem.addClass('qodef--appear');
				});
			}
		},
		calculateHeight: function () {
			var holder = $('.qodef-layout--horizontal_slider'),
				pageHeader = $('#qodef-page-header'),
				mobileHeader = $('#qodef-page-mobile-header'),
				pageFooter = $('#qodef-page-footer'),
				headerHeight = 0,
				footerHeight = 0;
			
			if (holder.length) {
				$('body').addClass('qodef--full-height-portfolio');
				
				if (qodef.windowWidth > 1024) {
					if (pageHeader.length) {
						headerHeight = pageHeader.outerHeight();
					}
				} else {
					if (mobileHeader.length) {
						headerHeight = mobileHeader.outerHeight();
					}
				}
				
				if (pageFooter.length) {
					footerHeight = pageFooter.outerHeight();
				}
				
				var holderHeight = headerHeight + footerHeight;
				if ($('body').hasClass('admin-bar')) {
					holderHeight = holderHeight + 32;
				}
			}
			
			if (qodef.windowWidth > 680) {
				if (holder.length) {
					holder.each(function () {
						var $thisHolder = $(this);
						
						$thisHolder.css('height', 'calc(100vh - ' + holderHeight + 'px)');
					});
				}
			}
		},
	}
	
	qodefCore.shortcodes[shortcode].qodefSkewSlider = qodefSkewSlider;
	
	qodefCore.shortcodes[shortcode].qodefCustomHorizontalSlider = qodefCustomHorizontalSlider;
	
	qodefCore.shortcodes[shortcode].qodefDistortAnimation = qodefCore.qodefDistortAnimation;
	
})(jQuery);
