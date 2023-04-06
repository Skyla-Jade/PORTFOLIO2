<?php

if ( ! function_exists( 'gracey_core_add_social_share_variation_text' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function gracey_core_add_social_share_variation_text( $variations ) {
		$variations['text'] = esc_html__( 'Text', 'gracey-core' );

		return $variations;
	}

	add_filter( 'gracey_core_filter_social_share_layouts', 'gracey_core_add_social_share_variation_text' );
}
