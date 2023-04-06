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