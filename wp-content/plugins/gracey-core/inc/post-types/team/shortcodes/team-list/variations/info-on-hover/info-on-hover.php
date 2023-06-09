<?php

if ( ! function_exists( 'gracey_core_add_team_list_variation_info_on_hover' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function gracey_core_add_team_list_variation_info_on_hover( $variations ) {
		$variations['info-on-hover'] = esc_html__( 'Info on Hover', 'gracey-core' );

		return $variations;
	}

	add_filter( 'gracey_core_filter_team_list_layouts', 'gracey_core_add_team_list_variation_info_on_hover' );
}
