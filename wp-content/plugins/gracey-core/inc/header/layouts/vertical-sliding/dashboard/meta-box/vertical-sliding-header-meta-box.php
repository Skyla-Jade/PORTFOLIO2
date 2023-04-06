<?php

if ( ! function_exists( 'gracey_core_add_vertical_sliding_header_meta' ) ) {
	/**
	 * Function that add additional header layout meta box options
	 *
	 * @param object $page
	 */
	function gracey_core_add_vertical_sliding_header_meta( $page ) {

		$section = $page->add_section_element(
			array(
				'name'       => 'qodef_vertical_sliding_header_section',
				'title'      => esc_html__( 'Vertical Sliding Header', 'gracey-core' ),
				'dependency' => array(
					'show' => array(
						'qodef_header_layout' => array(
							'values'        => 'vertical-sliding',
							'default_value' => '',
						),
					),
				),
			)
		);

		$section->add_field_element(
			array(
				'field_type'  => 'color',
				'name'        => 'qodef_vertical_sliding_header_background_color',
				'title'       => esc_html__( 'Header Background Color', 'gracey-core' ),
				'description' => esc_html__( 'Enter header background color', 'gracey-core' ),
			)
		);
	}

	add_action( 'gracey_core_action_after_page_header_meta_map', 'gracey_core_add_vertical_sliding_header_meta' );
}

if ( ! function_exists( 'gracey_core_add_vertical_sliding_header_logo_meta_options' ) ) {
	/**
	 * Function that add additional header logo meta box options
	 *
	 * @param object $page
	 * @param array $header_tab
     * @param array $logo_image_section
	 */
	function gracey_core_add_vertical_sliding_header_logo_meta_options( $page, $header_tab, $logo_image_section ) {

		if ( $header_tab ) {
            $logo_image_section->add_field_element(
				array(
					'field_type'  => 'image',
					'name'        => 'qodef_logo_vertical_sliding',
					'title'       => esc_html__( 'Logo - Vertical Sliding', 'gracey-core' ),
					'description' => esc_html__( 'Choose vertical sliding area logo image', 'gracey-core' ),
					'multiple'    => 'no',
				)
			);
		}
	}

    add_action( 'gracey_core_action_after_header_logo_image_section_meta_map', 'gracey_core_add_vertical_sliding_header_logo_meta_options', 10, 3 );
}
