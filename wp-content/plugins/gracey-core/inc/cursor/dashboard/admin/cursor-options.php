<?php

if ( ! function_exists( 'gracey_core_add_cursor_options' ) ) {
	/**
	 * Function that add general options for this module
	 */
	function gracey_core_add_cursor_options( $page ) {
		
		if ( $page ) {
			$page->add_field_element(
				array(
					'field_type'    => 'yesno',
					'name'          => 'qodef_cursor',
					'title'         => esc_html__( 'Enable Theme Cursor', 'fonster-core' ),
                    'description' => esc_html__( 'Not supported in Internet Explorer', 'fonster-core' ),
					'default_value' => 'no'
				)
			);
		}
	}
	
	add_action( 'gracey_core_action_after_general_options_map', 'gracey_core_add_cursor_options' );
}