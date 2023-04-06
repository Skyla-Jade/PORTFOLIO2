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

(function ( $ ) {
	'use strict';

	$( document ).ready(
		function () {
			qodefAgeVerificationModal.init();
		}
	);

	var qodefAgeVerificationModal = {
		init: function () {
			this.holder = $( '#qodef-age-verification-modal' );

			if ( this.holder.length ) {
				var $preventHolder = this.holder.find( '.qodef-m-content-prevent' );

				if ( $preventHolder.length ) {
					var $preventYesButton = $preventHolder.find( '.qodef-prevent--yes' );

					$preventYesButton.on(
						'click',
						function () {
							var cname  = 'disabledAgeVerification';
							var cvalue = 'Yes';
							var exdays = 7;
							var d      = new Date();

							d.setTime( d.getTime() + (exdays * 24 * 60 * 60 * 1000) );
							var expires     = 'expires=' + d.toUTCString();
							document.cookie = cname + '=' + cvalue + ';' + expires + ';path=/';

							qodefAgeVerificationModal.handleClassAndScroll( 'remove' );
						}
					);
				}
			}
		},

		handleClassAndScroll: function ( option ) {
			if ( option === 'remove' ) {
				qodefCore.body.removeClass( 'qodef-age-verification--opened' );
				qodefCore.qodefScroll.enable();
			}
			if ( option === 'add' ) {
				qodefCore.body.addClass( 'qodef-age-verification--opened' );
				qodefCore.qodefScroll.disable();
			}
		},
	};

})( jQuery );

(function ( $ ) {
	'use strict';

	$( document ).ready(
	    function () {
            qodefBackToTop.init();
        }
	);

	var qodefBackToTop = {
		init: function () {
			this.holder = $( '#qodef-back-to-top' );

			if ( this.holder.length ) {
				// Scroll To Top
				this.holder.on(
					'click',
					function ( e ) {
						e.preventDefault();
						qodefBackToTop.animateScrollToTop();
					}
				);

				qodefBackToTop.showHideBackToTop();
				qodefBackToTop.changeSkin();
			}
		},
		animateScrollToTop: function () {
			var startPos = qodef.scroll,
				newPos   = qodef.scroll,
				step     = .9,
				animationFrameId;

			var startAnimation = function () {
				if ( newPos === 0 ) {
                    return;
                }

				newPos < 0.0001 ? newPos = 0 : null;

				var ease = qodefBackToTop.easingFunction( (startPos - newPos) / startPos );
				$( 'html, body' ).scrollTop( startPos - (startPos - newPos) * ease );
				newPos = newPos * step;

				animationFrameId = requestAnimationFrame( startAnimation );
			};
			startAnimation();
			$( window ).one(
				'wheel touchstart',
				function () {
					cancelAnimationFrame( animationFrameId );
				}
			);
		},
		easingFunction: function ( n ) {
			return 0 == n ? 0 : Math.pow( 1024, n - 1 );
		},
		showHideBackToTop: function () {
			$( window ).scroll( function () {
				var $thisItem = $( this ),
					b         = $thisItem.scrollTop(),
					c         = $thisItem.height(),
					d;

				if ( b > 0 ) {
					d = b + c / 2;
				} else {
					d = 1;
				}

				if ( d < 1e3 ) {
					qodefBackToTop.addClass( 'off' );
				} else {
					qodefBackToTop.addClass( 'on' );
				}
			} );
		},
		addClass: function ( a ) {
			this.holder.removeClass( 'qodef--off qodef--on' );

			if ( a === 'on' ) {
				this.holder.addClass( 'qodef--on' );
			} else {
				this.holder.addClass( 'qodef--off' );
			}
		},
		changeSkin: function () {
			var $btt = $('#qodef-back-to-top'),
				$skinElements = $('.qodef-row-btt-light, #qodef-page-footer #qodef-page-footer-top-area:not(.qodef-skin--dark)'),
				$skinSet = false,
				$skinTrigger = new Array();

			//Control button skin
			var bttSkin = function () {
				if ( $skinElements.length ) {
					$skinElements.each( function ($i) {
						var $skinElement = $(this);

						if ( qodef.scroll + $btt.position().top >= $skinElement.offset().top && qodef.scroll + $btt.position().top <= $skinElement.offset().top + $skinElement.outerHeight() ) {
							$skinTrigger[$i] = true;
						} else {
							$skinTrigger[$i] = false;
						}
					});

					if ( jQuery.inArray(true, $skinTrigger) != -1 ) {
						if ( !$skinSet ) {
							$btt.addClass('qodef--light');
							$skinSet = true;
						}
					} else {
						if ( $skinSet ) {
							$btt.removeClass('qodef--light');
							$skinSet = false;
						}
					}
				}
			}

			if ( $btt.length && $skinElements.length ) {
				$(window).scroll( function () {
					bttSkin();
				});
			}
		}
	};

})( jQuery );

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
(function ( $ ) {
	'use strict';

	$( window ).on(
		'load',
		function () {
			qodefUncoverFooter.init();
		}
	);

	var qodefUncoverFooter = {
		holder: '',
		init: function () {
			this.holder = $( '#qodef-page-footer.qodef--uncover' );

			if ( this.holder.length && ! qodefCore.html.hasClass( 'touchevents' ) ) {
				qodefUncoverFooter.addClass();
				qodefUncoverFooter.setHeight( this.holder );

				$( window ).resize(
					function () {
						qodefUncoverFooter.setHeight( qodefUncoverFooter.holder );
					}
				);
			}
		},
		setHeight: function ( $holder ) {
			$holder.css( 'height', 'auto' );

			var footerHeight = $holder.outerHeight();

			if ( footerHeight > 0 ) {
				$( '#qodef-page-outer' ).css(
					{
						'margin-bottom': footerHeight,
						'background-color': qodefCore.body.css( 'backgroundColor' )
					}
				);

				$holder.css( 'height', footerHeight );
			}
		},
		addClass: function () {
			qodefCore.body.addClass( 'qodef-page-footer--uncover' );
		}
	};

})( jQuery );

(function ( $ ) {
	'use strict';

	$( document ).ready(
		function () {
			qodefFullscreenMenu.init();
		}
	);

	var qodefFullscreenMenu = {
		init: function () {
			var $fullscreenMenuOpener = $( 'a.qodef-fullscreen-menu-opener' ),
				$menuItems            = $( '#qodef-fullscreen-area nav ul li a' );

			// Open popup menu
			$fullscreenMenuOpener.on(
				'click',
				function ( e ) {
					e.preventDefault();
					var $thisOpener = $( this );

					if ( ! qodefCore.body.hasClass( 'qodef-fullscreen-menu--opened' ) ) {
						qodefFullscreenMenu.openFullscreen( $thisOpener );

						$( document ).keyup(
							function ( e ) {
								if ( e.keyCode === 27 ) {
									qodefFullscreenMenu.closeFullscreen( $thisOpener );
								}
							}
						);
					} else {
						qodefFullscreenMenu.closeFullscreen( $thisOpener );
					}
				}
			);

			//open dropdowns
			$menuItems.on(
				'tap click',
				function ( e ) {
					var $thisItem = $( this );

					if ( $thisItem.parent().hasClass( 'menu-item-has-children' ) ) {
						e.preventDefault();
						qodefFullscreenMenu.clickItemWithChild( $thisItem );
					} else if ( $thisItem.attr( 'href' ) !== 'http://#' && $thisItem.attr( 'href' ) !== '#' ) {
						qodefFullscreenMenu.closeFullscreen( $fullscreenMenuOpener );
					}
				}
			);
		},
		openFullscreen: function ( $opener ) {
			$opener.addClass( 'qodef--opened' );
			qodefCore.body.removeClass( 'qodef-fullscreen-menu-animate--out' ).addClass( 'qodef-fullscreen-menu--opened qodef-fullscreen-menu-animate--in' );
			qodefCore.qodefScroll.disable();
		},
		closeFullscreen: function ( $opener ) {
			$opener.removeClass( 'qodef--opened' );
			qodefCore.body.removeClass( 'qodef-fullscreen-menu--opened qodef-fullscreen-menu-animate--in' ).addClass( 'qodef-fullscreen-menu-animate--out' );
			qodefCore.qodefScroll.enable();
			$( 'nav.qodef-fullscreen-menu ul.sub_menu' ).slideUp( 200 );
		},
		clickItemWithChild: function ( thisItem ) {
			var $thisItemParent  = thisItem.parent(),
				$thisItemSubMenu = $thisItemParent.find( '.sub-menu' ).first();

			if ( $thisItemSubMenu.is( ':visible' ) ) {
				$thisItemSubMenu.slideUp( 300 );
				$thisItemParent.removeClass( 'qodef--opened' );
			} else {
				$thisItemSubMenu.slideDown( 300 );
				$thisItemParent.addClass( 'qodef--opened' ).siblings().find( '.sub-menu' ).slideUp( 400 );
			}
		}
	};

})( jQuery );

(function ( $ ) {
	'use strict';

	$( document ).ready(
		function () {
			qodefHeaderScrollAppearance.init();
		}
	);

	var qodefHeaderScrollAppearance = {
		appearanceType: function () {
			return qodefCore.body.attr( 'class' ).indexOf( 'qodef-header-appearance--' ) !== -1 ? qodefCore.body.attr( 'class' ).match( /qodef-header-appearance--([\w]+)/ )[1] : '';
		},
		init: function () {
			var appearanceType = this.appearanceType();

			if ( appearanceType !== '' && appearanceType !== 'none' ) {
				qodefCore[appearanceType + 'HeaderAppearance']();
			}
		}
	};

})( jQuery );

(function ( $ ) {
	'use strict';

	$( document ).ready(
	    function () {
            qodefMobileHeaderAppearance.init();
        }
	);

	/*
	 **	Init mobile header functionality
	 */
	var qodefMobileHeaderAppearance = {
		init: function () {
			if ( qodefCore.body.hasClass( 'qodef-mobile-header-appearance--sticky' ) ) {

				var docYScroll1   = qodefCore.scroll,
					displayAmount = qodefGlobal.vars.mobileHeaderHeight + qodefGlobal.vars.adminBarHeight,
					$pageOuter    = $( '#qodef-page-outer' );

				qodefMobileHeaderAppearance.showHideMobileHeader( docYScroll1, displayAmount, $pageOuter );

				$( window ).scroll(
				    function () {
                        qodefMobileHeaderAppearance.showHideMobileHeader( docYScroll1, displayAmount, $pageOuter );
                        docYScroll1 = qodefCore.scroll;
                    }
				);

				$( window ).resize(
				    function () {
                        $pageOuter.css( 'padding-top', 0 );
                        qodefMobileHeaderAppearance.showHideMobileHeader( docYScroll1, displayAmount, $pageOuter );
                    }
				);
			}
		},
		showHideMobileHeader: function ( docYScroll1, displayAmount, $pageOuter ) {
			if ( qodefCore.windowWidth <= 1024 ) {
				if ( qodefCore.scroll > displayAmount * 2 ) {
					//set header to be fixed
					qodefCore.body.addClass( 'qodef-mobile-header--sticky' );

					//add transition to it
					setTimeout(
						function () {
							qodefCore.body.addClass( 'qodef-mobile-header--sticky-animation' );
						},
						300
					); //300 is duration of sticky header animation

					//add padding to content so there is no 'jumping'
					$pageOuter.css( 'padding-top', qodefGlobal.vars.mobileHeaderHeight );
				} else {
					//unset fixed header
					qodefCore.body.removeClass( 'qodef-mobile-header--sticky' );

					//remove transition
					setTimeout(
						function () {
							qodefCore.body.removeClass( 'qodef-mobile-header--sticky-animation' );
						},
						300
					); //300 is duration of sticky header animation

					//remove padding from content since header is not fixed anymore
					$pageOuter.css( 'padding-top', 0 );
				}

				if ( (qodefCore.scroll > docYScroll1 && qodefCore.scroll > displayAmount) || (qodefCore.scroll < displayAmount * 3) ) {
					//show sticky header
					qodefCore.body.removeClass( 'qodef-mobile-header--sticky-display' );
				} else {
					//hide sticky header
					qodefCore.body.addClass( 'qodef-mobile-header--sticky-display' );
				}
			}
		}
	};

})( jQuery );

(function ( $ ) {
	'use strict';

	$( document ).ready(
		function () {
			qodefNavMenu.init();
		}
	);

	var qodefNavMenu = {
		init: function () {
			qodefNavMenu.dropdownBehavior();
			qodefNavMenu.wideDropdownPosition();
			qodefNavMenu.dropdownPosition();
		},
		dropdownBehavior: function () {
			var $menuItems = $( '.qodef-header-navigation > ul > li' );

			$menuItems.each(
				function () {
					var $thisItem = $( this );

					if ( $thisItem.find( '.qodef-drop-down-second' ).length ) {
						$thisItem.waitForImages(
							function () {
								var $dropdownHolder      = $thisItem.find( '.qodef-drop-down-second' ),
									$dropdownMenuItem    = $dropdownHolder.find( '.qodef-drop-down-second-inner ul' ),
									dropDownHolderHeight = $dropdownMenuItem.outerHeight();

								if ( navigator.userAgent.match( /(iPod|iPhone|iPad)/ ) ) {
									$thisItem.on(
										'touchstart mouseenter',
										function () {
											$dropdownHolder.css(
												{
													'height': dropDownHolderHeight,
													'overflow': 'visible',
													'visibility': 'visible',
													'opacity': '1',
												}
											);
										}
									).on(
										'mouseleave',
										function () {
											$dropdownHolder.css(
												{
													'height': '0px',
													'overflow': 'hidden',
													'visibility': 'hidden',
													'opacity': '0',
												}
											);
										}
									);
								} else {
									if ( qodefCore.body.hasClass( 'qodef-drop-down-second--animate-height' ) ) {
										var animateConfig = {
											interval: 0,
											over: function () {
												setTimeout(
													function () {
														$dropdownHolder.addClass( 'qodef-drop-down--start' ).css(
															{
																'visibility': 'visible',
																'height': '0',
																'opacity': '1',
															}
														);
														$dropdownHolder.stop().animate(
															{
																'height': dropDownHolderHeight,
															},
															400,
															'easeInOutQuint',
															function () {
																$dropdownHolder.css( 'overflow', 'visible' );
															}
														);
													},
													100
												);
											},
											timeout: 100,
											out: function () {
												$dropdownHolder.stop().animate(
													{
														'height': '0',
														'opacity': 0,
													},
													100,
													function () {
														$dropdownHolder.css(
															{
																'overflow': 'hidden',
																'visibility': 'hidden',
															}
														);
													}
												);

												$dropdownHolder.removeClass( 'qodef-drop-down--start' );
											}
										};

										$thisItem.hoverIntent( animateConfig );
									} else {
										var config = {
											interval: 0,
											over: function () {
												setTimeout(
													function () {
														$dropdownHolder.addClass( 'qodef-drop-down--start' ).stop().css( { 'height': dropDownHolderHeight } );
													},
													150
												);
											},
											timeout: 150,
											out: function () {
												$dropdownHolder.stop().css( { 'height': '0' } ).removeClass( 'qodef-drop-down--start' );
											}
										};

										$thisItem.hoverIntent( config );
									}
								}
							}
						);
					}
				}
			);
		},
		wideDropdownPosition: function () {
			var $menuItems = $( '.qodef-header-navigation > ul > li.qodef-menu-item--wide' );

			if ( $menuItems.length ) {
				$menuItems.each(
					function () {
						var $menuItem        = $( this );
						var $menuItemSubMenu = $menuItem.find( '.qodef-drop-down-second' );

						if ( $menuItemSubMenu.length ) {
							$menuItemSubMenu.css( 'left', 0 );

							var leftPosition = $menuItemSubMenu.offset().left;

							if ( qodefCore.body.hasClass( 'qodef--boxed' ) ) {
								//boxed layout case
								var boxedWidth = $( '.qodef--boxed #qodef-page-wrapper' ).outerWidth();
								leftPosition   = leftPosition - (qodefCore.windowWidth - boxedWidth) / 2;
								$menuItemSubMenu.css( { 'left': -leftPosition, 'width': boxedWidth } );

							} else if ( qodefCore.body.hasClass( 'qodef-drop-down-second--full-width' ) ) {
								//wide dropdown full width case
								$menuItemSubMenu.css( { 'left': -leftPosition } );
							} else {
								//wide dropdown in grid case
								$menuItemSubMenu.css( { 'left': -leftPosition + (qodefCore.windowWidth - $menuItemSubMenu.width()) / 2 } );
							}
						}
					}
				);
			}
		},
		dropdownPosition: function () {
			var $menuItems = $( '.qodef-header-navigation > ul > li.qodef-menu-item--narrow.menu-item-has-children' );

			if ( $menuItems.length ) {
				$menuItems.each(
					function () {
						var $thisItem         = $( this ),
							menuItemPosition  = $thisItem.offset().left,
							$dropdownHolder   = $thisItem.find( '.qodef-drop-down-second' ),
							$dropdownMenuItem = $dropdownHolder.find( '.qodef-drop-down-second-inner ul' ),
							dropdownMenuWidth = $dropdownMenuItem.outerWidth(),
							menuItemFromLeft  = $( window ).width() - menuItemPosition;

						if ( qodef.body.hasClass( 'qodef--boxed' ) ) {
							//boxed layout case
							var boxedWidth   = $( '.qodef--boxed #qodef-page-wrapper' ).outerWidth();
							menuItemFromLeft = boxedWidth - menuItemPosition;
						}

						var dropDownMenuFromLeft;

						if ( $thisItem.find( 'li.menu-item-has-children' ).length > 0 ) {
							dropDownMenuFromLeft = menuItemFromLeft - dropdownMenuWidth;
						}

						$dropdownHolder.removeClass( 'qodef-drop-down--right' );
						$dropdownMenuItem.removeClass( 'qodef-drop-down--right' );
						if ( menuItemFromLeft < dropdownMenuWidth || dropDownMenuFromLeft < dropdownMenuWidth ) {
							$dropdownHolder.addClass( 'qodef-drop-down--right' );
							$dropdownMenuItem.addClass( 'qodef-drop-down--right' );
						}
					}
				);
			}
		}
	};

})( jQuery );

