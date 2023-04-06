<?php

if ( ! function_exists( 'gracey_core_add_general_options' ) ) {
	/**
	 * Function that add general options for this module
	 */
	function gracey_core_add_general_options( $page ) {

		if ( $page ) {
			$page->add_field_element(
				array(
					'field_type'  => 'color',
					'name'        => 'qodef_main_color',
					'title'       => esc_html__( 'Main Color', 'gracey-core' ),
					'description' => esc_html__( 'Choose the most dominant theme color', 'gracey-core' ),
				)
			);

			$page->add_field_element(
				array(
					'field_type'  => 'color',
					'name'        => 'qodef_page_background_color',
					'title'       => esc_html__( 'Page Background Color', 'gracey-core' ),
					'description' => esc_html__( 'Set background color', 'gracey-core' ),
				)
			);

			$page->add_field_element(
				array(
					'field_type'  => 'image',
					'name'        => 'qodef_page_background_image',
					'title'       => esc_html__( 'Page Background Image', 'gracey-core' ),
					'description' => esc_html__( 'Set background image', 'gracey-core' ),
				)
			);

			$page->add_field_element(
				array(
					'field_type'  => 'select',
					'name'        => 'qodef_page_background_repeat',
					'title'       => esc_html__( 'Page Background Image Repeat', 'gracey-core' ),
					'description' => esc_html__( 'Set background image repeat', 'gracey-core' ),
					'options'     => array(
						''          => esc_html__( 'Default', 'gracey-core' ),
						'no-repeat' => esc_html__( 'No Repeat', 'gracey-core' ),
						'repeat'    => esc_html__( 'Repeat', 'gracey-core' ),
						'repeat-x'  => esc_html__( 'Repeat-x', 'gracey-core' ),
						'repeat-y'  => esc_html__( 'Repeat-y', 'gracey-core' ),
					),
				)
			);

			$page->add_field_element(
				array(
					'field_type'  => 'select',
					'name'        => 'qodef_page_background_size',
					'title'       => esc_html__( 'Page Background Image Size', 'gracey-core' ),
					'description' => esc_html__( 'Set background image size', 'gracey-core' ),
					'options'     => array(
						''        => esc_html__( 'Default', 'gracey-core' ),
						'contain' => esc_html__( 'Contain', 'gracey-core' ),
						'cover'   => esc_html__( 'Cover', 'gracey-core' ),
					),
				)
			);

			$page->add_field_element(
				array(
					'field_type'  => 'select',
					'name'        => 'qodef_page_background_attachment',
					'title'       => esc_html__( 'Page Background Image Attachment', 'gracey-core' ),
					'description' => esc_html__( 'Set background image attachment', 'gracey-core' ),
					'options'     => array(
						''       => esc_html__( 'Default', 'gracey-core' ),
						'fixed'  => esc_html__( 'Fixed', 'gracey-core' ),
						'scroll' => esc_html__( 'Scroll', 'gracey-core' ),
					),
				)
			);

			$page->add_field_element(
				array(
					'field_type'  => 'text',
					'name'        => 'qodef_page_content_padding',
					'title'       => esc_html__( 'Page Content Padding', 'gracey-core' ),
					'description' => esc_html__( 'Set padding that will be applied for page content in format: top right bottom left (e.g. 10px 5px 10px 5px)', 'gracey-core' ),
				)
			);

			$page->add_field_element(
				array(
					'field_type'  => 'text',
					'name'        => 'qodef_page_content_padding_mobile',
					'title'       => esc_html__( 'Page Content Padding Mobile', 'gracey-core' ),
					'description' => esc_html__( 'Set padding that will be applied for page content on mobile screens (1024px and below) in format: top right bottom left (e.g. 10px 5px 10px 5px)', 'gracey-core' ),
				)
			);

			$page->add_field_element(
				array(
					'field_type'    => 'yesno',
					'name'          => 'qodef_boxed',
					'title'         => esc_html__( 'Boxed Layout', 'gracey-core' ),
					'description'   => esc_html__( 'Set boxed layout', 'gracey-core' ),
					'default_value' => 'no',
				)
			);

			$boxed_section = $page->add_section_element(
				array(
					'name'       => 'qodef_boxed_section',
					'title'      => esc_html__( 'Boxed Layout Section', 'gracey-core' ),
					'dependency' => array(
						'hide' => array(
							'qodef_boxed' => array(
								'values'        => 'no',
								'default_value' => '',
							),
						),
					),
				)
			);

			$boxed_section->add_field_element(
				array(
					'field_type'  => 'color',
					'name'        => 'qodef_boxed_background_color',
					'title'       => esc_html__( 'Boxed Background Color', 'gracey-core' ),
					'description' => esc_html__( 'Set boxed background color', 'gracey-core' ),
				)
			);

			$boxed_section->add_field_element(
				array(
					'field_type'  => 'image',
					'name'        => 'qodef_boxed_background_pattern',
					'title'       => esc_html__( 'Boxed Background Pattern', 'gracey-core' ),
					'description' => esc_html__( 'Set boxed background pattern', 'gracey-core' ),
				)
			);

			$boxed_section->add_field_element(
				array(
					'field_type'  => 'select',
					'name'        => 'qodef_boxed_background_pattern_behavior',
					'title'       => esc_html__( 'Boxed Background Pattern Behavior', 'gracey-core' ),
					'description' => esc_html__( 'Set boxed background pattern behavior', 'gracey-core' ),
					'options'     => array(
						'fixed'  => esc_html__( 'Fixed', 'gracey-core' ),
						'scroll' => esc_html__( 'Scroll', 'gracey-core' ),
					),
				)
			);

			$page->add_field_element(
				array(
					'field_type'    => 'yesno',
					'name'          => 'qodef_passepartout',
					'title'         => esc_html__( 'Passepartout', 'gracey-core' ),
					'description'   => esc_html__( 'Enabling this option will display a passepartout around website content', 'gracey-core' ),
					'default_value' => 'no',
				)
			);

			$passepartout_section = $page->add_section_element(
				array(
					'name'       => 'qodef_passepartout_section',
					'title'      => esc_html__( 'Passepartout Section', 'gracey-core' ),
					'dependency' => array(
						'hide' => array(
							'qodef_passepartout' => array(
								'values'        => 'no',
								'default_value' => '',
							),
						),
					),
				)
			);

			$passepartout_section->add_field_element(
				array(
					'field_type'  => 'color',
					'name'        => 'qodef_passepartout_color',
					'title'       => esc_html__( 'Passepartout Color', 'gracey-core' ),
					'description' => esc_html__( 'Choose background color for passepartout', 'gracey-core' ),
				)
			);

			$passepartout_section->add_field_element(
				array(
					'field_type'  => 'image',
					'name'        => 'qodef_passepartout_image',
					'title'       => esc_html__( 'Passepartout Background Image', 'gracey-core' ),
					'description' => esc_html__( 'Set background image for passepartout', 'gracey-core' ),
				)
			);

			$passepartout_section->add_field_element(
				array(
					'field_type'  => 'text',
					'name'        => 'qodef_passepartout_size',
					'title'       => esc_html__( 'Passepartout Size', 'gracey-core' ),
					'description' => esc_html__( 'Enter size amount for passepartout', 'gracey-core' ),
					'args'        => array(
						'suffix' => esc_html__( 'px or %', 'gracey-core' ),
					),
				)
			);

			$passepartout_section->add_field_element(
				array(
					'field_type'  => 'text',
					'name'        => 'qodef_passepartout_size_responsive',
					'title'       => esc_html__( 'Passepartout Responsive Size', 'gracey-core' ),
					'description' => esc_html__( 'Enter size amount for passepartout for smaller screens (1024px and below)', 'gracey-core' ),
					'args'        => array(
						'suffix' => esc_html__( 'px or %', 'gracey-core' ),
					),
				)
			);

			$page->add_field_element(
				array(
					'field_type'    => 'select',
					'name'          => 'qodef_content_width',
					'title'         => esc_html__( 'Initial Width of Content', 'gracey-core' ),
					'description'   => esc_html__( 'Choose the initial width of content which is in grid (applies to pages set to "Default Template" and rows set to "In Grid")', 'gracey-core' ),
					'options'       => gracey_core_get_select_type_options_pool( 'content_width', false ),
					'default_value' => '1100',
				)
			);

			// Hook to include additional options after module options
			do_action( 'gracey_core_action_after_general_options_map', $page );

			$page->add_field_element(
				array(
					'field_type'  => 'textarea',
					'name'        => 'qodef_custom_js',
					'title'       => esc_html__( 'Custom JS', 'gracey-core' ),
					'description' => esc_html__( 'Enter your custom JavaScript here', 'gracey-core' ),
				)
			);
		}
	}

	add_action( 'gracey_core_action_default_options_init', 'gracey_core_add_general_options', gracey_core_get_admin_options_map_position( 'general' ) );
}
