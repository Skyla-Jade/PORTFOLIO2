<?php

if ( ! function_exists( 'gracey_core_add_portfolio_list_variation_slide_from_bottom' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function gracey_core_add_portfolio_list_variation_slide_from_bottom( $variations ) {
		$variations['slide-from-bottom'] = esc_html__( 'Slide From Bottom', 'gracey-core' );

		return $variations;
	}

	add_filter( 'gracey_core_filter_portfolio_list_layouts', 'gracey_core_add_portfolio_list_variation_slide_from_bottom' );
}
