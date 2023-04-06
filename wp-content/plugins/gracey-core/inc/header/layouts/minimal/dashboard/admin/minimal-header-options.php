<?php

if ( ! function_exists( 'gracey_core_add_minimal_header_options' ) ) {
	/**
	 * Function that add additional header layout options
	 *
	 * @param object $page
	 * @param array $general_header_tab
	 */
	function gracey_core_add_minimal_header_options( $page, $general_header_tab ) {

		$section = $general_header_tab->add_section_element(
			array(
				'name'       => 'qodef_minimal_header_section',
				'title'      => esc_html__( 'Minimal Header', 'gracey-core' ),
				'dependency' => array(
					'show' => array(
						'qodef_header_layout' => array(
							'values'        => 'minimal',
							'default_value' => '',
						),
					),
				),
			)
		);

		$section->add_field_element(
			array(
				'field_type'    => 'yesno',
				'name'          => 'qodef_minimal_header_in_grid',
				'title'         => esc_html__( 'Content in Grid', 'gracey-core' ),
				'description'   => esc_html__( 'Set content to be in grid', 'gracey-core' ),
				'default_value' => 'no',
			)
		);

		$section->add_field_element(
			array(
				'field_type'  => 'text',
				'name'        => 'qodef_minimal_header_height',
				'title'       => esc_html__( 'Header Height', 'gracey-core' ),
				'description' => esc_html__( 'Enter header height', 'gracey-core' ),
				'args'        => array(
					'suffix' => esc_html__( 'px', 'gracey-core' ),
				),
			)
		);

		$section->add_field_element(
			array(
				'field_type'  => 'text',
				'name'        => 'qodef_minimal_header_side_padding',
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
				'name'        => 'qodef_minimal_header_background_color',
				'title'       => esc_html__( 'Header Background Color', 'gracey-core' ),
				'description' => esc_html__( 'Enter header background color', 'gracey-core' ),
				'args'        => array(
					'suffix' => esc_html__( 'px', 'gracey-core' ),
				),
			)
		);

		$section->add_field_element(
			array(
				'field_type'  => 'color',
				'name'        => 'qodef_minimal_header_border_color',
				'title'       => esc_html__( 'Header Border Color', 'gracey-core' ),
				'description' => esc_html__( 'Enter header border color', 'gracey-core' ),
			)
		);

		$section->add_field_element(
			array(
				'field_type'  => 'text',
				'name'        => 'qodef_minimal_header_border_width',
				'title'       => esc_html__( 'Header Border Width', 'gracey-core' ),
				'description' => esc_html__( 'Enter header border width size', 'gracey-core' ),
				'args'        => array(
					'suffix' => esc_html__( 'px', 'gracey-core' ),
				),
			)
		);

		$section->add_field_element(
			array(
				'field_type'  => 'select',
				'name'        => 'qodef_minimal_header_border_style',
				'title'       => esc_html__( 'Header Border Style', 'gracey-core' ),
				'description' => esc_html__( 'Choose header border style', 'gracey-core' ),
				'options'     => gracey_core_get_select_type_options_pool( 'border_style' ),
			)
		);
	}

	add_action( 'gracey_core_action_after_header_options_map', 'gracey_core_add_minimal_header_options', 10, 2 );
}
