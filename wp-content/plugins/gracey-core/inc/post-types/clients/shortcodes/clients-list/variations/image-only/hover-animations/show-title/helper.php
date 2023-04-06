<?php

if ( ! function_exists( 'gracey_core_filter_clients_list_image_only_show_title' ) ) {
    /**
     * Function that add variation layout for this module
     *
     * @param array $variations
     *
     * @return array
     */
	function gracey_core_filter_clients_list_image_only_show_title( $variations ) {
		
		$variations['show-title'] = esc_html__( 'Show Title', 'gracey-core' );
		
		return $variations;
	}
	
	add_filter( 'gracey_core_filter_clients_list_image_only_animation_options', 'gracey_core_filter_clients_list_image_only_show_title' );
}