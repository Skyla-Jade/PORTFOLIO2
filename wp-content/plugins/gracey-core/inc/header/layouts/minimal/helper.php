<?php

if ( ! function_exists( 'gracey_core_add_minimal_header_global_option' ) ) {
	/**
	 * This function set header type value for global header option map
	 */
	function gracey_core_add_minimal_header_global_option( $header_layout_options ) {
		$header_layout_options['minimal'] = array(
			'image' => GRACEY_CORE_HEADER_LAYOUTS_URL_PATH . '/minimal/assets/img/minimal-header.png',
			'label' => esc_html__( 'Minimal', 'gracey-core' ),
		);

		return $header_layout_options;
	}

	add_filter( 'gracey_core_filter_header_layout_option', 'gracey_core_add_minimal_header_global_option' );
}

if ( ! function_exists( 'gracey_core_register_minimal_header_layout' ) ) {
	/**
	 * Function which add header layout into global list
	 *
	 * @param array $header_layouts
	 *
	 * @return array
	 */
	function gracey_core_register_minimal_header_layout( $header_layouts ) {
		$header_layouts['minimal'] = 'GraceyCore_Minimal_Header';

		return $header_layouts;
	}

	add_filter( 'gracey_core_filter_register_header_layouts', 'gracey_core_register_minimal_header_layout' );
}
