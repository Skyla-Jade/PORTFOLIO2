<?php

if ( ! function_exists( 'gracey_core_add_portfolio_single_variation_gallery_big' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function gracey_core_add_portfolio_single_variation_gallery_big( $variations ) {
		$variations['gallery-big'] = esc_html__( 'Gallery - Big', 'gracey-core' );

		return $variations;
	}

	add_filter( 'gracey_core_filter_portfolio_single_layout_options', 'gracey_core_add_portfolio_single_variation_gallery_big' );
}
