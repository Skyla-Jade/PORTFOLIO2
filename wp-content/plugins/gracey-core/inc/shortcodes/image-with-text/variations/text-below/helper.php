<?php

if ( ! function_exists( 'gracey_core_add_image_with_text_variation_text_below' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function gracey_core_add_image_with_text_variation_text_below( $variations ) {
		$variations['text-below'] = esc_html__( 'Text Below', 'gracey-core' );

		return $variations;
	}

	add_filter( 'gracey_core_filter_image_with_text_layouts', 'gracey_core_add_image_with_text_variation_text_below' );
}
