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
