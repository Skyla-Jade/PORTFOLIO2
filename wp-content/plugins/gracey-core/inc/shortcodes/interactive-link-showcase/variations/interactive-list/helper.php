<?php

if ( ! function_exists( 'gracey_core_add_interactive_link_showcase_variation_interactive_list' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function gracey_core_add_interactive_link_showcase_variation_interactive_list( $variations ) {
		$variations['interactive-list'] = esc_html__( 'Interactive List', 'gracey-core' );

		return $variations;
	}

	add_filter( 'gracey_core_filter_interactive_link_showcase_layouts', 'gracey_core_add_interactive_link_showcase_variation_interactive_list' );
}
