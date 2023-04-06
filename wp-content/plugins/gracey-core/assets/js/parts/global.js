(function ( $ ) {
	'use strict';

	// This case is important when theme is not active
	if ( typeof qodef !== 'object' ) {
		window.qodef = {};
	}

	window.qodefCore                = {};
	qodefCore.shortcodes            = {};
	qodefCore.listShortcodesScripts = {
		qodefSwiper: qodef.qodefSwiper,
		qodefPagination: qodef.qodefPagination,
		qodefFilter: qodef.qodefFilter,
		qodefMasonryLayout: qodef.qodefMasonryLayout,
		qodefJustifiedGallery: qodef.qodefJustifiedGallery,
	};

	qodefCore.body         = $( 'body' );
	qodefCore.html         = $( 'html' );
	qodefCore.windowWidth  = $( window ).width();
	qodefCore.windowHeight = $( window ).height();
	qodefCore.scroll       = 0;

	$( document ).ready(
		function () {
			qodefCore.scroll = $( window ).scrollTop();
			qodefInlinePageStyle.init();
			qodefDistortAnimation.init();
		}
	);
	
	$( document ).on(
		'gracey_trigger_get_new_posts',
		function () {
			qodefDistortAnimation.init();
		}
	);

	$( window ).resize(
		function () {
			qodefCore.windowWidth  = $( window ).width();
			qodefCore.windowHeight = $( window ).height();
		}
	);

	$( window ).scroll(
		function () {
			qodefCore.scroll = $( window ).scrollTop();
		}
	);

	var qodefScroll = {
		disable: function () {
			if ( window.addEventListener ) {
				window.addEventListener(
					'wheel',
					qodefScroll.preventDefaultValue,
					{ passive: false }
				);
			}

			// window.onmousewheel = document.onmousewheel = qodefScroll.preventDefaultValue;
			document.onkeydown = qodefScroll.keyDown;
		},
		enable: function () {
			if ( window.removeEventListener ) {
				window.removeEventListener(
					'wheel',
					qodefScroll.preventDefaultValue,
					{ passive: false }
				);
			}
			window.onmousewheel = document.onmousewheel = document.onkeydown = null;
		},
		preventDefaultValue: function ( e ) {
			e = e || window.event;
			if ( e.preventDefault ) {
				e.preventDefault();
			}
			e.returnValue = false;
		},
		keyDown: function ( e ) {
			var keys = [37, 38, 39, 40];
			for ( var i = keys.length; i--; ) {
				if ( e.keyCode === keys[i] ) {
					qodefScroll.preventDefaultValue( e );
					return;
				}
			}
		}
	};

	qodefCore.qodefScroll = qodefScroll;

	var qodefPerfectScrollbar = {
		init: function ( $holder ) {
			if ( $holder.length ) {
				qodefPerfectScrollbar.qodefInitScroll( $holder );
			}
		},
		qodefInitScroll: function ( $holder ) {
			var $defaultParams = {
				wheelSpeed: 0.6,
				suppressScrollX: true
			};

			var $ps = new PerfectScrollbar(
				$holder[0],
				$defaultParams
			);

			$( window ).resize(
				function () {
					$ps.update();
				}
			);
		}
	};

	qodefCore.qodefPerfectScrollbar = qodefPerfectScrollbar;
	
	/**
	 * Check element to be in the viewport
	 */
	var qodefIsInViewport = {
		check: function ( $element, callback, onlyOnce, callbackIfFalse = false ) {
			if ( $element.length ) {
				var offset = typeof $element.data( 'viewport-offset' ) !== 'undefined' ? $element.data( 'viewport-offset' ) : 0.1; // When item is 10% in the viewport
				
				var observer = new IntersectionObserver(
					function ( entries ) {
						// isIntersecting is true when element and viewport are overlapping
						// isIntersecting is false when element and viewport don't overlap
						if ( entries[0].isIntersecting === true ) {
							callback.call( $element );
							
							// Stop watching the element when it's initialize
							if ( onlyOnce !== false ) {
								observer.disconnect();
							}
						} else if ( callbackIfFalse !== false ){
							callbackIfFalse.call( $element );
						}
					},
					{ threshold: [offset] }
				);
				
				observer.observe( $element[0] );
			}
		},
	};
	
	qodefCore.qodefIsInViewport = qodefIsInViewport;

	var qodefInlinePageStyle = {
		init: function () {
			this.holder = $( '#gracey-core-page-inline-style' );

			if ( this.holder.length ) {
				var style = this.holder.data( 'style' );

				if ( style.length ) {
					$( 'head' ).append( '<style type="text/css">' + style + '</style>' );
				}
			}
		}
	};
	
	var qodefDistortAnimation = {
		init: function () {
			// this.holder = $( '.qodef--distort-animation:not(.qodef--distort-effect-5), .qodef--distort-animation-list .qodef-e-inner' );
			this.holder = $( '.qodef--distort-animation:not(.qodef--distort-effect-5), .qodef--distort-animation-list .qodef-e-inner' );
			var isSafari = qodefCore.body.hasClass('qodef-browser--safari');
			
			if ( this.holder.length ) {
				this.holder.each(
					function (index) {
						var thisHolder = $(this),
							disabledDistortEffectSafari = isSafari && (thisHolder.hasClass('qodef--distort-animation-disabled-on-safari') || thisHolder.closest('.qodef--distort-animation-list').hasClass('qodef--distort-animation-disabled-on-safari') ),
							disabledMobile = (thisHolder.hasClass('qodef--distort-animation-disabled-on-mobile') || thisHolder.closest('.qodef--distort-animation-list').hasClass('qodef--distort-animation-disabled-on-mobile') );
						
						// if (disabledDistortEffectSafari) {
						// 	// return false;
						// } else if(disabledMobile){
						// 	if (qodefCore.windowWidth > 1024){
						// 		qodefDistortAnimation.initItem(thisHolder, index);
						// 	}
						// } else {
						// 	qodefDistortAnimation.initItem(thisHolder, index);
						// }
						
						if (!disabledDistortEffectSafari){
							if(disabledMobile){
								if (qodefCore.windowWidth > 1024){
									qodefDistortAnimation.initItem(thisHolder, index);
								}
							} else {
								qodefDistortAnimation.initItem(thisHolder, index);
							}
						}
						
						// thisHolder.closest('.qodef--distort-animation-list').css('border','10px solid red');
					}
				)
			}
		},
		initItem: function (item, index ) {
			var itemFilterHolder = item.find('.qodef--item-filter-holder');
			
			if (!itemFilterHolder.length) {
				item.wrapInner( "<div class='qodef--item-filter-holder'></div>" );
				itemFilterHolder = item.find('.qodef--item-filter-holder');
			}
			
			if (!item.find('.qodef-svg-distort-filter').length) {
				qodefDistortAnimation.appendSvg( item, index);
			}
			
			var svg = item.find('.qodef-svg-distort-filter'),
				filter = svg.find('filter'),
				filterId = filter.attr("id"),
				displacementMap = filter.find('feDisplacementMap')[0],
				displacementMapScale = { val: 0},
				turbulence = filter.find('feTurbulence')[0],
				turbulenceBaseFrequency = { val: 0},
				infiniteAnimation = item.hasClass('qodef--infinite-animation') ? true : false,
				animationRepeat = infiniteAnimation ? -1 : 0,
				animationYoyo = infiniteAnimation ? true : false,
				effect = function(effect){
					if (item.hasClass('qodef--distort-effect-2')){
						effect = 'effect-2';
						return effect;
					} else if (item.hasClass('qodef--distort-effect-3')){
						effect = 'effect-3';
						return effect;
					} else if (item.hasClass('qodef--distort-effect-4')){
						effect = 'effect-4';
						return effect;
					} else if (item.hasClass('qodef--distort-effect-5')) {
						effect = 'effect-5';
						return effect
					} else {
						effect = 'default';
						return effect;
					}
				},
				animationDuration = ( effect() == 'effect-4' && infiniteAnimation )|| effect() == 'effect-5' ? 1 : .7,
				animationEase = ( effect() == 'effect-4' && infiniteAnimation ) ? 'none' : 'power1.out',
				hiddenOverflow = item.hasClass('qodef--distort-hide-overflow') || item.parents().hasClass('qodef--distort-hide-overflow'),
				yoyoEase = false,
				onlyEnterAnimation = item.hasClass('qodef--only--enter-animation') || item.parents().hasClass('qodef--only--enter-animation') ? true : false,
				customSwiperAnimation = item.parents().hasClass('qodef-layout--full_slider') || item.parents().hasClass('qodef-portfolio-vertical-slider-1')? true : false;
			
			if (onlyEnterAnimation || customSwiperAnimation) {
				animationDuration = .4;
				animationYoyo = true;
				animationRepeat = 1;
				yoyoEase = true;
			}

			gsap.set(svg, {transformOrigin: '50% 50%'});
			
			//create duplicate of an image to hide distortion on image edges
			if ( ( !item.find('.qodef--distort-img-clone').length ) &&  hiddenOverflow ) {
				itemFilterHolder.eq(0).find('img').clone().addClass('qodef--distort-img-clone').insertBefore(itemFilterHolder.eq(0));
			}

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
					gsap.set(itemFilterHolder, {
						filter: 'url(#' + filterId + ')',
					});
				},
				onReverseComplete: () => {
					if (!infiniteAnimation) {
						gsap.set(itemFilterHolder, {
							filter: 'none',
						});
					}
				},
				onUpdate: () => {
					if ( effect() == 'effect-4' || effect() == 'effect-5' ){
						turbulence.setAttribute('baseFrequency', turbulenceBaseFrequency.val)
					} else {
						displacementMap.setAttribute('scale', displacementMapScale.val)
					}
				}
			});
			
			gsap.set(itemFilterHolder, {
				filter: 'url(#' + filterId + ')',
			});

			switch (effect()) {
				case 'effect-2':
					item.timeline.to(itemFilterHolder, {
						xPercent: -9,
						yPercent: -2,
						rotate: -4,
					}, 0);

					item.timeline.to(displacementMapScale, {
						startAt: {
							val: 0
						},
						val: 150,
					}, 0);

					break;
				case 'effect-3':
					item.timeline.to(displacementMapScale, {
						startAt: {
							val: 0
						},
						val: 30,
						duration: 1,
					});

					break;
				case 'effect-4':
					if (infiniteAnimation) {
						item.timeline.fromTo(turbulenceBaseFrequency, {
								val: 0.02,
							},
							{
								val : .04,
							},"<");
					} else {
						item.timeline.to(turbulenceBaseFrequency, {
							val : .05,
						});
					}
					break;
				case 'effect-5':
				item.timeline.fromTo(turbulenceBaseFrequency, {
						val: 0.005,
					},
					{
						val : .009,
					});
				break;
				default:
					item.timeline.to(displacementMapScale, {
						startAt: {
							val: 0
						},
						val: 170,
					}, 0);

					break;
			}
			
			if (!customSwiperAnimation) {
				qodefDistortAnimation.initEvents( item, infiniteAnimation, onlyEnterAnimation );
			} else {
				var slider  =  item.closest('.qodef-swiper-container');
				slider[0].swiper.on('imagesReady', function(){

					if ( item.parents().hasClass('swiper-slide-active')){
						item.timeline.restart();
					}
				})

				slider[0].swiper.on('slideChangeTransitionStart', function(){
					// if ( item.parents().hasClass('swiper-slide-active') || item.parents().hasClass('swiper-slide-prev')){
					// 	item.timeline.restart();
					// }

					if ( item.parents().hasClass('swiper-slide-active')){
						item.timeline.restart();
					}
				})
			}
			
			// item.timeline.restart();
		},
		appendSvg(item, index) {
			var distortFilterEffect = '';
			
			//play with feTurbulence baseFrequency and numOctaves values
			//play with feDisplacementMap scale values
			if (item.hasClass('qodef--distort-effect-2')){
				distortFilterEffect = '<feTurbulence type="turbulence" baseFrequency="0.005 0.001" numOctaves="4" result="warp" />' +
									  '<feDisplacementMap xChannelSelector="R" yChannelSelector="G" scale="0" in="SourceGraphic" in2="warp" />';
			} else if (item.hasClass('qodef--distort-effect-3')){
				distortFilterEffect = '<feTurbulence type="turbulence" baseFrequency=".09 .002" numOctaves="2" seed="0" result="warp" />' +
					                  '<feDisplacementMap xChannelSelector="R" yChannelSelector="G" scale="0" in="SourceGraphic" in2="warp" />';
			} else if (item.hasClass('qodef--distort-effect-4')){
				distortFilterEffect = '<feTurbulence type="fractalNoise" baseFrequency="0.005" numOctaves="1" seed="3" result="warp" />' +
					                  '<feDisplacementMap xChannelSelector="R" yChannelSelector="G" scale="35" in="SourceGraphic" in2="warp" />';
			} else if (item.hasClass('qodef--distort-effect-5')){
				// distortFilterEffect = '<feTurbulence type="fractalNoise" baseFrequency="0.005" numOctaves="2" seed="0" result="warp" />' +
				// 	'<feDisplacementMap xChannelSelector="R" yChannelSelector="G" scale="100" in="SourceGraphic" in2="warp" />';
				distortFilterEffect = '<feTurbulence type="fractalNoise" baseFrequency="0.005" numOctaves="2" seed="0" result="warp" />' +
					                  '<feDisplacementMap xChannelSelector="R" yChannelSelector="G" scale="30" in="SourceGraphic" in2="warp" />';
			} else {
				distortFilterEffect = '<feTurbulence type="fractalNoise" baseFrequency="0.02 0.01" numOctaves="2" seed="2" result="warp" result="warp" />' +
					                  '<feDisplacementMap xChannelSelector="R" yChannelSelector="G" scale="0" in="SourceGraphic" in2="warp" />';
			}
			
			var distortFilterSvg = '<svg class="qodef-svg-distort-filter" width="100%" height="100%">' +
									'<filter id="qodef-svg-distort-' + index + '" x="-25%" y="-25%" width="150%" height="150%">' +
									 distortFilterEffect +
									'</filter>';
			
			item.append(distortFilterSvg);
		},
		initEvents(item, infiniteAnimation, onlyEnterAnimation) {
			if ( !infiniteAnimation ) {
				item[0].addEventListener('mouseenter', function () {
						item.timeline.restart();
					}
				);
				if ( !onlyEnterAnimation ) {
					item[0].addEventListener('mouseleave', function () {
							item.timeline.reverse();
						}
					);
				}
			} else {
				qodefCore.qodefIsInViewport.check(
					item,
					function () {
						item.timeline.play();
					}, false,
					function (){
						item.timeline.pause();
					}
				);
			}
		}
	};
	
	qodefCore.qodefDistortAnimation = qodefDistortAnimation;

})( jQuery );
