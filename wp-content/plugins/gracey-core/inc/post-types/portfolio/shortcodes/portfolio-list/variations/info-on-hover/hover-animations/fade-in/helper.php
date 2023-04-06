<?php

if ( ! function_exists( 'gracey_core_filter_portfolio_list_info_on_hover_fade_in' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function gracey_core_filter_portfolio_list_info_on_hover_fade_in( $variations ) {
		$variations['fade-in'] = esc_html__( 'Fade In', 'gracey-core' );

		return $variations;
	}

	add_filter( 'gracey_core_filter_portfolio_list_info_on_hover_animation_options', 'gracey_core_filter_portfolio_list_info_on_hover_fade_in' );
}
