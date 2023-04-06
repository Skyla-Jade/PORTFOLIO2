<?php

if ( ! function_exists( 'gracey_core_add_pricing_table_variation_standard' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function gracey_core_add_pricing_table_variation_standard( $variations ) {

		$variations['standard'] = esc_html__( 'Standard', 'gracey-core' );

		return $variations;
	}

	add_filter( 'gracey_core_filter_pricing_table_layouts', 'gracey_core_add_pricing_table_variation_standard' );
}
