<?php

if ( ! function_exists( 'gracey_core_add_sticky_header_meta_options' ) ) {
	/**
	 * Function that add additional meta box options for current module
	 *
	 * @param object $section
	 * @param array $custom_sidebars
	 */
	function gracey_core_add_sticky_header_meta_options( $section, $custom_sidebars ) {

		if ( $section ) {

			$sticky_section = $section->add_section_element(
				array(
					'name'       => 'qodef_sticky_header_section',
					'dependency' => array(
						'show' => array(
							'qodef_header_scroll_appearance' => array(
								'values'        => 'sticky',
								'default_value' => '',
							),
						),
					),
				)
			);

			$sticky_section->add_field_element(
				array(
					'field_type'  => 'select',
					'name'        => 'qodef_sticky_header_appearance',
					'title'       => esc_html__( 'Sticky Header Appearance', 'gracey-core' ),
					'description' => esc_html__( 'Select the appearance of sticky header when you scrolling the page', 'gracey-core' ),
					'options'     => array(
						''     => esc_html__( 'Default', 'gracey-core' ),
						'down' => esc_html__( 'Show Sticky on Scroll Down/Up', 'gracey-core' ),
						'up'   => esc_html__( 'Show Sticky on Scroll Up', 'gracey-core' ),
					),
				)
			);

			$sticky_section->add_field_element(
				array(
					'field_type'  => 'select',
					'name'        => 'qodef_sticky_header_skin',
					'title'       => esc_html__( 'Sticky Header Skin', 'gracey-core' ),
					'description' => esc_html__( 'Choose a predefined sticky header style for header elements', 'gracey-core' ),
					'options'     => array(
						''      => esc_html__( 'Default', 'gracey-core' ),
						'none'  => esc_html__( 'None', 'gracey-core' ),
						'light' => esc_html__( 'Light', 'gracey-core' ),
						'dark'  => esc_html__( 'Dark', 'gracey-core' ),
					),
				)
			);

			$sticky_section->add_field_element(
				array(
					'field_type'  => 'text',
					'name'        => 'qodef_sticky_header_scroll_amount',
					'title'       => esc_html__( 'Sticky Scroll Amount', 'gracey-core' ),
					'description' => esc_html__( 'Enter scroll amount for sticky header to appear', 'gracey-core' ),
					'args'        => array(
						'suffix' => esc_html__( 'px', 'gracey-core' ),
					),
				)
			);

			$sticky_section->add_field_element(
				array(
					'field_type'  => 'text',
					'name'        => 'qodef_sticky_header_side_padding',
					'title'       => esc_html__( 'Sticky Header Side Padding', 'gracey-core' ),
					'description' => esc_html__( 'Enter side padding for sticky header area', 'gracey-core' ),
					'args'        => array(
						'suffix' => esc_html__( 'px or %', 'gracey-core' ),
					),
				)
			);

			$sticky_section->add_field_element(
				array(
					'field_type'  => 'color',
					'name'        => 'qodef_sticky_header_background_color',
					'title'       => esc_html__( 'Sticky Header Background Color', 'gracey-core' ),
					'description' => esc_html__( 'Enter sticky header background color', 'gracey-core' ),
				)
			);

			$sticky_section->add_field_element(
				array(
					'field_type'  => 'select',
					'name'        => 'qodef_sticky_header_custom_widget_area_one',
					'title'       => esc_html__( 'Choose Custom Sticky Header Widget Area One', 'gracey-core' ),
					'description' => esc_html__( 'Choose custom widget area to display in sticky header widget area one', 'gracey-core' ),
					'options'     => $custom_sidebars,
				)
			);

			$sticky_section->add_field_element(
				array(
					'field_type'  => 'select',
					'name'        => 'qodef_sticky_header_custom_widget_area_two',
					'title'       => esc_html__( 'Choose Custom Sticky Header Widget Area Two', 'gracey-core' ),
					'description' => esc_html__( 'Choose custom widget area to display in sticky header widget area two', 'gracey-core' ),
					'options'     => $custom_sidebars,
				)
			);
		}
	}

	add_action( 'gracey_core_action_after_header_scroll_appearance_meta_options_map', 'gracey_core_add_sticky_header_meta_options', 10, 2 );
}

if ( ! function_exists( 'gracey_core_add_sticky_header_logo_meta_options' ) ) {
	/**
	 * Function that add additional header logo meta box options
	 *
	 * @param object $logo_tab
	 * @param array $header_logo_section
     * @param array $logo_image_section
	 */
	function gracey_core_add_sticky_header_logo_meta_options( $logo_tab, $header_logo_section, $logo_image_section ) {

		if ( $header_logo_section ) {

            $logo_image_section->add_field_element(
				array(
					'field_type'  => 'image',
					'name'        => 'qodef_logo_sticky',
					'title'       => esc_html__( 'Logo - Sticky', 'gracey-core' ),
					'description' => esc_html__( 'Choose sticky logo image', 'gracey-core' ),
					'multiple'    => 'no',
				)
			);
		}
	}

    add_action( 'gracey_core_action_after_header_logo_image_section_meta_map', 'gracey_core_add_sticky_header_logo_meta_options', 10, 3 );
}

if ( ! function_exists( 'gracey_core_add_sticky_header_logo_svg_meta_options' ) ) {
    /**
     * Function that add additional header logo options
     *
     * @param object $page
     * @param array $header_tab
     * @param array $logo_svg_path_section
     */
    function gracey_core_add_sticky_header_logo_svg_meta_options( $page, $header_tab, $logo_svg_path_section ) {

        if ( $header_tab ) {
            $logo_svg_path_section->add_field_element(
                array(
                    'field_type'  => 'textarea',
                    'name'        => 'qodef_logo_sticky_svg_path',
                    'title'       => esc_html__( 'Logo Sticky - SVG Path', 'gracey-core' ),
                    'description' => esc_html__( 'Enter your logo icon SVG path here. Please remove version and id attributes from your SVG path because of HTML validation', 'gracey-core' ),
                )
            );
        }
    }

    add_action( 'gracey_core_action_before_header_logo_svg_path_section_meta_map', 'gracey_core_add_sticky_header_logo_svg_meta_options', 10, 3 );
}
