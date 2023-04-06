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
