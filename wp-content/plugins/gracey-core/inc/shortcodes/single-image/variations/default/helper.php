<?php

if ( ! function_exists( 'gracey_core_add_single_image_variation_default' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function gracey_core_add_single_image_variation_default( $variations ) {
		$variations['default'] = esc_html__( 'Default', 'gracey-core' );

		return $variations;
	}

	add_filter( 'gracey_core_filter_single_image_layouts', 'gracey_core_add_single_image_variation_default' );
}
