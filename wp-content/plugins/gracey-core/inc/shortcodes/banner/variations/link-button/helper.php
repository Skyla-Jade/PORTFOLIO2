<?php

if ( ! function_exists( 'gracey_core_add_banner_variation_link_button' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function gracey_core_add_banner_variation_link_button( $variations ) {
		$variations['link-button'] = esc_html__( 'Link Button', 'gracey-core' );

		return $variations;
	}

	add_filter( 'gracey_core_filter_banner_layouts', 'gracey_core_add_banner_variation_link_button' );
}
