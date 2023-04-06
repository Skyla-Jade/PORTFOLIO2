<?php

if ( ! function_exists( 'gracey_core_add_call_to_action_variation_standard' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function gracey_core_add_call_to_action_variation_standard( $variations ) {
		$variations['standard'] = esc_html__( 'Standard', 'gracey-core' );

		return $variations;
	}

	add_filter( 'gracey_core_filter_call_to_action_layouts', 'gracey_core_add_call_to_action_variation_standard' );
}
