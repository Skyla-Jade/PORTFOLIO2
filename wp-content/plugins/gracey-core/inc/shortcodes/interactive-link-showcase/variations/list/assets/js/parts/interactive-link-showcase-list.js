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
