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
