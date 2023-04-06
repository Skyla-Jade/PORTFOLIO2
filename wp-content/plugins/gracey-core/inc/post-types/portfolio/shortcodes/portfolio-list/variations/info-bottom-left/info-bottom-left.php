<?php

if ( ! function_exists( 'gracey_core_add_portfolio_list_variation_info_bottom_left' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function gracey_core_add_portfolio_list_variation_info_bottom_left( $variations ) {
		$variations['info-bottom-left'] = esc_html__( 'Info Bottom Left', 'gracey-core' );

		return $variations;
	}

	add_filter( 'gracey_core_filter_portfolio_list_layouts', 'gracey_core_add_portfolio_list_variation_info_bottom_left' );
}
