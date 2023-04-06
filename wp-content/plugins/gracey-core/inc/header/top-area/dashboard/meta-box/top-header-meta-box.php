<?php
if ( ! function_exists( 'gracey_core_add_top_area_meta_options' ) ) {
	/**
	 * Function that add additional header layout meta box options
	 *
	 * @param object $page
	 */
	function gracey_core_add_top_area_meta_options( $page ) {
		$top_area_section = $page->add_section_element(
			array(
				'name'       => 'qodef_top_area_section',
				'title'      => esc_html__( 'Top Area', 'gracey-core' ),
				'dependency' => array(
					'hide' => array(
						'qodef_header_layout' => array(
							'values'        => gracey_core_dependency_for_top_area_options(),
							'default_value' => '',
						),
					),
				),
			)
		);

		$top_area_section->add_field_element(
			array(
				'field_type'  => 'select',
				'name'        => 'qodef_top_area_header',
				'title'       => esc_html__( 'Top Area', 'gracey-core' ),
				'description' => esc_html__( 'Enable top area', 'gracey-core' ),
				'options'     => gracey_core_get_select_type_options_pool( 'yes_no' ),
			)
		);

		$top_area_options_section = $top_area_section->add_section_element(
			array(
				'name'        => 'qodef_top_area_options_section',
				'title'       => esc_html__( 'Top Area Options', 'gracey-core' ),
				'description' => esc_html__( 'Set desired values for top area', 'gracey-core' ),
				'dependency'  => array(
					'show' => array(
						'qodef_top_area_header' => array(
							'values'        => 'yes',
							'default_value' => 'no',
						),
					),
				),
			)
		);

		$top_area_options_section->add_field_element(
			array(
				'field_type'    => 'yesno',
				'name'          => 'qodef_top_area_header_in_grid',
				'title'         => esc_html__( 'Content in Grid', 'gracey-core' ),
				'description'   => esc_html__( 'Set content to be in grid', 'gracey-core' ),
				'default_value' => 'no',
			)
		);

		$top_area_options_section->add_field_element(
			array(
				'field_type'  => 'color',
				'name'        => 'qodef_top_area_header_background_color',
				'title'       => esc_html__( 'Top Area Background Color', 'gracey-core' ),
				'description' => esc_html__( 'Choose top area background color', 'gracey-core' ),
			)
		);

		$top_area_options_section->add_field_element(
			array(
				'field_type'  => 'text',
				'name'        => 'qodef_top_area_header_height',
				'title'       => esc_html__( 'Top Area Height', 'gracey-core' ),
				'description' => esc_html__( 'Enter top area height (default is 30px)', 'gracey-core' ),
				'args'        => array(
					'suffix' => esc_html__( 'px', 'gracey-core' ),
				),
			)
		);

		$top_area_options_section->add_field_element(
			array(
				'field_type' => 'text',
				'name'       => 'qodef_top_area_header_side_padding',
				'title'      => esc_html__( 'Top Area Side Padding', 'gracey-core' ),
				'args'       => array(
					'suffix' => esc_html__( 'px or %', 'gracey-core' ),
				),
			)
		);

		$custom_sidebars = gracey_core_get_custom_sidebars();
		if ( ! empty( $custom_sidebars ) && count( $custom_sidebars ) > 1 ) {
			$top_area_options_section->add_field_element(
				array(
					'field_type'  => 'select',
					'name'        => 'qodef_top_area_header_custom_widget_area_left',
					'title'       => esc_html__( 'Choose Custom Left Widget Area for Top Area Header', 'gracey-core' ),
					'description' => esc_html__( 'Choose custom widget area to display in top area header inside left widget area', 'gracey-core' ),
					'options'     => $custom_sidebars,
				)
			);

			$top_area_options_section->add_field_element(
				array(
					'field_type'  => 'select',
					'name'        => 'qodef_top_area_header_custom_widget_area_right',
					'title'       => esc_html__( 'Choose Custom Right Widget Area for Top Area Header', 'gracey-core' ),
					'description' => esc_html__( 'Choose custom widget area to display in top area header inside right widget area', 'gracey-core' ),
					'options'     => $custom_sidebars,
				)
			);
		}
	}

	add_action( 'gracey_core_action_after_page_header_meta_map', 'gracey_core_add_top_area_meta_options', 20 );
}
