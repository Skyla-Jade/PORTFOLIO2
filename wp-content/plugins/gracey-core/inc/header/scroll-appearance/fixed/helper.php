<?php

if ( ! function_exists( 'gracey_core_add_fixed_header_option' ) ) {
	/**
	 * This function set header scrolling appearance value for global header option map
	 */
	function gracey_core_add_fixed_header_option( $options ) {
		$options['fixed'] = esc_html__( 'Fixed', 'gracey-core' );

		return $options;
	}

	add_filter( 'gracey_core_filter_header_scroll_appearance_option', 'gracey_core_add_fixed_header_option' );
}
