<?php

if ( ! function_exists( 'gracey_core_add_clock_spinner_layout_option' ) ) {
	/**
	 * Function that set new value into page spinner layout options map
	 *
	 * @param array $layouts - module layouts
	 *
	 * @return array
	 */
	function gracey_core_add_clock_spinner_layout_option( $layouts ) {
		$layouts['clock'] = esc_html__( 'Clock', 'gracey-core' );

		return $layouts;
	}

	add_filter( 'gracey_core_filter_page_spinner_layout_options', 'gracey_core_add_clock_spinner_layout_option' );
}