(function ( $ ) {
	'use strict';

	$( window ).on(
		'load',
		function () {
			qodefParallaxBackground.init();
		}
	);

	/**
	 * Init global parallax background functionality
	 */
	var qodefParallaxBackground = {
		init: function ( settings ) {
			this.$sections = $( '.qodef-parallax' );

			// Allow overriding the default config
			$.extend( this.$sections, settings );

			var isSupported = ! qodefCore.html.hasClass( 'touchevents' ) && ! qodefCore.body.hasClass( 'qodef-browser--edge' ) && ! qodefCore.body.hasClass( 'qodef-browser--ms-explorer' );

			if ( this.$sections.length && isSupported ) {
				this.$sections.each(
					function () {
						qodefParallaxBackground.ready( $( this ) );
					}
				);
			}
		},
		ready: function ( $section ) {
			$section.$imgHolder  = $section.find( '.qodef-parallax-img-holder' );
			$section.$imgWrapper = $section.find( '.qodef-parallax-img-wrapper' );
			$section.$img        = $section.find( 'img.qodef-parallax-img' );

			var h           = $section.height(),
				imgWrapperH = $section.$imgWrapper.height();

			$section.movement = 100 * (imgWrapperH - h) / h / 2; //percentage (divided by 2 due to absolute img centering in CSS)

			$section.buffer       = window.pageYOffset;
			$section.scrollBuffer = null;


			//calc and init loop
			requestAnimationFrame(
				function () {
					$section.$imgHolder.animate( { opacity: 1 }, 100 );
					qodefParallaxBackground.calc( $section );
					qodefParallaxBackground.loop( $section );
				}
			);

			//recalc
			$( window ).on(
				'resize',
				function () {
					qodefParallaxBackground.calc( $section );
				}
			);
		},
		calc: function ( $section ) {
			var wH = $section.$imgWrapper.height(),
				wW = $section.$imgWrapper.width();

			if ( $section.$img.width() < wW ) {
				$section.$img.css(
					{
						'width': '100%',
						'height': 'auto',
					}
				);
			}

			if ( $section.$img.height() < wH ) {
				$section.$img.css(
					{
						'height': '100%',
						'width': 'auto',
						'max-width': 'unset',
					}
				);
			}
		},
		loop: function ( $section ) {
			if ( $section.scrollBuffer === Math.round( window.pageYOffset ) ) {
				requestAnimationFrame(
					function () {
						qodefParallaxBackground.loop( $section );
					}
				); //repeat loop

				return false; //same scroll value, do nothing
			} else {
				$section.scrollBuffer = Math.round( window.pageYOffset );
			}

			var wH   = window.outerHeight,
				sTop = $section.offset().top,
				sH   = $section.height();

			if ( $section.scrollBuffer + wH * 1.2 > sTop && $section.scrollBuffer < sTop + sH ) {
				var delta = (Math.abs( $section.scrollBuffer + wH - sTop ) / (wH + sH)).toFixed( 4 ), //coeff between 0 and 1 based on scroll amount
					yVal  = (delta * $section.movement).toFixed( 4 );

				if ( $section.buffer !== delta ) {
					$section.$imgWrapper.css( 'transform', 'translate3d(0,' + yVal + '%, 0)' );
				}

				$section.buffer = delta;
			}

			requestAnimationFrame(
				function () {
					qodefParallaxBackground.loop( $section );
				}
			); //repeat loop
		}
	};

	qodefCore.qodefParallaxBackground = qodefParallaxBackground;

})( jQuery );

(function ( $ ) {
	'use strict';

	$( document ).ready(
		function () {
			qodefReview.init();
		}
	);

	var qodefReview = {
		init: function () {
			var ratingHolder = $( '#qodef-page-comments-form .qodef-rating-inner' );

			var addActive = function ( stars, ratingValue ) {
				for ( var i = 0; i < stars.length; i++ ) {
					var star = stars[i];

					if ( i < ratingValue ) {
						$( star ).addClass( 'active' );
					} else {
						$( star ).removeClass( 'active' );
					}
				}
			};

			ratingHolder.each(
				function () {
					var thisHolder  = $( this ),
						ratingInput = thisHolder.find( '.qodef-rating' ),
						ratingValue = ratingInput.val(),
						stars       = thisHolder.find( '.qodef-star-rating' );

					addActive( stars, ratingValue );

					stars.on(
						'click',
						function () {
							ratingInput.val( $( this ).data( 'value' ) ).trigger( 'change' );
						}
					);

					ratingInput.change(
						function () {
							ratingValue = ratingInput.val();

							addActive( stars, ratingValue );
						}
					);
				}
			);
		}
	};

})( jQuery );

(function ( $ ) {
	'use strict';

	$( document ).ready(
		function () {
			qodefSideArea.init();
		}
	);

	var qodefSideArea = {
		init: function () {
			var $sideAreaOpener = $( 'a.qodef-side-area-opener' ),
				$sideAreaClose  = $( '#qodef-side-area-close' ),
				$sideArea       = $( '#qodef-side-area' );

			qodefSideArea.openerHoverColor( $sideAreaOpener );

			// Open Side Area
			$sideAreaOpener.on(
				'click',
				function ( e ) {
					e.preventDefault();

					if ( ! qodefCore.body.hasClass( 'qodef-side-area--opened' ) ) {
						qodefSideArea.openSideArea();

						$( document ).keyup(
							function ( e ) {
								if ( e.keyCode === 27 ) {
									qodefSideArea.closeSideArea();
								}
							}
						);
					} else {
						qodefSideArea.closeSideArea();
					}
				}
			);

			$sideAreaClose.on(
				'click',
				function ( e ) {
					e.preventDefault();
					qodefSideArea.closeSideArea();
				}
			);

			if ( $sideArea.length && typeof qodefCore.qodefPerfectScrollbar === 'object' ) {
				qodefCore.qodefPerfectScrollbar.init( $sideArea );
			}
		},
		openSideArea: function () {
			var $wrapper      = $( '#qodef-page-wrapper' );
			var currentScroll = $( window ).scrollTop();

			$( '.qodef-side-area-cover' ).remove();
			$wrapper.prepend( '<div class="qodef-side-area-cover"/>' );
			qodefCore.body.removeClass( 'qodef-side-area-animate--out' ).addClass( 'qodef-side-area--opened qodef-side-area-animate--in' );

			$( '.qodef-side-area-cover' ).on(
				'click',
				function ( e ) {
					e.preventDefault();
					qodefSideArea.closeSideArea();
				}
			);

			$( window ).scroll(
				function () {
					if ( Math.abs( qodefCore.scroll - currentScroll ) > 400 ) {
						qodefSideArea.closeSideArea();
					}
				}
			);
		},
		closeSideArea: function () {
			qodefCore.body.removeClass( 'qodef-side-area--opened qodef-side-area-animate--in' ).addClass( 'qodef-side-area-animate--out' );
		},
		openerHoverColor: function ( $opener ) {
			if ( typeof $opener.data( 'hover-color' ) !== 'undefined' ) {
				var hoverColor    = $opener.data( 'hover-color' );
				var originalColor = $opener.css( 'color' );

				$opener.on(
					'mouseenter',
					function () {
						$opener.css( 'color', hoverColor );
					}
				).on(
					'mouseleave',
					function () {
						$opener.css( 'color', originalColor );
					}
				);
			}
		}
	};

})( jQuery );

(function ( $ ) {
	'use strict';
	
	$( document ).ready(
		function () {
			qodefSpinner.init();
		}
	);
	
	$( window ).on(
		'load',
		function () {
			qodefSpinner.windowLoaded = true;
			qodefSpinner.fadeOutLoader();
		}
	);
	
	$( window ).on(
		'elementor/frontend/init',
		
		function () {
			var isEditMode = Boolean( elementorFrontend.isEditMode() );
			
			if ( isEditMode ) {
				qodefSpinner.init( isEditMode );
			}
		}
	);
	
	var qodefSpinner = {
		holder: '',
		windowLoaded: false,
		init: function ( isEditMode ) {
			this.holder = $( '#qodef-page-spinner:not(.qodef--custom-spinner)' );
			
			if ( this.holder.length ) {
				qodefSpinner.animateSpinner( this.holder, isEditMode );
				qodefSpinner.fadeOutAnimation();
			}
		},
		animateSpinner: function ( $holder, isEditMode ) {
			if ( isEditMode ) {
				qodefSpinner.fadeOutLoader();
			}
		},
		fadeOutLoader: function ( speed, delay, easing ) {
			var $holder = qodefSpinner.holder.length ? qodefSpinner.holder : $( '#qodef-page-spinner:not(.qodef--custom-spinner)' );
			speed  = speed ? speed : 700;
			delay  = delay ? delay : 1500;
			easing = easing ? easing : 'swing';
			
			var introHolder = $('.qodef-intro-section.qodef--has-disappear');
			
			if(introHolder.length){
				setTimeout(function() {
					introHolder.addClass('qodef-appear');
				}, delay - 100);
				setTimeout(function() {
					introHolder.addClass('qodef-animation-end');
				}, delay + 3300);
			}
			
			$holder.delay( delay ).fadeOut( speed, easing );
			
			$( window ).on(
				'bind',
				'pageshow',
				function ( event ) {
					if ( event.originalEvent.persisted ) {
						$holder.fadeOut( speed, easing );
					}
				}
			);
		},
		fadeOutAnimation: function () {
			// Check for fade out animation
			if ( qodefCore.body.hasClass( 'qodef-spinner--fade-out' ) ) {
				var $pageHolder = $( '#qodef-page-wrapper' ),
					$linkItems  = $( 'a' );
				
				// If back button is pressed, than show content to avoid state where content is on display:none
				window.addEventListener(
					'pageshow',
					function ( event ) {
						var historyPath = event.persisted || (typeof window.performance !== 'undefined' && window.performance.navigation.type === 2);
						if ( historyPath && ! $pageHolder.is( ':visible' ) ) {
							$pageHolder.show();
						}
					}
				);
				
				$linkItems.on(
					'click',
					function ( e ) {
						var $clickedLink = $( this );
						
						if (
							e.which === 1 && // check if the left mouse button has been pressed
							$clickedLink.attr( 'href' ).indexOf( window.location.host ) >= 0 && // check if the link is to the same domain
							! $clickedLink.hasClass( 'remove' ) && // check is WooCommerce remove link
							$clickedLink.parent( '.product-remove' ).length <= 0 && // check is WooCommerce remove link
							$clickedLink.parents( '.woocommerce-product-gallery__image' ).length <= 0 && // check is product gallery link
							typeof $clickedLink.data( 'rel' ) === 'undefined' && // check pretty photo link
							typeof $clickedLink.attr( 'rel' ) === 'undefined' && // check VC pretty photo link
							! $clickedLink.hasClass( 'lightbox-active' ) && // check is lightbox plugin active
							! $clickedLink.hasClass( 'qodef-popup-item' ) && // prevents fadeout navigation when item has popup class
							(typeof $clickedLink.attr( 'target' ) === 'undefined' || $clickedLink.attr( 'target' ) === '_self') && // check if the link opens in the same window
							$clickedLink.attr( 'href' ).split( '#' )[0] !== window.location.href.split( '#' )[0] // check if it is an anchor aiming for a different page
						) {
							e.preventDefault();
							
							$pageHolder.fadeOut(
								600,
								'easeOutSine',
								function () {
									window.location = $clickedLink.attr( 'href' );
								}
							);
						}
					}
				);
			}
		}
	};
	
})( jQuery );

(function ( $ ) {
	'use strict';

	$( window ).on(
		'load',
		function () {
			qodefSubscribeModal.init();
		}
	);

	var qodefSubscribeModal = {
		init: function () {
			this.holder = $( '#qodef-subscribe-popup-modal' );

			if ( this.holder.length ) {
				var $preventHolder = this.holder.find( '.qodef-sp-prevent' ),
					$modalClose    = $( '.qodef-sp-close' ),
					disabledPopup  = 'no';

				if ( $preventHolder.length ) {
					var isLocalStorage = this.holder.hasClass( 'qodef-sp-prevent-cookies' ),
						$preventInput  = $preventHolder.find( '.qodef-sp-prevent-input' ),
						preventValue   = $preventInput.data( 'value' );

					if ( isLocalStorage ) {
						disabledPopup = localStorage.getItem( 'disabledPopup' );
						sessionStorage.removeItem( 'disabledPopup' );
					} else {
						disabledPopup = sessionStorage.getItem( 'disabledPopup' );
						localStorage.removeItem( 'disabledPopup' );
					}

					$preventHolder.children().on(
						'click',
						function ( e ) {
							if ( preventValue !== 'yes' ) {
								preventValue = 'yes';
								$preventInput.addClass( 'qodef-sp-prevent-clicked' ).data( 'value', 'yes' );
							} else {
								preventValue = 'no';
								$preventInput.removeClass( 'qodef-sp-prevent-clicked' ).data( 'value', 'no' );
							}

							if ( preventValue === 'yes' ) {
								if ( isLocalStorage ) {
									localStorage.setItem( 'disabledPopup', 'yes' );
								} else {
									sessionStorage.setItem( 'disabledPopup', 'yes' );
								}
							} else {
								if ( isLocalStorage ) {
									localStorage.setItem( 'disabledPopup', 'no' );
								} else {
									sessionStorage.setItem( 'disabledPopup', 'no' );
								}
							}
						}
					);
				}

				if ( disabledPopup !== 'yes' ) {
					if ( qodefCore.body.hasClass( 'qodef-sp-opened' ) ) {
						qodefSubscribeModal.handleClassAndScroll( 'remove' );
					} else {
						qodefSubscribeModal.handleClassAndScroll( 'add' );
					}

					$modalClose.on(
						'click',
						function ( e ) {
							e.preventDefault();

							qodefSubscribeModal.handleClassAndScroll( 'remove' );
						}
					);

					// Close on escape
					$( document ).keyup(
						function ( e ) {
							if ( e.keyCode === 27 ) { // KeyCode for ESC button is 27
								qodefSubscribeModal.handleClassAndScroll( 'remove' );
							}
						}
					);
				}
			}
		},

		handleClassAndScroll: function ( option ) {
			if ( option === 'remove' ) {
				qodefCore.body.removeClass( 'qodef-sp-opened' );
				qodefCore.qodefScroll.enable();
			}

			if ( option === 'add' ) {
				qodefCore.body.addClass( 'qodef-sp-opened' );
				qodefCore.qodefScroll.disable();
			}
		},
	};

})( jQuery );

