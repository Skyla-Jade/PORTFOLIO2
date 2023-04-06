<?php

if ( ! function_exists( 'gracey_core_add_product_category_list_variation_info_on_image' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function gracey_core_add_product_category_list_variation_info_on_image( $variations ) {
		$variations['info-on-image'] = esc_html__( 'Info On Image', 'gracey-core' );

		return $variations;
	}

	add_filter( 'gracey_core_filter_product_category_list_layouts', 'gracey_core_add_product_category_list_variation_info_on_image' );
}
