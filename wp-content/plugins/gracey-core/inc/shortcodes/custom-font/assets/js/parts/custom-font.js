(function ($) {
	'use strict';
	
	qodefCore.shortcodes.gracey_core_custom_font = {};
	
	$(document).ready(
		function () {
			qodefCustomFont.init();
			qodefCustomFontDistortion.init();
		}
	);
	
	var qodefCustomFont = {
		init: function () {
			this.holder = $('.qodef-custom-font-holder.qodef--custom-o-animation');
			
			if (this.holder.length) {
				this.holder.each(
					function () {
						var $thisHolder = $(this),
							str = $thisHolder.text().toLowerCase(),
							newStr = str.replace(/o/g, '<span>o</span>');
						
						$thisHolder.html('<span class="qodef-custom-font-inner">' + newStr + '</span>');
					}
				);
			}
		}
	};
	
	var qodefCustomFontDistortion = {
		init: function () {
			this.holder = $('.qodef-custom-font-holder.qodef--distort-text-animation');
			
			if (this.holder.length) {
				this.holder.each(
					function () {
						var $thisHolder = $(this);
						
						qodefCustomFontDistortion.animate($thisHolder);
					}
				);
			}
		},
		animate: function (holder) {
			var initText = holder.text(),
				speed = holder.hasClass('qodef--distort-text-animation--slow') ? .3 : .5,
				customDisappear = holder.parents().hasClass('qodef--has-disappear'),
				text = new Blotter.Text(initText, {
					size: parseInt(holder.css("font-size")),
					family: holder.css("font-family"),
					weight: holder.css("font-weight"),
					fill: holder.css("color"),
					paddingLeft: 100,
					paddingRight: 100,
					leading: 1.1,
					style: 'normal',
				});
			var tl = gsap.timeline({
				paused: true,
			});
			
			
			var material = new Blotter.LiquidDistortMaterial();
			material.uniforms.uSpeed.value = speed;
			// material.uniforms.uVolatility.value = 0.07;
			material.uniforms.uVolatility.value = 0;
			material.uniforms.uSeed.value = .1;
			
			
			var blotter = new Blotter(material, {
				texts: text,
				autostart: false,
			});
			
			holder.wrapInner("<div class='qodef--hidden-text'></div>");
			
			var scope = blotter.forText(text);
			
			scope.appendTo(holder);
			
			// material.needsUpdate = true;
			tl.fromTo(
				material.uniforms.uVolatility, .8,
				{
					value: 0,
				},
				{
					value: .07,
					// delay: 5,
					onReverseComplete: () =>{
						blotter.stop();
					}
				}
			);
			
			qodefCustomFontDistortion.control(holder, customDisappear, blotter, tl);
		},
		control: function (holder, customDisappear, blotter, tl) {
			if (customDisappear) {
				var stampHolder = customDisappear ? holder.parents().find('.qodef--has-disappear') : false,
					stamp = stampHolder ? stampHolder.find('.qodef-stamp') : false;
				
				blotter.start();
				tl.play();
				
				stamp.on('click', function (e) {
					// blotter.stop();
					if (holder.hasClass('qodef-animation-end')){
						tl.reverse();
					}
				})
				
				$(window).one('wheel touchstart', function () {
					if (holder.hasClass('qodef-animation-end')) {
						tl.reverse();
					}
				});
				
			} else {
				qodefCore.qodefIsInViewport.check(
					holder,
					function () {
						blotter.start();
						tl.play();
					}, false,
					function () {
						blotter.stop();
					}
				);
			}
		}
	};
	
	qodefCore.shortcodes.gracey_core_custom_font.qodefCustomFont = qodefCustomFont;
	
})(jQuery);