(function ( $ ) {
	'use strict';

	$( document ).ready(
		function () {
			qodefWishlist.init();
		}
	);

	/**
	 * Function object that represents wishlist area popup.
	 * @returns {{init: Function}}
	 */
	var qodefWishlist = {
		init: function () {
			var $wishlistLink = $( '.qodef-wishlist .qodef-m-link' );

			if ( $wishlistLink.length ) {
				$wishlistLink.each(
					function () {
						var $thisWishlistLink = $( this ),
							wishlistIconHTML  = $thisWishlistLink.html(),
							$responseMessage  = $thisWishlistLink.siblings( '.qodef-m-response' );

						$thisWishlistLink.off().on(
							'click',
							function ( e ) {
								e.preventDefault();

								if ( qodefCore.body.hasClass( 'logged-in' ) ) {
									var itemID = $thisWishlistLink.data( 'id' );

									if ( itemID !== 'undefined' && ! $thisWishlistLink.hasClass( 'qodef--added' ) ) {
										$thisWishlistLink.html( '<span class="fa fa-spinner fa-spin" aria-hidden="true"></span>' );

										var wishlistData = {
											type: 'add',
											itemID: itemID,
										};

										$.ajax(
											{
												type: 'POST',
												url: qodefGlobal.vars.restUrl + qodefGlobal.vars.wishlistRestRoute,
												data: {
													options: wishlistData,
												},
												beforeSend: function ( request ) {
													request.setRequestHeader( 'X-WP-Nonce', qodefGlobal.vars.restNonce );
												},
												success: function ( response ) {

													if ( response.status === 'success' ) {
														$thisWishlistLink.addClass( 'qodef--added' );
														$responseMessage.html( response.message ).addClass( 'qodef--show' ).fadeIn( 200 );

														$( document ).trigger(
															'gracey_core_wishlist_item_is_added',
															[itemID, response.data.user_id]
														);
													} else {
														$responseMessage.html( response.message ).addClass( 'qodef--show' ).fadeIn( 200 );
													}

													setTimeout(
														function () {
															$thisWishlistLink.html( wishlistIconHTML );

															var $wishlistTitle = $thisWishlistLink.find( '.qodef-m-link-label' );

															if ( $wishlistTitle.length ) {
																$wishlistTitle.text( $wishlistTitle.data( 'added-title' ) );
															}

															$responseMessage.fadeOut( 300 ).removeClass( 'qodef--show' ).empty();
														},
														800
													);
												}
											}
										);
									}
								} else {
									// Trigger event.
									$( document.body ).trigger( 'gracey_membership_trigger_login_modal' );
								}
							}
						);
					}
				);
			}
		}
	};

	$( document ).on(
		'gracey_core_wishlist_item_is_removed',
		function ( e, removedItemID ) {
			var $wishlistLink = $( '.qodef-wishlist .qodef-m-link' );

			if ( $wishlistLink.length ) {
				$wishlistLink.each(
					function () {
						var $thisWishlistLink = $( this ),
							$wishlistTitle    = $thisWishlistLink.find( '.qodef-m-link-label' );

						if ( $thisWishlistLink.data( 'id' ) === removedItemID && $thisWishlistLink.hasClass( 'qodef--added' ) ) {
							$thisWishlistLink.removeClass( 'qodef--added' );

							if ( $wishlistTitle.length ) {
								$wishlistTitle.text( $wishlistTitle.data( 'title' ) );
							}
						}
					}
				);
			}
		}
	);

})( jQuery );

(function ( $ ) {
	'use strict';

	qodefCore.shortcodes.gracey_core_accordion = {};

	$( document ).ready(
		function () {
			qodefAccordion.init();
		}
	);

	var qodefAccordion = {
		init: function () {
			this.holder = $( '.qodef-accordion' );

			if ( this.holder.length ) {
				this.holder.each(
					function () {
						var $thisHolder = $( this );

						if ( $thisHolder.hasClass( 'qodef-behavior--accordion' ) ) {
							qodefAccordion.initAccordion( $thisHolder );
						}

						if ( $thisHolder.hasClass( 'qodef-behavior--toggle' ) ) {
							qodefAccordion.initToggle( $thisHolder );
						}

						$thisHolder.addClass( 'qodef--init' );
					}
				);
			}
		},
		initAccordion: function ( $accordion ) {
			$accordion.accordion(
				{
					animate: 'swing',
					collapsible: true,
					active: 0,
					icons: '',
					heightStyle: 'content',
				}
			);
		},
		initToggle: function ( $toggle ) {
			var $toggleAccordionTitle   = $toggle.find( '.qodef-accordion-title' ),
				$toggleAccordionContent = $toggleAccordionTitle.next();

			$toggle.addClass( 'accordion ui-accordion ui-accordion-icons ui-widget ui-helper-reset' );
			$toggleAccordionTitle.addClass( 'ui-accordion-header ui-state-default ui-corner-top ui-corner-bottom' );
			$toggleAccordionContent.addClass( 'ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom' ).hide();

			$toggleAccordionTitle.each(
				function () {
					var $thisTitle = $( this );

					$thisTitle.hover(
						function () {
							$thisTitle.toggleClass( 'ui-state-hover' );
						}
					);

					$thisTitle.on(
						'click',
						function () {
							$thisTitle.toggleClass( 'ui-accordion-header-active ui-state-active ui-state-default ui-corner-bottom' );
							$thisTitle.next().toggleClass( 'ui-accordion-content-active' ).slideToggle( 400 );
						}
					);
				}
			);
		}
	};

	qodefCore.shortcodes.gracey_core_accordion.qodefAccordion = qodefAccordion;

})( jQuery );

(function ( $ ) {
	'use strict';

	qodefCore.shortcodes.gracey_core_button = {};

	$( document ).ready(
		function () {
			qodefButton.init();
		}
	);

	var qodefButton = {
		init: function () {
			this.buttons = $( '.qodef-button' );

			if ( this.buttons.length ) {
				this.buttons.each(
					function () {
						var $thisButton = $( this );

						qodefButton.buttonHoverColor( $thisButton );
						qodefButton.buttonHoverBgColor( $thisButton );
						qodefButton.buttonHoverBorderColor( $thisButton );
					}
				);
			}
		},
		buttonHoverColor: function ( $button ) {
			if ( typeof $button.data( 'hover-color' ) !== 'undefined' ) {
				var hoverColor    = $button.data( 'hover-color' );
				var originalColor = $button.css( 'color' );

				$button.on(
					'mouseenter touchstart',
					function () {
						qodefButton.changeColor( $button, 'color', hoverColor );
					}
				);
				$button.on(
					'mouseleave touchend',
					function () {
						qodefButton.changeColor( $button, 'color', originalColor );
					}
				);
			}
		},
		buttonHoverBgColor: function ( $button ) {
			if ( typeof $button.data( 'hover-background-color' ) !== 'undefined' ) {
				var hoverBackgroundColor    = $button.data( 'hover-background-color' );
				var originalBackgroundColor = $button.css( 'background-color' );

				$button.on(
					'mouseenter touchstart',
					function () {
						qodefButton.changeColor( $button, 'background-color', hoverBackgroundColor );
					}
				);
				$button.on(
					'mouseleave touchend',
					function () {
						qodefButton.changeColor( $button, 'background-color', originalBackgroundColor );
					}
				);
			}
		},
		buttonHoverBorderColor: function ( $button ) {
			if ( typeof $button.data( 'hover-border-color' ) !== 'undefined' ) {
				var hoverBorderColor    = $button.data( 'hover-border-color' );
				var originalBorderColor = $button.css( 'borderTopColor' );

				$button.on(
					'mouseenter touchstart',
					function () {
						qodefButton.changeColor( $button, 'border-color', hoverBorderColor );
					}
				);
				$button.on(
					'mouseleave touchend',
					function () {
						qodefButton.changeColor( $button, 'border-color', originalBorderColor );
					}
				);
			}
		},
		changeColor: function ( $button, cssProperty, color ) {
			$button.css( cssProperty, color );
		}
	};

	qodefCore.shortcodes.gracey_core_button.qodefButton = qodefButton;

})( jQuery );

(function ( $ ) {
	'use strict';

	qodefCore.shortcodes.gracey_core_cards_gallery = {};

	$( document ).ready(
		function () {
			qodefCardsGallery.init();
		}
	);
	
	var qodefCardsGallery = {
		init: function () {
			this.holder = $( '.qodef-cards-gallery' );
			
			if ( this.holder.length ) {
				this.holder.each(
					function () {
						qodefCardsGallery.initItem( $( this ) );
					}
				);
			}
		},
		initItem: function ( $currentItem ) {
			qodefCardsGallery.initCards( $currentItem );
			qodefCardsGallery.initBundle( $currentItem );
		},
		initCards: function ( $holder ) {
			var $cards = $holder.find( '.qodef-m-card' );
			$cards.each(
				function () {
					var $card = $( this );
					
					$card.on(
						qodef.windowWidth <1025 ? 'touchend' : 'click',
						function () {
							if ( ! $cards.last().is( $card ) ) {
								$card.addClass( 'qodef-out qodef-animating' ).siblings().addClass( 'qodef-animating-siblings' );
								$card.detach();
								$card.insertAfter( $cards.last() );
								
								setTimeout(
									function () {
										$card.removeClass( 'qodef-out' );
									},
									200
								);
								
								setTimeout(
									function () {
										$card.removeClass( 'qodef-animating' ).siblings().removeClass( 'qodef-animating-siblings' );
									},
									1200
								);
								
								$cards = $holder.find( '.qodef-m-card' );
								
								return false;
							}
						}
					);
				}
			);
		},
		initBundle: function ( $holder ) {
			if ( $holder.hasClass( 'qodef-animation--bundle' )) {
				qodefCore.qodefIsInViewport.check(
					$holder,
					function () {
						$holder.addClass( 'qodef-appeared' );
						$holder.find( 'img' ).one(
							'animationend webkitAnimationEnd MSAnimationEnd oAnimationEnd',
							function () {
								$( this ).addClass( 'qodef-animation-done' );
							}
						);
					}
				);
			}
		}
	};

	qodefCore.shortcodes.gracey_core_cards_gallery.qodefCardsGallery = qodefCardsGallery;

})( jQuery );

(function ( $ ) {
	'use strict';

	qodefCore.shortcodes.gracey_core_countdown = {};

	$( document ).ready(
		function () {
			qodefCountdown.init();
		}
	);

	var qodefCountdown = {
		init: function () {
			this.countdowns = $( '.qodef-countdown' );

			if ( this.countdowns.length ) {
				this.countdowns.each(
					function () {
						var $thisCountdown    = $( this ),
							$countdownElement = $thisCountdown.find( '.qodef-m-date' ),
							options           = qodefCountdown.generateOptions( $thisCountdown );

						qodefCountdown.initCountdown( $countdownElement, options );
					}
				);
			}
		},
		generateOptions: function ( $countdown ) {
			var options  = {};
			options.date = typeof $countdown.data( 'date' ) !== 'undefined' ? $countdown.data( 'date' ) : null;

			options.monthLabel       = typeof $countdown.data( 'month-label' ) !== 'undefined' ? $countdown.data( 'month-label' ) : '';
			options.monthLabelPlural = typeof $countdown.data( 'month-label-plural' ) !== 'undefined' ? $countdown.data( 'month-label-plural' ) : '';

			options.dayLabel       = typeof $countdown.data( 'day-label' ) !== 'undefined' ? $countdown.data( 'day-label' ) : '';
			options.dayLabelPlural = typeof $countdown.data( 'day-label-plural' ) !== 'undefined' ? $countdown.data( 'day-label-plural' ) : '';

			options.hourLabel       = typeof $countdown.data( 'hour-label' ) !== 'undefined' ? $countdown.data( 'hour-label' ) : '';
			options.hourLabelPlural = typeof $countdown.data( 'hour-label-plural' ) !== 'undefined' ? $countdown.data( 'hour-label-plural' ) : '';

			options.minuteLabel       = typeof $countdown.data( 'minute-label' ) !== 'undefined' ? $countdown.data( 'minute-label' ) : '';
			options.minuteLabelPlural = typeof $countdown.data( 'minute-label-plural' ) !== 'undefined' ? $countdown.data( 'minute-label-plural' ) : '';

			options.secondLabel       = typeof $countdown.data( 'second-label' ) !== 'undefined' ? $countdown.data( 'second-label' ) : '';
			options.secondLabelPlural = typeof $countdown.data( 'second-label-plural' ) !== 'undefined' ? $countdown.data( 'second-label-plural' ) : '';

			return options;
		},
		initCountdown: function ( $countdownElement, options ) {
			var $monthHTML   = '<span class="qodef-digit-wrapper"><span class="qodef-digit">%m</span><span class="qodef-label">' + '%!m:' + options.monthLabel + ',' + options.monthLabelPlural + ';</span></span>';
			var $dayHTML    = '<span class="qodef-digit-wrapper"><span class="qodef-digit">%n</span><span class="qodef-label">' + '%!n:' + options.dayLabel + ',' + options.dayLabelPlural + ';</span></span>';
			var $hourHTML   = '<span class="qodef-digit-wrapper"><span class="qodef-digit">%H</span><span class="qodef-label">' + '%!H:' + options.hourLabel + ',' + options.hourLabelPlural + ';</span></span>';
			var $minuteHTML = '<span class="qodef-digit-wrapper"><span class="qodef-digit">%M</span><span class="qodef-label">' + '%!M:' + options.minuteLabel + ',' + options.minuteLabelPlural + ';</span></span>';
			var $secondHTML = '<span class="qodef-digit-wrapper"><span class="qodef-digit">%S</span><span class="qodef-label">' + '%!S:' + options.secondLabel + ',' + options.secondLabelPlural + ';</span></span>';

			$countdownElement.countdown(
				options.date,
				function ( event ) {
					$( this ).html( event.strftime( $monthHTML + $dayHTML + $hourHTML + $minuteHTML + $secondHTML ) );
				}
			);
		}
	};

	qodefCore.shortcodes.gracey_core_countdown.qodefCountdown = qodefCountdown;

})( jQuery );

(function ( $ ) {
	'use strict';

	qodefCore.shortcodes.gracey_core_counter = {};

	$( document ).ready(
		function () {
			qodefCounter.init();
		}
	);

	var qodefCounter = {
		init: function () {
			this.counters = $( '.qodef-counter' );

			if ( this.counters.length ) {
				this.counters.each(
					function () {
						var $thisCounter    = $( this ),
							$counterElement = $thisCounter.find( '.qodef-m-digit' ),
							options         = qodefCounter.generateOptions( $thisCounter );

						qodefCounter.counterScript( $counterElement, options );
					}
				);
			}
		},
		generateOptions: function ( $counter ) {
			var options   = {};
			options.start = typeof $counter.data( 'start-digit' ) !== 'undefined' && $counter.data( 'start-digit' ) !== '' ? $counter.data( 'start-digit' ) : 0;
			options.end   = typeof $counter.data( 'end-digit' ) !== 'undefined' && $counter.data( 'end-digit' ) !== '' ? $counter.data( 'end-digit' ) : null;
			options.step  = typeof $counter.data( 'step-digit' ) !== 'undefined' && $counter.data( 'step-digit' ) !== '' ? $counter.data( 'step-digit' ) : 1;
			options.delay = typeof $counter.data( 'step-delay' ) !== 'undefined' && $counter.data( 'step-delay' ) !== '' ? parseInt( $counter.data( 'step-delay' ), 10 ) : 100;
			options.txt   = typeof $counter.data( 'digit-label' ) !== 'undefined' && $counter.data( 'digit-label' ) !== '' ? $counter.data( 'digit-label' ) : '';

			return options;
		},
		counterScript: function ( $counterElement, options ) {
			var defaults = {
				start: 0,
				end: null,
				step: 1,
				delay: 50,
				txt: '',
			};

			var settings = $.extend( defaults, options || {} );
			var nb_start = settings.start;
			var nb_end   = settings.end;

			$counterElement.text( nb_start + settings.txt );

			var counter = function () {
				// Definition of conditions of arrest
				if ( nb_end !== null && nb_start >= nb_end ) {
					return;
				}
				// incrementation
				nb_start = nb_start + settings.step;

				if ( nb_start >= nb_end ) {
					nb_start = nb_end;
				}
				// display
				$counterElement.text( nb_start + settings.txt );
			};

			// Timer
			// Launches every "settings.delay"
			$counterElement.appear(
				function () {
					setInterval( counter, settings.delay );
				},
				{ accX: 0, accY: 0 }
			);
		}
	};

	qodefCore.shortcodes.gracey_core_counter.qodefCounter = qodefCounter;

})( jQuery );

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

(function ( $ ) {
	'use strict';

	qodefCore.shortcodes.gracey_core_google_map = {};

	$( document ).ready(
		function () {
			qodefGoogleMap.init();
		}
	);

	var qodefGoogleMap = {
		init: function () {
			this.holder = $( '.qodef-google-map' );

			if ( this.holder.length ) {
				this.holder.each(
					function () {
						if ( typeof window.qodefGoogleMap !== 'undefined' ) {
							window.qodefGoogleMap.init( $( this ).find( '.qodef-m-map' ) );
						}
					}
				);
			}
		}
	};

	qodefCore.shortcodes.gracey_core_google_map.qodefGoogleMap = qodefGoogleMap;

})( jQuery );

