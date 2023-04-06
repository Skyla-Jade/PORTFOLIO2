<?php

if ( ! function_exists( 'gracey_core_add_button_variation_outlined' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function gracey_core_add_button_variation_outlined( $variations ) {
		$variations['outlined'] = esc_html__( 'Outlined', 'gracey-core' );

		return $variations;
	}

	add_filter( 'gracey_core_filter_button_layouts', 'gracey_core_add_button_variation_outlined' );
}
