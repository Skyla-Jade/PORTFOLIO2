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