(function ( $ ) {
	'use strict';

	qodefCore.shortcodes.gracey_core_icon = {};

	$( document ).ready(
		function () {
			qodefIcon.init();
		}
	);

	var qodefIcon = {
		init: function () {
			this.icons = $( '.qodef-icon-holder' );

			if ( this.icons.length ) {
				this.icons.each(
					function () {
						var $thisIcon = $( this );

						qodefIcon.iconHoverColor( $thisIcon );
						qodefIcon.iconHoverBgColor( $thisIcon );
						qodefIcon.iconHoverBorderColor( $thisIcon );
					}
				);
			}
		},
		iconHoverColor: function ( $iconHolder ) {
			if ( typeof $iconHolder.data( 'hover-color' ) !== 'undefined' ) {
				var spanHolder    = $iconHolder.find( 'span' );
				var originalColor = spanHolder.css( 'color' );
				var hoverColor    = $iconHolder.data( 'hover-color' );

				$iconHolder.on(
					'mouseenter',
					function () {
						qodefIcon.changeColor(
							spanHolder,
							'color',
							hoverColor
						);
					}
				);
				$iconHolder.on(
					'mouseleave',
					function () {
						qodefIcon.changeColor(
							spanHolder,
							'color',
							originalColor
						);
					}
				);
			}
		},
		iconHoverBgColor: function ( $iconHolder ) {
			if ( typeof $iconHolder.data( 'hover-background-color' ) !== 'undefined' ) {
				var hoverBackgroundColor    = $iconHolder.data( 'hover-background-color' );
				var originalBackgroundColor = $iconHolder.css( 'background-color' );

				$iconHolder.on(
					'mouseenter',
					function () {
						qodefIcon.changeColor(
							$iconHolder,
							'background-color',
							hoverBackgroundColor
						);
					}
				);
				$iconHolder.on(
					'mouseleave',
					function () {
						qodefIcon.changeColor(
							$iconHolder,
							'background-color',
							originalBackgroundColor
						);
					}
				);
			}
		},
		iconHoverBorderColor: function ( $iconHolder ) {
			if ( typeof $iconHolder.data( 'hover-border-color' ) !== 'undefined' ) {
				var hoverBorderColor    = $iconHolder.data( 'hover-border-color' );
				var originalBorderColor = $iconHolder.css( 'borderTopColor' );

				$iconHolder.on(
					'mouseenter',
					function () {
						qodefIcon.changeColor(
							$iconHolder,
							'border-color',
							hoverBorderColor
						);
					}
				);
				$iconHolder.on(
					'mouseleave',
					function () {
						qodefIcon.changeColor(
							$iconHolder,
							'border-color',
							originalBorderColor
						);
					}
				);
			}
		},
		changeColor: function ( iconElement, cssProperty, color ) {
			iconElement.css(
				cssProperty,
				color
			);
		}
	};

	qodefCore.shortcodes.gracey_core_icon.qodefIcon = qodefIcon;

})( jQuery );

(function ( $ ) {
	'use strict';

	qodefCore.shortcodes.gracey_core_image_gallery                    = {};
	qodefCore.shortcodes.gracey_core_image_gallery.qodefSwiper        = qodef.qodefSwiper;
	qodefCore.shortcodes.gracey_core_image_gallery.qodefMasonryLayout = qodef.qodefMasonryLayout;

})( jQuery );

(function ( $ ) {
	'use strict';

	qodefCore.shortcodes.gracey_core_image_with_text                    = {};
	qodefCore.shortcodes.gracey_core_image_with_text.qodefMagnificPopup = qodef.qodefMagnificPopup;

})( jQuery );

(function ( $ ) {
	'use strict';

	qodefCore.shortcodes.gracey_core_interactive_link_showcase = {};

})( jQuery );

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

(function ( $ ) {
	'use strict';

	qodefCore.shortcodes.gracey_core_progress_bar = {};

	$( document ).ready(
		function () {
			qodefProgressBar.init();
		}
	);

	/**
	 * Init progress bar shortcode functionality
	 */
	var qodefProgressBar = {
		init: function () {
			this.holder = $( '.qodef-progress-bar' );

			if ( this.holder.length ) {
				this.holder.each(
					function () {
						var $thisHolder = $( this ),
							layout      = $thisHolder.data( 'layout' );

						$thisHolder.appear(
							function () {
								$thisHolder.addClass( 'qodef--init' );

								var $container = $thisHolder.find( '.qodef-m-canvas' ),
									data       = qodefProgressBar.generateBarData( $thisHolder, layout ),
									number     = $thisHolder.data( 'number' ) / 100;

								switch (layout) {
									case 'circle':
										qodefProgressBar.initCircleBar( $container, data, number );
										break;
									case 'semi-circle':
										qodefProgressBar.initSemiCircleBar( $container, data, number );
										break;
									case 'line':
										data = qodefProgressBar.generateLineData( $thisHolder, number );
										qodefProgressBar.initLineBar( $container, data );
										break;
									case 'custom':
										qodefProgressBar.initCustomBar( $container, data, number );
										break;
								}
							}
						);
					}
				);
			}
		},
		generateBarData: function ( thisBar, layout ) {
			var activeWidth   = thisBar.data( 'active-line-width' );
			var activeColor   = thisBar.data( 'active-line-color' );
			var inactiveWidth = thisBar.data( 'inactive-line-width' );
			var inactiveColor = thisBar.data( 'inactive-line-color' );
			var easing        = 'linear';
			var duration      = typeof thisBar.data( 'duration' ) !== 'undefined' && thisBar.data( 'duration' ) !== '' ? parseInt( thisBar.data( 'duration' ), 10 ) : 1600;
			var textColor     = thisBar.data( 'text-color' );

			return {
				strokeWidth: activeWidth,
				color: activeColor,
				trailWidth: inactiveWidth,
				trailColor: inactiveColor,
				easing: easing,
				duration: duration,
				svgStyle: {
					width: '100%',
					height: '100%'
				},
				text: {
					style: {
						color: textColor
					},
					autoStyleContainer: false
				},
				from: {
					color: inactiveColor
				},
				to: {
					color: activeColor
				},
				step: function ( state, bar ) {
					if ( layout !== 'custom' ) {
						bar.setText( Math.round( bar.value() * 100 ) + '%' );
					}
				},
			};
		},
		generateLineData: function ( thisBar, number ) {
			var height         = thisBar.data( 'active-line-width' );
			var activeColor    = thisBar.data( 'active-line-color' );
			var inactiveHeight = thisBar.data( 'inactive-line-width' );
			var inactiveColor  = thisBar.data( 'inactive-line-color' );
			var duration       = typeof thisBar.data( 'duration' ) !== 'undefined' && thisBar.data( 'duration' ) !== '' ? parseInt( thisBar.data( 'duration' ), 10 ) : 1600;
			var textColor      = thisBar.data( 'text-color' );

			return {
				percentage: number * 100,
				duration: duration,
				fillBackgroundColor: activeColor,
				backgroundColor: inactiveColor,
				height: height,
				inactiveHeight: inactiveHeight,
				followText: thisBar.hasClass( 'qodef-percentage--floating' ),
				textColor: textColor,
			};
		},
		initCircleBar: function ( $container, data, number ) {
			if ( qodefProgressBar.checkBar( $container ) ) {
				var $bar = new ProgressBar.Circle( $container[0], data );

				$bar.animate( number );
			}
		},
		initSemiCircleBar: function ( $container, data, number ) {
			if ( qodefProgressBar.checkBar( $container ) ) {
				var $bar = new ProgressBar.SemiCircle( $container[0], data );

				$bar.animate( number );
			}
		},
		initCustomBar: function ( $container, data, number ) {
			if ( qodefProgressBar.checkBar( $container ) ) {
				var $bar = new ProgressBar.Path( $container[0], data );

				$bar.set( 0 );
				$bar.animate( number );
			}
		},
		initLineBar: function ( $container, data ) {
			$container.LineProgressbar( data );
		},
		checkBar: function ( $container ) {
			// check if svg is already in container, elementor fix
			if ( $container.find( 'svg' ).length ) {
				return false;
			}

			return true;
		}
	};

	qodefCore.shortcodes.gracey_core_progress_bar.qodefProgressBar = qodefProgressBar;

})( jQuery );

(function ( $ ) {
	'use strict';

	qodefCore.shortcodes.gracey_core_single_image = {};
	
	qodefCore.shortcodes.gracey_core_single_image.qodefDistortAnimation = qodefCore.qodefDistortAnimation;

	$(window).on(
		'load',
		function () {
			qodefSingleImageRipple.init();
		}
	);
	
	var qodefSingleImageRipple = {
		init: function () {
			this.holder = $('.qodef-single-image.qodef--distort-effect-5');
			
			if (this.holder.length) {
				this.holder.each(
					function () {
						var $thisHolder = $(this);
						
						qodefSingleImageRipple.qodefInitRippleHover($thisHolder);
					}
				);
			}
		},
		qodefRippleEffect: function(element, options) {
		
		//  OPTIONS
		/// ---------------------------
		options = options || {};
		options.stageWidth = options.hasOwnProperty('stageWidth') ? options.stageWidth : 400;
		options.stageHeight = options.hasOwnProperty('stageHeight') ? options.stageHeight : 600;
		options.pixiSprite = options.hasOwnProperty('imageSrc') ? options.imageSrc : '';
		options.pixelSpriteScale = options.hasOwnProperty('spriteScale') ? options.spriteScale : [3, 3];
		options.imageScale = options.hasOwnProperty('imageScale') ? options.imageScale : [1.2, 1.2];
		options.autoPlay = options.hasOwnProperty('autoPlay') ? options.autoPlay : false;
		options.shakeSpeed = options.hasOwnProperty('shakeSpeed') ? options.shakeSpeed : [10, 3];
		options.displaceOnce = options.hasOwnProperty('displaceOnce') ? options.displaceOnce : false;
		options.displacementSprite = options.hasOwnProperty('displacementSprite') ? options.displacementSprite : '';
		options.centerDisplacement = options.hasOwnProperty('centerDisplacement') ? options.centerDisplacement : false;
		options.interactive = options.hasOwnProperty('interactive') ? options.interactive : false;
		options.interactionEvent = options.hasOwnProperty('interactionEvent') ? options.interactionEvent : '';
		options.hoverEaseInDuration = options.hasOwnProperty('hoverEaseInDuration') ? options.hoverEaseInDuration : 0.3;
		options.hoverEaseOutDuration = options.hasOwnProperty('hoverEaseOutDuration') ? options.hoverEaseOutDuration : 1;
		options.displaceSpeed = options.hasOwnProperty('displaceSpeed') ? options.displaceSpeed : [40, 40];
		
		//  PIXI VARIABLES
		/// ---------------------------
		var renderer = new PIXI.autoDetectRenderer(options.stageWidth, options.stageHeight, {transparent: true});
		var stage = new PIXI.Container();
		var container = new PIXI.Container();
		var displacementSprite = new PIXI.Sprite.fromImage(options.displacementSprite);
		var displacementFilter = new PIXI.filters.DisplacementFilter(displacementSprite);
		
		/// ---------------------------
		//  INITIALISE PIXI
		/// ---------------------------
		var initPixi = function () {
			
			// Add canvas to the HTML element
			element.appendChild(renderer.view);
			
			// Add child container to the main container
			stage.addChild(container);
			
			// Enable Interactions
			stage.interactive = true;
			displacementSprite.texture.baseTexture.wrapMode = PIXI.WRAP_MODES.REPEAT;
			
			// Set the filter to stage and set some default values for the animation
			stage.filters = [displacementFilter];
			
			if (options.displaceOnce === true) {
				options.autoPlay = false;
			}
			
			if (options.autoPlay === false) {
				displacementFilter.scale.x = 0;
				displacementFilter.scale.y = 0;
			} else {
				displacementFilter.scale.x = options.displaceSpeed[0];
				displacementFilter.scale.y = options.displaceSpeed[1];
			}
			
			if (options.centerDisplacement === true) {
				displacementSprite.anchor.set(0.5);
			}
			
			displacementSprite.scale.x = options.pixelSpriteScale[0];
			displacementSprite.scale.y = options.pixelSpriteScale[1];
			
			stage.addChild(displacementSprite);
			
		};
		
		/// ---------------------------
		//  LOAD IMAGES TO CANVAS
		/// ---------------------------
		var loadPixiSprite = function (sprite) {
			
			var texture = new PIXI.Texture.fromImage(sprite);
			var image = new PIXI.Sprite(texture);
			
			image.anchor.set(0.5);
			image.x = renderer.width / 2 ;
			image.y = renderer.height / 2;
			image.width = renderer.width * options.imageScale[0];
			image.height = renderer.height * options.imageScale[1];
			
			container.addChild(image);
		};
		
		/// ---------------------------
		//  DEFAULT RENDER/ANIMATION
		/// ---------------------------
		if (options.displaceOnce === false) {
			
			var ticker = new PIXI.ticker.Ticker();
			
			ticker.autoStart = true;
			
			ticker.add(function (delta) {
				
				displacementSprite.x += options.shakeSpeed[0] * delta;
				displacementSprite.y += options.shakeSpeed[1] ;
				
				renderer.render(stage);
				
			});
			
		} else {
			
			var render = new PIXI.ticker.Ticker();
			
			render.autoStart = true;
			
			render.add(function (delta) {
				renderer.render(stage);
			});
			
		}
		
		/// ---------------------------
		//  INTERACTIONS
		/// ---------------------------
		function rotateSpite() {
			// displacementSprite.rotation += 0.001;
			rafID = requestAnimationFrame(rotateSpite);
		}
		
		if (options.interactive === true) {
			
			var rafID;
			
			// Enable interactions
			container.interactive = true;
			container.buttonMode = true;
			
			gsap.to(displacementFilter.scale, options.hoverEaseInDuration, {
				x: options.displaceSpeed[0],
				y: options.displaceSpeed[1],
				yoyo: false,
			});
			rotateSpite();
			
			// HOVER
			if (options.interactionEvent === 'hover') {
				
				container.pointerover = function () {
					gsap.to(displacementFilter.scale, options.hoverEaseOutDuration, {x: 0, y: 0});
					cancelAnimationFrame(rafID);
				};
				
				container.pointerout = function () {
					gsap.to(displacementFilter.scale, options.hoverEaseInDuration, {
						x: options.displaceSpeed[0],
						y: options.displaceSpeed[1],
						yoyo: false,
					});
					rotateSpite();
				};
			}
		}
		
		/// ---------------------------
		//  INIT FUNCTIONS
		/// ---------------------------
		var init = function () {
			initPixi();
			loadPixiSprite(options.pixiSprite);
		};
		
		init();
	},
		
		qodefInitRippleHover : function(item) {
			var thisImage = item[0],
				itemImage = thisImage.querySelector('img'),
				infiniteAnimation = item.hasClass('qodef--infinite-animation');
			
			qodefSingleImageRipple.qodefRippleEffect(thisImage, {
				imageSrc: itemImage.getAttribute('src'),
				imageScale: [.9, .9], // image scale on x and y axis, set to 1.1 not to affect the edges
				stageWidth: itemImage.width,
				stageHeight: itemImage.height,
				displacementSprite: '/wp-content/plugins/gracey-core/inc/shortcodes/single-image/assets/img/image-hover-pattern.jpg', // sprite image used to create ripple effect
				spriteScale: [4, 3], // sprite image scale on x and y axis (high values - subtle effect, low values - granular effect)
				centerDisplacement: true, // recommended set to true
				autoPlay: false, // autoplay effect, displaceOnce has to be false
				shakeSpeed: [2, 1.5], // ripple SHAKE SPEED on x and y axis, displaceOnce has to be false, recommended low values
				displaceSpeed: [110, 80], // ripple effect DISPLACE SPEED on x and y axis, play with those
				displaceOnce: false, // set to true and the image will displace once to final form (no repeating effect)
				interactive: true, // has to be set to true for hover
				interactionEvent: infiniteAnimation ? '' : 'hover',
				hoverEaseInDuration: .5, // hover ease in duration for ripple effect
				hoverEaseOutDuration: .5, // hover ease out duration for ripple effect
			});
		}
	};

})( jQuery );

(function ( $ ) {
	'use strict';

	qodefCore.shortcodes.gracey_core_stacked_images = {};

	$( document ).ready(
		function () {
			qodefStackedImages.init();
		}
	);

	var qodefStackedImages = {
		init: function () {
			this.images = $( '.qodef-stacked-images' );

			if ( this.images.length ) {
				this.images.each(
					function () {
						var $thisImage = $( this );

						qodefStackedImages.animate( $thisImage );
					}
				);
			}
		},
		animate: function ( $image ) {

			var itemImage = $image.find( '.qodef-m-images' );
			$image.animate(
				{ opacity: 1 },
				300
			);

			setTimeout(
				function () {
					$image.appear(
						function () {
							itemImage.addClass( 'qodef--appeared' );
						}
					);
				},
				200
			);

		}
	};

	qodefCore.shortcodes.gracey_core_stacked_images.qodefStackedImages = qodefStackedImages;

})( jQuery );

