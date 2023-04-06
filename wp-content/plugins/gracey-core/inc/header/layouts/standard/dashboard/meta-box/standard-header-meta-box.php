<?php

if ( ! function_exists( 'gracey_core_add_standard_header_meta' ) ) {
	/**
	 * Function that add additional header layout meta box options
	 *
	 * @param object $page
	 */
	function gracey_core_add_standard_header_meta( $page ) {
		$section = $page->add_section_element(
			array(
				'name'       => 'qodef_standard_header_section',
				'title'      => esc_html__( 'Standard Header', 'gracey-core' ),
				'dependency' => array(
					'show' => array(
						'qodef_header_layout' => array(
							'values'        => array( '', 'standard' ),
							'default_value' => '',
						),
					),
				),
			)
		);

		$section->add_field_element(
			array(
				'field_type'    => 'select',
				'name'          => 'qodef_standard_header_in_grid',
				'title'         => esc_html__( 'Content in Grid', 'gracey-core' ),
				'description'   => esc_html__( 'Set content to be in grid', 'gracey-core' ),
				'default_value' => '',
				'options'       => gracey_core_get_select_type_options_pool( 'no_yes' ),
			)
		);

		$section->add_field_element(
			array(
				'field_type'  => 'text',
				'name'        => 'qodef_standard_header_height',
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
				'name'        => 'qodef_standard_header_side_padding',
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
				'name'        => 'qodef_standard_header_background_color',
				'title'       => esc_html__( 'Header Background Color', 'gracey-core' ),
				'description' => esc_html__( 'Enter header background color', 'gracey-core' ),
			)
		);

		$section->add_field_element(
			array(
				'field_type'  => 'color',
				'name'        => 'qodef_standard_header_border_color',
				'title'       => esc_html__( 'Header Border Color', 'gracey-core' ),
				'description' => esc_html__( 'Enter header border color', 'gracey-core' ),
			)
		);

		$section->add_field_element(
			array(
				'field_type'  => 'text',
				'name'        => 'qodef_standard_header_border_width',
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
				'name'        => 'qodef_standard_header_border_style',
				'title'       => esc_html__( 'Header Border Style', 'gracey-core' ),
				'description' => esc_html__( 'Choose header border style', 'gracey-core' ),
				'options'     => gracey_core_get_select_type_options_pool( 'border_style' ),
			)
		);

		$section->add_field_element(
			array(
				'field_type'    => 'select',
				'name'          => 'qodef_standard_header_menu_position',
				'title'         => esc_html__( 'Menu position', 'gracey-core' ),
				'default_value' => '',
				'options'       => array(
					''       => esc_html__( 'Default', 'gracey-core' ),
					'left'   => esc_html__( 'Left', 'gracey-core' ),
					'center' => esc_html__( 'Center', 'gracey-core' ),
					'right'  => esc_html__( 'Right', 'gracey-core' ),
				),
			)
		);
	}

	add_action( 'gracey_core_action_after_page_header_meta_map', 'gracey_core_add_standard_header_meta' );
}
