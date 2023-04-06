<?php

if ( ! function_exists( 'gracey_core_add_portfolio_category_list_variation_gallery' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function gracey_core_add_portfolio_category_list_variation_gallery( $variations ) {
		$variations['gallery'] = esc_html__( 'Gallery', 'gracey-core' );

		return $variations;
	}

	add_filter( 'gracey_core_filter_portfolio_category_list_layouts', 'gracey_core_add_portfolio_category_list_variation_gallery' );
}