(function ( $ ) {
	'use strict';

	qodefCore.shortcodes.gracey_core_stamp = {};

	$( document ).ready(
		function () {
			qodefInitStamp.init();
		}
	);

	/**
	 * Init stamp shortcode on appear
	 */
	var qodefInitStamp = {
		init: function () {
			this.holder = $( '.qodef-stamp' );

			if ( this.holder.length ) {
				this.holder.each(
					function () {
						var $holder         = $( this ),
							appearing_delay = typeof $holder.data( 'appearing-delay' ) !== 'undefined' ? parseInt( $holder.data( 'appearing-delay' ), 10 ) : 0;

						// Initialization
						qodefInitStamp.initStampText( $holder );
						qodefInitStamp.load( $holder, appearing_delay );

						if ( $holder.hasClass( 'qodef--repeating' ) ) {
							setInterval(
								function () {
									qodefInitStamp.reLoad( $holder );
								},
								5500
							);
						}
					}
				);
			}
		},
		initStampText: function ( $holder ) {
			var $stamp = $holder.children( '.qodef-m-text' ),
				count  = typeof $holder.data( 'appearing-delay' ) !== 'undefined' ? parseInt( $stamp.data( 'count' ), 10 ) : 1;

			$stamp.children().each(
				function ( i ) {
					var transform       = -90 + i * 360 / count,
						// transitionDelay = i * 60 / count * 10;
						transitionDelay = 0;

					$( this ).css(
						{
							'transform': 'rotate(' + transform + 'deg) translateZ(0)',
							'transition-delay': transitionDelay + 'ms',
						}
					);
				}
			);
		},
		load: function ( $holder, appearing_delay ) {
			if ( $holder.hasClass( 'qodef--nested' ) ) {
				setTimeout(
					function () {
						qodefInitStamp.appear( $holder );
					},
					appearing_delay
				);
			} else {
				qodefCore.qodefIsInViewport.check(
					$holder,
					function () {
						setTimeout(
							function () {
								qodefInitStamp.appear( $holder );
							},
							appearing_delay
						);
					}
				)
			}
		},
		reLoad: function ( $holder ) {
			$holder.removeClass( 'qodef--init' );

			setTimeout(
				function () {
					$holder.removeClass( 'qodef--appear' );

					setTimeout(
						function () {
							qodefInitStamp.appear( $holder );
						},
						500
					);
				},
				600
			);
		},
		appear: function ( $holder ) {
			$holder.addClass( 'qodef--appear' );

			setTimeout(
				function () {
					$holder.addClass( 'qodef--init' );
				},
				300
			);
		}
	};

	qodefCore.shortcodes.gracey_core_stamp.qodefInitStamp = qodefInitStamp;

})( jQuery );

(function ( $ ) {
	'use strict';

	qodefCore.shortcodes.gracey_core_swapping_image_gallery = {};

	$( document ).ready(
		function () {
			qodefSwappingImageGallery.init();
		}
	);

	var qodefSwappingImageGallery = {
		init: function () {
			this.holder = $( '.qodef-swapping-image-gallery' );

			if ( this.holder.length ) {
				this.holder.each(
					function () {
						var $thisHolder = $( this );
						qodefSwappingImageGallery.createSlider( $thisHolder );
					}
				);
			}
		},
		createSlider: function ( $holder ) {
			var $swiperHolder     = $holder.find( '.qodef-m-image-holder' );
			var $paginationHolder = $holder.find( '.qodef-m-thumbnails-holder .qodef-grid-inner' );
			var spaceBetween      = 0;
			var slidesPerView     = 1;
			var centeredSlides    = false;
			var loop              = false;
			var autoplay          = false;
			var speed             = 800;

			var $swiper = new Swiper(
				$swiperHolder,
				{
					slidesPerView: slidesPerView,
					centeredSlides: centeredSlides,
					spaceBetween: spaceBetween,
					autoplay: autoplay,
					loop: loop,
					speed: speed,
					pagination: {
						el: $paginationHolder,
						type: 'custom',
						clickable: true,
						bulletClass: 'qodef-m-thumbnail',
					},
					on: {
						init: function () {
							$swiperHolder.addClass( 'qodef-swiper--initialized' );
							$paginationHolder.find( '.qodef-m-thumbnail' ).eq( 0 ).addClass( 'qodef--active' );
						},
						slideChange: function slideChange() {
							var swiper      = this;
							var activeIndex = swiper.activeIndex;
							$paginationHolder.find( '.qodef--active' ).removeClass( 'qodef--active' );
							$paginationHolder.find( '.qodef-m-thumbnail' ).eq( activeIndex ).addClass( 'qodef--active' );
						}
					},
				}
			);
		}
	};

	qodefCore.shortcodes.gracey_core_swapping_image_gallery.qodefSwappingImageGallery = qodefSwappingImageGallery;

})( jQuery );

(function ( $ ) {
	'use strict';

	qodefCore.shortcodes.gracey_core_tabs = {};

	$( document ).ready(
		function () {
			qodefTabs.init();
		}
	);

	var qodefTabs = {
		init: function () {
			this.holder = $( '.qodef-tabs' );

			if ( this.holder.length ) {
				this.holder.each(
					function () {
						qodefTabs.initTabs( $( this ) );
					}
				);
			}
		},
		initTabs: function ( $tabs ) {
			$tabs.children( '.qodef-tabs-content' ).each(
				function ( index ) {
					index = index + 1;

					var $that    = $( this ),
						link     = $that.attr( 'id' ),
						$navItem = $that.parent().find( '.qodef-tabs-navigation li:nth-child(' + index + ') a' ),
						navLink  = $navItem.attr( 'href' );

					link = '#' + link;

					if ( link.indexOf( navLink ) > -1 ) {
						$navItem.attr(
							'href',
							link
						);
					}
				}
			);

			$tabs.addClass( 'qodef--init' ).tabs();
		}
	};

	qodefCore.shortcodes.gracey_core_tabs.qodefTabs = qodefTabs;

})( jQuery );

(function ( $ ) {
	'use strict';

	qodefCore.shortcodes.gracey_core_text_marquee = {};

	$( document ).ready(
		function () {
			qodefTextMarquee.init();
		}
	);

	var qodefTextMarquee = {
		init: function () {
			this.holder = $( '.qodef-text-marquee' );

			if ( this.holder.length ) {
				this.holder.each(
					function () {
						qodefTextMarquee.initItem( $( this ) );
					}
				);
			}
		},
		initItem: function ( $currentItem ) {
			qodefTextMarquee.initMarquee( $currentItem );
			qodefTextMarquee.initResponsive( $currentItem.find( '.qodef-m-content' ) );
		},
		initResponsive: function ( thisMarquee ) {
			var fontSize,
				lineHeight,
				coef1 = 1,
				coef2 = 1;

			if ( qodefCore.windowWidth < 1480 ) {
				coef1 = 0.8;
			}

			if ( qodefCore.windowWidth < 1200 ) {
				coef1 = 0.7;
			}

			if ( qodefCore.windowWidth < 768 ) {
				coef1 = 0.55;
				coef2 = 0.65;
			}

			if ( qodefCore.windowWidth < 600 ) {
				coef1 = 0.45;
				coef2 = 0.55;
			}

			if ( qodefCore.windowWidth < 480 ) {
				coef1 = 0.4;
				coef2 = 0.5;
			}

			fontSize = parseInt( thisMarquee.css( 'font-size' ) );

			if ( fontSize > 200 ) {
				fontSize = Math.round( fontSize * coef1 );
			} else if ( fontSize > 60 ) {
				fontSize = Math.round( fontSize * coef2 );
			}

			thisMarquee.css( 'font-size', fontSize + 'px' );

			lineHeight = parseInt( thisMarquee.css( 'line-height' ) );

			if ( lineHeight > 70 && qodefCore.windowWidth < 1440 ) {
				lineHeight = '1.2em';
			} else if ( lineHeight > 35 && qodefCore.windowWidth < 768 ) {
				lineHeight = '1.2em';
			} else {
				lineHeight += 'px';
			}

			thisMarquee.css( 'line-height', lineHeight );
		},
		initMarquee: function ( thisMarquee ) {
			var elements = thisMarquee.find( '.qodef-m-text' ),
				// isFirefox = qodefCore.body.hasClass('qodef-browser--firefox'),
				// isSafari = qodefCore.body.hasClass('qodef-browser--safari'),
			    delta =  .09;
			
			elements.each(
				function ( i ) {
					$( this ).data( 'x', 0 );
				}
			);

			requestAnimationFrame(
				function () {
					qodefTextMarquee.loop( thisMarquee, elements, delta );
				}
			);
		},
		inRange: function ( thisMarquee ) {
			if ( qodefCore.scroll + qodefCore.windowHeight >= thisMarquee.offset().top && qodefCore.scroll < thisMarquee.offset().top + thisMarquee.height() ) {
				return true;
			}

			return false;
		},
		loop: function ( thisMarquee, elements, delta ) {
			if ( ! qodefTextMarquee.inRange( thisMarquee ) ) {
				requestAnimationFrame(
					function () {
						qodefTextMarquee.loop( thisMarquee, elements, delta );
					}
				);
				return false;
			} else {
				elements.each(
					function ( i ) {
						var el = $( this ),
							rightBoundary = thisMarquee.width() + thisMarquee.offset().left - 25;

						if ( thisMarquee.hasClass('qodef-animation--reverse') ) {
							if ( !thisMarquee.hasClass('qodef-marquee-paused') ){
								el.css( 'transform', 'translate3d(' + -el.data( 'x' ) + '%, 0, 0)' );
								el.data( 'x', (el.data( 'x' ) - delta).toFixed( 2 ) );
							}
							el.offset().left > rightBoundary && el.data( 'x', 100 * Math.abs( i - 1 ) );
						} else {
							if ( !thisMarquee.hasClass('qodef-marquee-paused') ) {
								el.css('transform', 'translate3d(' + el.data('x') + '%, 0, 0)');
								el.data('x', (el.data('x') - delta).toFixed(2));
							}
							el.offset().left < -el.width() - 25 && el.data( 'x', 100 * Math.abs( i - 1 ) );
						}
					}
				);
				requestAnimationFrame(
					function () {
						qodefTextMarquee.loop( thisMarquee, elements, delta );
					}
				);
			}
		}
	};

	qodefCore.shortcodes.gracey_core_text_marquee.qodefTextMarquee = qodefTextMarquee;
	
})( jQuery );

(function ( $ ) {
	'use strict';

	qodefCore.shortcodes.gracey_core_video_button                    = {};
	qodefCore.shortcodes.gracey_core_video_button.qodefMagnificPopup = qodef.qodefMagnificPopup;

})( jQuery );

(function ( $ ) {
	'use strict';

	$( window ).on(
		'load',
		function () {
			qodefStickySidebar.init();
		}
	);

	var qodefStickySidebar = {
		init: function () {
			var info = $( '.widget_gracey_core_sticky_sidebar' );

			if ( info.length && qodefCore.windowWidth > 1024 ) {
				info.wrapper = info.parents( '#qodef-page-sidebar' );
				info.c       = 24;
				info.offsetM = info.offset().top - info.wrapper.offset().top;
				info.adj     = 15;

				qodefStickySidebar.callStack( info );

				$( window ).on(
					'resize',
					function () {
						if ( qodefCore.windowWidth > 1024 ) {
							qodefStickySidebar.callStack( info );
						}
					}
				);

				$( window ).on(
					'scroll',
					function () {
						if ( qodefCore.windowWidth > 1024 ) {
							qodefStickySidebar.infoPosition( info );
						}
					}
				);
			}
		},
		calc: function ( info ) {
			var content = $( '.qodef-page-content-section' ),
				headerH = qodefCore.body.hasClass( 'qodef-header-appearance--none' ) ? 0 : parseInt( qodefGlobal.vars.headerHeight, 10 );

			info.start = content.offset().top;
			info.end   = content.outerHeight();
			info.h     = info.wrapper.height();
			info.w     = info.outerWidth();
			info.left  = info.offset().left;
			info.top   = headerH + qodefGlobal.vars.adminBarHeight + info.c - info.offsetM;
			info.data( 'state', 'top' );
		},
		infoPosition: function ( info ) {
			if ( qodefCore.scroll < info.start - info.top && qodefCore.scroll + info.h && info.data( 'state' ) !== 'top' ) {
				TweenMax.to(
					info.wrapper,
					.1,
					{
						y: 5,
					}
				);
				TweenMax.to(
					info.wrapper,
					.3,
					{
						y: 0,
						delay: .1,
					}
				);
				info.data( 'state', 'top' );
				info.wrapper.css(
					{
						'position': 'static',
					}
				);
			} else if ( qodefCore.scroll >= info.start - info.top && qodefCore.scroll + info.h + info.adj <= info.start + info.end &&
				info.data( 'state' ) !== 'fixed' ) {
				var c = info.data( 'state' ) === 'top' ? 1 : -1;
				info.data( 'state', 'fixed' );
				info.wrapper.css(
					{
						'position': 'fixed',
						'top': info.top,
						'left': info.left,
						'width': info.w,
					}
				);
				TweenMax.fromTo(
					info.wrapper,
					.2,
					{
						y: 0
					},
					{
						y: c * 10,
						ease: Power4.easeInOut
					}
				);
				TweenMax.to(
					info.wrapper,
					.2,
					{
						y: 0,
						delay: .2,
					}
				);
			} else if ( qodefCore.scroll + info.h + info.adj > info.start + info.end && info.data( 'state' ) !== 'bottom' ) {
				info.data( 'state', 'bottom' );
				info.wrapper.css(
					{
						'position': 'absolute',
						'top': info.end - info.h - info.adj,
						'left': 0,
					}
				);
				TweenMax.fromTo(
					info.wrapper,
					.1,
					{
						y: 0
					},
					{
						y: -5,
					}
				);
				TweenMax.to(
					info.wrapper,
					.3,
					{
						y: 0,
						delay: .1,
					}
				);
			}
		},
		callStack: function ( info ) {
			this.calc( info );
			this.infoPosition( info );
		}
	};

})( jQuery );

(function ( $ ) {
	'use strict';

	var shortcode = 'gracey_core_blog_list';

	qodefCore.shortcodes[shortcode] = {};

	if ( typeof qodefCore.listShortcodesScripts === 'object' ) {
		$.each(
			qodefCore.listShortcodesScripts,
			function ( key, value ) {
				qodefCore.shortcodes[shortcode][key] = value;
			}
		);
	}

	qodefCore.shortcodes[shortcode].qodefResizeIframes = qodef.qodefResizeIframes;

})( jQuery );

