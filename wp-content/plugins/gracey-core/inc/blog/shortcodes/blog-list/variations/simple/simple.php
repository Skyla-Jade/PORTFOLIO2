<?php

if ( ! function_exists( 'gracey_core_add_blog_list_variation_simple' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function gracey_core_add_blog_list_variation_simple( $variations ) {
		$variations['simple'] = esc_html__( 'Simple', 'gracey-core' );

		return $variations;
	}

	add_filter( 'gracey_core_filter_blog_list_layouts', 'gracey_core_add_blog_list_variation_simple' );
}
