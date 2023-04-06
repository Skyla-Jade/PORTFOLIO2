<?php

if ( ! function_exists( 'gracey_core_add_button_variation_filled' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function gracey_core_add_button_variation_filled( $variations ) {
		$variations['filled'] = esc_html__( 'Filled', 'gracey-core' );

		return $variations;
	}

	add_filter( 'gracey_core_filter_button_layouts', 'gracey_core_add_button_variation_filled' );
}