(function ( $ ) {
	'use strict';

	$( document ).ready(
		function () {
			qodefVerticalNavMenu.init();
		}
	);

	/**
	 * Function object that represents vertical menu area.
	 * @returns {{init: Function}}
	 */
	var qodefVerticalNavMenu = {
		initNavigation: function ( $verticalMenuObject ) {
			var $verticalNavObject = $verticalMenuObject.find( '.qodef-header-vertical-navigation' );

			if ( $verticalNavObject.hasClass( 'qodef-vertical-drop-down--below' ) ) {
				qodefVerticalNavMenu.dropdownClickToggle( $verticalNavObject );
			} else if ( $verticalNavObject.hasClass( 'qodef-vertical-drop-down--side' ) ) {
				qodefVerticalNavMenu.dropdownFloat( $verticalNavObject );
			}
		},
		dropdownClickToggle: function ( $verticalNavObject ) {
			var $menuItems = $verticalNavObject.find( 'ul li.menu-item-has-children' );

			$menuItems.each(
				function () {
					var $elementToExpand = $( this ).find( ' > .qodef-drop-down-second, > ul' );
					var menuItem         = this;
					var $dropdownOpener  = $( this ).find( '> a' );
					var slideUpSpeed     = 'fast';
					var slideDownSpeed   = 'slow';

					$dropdownOpener.on(
						'click tap',
						function ( e ) {
							e.preventDefault();
							e.stopPropagation();

							if ( $elementToExpand.is( ':visible' ) ) {
								$( menuItem ).removeClass( 'qodef-menu-item--open' );
								$elementToExpand.slideUp( slideUpSpeed );
							} else if ( $dropdownOpener.parent().parent().children().hasClass( 'qodef-menu-item--open' ) && $dropdownOpener.parent().parent().parent().hasClass( 'qodef-vertical-menu' ) ) {
								$( this ).parent().parent().children().removeClass( 'qodef-menu-item--open' );
								$( this ).parent().parent().children().find( ' > .qodef-drop-down-second' ).slideUp( slideUpSpeed );

								$( menuItem ).addClass( 'qodef-menu-item--open' );
								$elementToExpand.slideDown( slideDownSpeed );
							} else {

								if ( ! $( this ).parents( 'li' ).hasClass( 'qodef-menu-item--open' ) ) {
									$menuItems.removeClass( 'qodef-menu-item--open' );
									$menuItems.find( ' > .qodef-drop-down-second, > ul' ).slideUp( slideUpSpeed );
								}

								if ( $( this ).parent().parent().children().hasClass( 'qodef-menu-item--open' ) ) {
									$( this ).parent().parent().children().removeClass( 'qodef-menu-item--open' );
									$( this ).parent().parent().children().find( ' > .qodef-drop-down-second, > ul' ).slideUp( slideUpSpeed );
								}

								$( menuItem ).addClass( 'qodef-menu-item--open' );
								$elementToExpand.slideDown( slideDownSpeed );
							}
						}
					);
				}
			);
		},
		dropdownFloat: function ( $verticalNavObject ) {
			var $menuItems = $verticalNavObject.find( 'ul li.menu-item-has-children' );
			var $allDropdowns = $menuItems.find( ' > .qodef-drop-down-second > .qodef-drop-down-second-inner > ul, > ul' );

			$menuItems.each(
				function () {
					var $elementToExpand = $( this ).find( ' > .qodef-drop-down-second > .qodef-drop-down-second-inner > ul, > ul' );
					var menuItem         = this;

					if ( Modernizr.touch ) {
						var $dropdownOpener = $( this ).find( '> a' );

						$dropdownOpener.on(
							'click tap',
							function ( e ) {
								e.preventDefault();
								e.stopPropagation();

								if ( $elementToExpand.hasClass( 'qodef-float--open' ) ) {
									$elementToExpand.removeClass( 'qodef-float--open' );
									$( menuItem ).removeClass( 'qodef-menu-item--open' );
								} else {
									if ( ! $( this ).parents( 'li' ).hasClass( 'qodef-menu-item--open' ) ) {
										$menuItems.removeClass( 'qodef-menu-item--open' );
										$allDropdowns.removeClass( 'qodef-float--open' );
									}

									$elementToExpand.addClass( 'qodef-float--open' );
									$( menuItem ).addClass( 'qodef-menu-item--open' );
								}
							}
						);
					} else {
						//must use hoverIntent because basic hover effect doesn't catch dropdown
						//it doesn't start from menu item's edge
						$( this ).hoverIntent(
							{
								over: function () {
									$elementToExpand.addClass( 'qodef-float--open' );
									$( menuItem ).addClass( 'qodef-menu-item--open' );
								},
								out: function () {
									$elementToExpand.removeClass( 'qodef-float--open' );
									$( menuItem ).removeClass( 'qodef-menu-item--open' );
								},
								timeout: 300
							}
						);
					}
				}
			);
		},
		verticalAreaScrollable: function ( $verticalMenuObject ) {
			return $verticalMenuObject.hasClass( 'qodef-with-scroll' );
		},
		initVerticalAreaScroll: function ( $verticalMenuObject ) {
			if ( qodefVerticalNavMenu.verticalAreaScrollable( $verticalMenuObject ) && typeof qodefCore.qodefPerfectScrollbar === 'object' ) {
				qodefCore.qodefPerfectScrollbar.init( $verticalMenuObject );
			}
		},
		init: function () {
			var $verticalMenuObject = $( '.qodef-header--vertical #qodef-page-header' );

			if ( $verticalMenuObject.length ) {
				qodefVerticalNavMenu.initNavigation( $verticalMenuObject );
				qodefVerticalNavMenu.initVerticalAreaScroll( $verticalMenuObject );
			}
		}
	};

})( jQuery );

(function ( $ ) {
	'use strict';

	$( document ).ready(
	    function () {
            qodefVerticalSlidingNavMenu.init();
        }
	);

	/**
	 * Function object that represents vertical menu area.
	 * @returns {{init: Function}}
	 */
	var qodefVerticalSlidingNavMenu = {
		openedScroll: 0,

		initNavigation: function ( $verticalSlidingMenuObject ) {
			var $verticalSlidingNavObject = $verticalSlidingMenuObject.find( '.qodef-header-vertical-sliding-navigation' );

			if ( $verticalSlidingNavObject.hasClass( 'qodef-vertical-sliding-drop-down--below' ) ) {
				qodefVerticalSlidingNavMenu.dropdownClickToggle( $verticalSlidingNavObject );
			} else if ( $verticalSlidingNavObject.hasClass( 'qodef-vertical-sliding-drop-down--side' ) ) {
				qodefVerticalSlidingNavMenu.dropdownFloat( $verticalSlidingNavObject );
			}
		},
		dropdownClickToggle: function ( $verticalSlidingNavObject ) {
			var $menuItems = $verticalSlidingNavObject.find( 'ul li.menu-item-has-children' );

			$menuItems.each(
				function () {
					var $elementToExpand = $( this ).find( ' > .qodef-drop-down-second, > ul' );
					var menuItem         = this;
					var $dropdownOpener  = $( this ).find( '> a' );
					var slideUpSpeed     = 'fast';
					var slideDownSpeed   = 'slow';

					$dropdownOpener.on(
						'click tap',
						function ( e ) {
							e.preventDefault();
							e.stopPropagation();

							if ( $elementToExpand.is( ':visible' ) ) {
								$( menuItem ).removeClass( 'qodef-menu-item--open' );
								$elementToExpand.slideUp( slideUpSpeed );
							} else if ( $dropdownOpener.parent().parent().children().hasClass( 'qodef-menu-item--open' ) && $dropdownOpener.parent().parent().parent().hasClass( 'qodef-vertical-menu' ) ) {
								$( this ).parent().parent().children().removeClass( 'qodef-menu-item--open' );
								$( this ).parent().parent().children().find( ' > .qodef-drop-down-second' ).slideUp( slideUpSpeed );

								$( menuItem ).addClass( 'qodef-menu-item--open' );
								$elementToExpand.slideDown( slideDownSpeed );
							} else {

								if ( ! $( this ).parents( 'li' ).hasClass( 'qodef-menu-item--open' ) ) {
									$menuItems.removeClass( 'qodef-menu-item--open' );
									$menuItems.find( ' > .qodef-drop-down-second, > ul' ).slideUp( slideUpSpeed );
								}

								if ( $( this ).parent().parent().children().hasClass( 'qodef-menu-item--open' ) ) {
									$( this ).parent().parent().children().removeClass( 'qodef-menu-item--open' );
									$( this ).parent().parent().children().find( ' > .qodef-drop-down-second, > ul' ).slideUp( slideUpSpeed );
								}

								$( menuItem ).addClass( 'qodef-menu-item--open' );
								$elementToExpand.slideDown( slideDownSpeed );
							}
						}
					);
				}
			);
		},
		dropdownFloat: function ( $verticalSlidingNavObject ) {
			var $menuItems = $verticalSlidingNavObject.find( 'ul li.menu-item-has-children' );
			var $allDropdowns = $menuItems.find( ' > .qodef-drop-down-second > .qodef-drop-down-second-inner > ul, > ul' );

			$menuItems.each(
				function () {
					var $elementToExpand = $( this ).find( ' > .qodef-drop-down-second > .qodef-drop-down-second-inner > ul, > ul' );
					var menuItem         = this;

					if ( Modernizr.touch ) {
						var $dropdownOpener = $( this ).find( '> a' );

						$dropdownOpener.on(
							'click tap',
							function ( e ) {
								e.preventDefault();
								e.stopPropagation();

								if ( $elementToExpand.hasClass( 'qodef-float--open' ) ) {
									$elementToExpand.removeClass( 'qodef-float--open' );
									$( menuItem ).removeClass( 'qodef-menu-item--open' );
								} else {
									if ( ! $( this ).parents( 'li' ).hasClass( 'qodef-menu-item--open' ) ) {
										$menuItems.removeClass( 'qodef-menu-item--open' );
										$allDropdowns.removeClass( 'qodef-float--open' );
									}

									$elementToExpand.addClass( 'qodef-float--open' );
									$( menuItem ).addClass( 'qodef-menu-item--open' );
								}
							}
						);
					} else {
						//must use hoverIntent because basic hover effect doesn't catch dropdown
						//it doesn't start from menu item's edge
						$( this ).hoverIntent(
							{
								over: function () {
									$elementToExpand.addClass( 'qodef-float--open' );
									$( menuItem ).addClass( 'qodef-menu-item--open' );
								},
								out: function () {
									$elementToExpand.removeClass( 'qodef-float--open' );
									$( menuItem ).removeClass( 'qodef-menu-item--open' );
								},
								timeout: 300
							}
						);
					}
				}
			);
		},
		verticalSlidingAreaScrollable: function ( $verticalSlidingMenuObject ) {
			return $verticalSlidingMenuObject.hasClass( 'qodef-with-scroll' );
		},
		initVerticalSlidingAreaScroll: function ( $verticalSlidingMenuObject ) {
			if ( qodefVerticalSlidingNavMenu.verticalSlidingAreaScrollable( $verticalSlidingMenuObject ) && typeof qodefCore.qodefPerfectScrollbar === 'object' ) {
				qodefCore.qodefPerfectScrollbar.init( $verticalSlidingMenuObject );
			}
		},
		verticalSlidingAreaShowHide: function ( $verticalSlidingMenuObject ) {
			var $verticalSlidingMenuOpener = $verticalSlidingMenuObject.find( '.qodef-vertical-sliding-menu-opener' );

			$verticalSlidingMenuOpener.on(
				'click',
				function ( e ) {
					e.preventDefault();

					if ( ! $verticalSlidingMenuObject.hasClass( 'qodef-vertical-sliding-menu--opened' ) ) {
						$verticalSlidingMenuObject.addClass( 'qodef-vertical-sliding-menu--opened' );
						qodefVerticalSlidingNavMenu.openedScroll = qodef.window.scrollTop();
					} else {
						$verticalSlidingMenuObject.removeClass( 'qodef-vertical-sliding-menu--opened' );
					}
				}
			);
		},
		verticalSlidingAreaCloseOnScroll: function ( $verticalSlidingMenuObject ) {
			qodef.window.on(
				'scroll',
				function () {
					if ( $verticalSlidingMenuObject.hasClass( 'qodef-vertical-sliding-menu--opened' ) && Math.abs( qodef.scroll - qodefVerticalSlidingNavMenu.openedScroll ) > 400 ) {
						$verticalSlidingMenuObject.removeClass( 'qodef-vertical-sliding-menu--opened' );
					}
				}
			);
		},
		init: function () {
			var $verticalSlidingMenuObject = $( '.qodef-header--vertical-sliding #qodef-page-header' );

			if ( $verticalSlidingMenuObject.length ) {
				qodefVerticalSlidingNavMenu.verticalSlidingAreaShowHide( $verticalSlidingMenuObject );
				qodefVerticalSlidingNavMenu.verticalSlidingAreaCloseOnScroll( $verticalSlidingMenuObject );
				qodefVerticalSlidingNavMenu.initNavigation( $verticalSlidingMenuObject );
				qodefVerticalSlidingNavMenu.initVerticalSlidingAreaScroll( $verticalSlidingMenuObject );
			}
		}
	};

})( jQuery );

(function ( $ ) {
	'use strict';

	var fixedHeaderAppearance = {
		showHideHeader: function ( $pageOuter, $header ) {
			if ( qodefCore.windowWidth > 1024 ) {
				if ( qodefCore.scroll <= 0 ) {
					qodefCore.body.removeClass( 'qodef-header--fixed-display' );
					$pageOuter.css( 'padding-top', '0' );
					$header.css( 'margin-top', '0' );
				} else {
					qodefCore.body.addClass( 'qodef-header--fixed-display' );
					$pageOuter.css( 'padding-top', parseInt( qodefGlobal.vars.headerHeight + qodefGlobal.vars.topAreaHeight ) + 'px' );
					$header.css( 'margin-top', parseInt( qodefGlobal.vars.topAreaHeight ) + 'px' );
				}
			}
		},
		init: function () {

			if ( ! qodefCore.body.hasClass( 'qodef-header--vertical' ) ) {
				var $pageOuter = $( '#qodef-page-outer' ),
					$header    = $( '#qodef-page-header' );

				fixedHeaderAppearance.showHideHeader( $pageOuter, $header );

				$( window ).scroll(
					function () {
						fixedHeaderAppearance.showHideHeader( $pageOuter, $header );
					}
				);

				$( window ).resize(
					function () {
						$pageOuter.css( 'padding-top', '0' );
						fixedHeaderAppearance.showHideHeader( $pageOuter, $header );
					}
				);
			}
		}
	};

	qodefCore.fixedHeaderAppearance = fixedHeaderAppearance.init;

})( jQuery );

(function ( $ ) {
	'use strict';

	var stickyHeaderAppearance = {
		header: '',
		docYScroll: 0,
		init: function () {
			var displayAmount = stickyHeaderAppearance.displayAmount();

			// Set variables
			stickyHeaderAppearance.header 	  = $( '.qodef-header-sticky' );
			stickyHeaderAppearance.docYScroll = $( document ).scrollTop();

			// Set sticky visibility
			stickyHeaderAppearance.setVisibility( displayAmount );

			$( window ).scroll(
				function () {
					stickyHeaderAppearance.setVisibility( displayAmount );
				}
			);
		},
		displayAmount: function () {
			if ( qodefGlobal.vars.qodefStickyHeaderScrollAmount !== 0 ) {
				return parseInt( qodefGlobal.vars.qodefStickyHeaderScrollAmount, 10 );
			} else {
				return parseInt( qodefGlobal.vars.headerHeight + qodefGlobal.vars.adminBarHeight, 10 );
			}
		},
		setVisibility: function ( displayAmount ) {
			var isStickyHidden = qodefCore.scroll < displayAmount;

			if ( stickyHeaderAppearance.header.hasClass( 'qodef-appearance--up' ) ) {
				var currentDocYScroll = $( document ).scrollTop();

				isStickyHidden = (currentDocYScroll > stickyHeaderAppearance.docYScroll && currentDocYScroll > displayAmount) || (currentDocYScroll < displayAmount);

				stickyHeaderAppearance.docYScroll = $( document ).scrollTop();
			}

			stickyHeaderAppearance.showHideHeader( isStickyHidden );
		},
		showHideHeader: function ( isStickyHidden ) {
			if ( isStickyHidden ) {
				qodefCore.body.removeClass( 'qodef-header--sticky-display' );
			} else {
				qodefCore.body.addClass( 'qodef-header--sticky-display' );
			}
		},
	};

	qodefCore.stickyHeaderAppearance = stickyHeaderAppearance.init;

})( jQuery );

(function ( $ ) {
	'use strict';

	$( document ).ready(
		function () {
			qodefSideAreaMobileHeader.init();
		}
	);

	var qodefSideAreaMobileHeader = {
		init: function () {
			var $holder = $( '#qodef-side-area-mobile-header' );

			if ( $holder.length && qodefCore.body.hasClass( 'qodef-mobile-header--side-area' ) ) {
				var $navigation = $holder.find( '.qodef-m-navigation' );

				qodefSideAreaMobileHeader.initOpenerTrigger( $holder, $navigation );
				qodefSideAreaMobileHeader.initNavigationClickToggle( $navigation );

				if ( typeof qodefCore.qodefPerfectScrollbar === 'object' ) {
					qodefCore.qodefPerfectScrollbar.init( $holder );
				}
			}
		},
		initOpenerTrigger: function ( $holder, $navigation ) {
			var $openerIcon = $( '.qodef-side-area-mobile-header-opener' ),
				$closeIcon  = $holder.children( '.qodef-m-close' );

			if ( $openerIcon.length && $navigation.length ) {
				$openerIcon.on(
					'tap click',
					function ( e ) {
						e.stopPropagation();
						e.preventDefault();

						if ( $holder.hasClass( 'qodef--opened' ) ) {
							$holder.removeClass( 'qodef--opened' );
						} else {
							$holder.addClass( 'qodef--opened' );
						}
					}
				);
			}

			$closeIcon.on(
				'tap click',
				function ( e ) {
					e.stopPropagation();
					e.preventDefault();

					if ( $holder.hasClass( 'qodef--opened' ) ) {
						$holder.removeClass( 'qodef--opened' );
					}
				}
			);
		},
		initNavigationClickToggle: function ( $navigation ) {
			var $menuItems = $navigation.find( 'ul li.menu-item-has-children' );

			$menuItems.each(
				function () {
					var $thisItem        = $( this ),
						$elementToExpand = $thisItem.find( ' > .qodef-drop-down-second, > ul' ),
						$dropdownOpener  = $thisItem.find( '> a' ),
						slideUpSpeed     = 'fast',
						slideDownSpeed   = 'slow';

					$dropdownOpener.on(
						'click tap',
						function ( e ) {
							e.preventDefault();
							e.stopPropagation();

							if ( $elementToExpand.is( ':visible' ) ) {
								$thisItem.removeClass( 'qodef-menu-item--open' );
								$elementToExpand.slideUp( slideUpSpeed );
							} else if ( $dropdownOpener.parent().parent().children().hasClass( 'qodef-menu-item--open' ) && $dropdownOpener.parent().parent().parent().hasClass( 'qodef-vertical-menu' ) ) {
								$thisItem.parent().parent().children().removeClass( 'qodef-menu-item--open' );
								$thisItem.parent().parent().children().find( ' > .qodef-drop-down-second' ).slideUp( slideUpSpeed );

								$thisItem.addClass( 'qodef-menu-item--open' );
								$elementToExpand.slideDown( slideDownSpeed );
							} else {

								if ( ! $thisItem.parents( 'li' ).hasClass( 'qodef-menu-item--open' ) ) {
									$menuItems.removeClass( 'qodef-menu-item--open' );
									$menuItems.find( ' > .qodef-drop-down-second, > ul' ).slideUp( slideUpSpeed );
								}

								if ( $thisItem.parent().parent().children().hasClass( 'qodef-menu-item--open' ) ) {
									$thisItem.parent().parent().children().removeClass( 'qodef-menu-item--open' );
									$thisItem.parent().parent().children().find( ' > .qodef-drop-down-second, > ul' ).slideUp( slideUpSpeed );
								}

								$thisItem.addClass( 'qodef-menu-item--open' );
								$elementToExpand.slideDown( slideDownSpeed );
							}
						}
					);
				}
			);
		},
	};

})( jQuery );

