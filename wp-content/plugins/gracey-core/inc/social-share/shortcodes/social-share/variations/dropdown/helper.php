<?php

if ( ! function_exists( 'gracey_core_add_social_share_variation_dropdown' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function gracey_core_add_social_share_variation_dropdown( $variations ) {
		$variations['dropdown'] = esc_html__( 'Dropdown', 'gracey-core' );

		return $variations;
	}

	add_filter( 'gracey_core_filter_social_share_layouts', 'gracey_core_add_social_share_variation_dropdown' );
}
