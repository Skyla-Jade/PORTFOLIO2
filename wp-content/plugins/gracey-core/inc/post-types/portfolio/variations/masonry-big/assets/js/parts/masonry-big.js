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