(function ( $ ) {
	'use strict';

	$( document ).ready(
		function () {
			qodefSearchCoversHeader.init();
		}
	);

	var qodefSearchCoversHeader = {
		init: function () {
			var $searchOpener = $( 'a.qodef-search-opener' ),
				$searchForm   = $( '.qodef-search-cover-form' ),
				$searchClose  = $searchForm.find( '.qodef-m-close' );

			if ( $searchOpener.length && $searchForm.length ) {
				$searchOpener.on(
					'click',
					function ( e ) {
						e.preventDefault();
						qodefSearchCoversHeader.openCoversHeader( $searchForm );
					}
				);
				$searchClose.on(
					'click',
					function ( e ) {
						e.preventDefault();
						qodefSearchCoversHeader.closeCoversHeader( $searchForm );
					}
				);
			}
		},
		openCoversHeader: function ( $searchForm ) {
			qodefCore.body.addClass( 'qodef-covers-search--opened qodef-covers-search--fadein' );
			qodefCore.body.removeClass( 'qodef-covers-search--fadeout' );

			setTimeout(
				function () {
					$searchForm.find( '.qodef-m-form-field' ).focus();
				},
				600
			);
		},
		closeCoversHeader: function ( $searchForm ) {
			qodefCore.body.removeClass( 'qodef-covers-search--opened qodef-covers-search--fadein' );
			qodefCore.body.addClass( 'qodef-covers-search--fadeout' );

			setTimeout(
				function () {
					$searchForm.find( '.qodef-m-form-field' ).val( '' );
					$searchForm.find( '.qodef-m-form-field' ).blur();
					qodefCore.body.removeClass( 'qodef-covers-search--fadeout' );
				},
				300
			);
		}
	};

})( jQuery );

(function ( $ ) {
	'use strict';

	$( document ).ready(
		function () {
			qodefSearchFullscreen.init();
		}
	);

	var qodefSearchFullscreen = {
		init: function () {
			var $searchOpener = $( 'a.qodef-search-opener' ),
				$searchHolder = $( '.qodef-fullscreen-search-holder' ),
				$searchClose  = $searchHolder.find( '.qodef-m-close' );

			if ( $searchOpener.length && $searchHolder.length ) {
				$searchOpener.on(
					'click',
					function ( e ) {
						e.preventDefault();
						if ( qodefCore.body.hasClass( 'qodef-fullscreen-search--opened' ) ) {
							qodefSearchFullscreen.closeFullscreen( $searchHolder );
						} else {
							qodefSearchFullscreen.openFullscreen( $searchHolder );
						}
					}
				);
				$searchClose.on(
					'click',
					function ( e ) {
						e.preventDefault();
						qodefSearchFullscreen.closeFullscreen( $searchHolder );
					}
				);

				//Close on escape
				$( document ).keyup(
					function ( e ) {
						if ( e.keyCode === 27 && qodefCore.body.hasClass( 'qodef-fullscreen-search--opened' ) ) { //KeyCode for ESC button is 27
							qodefSearchFullscreen.closeFullscreen( $searchHolder );
						}
					}
				);
			}
		},
		openFullscreen: function ( $searchHolder ) {
			qodefCore.body.removeClass( 'qodef-fullscreen-search--fadeout' );
			qodefCore.body.addClass( 'qodef-fullscreen-search--opened qodef-fullscreen-search--fadein' );

			setTimeout(
				function () {
					$searchHolder.find( '.qodef-m-form-field' ).focus();
				},
				900
			);

			qodefCore.qodefScroll.disable();
		},
		closeFullscreen: function ( $searchHolder ) {
			qodefCore.body.removeClass( 'qodef-fullscreen-search--opened qodef-fullscreen-search--fadein' );
			qodefCore.body.addClass( 'qodef-fullscreen-search--fadeout' );

			setTimeout(
				function () {
					$searchHolder.find( '.qodef-m-form-field' ).val( '' );
					$searchHolder.find( '.qodef-m-form-field' ).blur();
					qodefCore.body.removeClass( 'qodef-fullscreen-search--fadeout' );
				},
				300
			);

			qodefCore.qodefScroll.enable();
		}
	};

})( jQuery );

(function ( $ ) {
	'use strict';

	$( document ).ready(
		function () {
			qodefSearch.init();
		}
	);

	var qodefSearch = {
		init: function () {
			this.search = $( 'a.qodef-search-opener' );

			if ( this.search.length ) {
				this.search.each(
					function () {
						var $thisSearch = $( this );

						qodefSearch.searchHoverColor( $thisSearch );
					}
				);
			}
		},
		searchHoverColor: function ( $searchHolder ) {
			if ( typeof $searchHolder.data( 'hover-color' ) !== 'undefined' ) {
				var hoverColor    = $searchHolder.data( 'hover-color' ),
					originalColor = $searchHolder.css( 'color' );

				$searchHolder.on(
					'mouseenter',
					function () {
						$searchHolder.css( 'color', hoverColor );
					}
				).on(
					'mouseleave',
					function () {
						$searchHolder.css( 'color', originalColor );
					}
				);
			}
		}
	};

})( jQuery );

(function ( $ ) {
	'use strict';

	$( document ).ready(
		function () {
			qodefProgressBarSpinner.init();
		}
	);

	var qodefProgressBarSpinner = {
		percentNumber: 0,
		init: function () {
			this.holder = $( '#qodef-page-spinner.qodef-layout--progress-bar' );

			if ( this.holder.length ) {
				qodefProgressBarSpinner.animateSpinner( this.holder );
			}
		},
		animateSpinner: function ( $holder ) {

			var $numberHolder = $holder.find( '.qodef-m-spinner-number-label' ),
				$spinnerLine  = $holder.find( '.qodef-m-spinner-line-front' ),
				numberIntervalFastest,
				windowLoaded  = false;

			$spinnerLine.animate(
				{ 'width': '100%' },
				10000,
				'linear'
			);

			var numberInterval = setInterval(
				function () {
					qodefProgressBarSpinner.animatePercent( $numberHolder, qodefProgressBarSpinner.percentNumber );

					if ( windowLoaded ) {
						clearInterval( numberInterval );
					}
				},
				100
			);

			$( window ).on(
				'load',
				function () {
					windowLoaded = true;

					numberIntervalFastest = setInterval(
						function () {
							if ( qodefProgressBarSpinner.percentNumber >= 100 ) {
								clearInterval( numberIntervalFastest );
								$spinnerLine.stop().animate(
									{ 'width': '100%' },
									500
								);

								setTimeout(
									function () {
										$holder.addClass( 'qodef--finished' );

										setTimeout(
											function () {
												qodefProgressBarSpinner.fadeOutLoader( $holder );
											},
											1000
										);
									},
									600
								);
							} else {
								qodefProgressBarSpinner.animatePercent( $numberHolder, qodefProgressBarSpinner.percentNumber );
							}
						},
						6
					);
				}
			);
		},
		animatePercent: function ( $numberHolder, percentNumber ) {
			if ( percentNumber < 100 ) {
				percentNumber += 5;
				$numberHolder.text( percentNumber );

				qodefProgressBarSpinner.percentNumber = percentNumber;
			}
		},
		fadeOutLoader: function ( $holder, speed, delay, easing ) {
			speed = speed ? speed : 600;
			delay = delay ? delay : 0;
			easing = easing ? easing : 'swing';

			$holder.delay( delay ).fadeOut( speed, easing );

			$( window ).on(
				'bind',
				'pageshow',
				function ( event ) {
					if ( event.originalEvent.persisted ) {
						$holder.fadeOut( speed, easing );
					}
				}
			);
		}
	};

})( jQuery );

(function ( $ ) {
	'use strict';

	$( document ).ready(
		function () {
			qodefWishlistDropdown.init();
		}
	);

	/**
	 * Function object that represents wishlist dropdown.
	 * @returns {{init: Function}}
	 */
	var qodefWishlistDropdown = {
		init: function () {
			var $holder = $( '.qodef-wishlist-dropdown' );

			if ( $holder.length ) {
				$holder.each(
					function () {
						var $thisHolder = $( this ),
							$link       = $thisHolder.find( '.qodef-m-link' );

						$link.on(
							'click',
							function ( e ) {
								e.preventDefault();
							}
						);

						qodefWishlistDropdown.removeItem( $thisHolder );
					}
				);
			}
		},
		removeItem: function ( $holder ) {
			var $removeLink = $holder.find( '.qodef-e-remove' );

			$removeLink.off().on(
				'click',
				function ( e ) {
					e.preventDefault();

					var $thisRemoveLink = $( this ),
						removeLinkHTML  = $thisRemoveLink.html(),
						removeItemID    = $thisRemoveLink.data( 'id' );

					$thisRemoveLink.html( '<span class="fa fa-spinner fa-spin" aria-hidden="true"></span>' );

					var wishlistData = {
						type: 'remove',
						itemID: removeItemID,
					};

					$.ajax(
						{
							type: 'POST',
							url: qodefGlobal.vars.restUrl + qodefGlobal.vars.wishlistRestRoute,
							data: {
								options: wishlistData,
							},
							beforeSend: function ( request ) {
								request.setRequestHeader( 'X-WP-Nonce', qodefGlobal.vars.restNonce );
							},
							success: function ( response ) {
								if ( response.status === 'success' ) {
									var newNumberOfItemsValue = parseInt( response.data['count'], 10 );

									$holder.find( '.qodef-m-link-count' ).html( newNumberOfItemsValue );

									if ( newNumberOfItemsValue === 0 ) {
										$holder.removeClass( 'qodef-items--has' ).addClass( 'qodef-items--no' );
									}

									$thisRemoveLink.closest( '.qodef-m-item' ).fadeOut( 200 ).remove();

									$( document ).trigger(
										'gracey_core_wishlist_item_is_removed',
										[removeItemID]
									);
								} else {
									$thisRemoveLink.html( removeLinkHTML );
								}
							}
						}
					);
				}
			);
		}
	};

	$( document ).on(
		'gracey_core_wishlist_item_is_added',
		function ( e, addedItemID, addedUserID ) {
			var $holder = $( '.qodef-wishlist-dropdown' );

			if ( $holder.length ) {
				$holder.each(
					function () {
						var $thisHolder        = $( this ),
							$link              = $thisHolder.find( '.qodef-m-link' ),
							numberOfItemsValue = $link.find( '.qodef-m-link-count' ),
							$itemsHolder       = $thisHolder.find( '.qodef-m-items' );

						var wishlistData = {
							itemID: addedItemID,
							userID: addedUserID,
						};

						$.ajax(
							{
								type: 'POST',
								url: qodefGlobal.vars.restUrl + qodefGlobal.vars.wishlistDropdownRestRoute,
								data: {
									options: wishlistData,
								},
								beforeSend: function ( request ) {
									request.setRequestHeader( 'X-WP-Nonce', qodefGlobal.vars.restNonce );
								},
								success: function ( response ) {
									if ( response.status === 'success' ) {
										numberOfItemsValue.html( parseInt( response.data['count'], 10 ) );

										if ( $thisHolder.hasClass( 'qodef-items--no' ) ) {
											$thisHolder.removeClass( 'qodef-items--no' ).addClass( 'qodef-items--has' );
										}

										$itemsHolder.append( response.data['new_html'] );
									}
								},
								complete: function () {
									qodefWishlistDropdown.init();
								}
							}
						);
					}
				);
			}
		}
	);

})( jQuery );

(function ( $ ) {
	'use strict';

	qodefCore.shortcodes.gracey_core_instagram_list = {};

	$( document ).ready(
		function () {
			qodefInstagram.init();
		}
	);

	var qodefInstagram = {
		init: function () {
			this.holder = $( '.sbi.qodef-instagram-swiper-container' );

			if ( this.holder.length ) {
				this.holder.each(
					function () {
						var $thisHolder     = $( this ),
							sliderOptions   = $thisHolder.parent().attr( 'data-options' ),
							$instagramImage = $thisHolder.find( '.sbi_item.sbi_type_image' ),
							$imageHolder    = $thisHolder.find( '#sbi_images' );

						$thisHolder.attr( 'data-options', sliderOptions );

						$imageHolder.addClass( 'swiper-wrapper' );

						if ( $instagramImage.length ) {
							$instagramImage.each(
								function () {
									$( this ).addClass( 'qodef-e qodef-image-wrapper swiper-slide' );
								}
							);
						}

						if ( typeof qodef.qodefSwiper === 'object' ) {
							qodef.qodefSwiper.init( $thisHolder );
						}
					}
				);
			}
		},
	};

	qodefCore.shortcodes.gracey_core_instagram_list.qodefInstagram = qodefInstagram;
	qodefCore.shortcodes.gracey_core_instagram_list.qodefSwiper    = qodef.qodefSwiper;

})( jQuery );

(function ( $ ) {
	'use strict';

	/*
	 **	Re-init scripts on gallery loaded
	 */
	$( document ).on(
		'yith_wccl_product_gallery_loaded',
		function () {

			if ( typeof qodefCore.qodefWooMagnificPopup === 'function' ) {
				qodefCore.qodefWooMagnificPopup.init();
			}
		}
	);

})( jQuery );

(function ( $ ) {
	'use strict';

	var shortcode = 'gracey_core_product_list';

	qodefCore.shortcodes[shortcode] = {};

	if ( typeof qodefCore.listShortcodesScripts === 'object' ) {
		$.each(
			qodefCore.listShortcodesScripts,
			function ( key, value ) {
				qodefCore.shortcodes[shortcode][key] = value;
			}
		);
	}

})( jQuery );

(function ( $ ) {
	'use strict';

	qodefCore.shortcodes.gracey_core_product_category_list                    = {};
	qodefCore.shortcodes.gracey_core_product_category_list.qodefMasonryLayout = qodef.qodefMasonryLayout;
	qodefCore.shortcodes.gracey_core_product_category_list.qodefSwiper        = qodef.qodefSwiper;

})( jQuery );

