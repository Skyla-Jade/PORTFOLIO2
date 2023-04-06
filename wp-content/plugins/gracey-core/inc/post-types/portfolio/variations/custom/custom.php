<?php

if ( ! function_exists( 'gracey_core_add_portfolio_single_variation_custom' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function gracey_core_add_portfolio_single_variation_custom( $variations ) {
		$variations['custom'] = esc_html__( 'Custom', 'gracey-core' );

		return $variations;
	}

	add_filter( 'gracey_core_filter_portfolio_single_layout_options', 'gracey_core_add_portfolio_single_variation_custom' );
}
