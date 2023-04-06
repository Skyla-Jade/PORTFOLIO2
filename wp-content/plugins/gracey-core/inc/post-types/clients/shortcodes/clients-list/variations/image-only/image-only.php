<?php

if ( ! function_exists( 'gracey_core_add_clients_list_variation_image_only' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function gracey_core_add_clients_list_variation_image_only( $variations ) {
		$variations['image-only'] = esc_html__( 'Image Only', 'gracey-core' );

		return $variations;
	}

	add_filter( 'gracey_core_filter_clients_list_layouts', 'gracey_core_add_clients_list_variation_image_only' );
}
