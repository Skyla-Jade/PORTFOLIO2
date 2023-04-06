<?php

if ( ! function_exists( 'gracey_core_add_text_marquee_variation_default' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function gracey_core_add_text_marquee_variation_default( $variations ) {
		$variations['default'] = esc_html__( 'Default', 'gracey-core' );

		return $variations;
	}

	add_filter( 'gracey_core_filter_text_marquee_layouts', 'gracey_core_add_text_marquee_variation_default' );
}
