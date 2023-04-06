<?php

if ( ! function_exists( 'gracey_core_add_button_variation_textual' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function gracey_core_add_button_variation_textual( $variations ) {
		$variations['textual'] = esc_html__( 'Textual', 'gracey-core' );

		return $variations;
	}

	add_filter( 'gracey_core_filter_button_layouts', 'gracey_core_add_button_variation_textual' );
}
