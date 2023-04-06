<?php

if ( ! function_exists( 'gracey_core_add_portfolio_single_variation_slider_small' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function gracey_core_add_portfolio_single_variation_slider_small( $variations ) {
		$variations['slider-small'] = esc_html__( 'Slider - Small', 'gracey-core' );

		return $variations;
	}

	add_filter( 'gracey_core_filter_portfolio_single_layout_options', 'gracey_core_add_portfolio_single_variation_slider_small' );
}
