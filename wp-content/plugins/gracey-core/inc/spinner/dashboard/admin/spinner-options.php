<?php

if ( ! function_exists( 'gracey_core_add_page_spinner_options' ) ) {
	/**
	 * Function that add general options for this module
	 */
	function gracey_core_add_page_spinner_options( $page ) {

		if ( $page ) {
			$page->add_field_element(
				array(
					'field_type'    => 'yesno',
					'name'          => 'qodef_enable_page_spinner',
					'title'         => esc_html__( 'Enable Page Spinner', 'gracey-core' ),
					'description'   => esc_html__( 'Enable Page Spinner Effect', 'gracey-core' ),
					'default_value' => 'no',
				)
			);

			$spinner_section = $page->add_section_element(
				array(
					'name'       => 'qodef_page_spinner_section',
					'title'      => esc_html__( 'Page Spinner Section', 'gracey-core' ),
					'dependency' => array(
						'show' => array(
							'qodef_enable_page_spinner' => array(
								'values'        => 'yes',
								'default_value' => 'no',
							),
						),
					),
				)
			);

			$spinner_section->add_field_element(
				array(
					'field_type'    => 'select',
					'name'          => 'qodef_page_spinner_type',
					'title'         => esc_html__( 'Select Page Spinner Type', 'gracey-core' ),
					'description'   => esc_html__( 'Choose a page spinner animation style', 'gracey-core' ),
					'options'       => apply_filters( 'gracey_core_filter_page_spinner_layout_options', array() ),
					'default_value' => apply_filters( 'gracey_core_filter_page_spinner_default_layout_option', '' ),
				)
			);
			
			$spinner_section->add_field_element(
				array(
					'field_type'    => 'text',
					'name'          => 'qodef_page_spinner_text',
					'title'         => esc_html__( 'Spinner Text', 'gracey-core' ),
					'description'   => esc_html__( 'Choose the spinner text', 'gracey-core' ),
					'default_value' => 'Gracey Gracey Gracey ',
					'dependency'    => array(
						'show' => array(
							'qodef_page_spinner_type' => array(
								'values'        => 'textual',
								'default_value' => 'no'
							)
						)
					)
				
				)
			);

			$spinner_section->add_field_element(
				array(
					'field_type'  => 'color',
					'name'        => 'qodef_page_spinner_background_color',
					'title'       => esc_html__( 'Spinner Background Color', 'gracey-core' ),
					'description' => esc_html__( 'Choose the spinner background color', 'gracey-core' ),
				)
			);

			$spinner_section->add_field_element(
				array(
					'field_type'  => 'color',
					'name'        => 'qodef_page_spinner_color',
					'title'       => esc_html__( 'Spinner Color', 'gracey-core' ),
					'description' => esc_html__( 'Choose the spinner color', 'gracey-core' ),
				)
			);

			$spinner_section->add_field_element(
				array(
					'field_type'    => 'yesno',
					'name'          => 'qodef_page_spinner_fade_out_animation',
					'title'         => esc_html__( 'Enable Fade Out Animation', 'gracey-core' ),
					'description'   => esc_html__( 'Enabling this option will turn on fade out animation when leaving page', 'gracey-core' ),
					'default_value' => 'no',
				)
			);
		}
	}

	add_action( 'gracey_core_action_after_general_options_map', 'gracey_core_add_page_spinner_options' );
}
