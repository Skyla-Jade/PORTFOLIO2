<?php

if ( ! function_exists( 'gracey_core_add_pulse_circles_spinner_layout_option' ) ) {
	/**
	 * Function that set new value into page spinner layout options map
	 *
	 * @param array $layouts - module layouts
	 *
	 * @return array
	 */
	function gracey_core_add_pulse_circles_spinner_layout_option( $layouts ) {
		$layouts['pulse-circles'] = esc_html__( 'Pulse Circles', 'gracey-core' );

		return $layouts;
	}

	add_filter( 'gracey_core_filter_page_spinner_layout_options', 'gracey_core_add_pulse_circles_spinner_layout_option' );
}
