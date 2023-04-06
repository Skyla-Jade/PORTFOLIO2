<?php

if ( ! function_exists( 'gracey_core_add_portfolio_vertical_slider_variation_standard' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function gracey_core_add_portfolio_vertical_slider_variation_standard( $variations ) {
		
		$variations['standard'] = esc_html__( 'Standard', 'gracey-core' );
		
		return $variations;
	}
	
	add_filter( 'gracey_core_filter_portfolio_vertical_slider_layouts', 'gracey_core_add_portfolio_vertical_slider_variation_standard' );
}