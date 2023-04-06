<?php

if ( ! function_exists( 'gracey_core_add_interactive_link_showcase_variation_slider' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function gracey_core_add_interactive_link_showcase_variation_slider( $variations ) {
		$variations['slider'] = esc_html__( 'Slider', 'gracey-core' );

		return $variations;
	}

	add_filter( 'gracey_core_filter_interactive_link_showcase_layouts', 'gracey_core_add_interactive_link_showcase_variation_slider' );
}