(function ($) {
	"use strict";

	$(document).ready(function () {
		qodefSideAreaCart.init();
	});

	var qodefSideAreaCart = {
		init: function () {
			var $holder = $('.qodef-woo-side-area-cart');

			if ($holder.length) {
				$holder.each(function () {
					var $thisHolder = $(this);

					if (qodefCore.windowWidth > 680) {
						qodefSideAreaCart.trigger($thisHolder);
						qodef.body.addClass('qodef-side-cart--initialized');

						qodefCore.body.on('added_to_cart', function () {
							if (!qodef.body.hasClass('qodef-side-cart--initialized')) {
								qodefSideAreaCart.trigger($thisHolder);
							}
						});
					}
				});
			}
		},
		trigger: function ($holder) {
			var $items = $holder.find('.qodef-m-items');

			// Open Side Area
			$('.qodef-woo-side-area-cart').on('click', '.qodef-m-opener', function (e) {
				e.preventDefault();

				if (!$holder.hasClass('qodef--opened')) {
					qodefSideAreaCart.openSideArea($holder);
					if ($items.length && typeof qodefCore.qodefPerfectScrollbar === 'object') {
						qodefCore.qodefPerfectScrollbar.init($items);
					}

					$(document).keyup(function (e) {
						if (e.keyCode === 27) {
							qodefSideAreaCart.closeSideArea($holder);
						}
					});
				} else {
					qodefSideAreaCart.closeSideArea($holder);
				}
			});

			$('.qodef-woo-side-area-cart').on('click', '.qodef-m-close', function (e) {
				e.preventDefault();
				qodefSideAreaCart.closeSideArea($holder);
			});
		},
		openSideArea: function ($holder) {
			qodefCore.qodefScroll.disable();

			$holder.addClass('qodef--opened');
			$('#qodef-page-wrapper').prepend('<div class="qodef-woo-side-area-cart-cover"/>');

			$('.qodef-woo-side-area-cart-cover').on('click', function (e) {
				e.preventDefault();

				qodefSideAreaCart.closeSideArea($holder);
			});
		},
		closeSideArea: function ($holder) {
			if ($holder.hasClass('qodef--opened')) {
				qodefCore.qodefScroll.enable();

				$holder.removeClass('qodef--opened');
				$('.qodef-woo-side-area-cart-cover').remove();
			}
		}
	};

})(jQuery);

(function ($) {
	'use strict';

	var shortcode = 'gracey_core_clients_list';

	qodefCore.shortcodes[shortcode] = {};

	if (typeof qodefCore.listShortcodesScripts === 'object') {
		$.each(qodefCore.listShortcodesScripts, function (key, value) {
			qodefCore.shortcodes[shortcode][key] = value;
		});
	}

	// $(document).ready(function () {
	// 	qodefClientsList.init();
	// });

	var qodefClientsList = {
		init: function () {
			this.holder = $('.qodef-clients-list');
			if ( this.holder.length ) {
				this.holder.each( function () {
					var $thisHolder = $(this);

					if ( $thisHolder.hasClass('qodef-hover-animation--inverse-fade') ) {
						var $items = qodefClientsList.getItems( $thisHolder );

						!$thisHolder.hasClass('qodef-swiper-container') && $thisHolder.appear( function () {
							qodefClientsList.loadingAnimation( $items );
						});

						$items.each( function () {
							var $item = $(this);

							qodefClientsList.hoverAnimation( $thisHolder, $item, $items );
						});
					}
				});
			}
		},
		loadingAnimation: function ( $items ) {
			TweenMax.staggerTo($items, .4, {
				autoAlpha: 1,
			}, .05);
		},
		hoverAnimation: function ( $thisHolder, $item, $items ) {
			$item
				.on('mouseenter', function () {
					$item.addClass('qodef--hovered');

					TweenMax.to($item, .2, {
						autoAlpha: 1,
						overwrite: 1
					})
					TweenMax.fromTo($item, .3, {
						y: 0
					}, {
						y: -7,
						ease: Power4.ease,
						yoyo: true,
						repeat: 1,
					})
					TweenMax.staggerTo($items.not('.qodef--hovered'), .2, {
						autoAlpha: .5,
						overwrite: 1,
						ease: Power4.easeOut,
					}, .015);
				});

			$item
				.on('mouseleave', function () {
					$item.removeClass('qodef--hovered');
					TweenMax.staggerTo($items.filter('.qodef--hovered'), .2, {
						autoAlpha: 0,
						ease: Power2.easeOut
					}, .1);
				});

			$thisHolder
				.on('mouseleave', function () {
					$item.removeClass('qodef--hovered');
					TweenMax.staggerTo($items, .2, {
						autoAlpha: 1,
						ease: Power2.easeOut
					}, .05);
				});
		},
		getItems: function ( $holder ) {
			var $items = $holder.find('.qodef-e').sort( function () {
				return 0.5 - Math.random()
			});

			return $items;
		}
	};

	qodefCore.shortcodes.gracey_core_clients_list.qodefClientsList = qodefClientsList;
	qodefCore.shortcodes.gracey_core_clients_list.qodefSwiper = qodef.qodefSwiper;

})(jQuery);
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

(function ( $ ) {
	'use strict';

	$( document ).ready(
		function () {
			qodefMasonryBigPortfolio.init();
		}
	);

	$( window ).resize(
		function () {
			qodefMasonryBigPortfolio.init();
			qodef.qodefMasonryLayout.reInit();
		}
	);

	var qodefMasonryBigPortfolio = {
		init: function () {
			this.holder = $( '.qodef-portfolio-single.qodef-layout--masonry-big .qodef-media' );

			if (this.holder.length) {
				this.holder.each(function () {
					qodefMasonryBigPortfolio.calculateHeight($(this));
				});
			}
		},
		calculateHeight: function (holder) {
			var $masonry = holder.find('.qodef-grid-inner'),
				$masonryItem = $masonry.find('.qodef-grid-item'),
				$firstItemImage = $masonryItem.first().find('img'),
				itemHeight = 0;

			if ( $firstItemImage.length ) {
				itemHeight = $firstItemImage.outerHeight();
			}

			if ( qodef.windowWidth > 680 ) {
				$masonryItem.css('height', itemHeight);
			} else {
				$masonryItem.css('height', 'auto');
			}
		}
	}

	qodef.qodefMasonryBigPortfolio = qodefMasonryBigPortfolio;

})( jQuery );

(function ( $ ) {
	'use strict';

	var shortcode = 'gracey_core_team_list';

	qodefCore.shortcodes[shortcode] = {};

	if ( typeof qodefCore.listShortcodesScripts === 'object' ) {
		$.each(
			qodefCore.listShortcodesScripts,
			function ( key, value ) {
				qodefCore.shortcodes[shortcode][key] = value;
			}
		);
	}

})( jQuery );

(function ( $ ) {
	'use strict';

	qodefCore.shortcodes.gracey_core_testimonials_list             = {};
	qodefCore.shortcodes.gracey_core_testimonials_list.qodefSwiper = qodef.qodefSwiper;

})( jQuery );

(function ( $ ) {
	'use strict';

	$( document ).ready(
		function () {
			qodefInteractiveLinkShowcaseInteractiveList.init();
		}
	);

	var qodefInteractiveLinkShowcaseInteractiveList = {
		init: function () {
			this.holder = $( '.qodef-interactive-link-showcase.qodef-layout--interactive-list' );

			if ( this.holder.length ) {
				this.holder.each(
					function () {
						var $thisHolder       = $( this ),
							$links            = $thisHolder.find( '.qodef-m-item' ),
							x                 = 0,
							y                 = 0,
							currentXCPosition = 0,
							currentYCPosition = 0;

						if ( $links.length ) {
							$links.on(
								'mouseenter',
								function () {
									$links.removeClass( 'qodef--active' );
									$( this ).addClass( 'qodef--active' );
								}
							).on(
								'mousemove',
								function ( event ) {
									var $thisLink         = $( this ),
										$followInfoHolder = $thisLink.find( '.qodef-e-follow-content' ),
										$followImage      = $followInfoHolder.find( '.qodef-e-follow-image' ),
										$followImageItem  = $followImage.find( 'img' ),
										followImageWidth  = $followImageItem.width(),
										followImagesCount = parseInt( $followImage.data( 'images-count' ), 10 ),
										followImagesSrc   = $followImage.data( 'images' ),
										$followTitle      = $followInfoHolder.find( '.qodef-e-follow-title' ),
										itemWidth         = $thisLink.outerWidth(),
										itemHeight        = $thisLink.outerHeight(),
										itemOffsetTop     = $thisLink.offset().top - qodefCore.scroll,
										itemOffsetLeft    = $thisLink.offset().left;

									x = (event.clientX - itemOffsetLeft) >> 0;
									y = (event.clientY - itemOffsetTop) >> 0;

									if ( x > itemWidth ) {
										currentXCPosition = itemWidth;
									} else if ( x < 0 ) {
										currentXCPosition = 0;
									} else {
										currentXCPosition = x;
									}

									if ( y > itemHeight ) {
										currentYCPosition = itemHeight;
									} else if ( y < 0 ) {
										currentYCPosition = 0;
									} else {
										currentYCPosition = y;
									}

									if ( followImagesCount > 1 ) {
										var imagesUrl    = followImagesSrc.split( '|' ),
											itemPartSize = itemWidth / followImagesCount;

										$followImageItem.removeAttr( 'srcset' );

										if ( currentXCPosition < itemPartSize ) {
											$followImageItem.attr( 'src', imagesUrl[0] );
										}

										// -2 is constant - to remove first and last item from the loop
										for ( var index = 1; index <= (followImagesCount - 2); index++ ) {
											if ( currentXCPosition >= itemPartSize * index && currentXCPosition < itemPartSize * (index + 1) ) {
												$followImageItem.attr( 'src', imagesUrl[index] );
											}
										}

										if ( currentXCPosition >= itemWidth - itemPartSize ) {
											$followImageItem.attr( 'src', imagesUrl[followImagesCount - 1] );
										}
									}

									$followImage.css(
										{
											'top': itemHeight / 2,
										}
									);
									$followTitle.css(
										{
											'transform': 'translateY(' + -(parseInt( itemHeight, 10 ) / 2 + currentYCPosition) + 'px)',
											'left': -(currentXCPosition - followImageWidth / 2),
										}
									);
									$followInfoHolder.css( { 'top': currentYCPosition, 'left': currentXCPosition } );
								}
							).on(
								'mouseleave',
								function () {
									$links.removeClass( 'qodef--active' );
								}
							);
						}
						$thisHolder.addClass( 'qodef--init' );
					}
				);
			}
		}
	};

	qodefCore.shortcodes.gracey_core_interactive_link_showcase.qodefInteractiveLinkShowcaseInteractiveList = qodefInteractiveLinkShowcaseInteractiveList;

})( jQuery );

(function ( $ ) {
	'use strict';

	$( document ).ready(
		function () {
			qodefInteractiveLinkShowcaseList.init();
		}
	);

	var qodefInteractiveLinkShowcaseList = {
		init: function () {
			this.holder = $( '.qodef-interactive-link-showcase.qodef-layout--list' );

			if ( this.holder.length ) {
				this.holder.each(
					function () {
						var $thisHolder = $( this ),
							$items       = $thisHolder.find( '.qodef-m-item' );

						$items.eq( 0 ).addClass( 'qodef--active' );

						$items.on(
							'touchstart mouseenter',
							function ( e ) {
								var $thisLink = $( this );

								if ( ! qodefCore.html.hasClass( 'touchevents' ) || ( ! $thisLink.hasClass( 'qodef--active' ) && qodefCore.windowWidth > 680) ) {
									e.preventDefault();
									$items.removeClass( 'qodef--active' ).eq( $thisLink.index() ).addClass( 'qodef--active' );
								}
							}
						).on(
							'touchend mouseleave',
							function () {
								var $thisLink = $( this );

								if ( ! qodefCore.html.hasClass( 'touchevents' ) || ( ! $thisLink.hasClass( 'qodef--active' ) && qodefCore.windowWidth > 680) ) {
									$items.removeClass( 'qodef--active' ).eq( $thisLink.index() ).addClass( 'qodef--active' );
								}
							}
						);

						$thisHolder.addClass( 'qodef--init' );
					}
				);
			}
		}
	};

	qodefCore.shortcodes.gracey_core_interactive_link_showcase.qodefInteractiveLinkShowcaseList = qodefInteractiveLinkShowcaseList;

})( jQuery );

(function ( $ ) {
	'use strict';

	$( document ).ready(
		function () {
			qodefInteractiveLinkShowcaseSlider.init();
		}
	);

	var qodefInteractiveLinkShowcaseSlider = {
		init: function () {
			this.holder = $( '.qodef-interactive-link-showcase.qodef-layout--slider' );

			if ( this.holder.length ) {
				this.holder.each(
					function () {
						var $thisHolder = $( this ),
							$images     = $thisHolder.find( '.qodef-m-image' );

						var $swiperSlider = new Swiper(
							$thisHolder.find( '.swiper-container' ),
							{
								loop: true,
								slidesPerView: 'auto',
								centeredSlides: true,
								speed: 1400,
								mousewheel: true,
								init: false
							}
						);

						$thisHolder.waitForImages(
							function () {
								$swiperSlider.init();
							}
						);

						$swiperSlider.on(
							'init',
							function () {
								$images.eq( 0 ).addClass( 'qodef--active' );
								$thisHolder.find( '.swiper-slide-active' ).addClass( 'qodef--active' );

								$swiperSlider.on(
									'slideChangeTransitionStart',
									function () {
										var $swiperSlides    = $thisHolder.find( '.swiper-slide' ),
											$activeSlideItem = $thisHolder.find( '.swiper-slide-active' );

										$images.removeClass( 'qodef--active' ).eq( $activeSlideItem.data( 'swiper-slide-index' ) ).addClass( 'qodef--active' );
										$swiperSlides.removeClass( 'qodef--active' );

										$activeSlideItem.addClass( 'qodef--active' );
									}
								);

								$thisHolder.find( '.swiper-slide' ).on(
									'click',
									function ( e ) {
										var $thisSwiperLink  = $( this ),
											$activeSlideItem = $thisHolder.find( '.swiper-slide-active' );

										if ( ! $thisSwiperLink.hasClass( 'swiper-slide-active' ) ) {
											e.preventDefault();
											e.stopImmediatePropagation();

											if ( e.pageX < $activeSlideItem.offset().left ) {
												$swiperSlider.slidePrev();
												return false;
											}

											if ( e.pageX > $activeSlideItem.offset().left + $activeSlideItem.outerWidth() ) {
												$swiperSlider.slideNext();
												return false;
											}
										}
									}
								);

								$thisHolder.addClass( 'qodef--init' );
							}
						);
					}
				);
			}
		}
	};

	qodefCore.shortcodes.gracey_core_interactive_link_showcase.qodefInteractiveLinkShowcaseSlider = qodefInteractiveLinkShowcaseSlider;

})( jQuery );

(function ( $ ) {
	'use strict';

	$( document ).ready(
		function () {
			if (qodefCore.windowWidth > 1024){
				qodefInfoFollow.init();
			}
		}
	);

	$( document ).on(
		'gracey_trigger_get_new_posts',
		function () {
			if (qodefCore.windowWidth > 1024){
				qodefInfoFollow.init();
			}
		}
	);

	var qodefInfoFollow = {
		init: function () {
			var $gallery = $( '.qodef-hover-animation--follow' ),
				disabledBgClass = $gallery.hasClass('qodef--disabled-info-follow-bg') ? 'qodef-bg-color-disabled' : '';

			if ( $gallery.length ) {
				qodefCore.body.append( `<div class="qodef-follow-info-holder ${disabledBgClass}"><div class="qodef-follow-info-inner"><span class="qodef-follow-info-title"></span><br/><span class="qodef-follow-info-category"></span></div></div>` );

				var $followInfoHolder   = $( '.qodef-follow-info-holder' ),
					$followInfoCategory = $followInfoHolder.find( '.qodef-follow-info-category' ),
					$followInfoTitle    = $followInfoHolder.find( '.qodef-follow-info-title' );
					
					$gallery.each(
					function () {
						$gallery.find( '.qodef-e-inner' ).each(
							function () {
								var $thisItem = $( this );

								//info element position
								$thisItem.on(
									'mousemove',
									function ( e ) {
										if ( e.clientX + 20 + $followInfoHolder.width() > qodefCore.windowWidth ) {
											$followInfoHolder.addClass( 'qodef-right' );
										} else {
											$followInfoHolder.removeClass( 'qodef-right' );
										}

										$followInfoHolder.css(
											{
												top: e.clientY + 20,
												left: e.clientX + 20,
											}
										);
									}
								);

								//show/hide info element
								$thisItem.on(
									'mouseenter',
									function () {
										var $thisItemTitle    = $( this ).find( '.qodef-e-title' ),
											$thisItemCategory = $( this ).find( '.qodef-e-info-category' );

										if ( $thisItemTitle.length ) {
											$followInfoTitle.html( $thisItemTitle.clone() );
										}

										if ( $thisItemCategory.length ) {
											$followInfoCategory.html( $thisItemCategory.html() );
										}

										if ( ! $followInfoHolder.hasClass( 'qodef-is-active' ) ) {
											$followInfoHolder.addClass( 'qodef-is-active' );
										}
									}
								).on(
									'mouseleave',
									function () {
										if ( $followInfoHolder.hasClass( 'qodef-is-active' ) ) {
											$followInfoHolder.removeClass( 'qodef-is-active' );
										}
									}
								);
							}
						);
						
					}
				);
			}
		},
	};

	qodefCore.shortcodes.gracey_core_portfolio_list.qodefInfoFollow = qodefInfoFollow;

})( jQuery );
