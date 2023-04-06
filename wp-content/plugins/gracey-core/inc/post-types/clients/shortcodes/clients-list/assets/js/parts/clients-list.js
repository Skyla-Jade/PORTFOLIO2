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