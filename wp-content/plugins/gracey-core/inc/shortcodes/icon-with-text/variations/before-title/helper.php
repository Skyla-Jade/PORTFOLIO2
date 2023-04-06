<?php

if ( ! function_exists( 'gracey_core_add_icon_with_text_variation_before_title' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function gracey_core_add_icon_with_text_variation_before_title( $variations ) {
		$variations['before-title'] = esc_html__( 'Before Title', 'gracey-core' );

		return $variations;
	}

	add_filter( 'gracey_core_filter_icon_with_text_layouts', 'gracey_core_add_icon_with_text_variation_before_title' );
}
