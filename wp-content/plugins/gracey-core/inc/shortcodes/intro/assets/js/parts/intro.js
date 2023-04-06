(function ($) {
	'use strict';
	
	qodefCore.shortcodes.gracey_core_intro = {};
	
	$(document).ready(
		function () {
			qodefIntro.init();
		}
	);
	
	var qodefIntro = {
		init: function () {
			var holder = $('.qodef-intro-section');
			
			if (holder.length) {
				holder.each(function () {
					var $thisHolder = $(this);
					qodefIntro.animateElements($thisHolder);
				});
			}
		},
		animateElements: function (holder) {
			var hasDisappear = holder.hasClass('qodef--has-disappear'),
				stamp = holder.find('.qodef-stamp'),
				text = holder.find('.qodef-custom-font-holder'),
				item = holder.find('.qodef-e-item'),
				tlOut = gsap.timeline({
					paused: true,
				});
				var fixedSection = holder.closest('section');
				var otherSections = fixedSection.siblings();
			
			
			// gsap.set(pageWrapper, {
			// 	y: '100vH',
			// })
			
			
			if (hasDisappear) {
				setTimeout(function () {
					$('html, body').scrollTop(0);
					qodefCore.qodefScroll.disable();
				}, 500);
				
				// $('html, body').scrollTop(0);
				// qodefCore.qodefScroll.disable();
				
				if (history.scrollRestoration) {
					history.scrollRestoration = 'manual';
				} else {
					window.onbeforeunload = function () {
						window.scrollTo(0, 0);
					}
				}
				
				tlOut
					.addLabel('tlOutStart')
					.to(stamp, {
						autoAlpha: 0,
						onStart: () => {
							holder.removeClass('qodef-appear').addClass('qodef-disappear');
						}
					})
					.to(text, {
						y: '-100%',
						autoAlpha: 0,
					}, 'tlOutStart')
					.to(holder, {
						height: 0,
						// y: '-150%',
						duration: 1.5,
						ease: 'sine.out',
						onComplete: () => {
							qodefCore.qodefScroll.enable();
							holder.addClass('qodef-hide-overflow');
						}
					}, 'tlOutStart+=.7')
					.to(otherSections, {
						y: '0',
						duration: 2,
						ease: 'sine.out',
						onComplete: () => {
							qodefCore.qodefScroll.enable();
							holder.addClass('qodef-hide-overflow');
						}
					}, 'tlOutStart+=.7')
				
				
				$(window).on('wheel touchstart', function (e) {
					if (holder.hasClass('qodef-animation-end')) {
						tlOut.play();
					}
				});

				stamp.on('click', function (e) {
					if (holder.hasClass('qodef-animation-end')) {
						e.preventDefault();
						tlOut.play();
					}
				});
			}
			
			if (!hasDisappear) {
				qodefCore.qodefIsInViewport.check(
					holder,
					function () {
						holder.addClass('qodef-appear');
					}
				);
			} else {
				var isEditMode = Boolean(elementorFrontend.isEditMode());
				
				if (isEditMode) {
					holder.addClass('qodef-appear');
				}
			}
		},
	};
	
	qodefCore.shortcodes.gracey_core_intro.qodefIntro = qodefIntro;
	
})(jQuery);
