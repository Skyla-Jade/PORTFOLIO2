<?php

if ( ! function_exists( 'gracey_core_add_portfolio_list_variation_info_follow' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function gracey_core_add_portfolio_list_variation_info_follow( $variations ) {
		$variations['info-follow'] = esc_html__( 'Info Follow', 'gracey-core' );

		return $variations;
	}

	add_filter( 'gracey_core_filter_portfolio_list_layouts', 'gracey_core_add_portfolio_list_variation_info_follow' );
}
