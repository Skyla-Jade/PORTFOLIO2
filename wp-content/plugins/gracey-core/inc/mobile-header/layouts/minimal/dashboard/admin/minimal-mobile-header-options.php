<?php

if ( ! function_exists( 'gracey_core_add_minimal_mobile_header_options' ) ) {
	/**
	 * Function that add additional header layout options
	 *
	 * @param object $page
	 * @param array $general_tab
	 */
	function gracey_core_add_minimal_mobile_header_options( $page, $general_tab ) {

		$section = $general_tab->add_section_element(
			array(
				'name'       => 'qodef_minimal_mobile_header_section',
				'title'      => esc_html__( 'Minimal Mobile Header', 'gracey-core' ),
				'dependency' => array(
					'show' => array(
						'qodef_mobile_header_layout' => array(
							'values'        => 'minimal',
							'default_value' => '',
						),
					),
				),
			)
		);

        $section->add_field_element(
            array(
                'field_type'  => 'select',
                'name'        => 'qodef_minimal_mobile_header_skin',
                'title'       => esc_html__( 'Minimal Header Skin', 'gracey-core' ),
                'description' => esc_html__( 'Choose a predefined header style for minimal mobile header', 'gracey-core' ),
                'options'     => array(
                    'dark'  => esc_html__( 'Dark', 'gracey-core' ),
                    'light' => esc_html__( 'Light', 'gracey-core' ),
                ),
            )
        );

		$section->add_field_element(
			array(
				'field_type'  => 'text',
				'name'        => 'qodef_minimal_mobile_header_height',
				'title'       => esc_html__( 'Minimal Height', 'gracey-core' ),
				'description' => esc_html__( 'Enter header height', 'gracey-core' ),
				'args'        => array(
					'suffix' => esc_html__( 'px', 'gracey-core' ),
				),
			)
		);

		$section->add_field_element(
			array(
				'field_type'  => 'text',
				'name'        => 'qodef_minimal_mobile_header_side_padding',
				'title'       => esc_html__( 'Header Side Padding', 'gracey-core' ),
				'description' => esc_html__( 'Enter side padding for header area', 'gracey-core' ),
				'args'        => array(
					'suffix' => esc_html__( 'px or %', 'gracey-core' ),
				),
			)
		);

		$section->add_field_element(
			array(
				'field_type'  => 'color',
				'name'        => 'qodef_minimal_mobile_header_background_color',
				'title'       => esc_html__( 'Header Background Color', 'gracey-core' ),
				'description' => esc_html__( 'Enter header background color', 'gracey-core' ),
			)
		);
	}

	add_action( 'gracey_core_action_after_mobile_header_options_map', 'gracey_core_add_minimal_mobile_header_options', 10, 2 );
}
