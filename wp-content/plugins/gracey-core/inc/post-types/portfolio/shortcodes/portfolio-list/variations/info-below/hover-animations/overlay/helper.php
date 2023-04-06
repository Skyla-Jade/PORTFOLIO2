<?php

if ( ! function_exists( 'gracey_core_filter_portfolio_list_info_below_overlay' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function gracey_core_filter_portfolio_list_info_below_overlay( $variations ) {
		$variations['overlay'] = esc_html__( 'Overlay', 'gracey-core' );

		return $variations;
	}

	add_filter( 'gracey_core_filter_portfolio_list_info_below_animation_options', 'gracey_core_filter_portfolio_list_info_below_overlay' );
}
