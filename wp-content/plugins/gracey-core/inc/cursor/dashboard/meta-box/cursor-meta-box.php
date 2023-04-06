<?php

if ( ! function_exists( 'gracey_core_add_page_cursor_meta_box' ) ) {
	/**
	 * Function that add general options for this module
	 */
	function gracey_core_add_page_cursor_meta_box( $page ) {
		
		if ( $page ) {
			$page->add_field_element(
				array(
					'field_type'  => 'select',
					'name'        => 'qodef_cursor',
                    'title'       => esc_html__( 'Enable Theme Cursor', 'fonster-core' ),
                    'description' => esc_html__( 'Not supported in Internet Explorer', 'fonster-core' ),
					'options'     => gracey_core_get_select_type_options_pool( 'yes_no' )
				)
			);
		}
	}
	
	add_action( 'gracey_core_action_after_general_page_meta_box_map', 'gracey_core_add_page_cursor_meta_box', 9 );
}