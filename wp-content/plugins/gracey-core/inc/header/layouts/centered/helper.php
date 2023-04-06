<?php

if ( ! function_exists( 'gracey_core_add_centered_header_global_option' ) ) {
	/**
	 * This function set header type value for global header option map
	 */
	function gracey_core_add_centered_header_global_option( $header_layout_options ) {
		$header_layout_options['centered'] = array(
			'image' => GRACEY_CORE_HEADER_LAYOUTS_URL_PATH . '/centered/assets/img/centered-header.png',
			'label' => esc_html__( 'Centered', 'gracey-core' ),
		);

		return $header_layout_options;
	}

	add_filter( 'gracey_core_filter_header_layout_option', 'gracey_core_add_centered_header_global_option' );
}

if ( ! function_exists( 'gracey_core_register_centered_header_layout' ) ) {
	/**
	 * Function which add header layout into global list
	 *
	 * @param array $header_layouts
	 *
	 * @return array
	 */
	function gracey_core_register_centered_header_layout( $header_layouts ) {
		$header_layouts['centered'] = 'GraceyCore_Centered_Header';

		return $header_layouts;
	}

	add_filter( 'gracey_core_filter_register_header_layouts', 'gracey_core_register_centered_header_layout' );
}
