<?php

if ( ! function_exists( 'gracey_core_add_general_page_meta_box' ) ) {
	/**
	 * Function that add general meta box options for this module
	 *
	 * @param object $page
	 */
	function gracey_core_add_general_page_meta_box( $page ) {

		$general_tab = $page->add_tab_element(
			array(
				'name'        => 'tab-page',
				'icon'        => 'fa fa-cog',
				'title'       => esc_html__( 'Page Settings', 'gracey-core' ),
				'description' => esc_html__( 'General page layout settings', 'gracey-core' ),
			)
		);

		$general_tab->add_field_element(
			array(
				'field_type'  => 'color',
				'name'        => 'qodef_page_background_color',
				'title'       => esc_html__( 'Page Background Color', 'gracey-core' ),
				'description' => esc_html__( 'Set background color', 'gracey-core' ),
			)
		);

		$general_tab->add_field_element(
			array(
				'field_type'  => 'image',
				'name'        => 'qodef_page_background_image',
				'title'       => esc_html__( 'Page Background Image', 'gracey-core' ),
				'description' => esc_html__( 'Set background image', 'gracey-core' ),
			)
		);

		$general_tab->add_field_element(
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

		$general_tab->add_field_element(
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

		$general_tab->add_field_element(
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

		$general_tab->add_field_element(
			array(
				'field_type'  => 'text',
				'name'        => 'qodef_page_content_padding',
				'title'       => esc_html__( 'Page Content Padding', 'gracey-core' ),
				'description' => esc_html__( 'Set padding that will be applied for page content in format: top right bottom left (e.g. 10px 5px 10px 5px)', 'gracey-core' ),
			)
		);

		$general_tab->add_field_element(
			array(
				'field_type'  => 'text',
				'name'        => 'qodef_page_content_padding_mobile',
				'title'       => esc_html__( 'Page Content Padding Mobile', 'gracey-core' ),
				'description' => esc_html__( 'Set padding that will be applied for page content on mobile screens (1024px and below) in format: top right bottom left (e.g. 10px 5px 10px 5px)', 'gracey-core' ),
			)
		);

		$general_tab->add_field_element(
			array(
				'field_type'    => 'select',
				'name'          => 'qodef_boxed',
				'title'         => esc_html__( 'Boxed Layout', 'gracey-core' ),
				'description'   => esc_html__( 'Set boxed layout', 'gracey-core' ),
				'default_value' => '',
				'options'       => gracey_core_get_select_type_options_pool( 'yes_no' ),
			)
		);

		$boxed_section = $general_tab->add_section_element(
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
					''       => esc_html__( 'Default', 'gracey-core' ),
					'fixed'  => esc_html__( 'Fixed', 'gracey-core' ),
					'scroll' => esc_html__( 'Scroll', 'gracey-core' ),
				),
			)
		);

        $general_tab->add_field_element(
            array(
                'field_type'    => 'select',
                'name'          => 'qodef_left_fixed_area',
                'title'         => esc_html__( 'Enable Left Fixed Area', 'gracey-core' ),
                'default_value' => '',
                'options'       => gracey_core_get_select_type_options_pool( 'no_yes' )
            )
        );

		$general_tab->add_field_element(
			array(
				'field_type'    => 'select',
				'name'          => 'qodef_passepartout',
				'title'         => esc_html__( 'Passepartout', 'gracey-core' ),
				'description'   => esc_html__( 'Enabling this option will display a passepartout around website content', 'gracey-core' ),
				'default_value' => '',
				'options'       => gracey_core_get_select_type_options_pool( 'yes_no' ),
			)
		);

		$passepartout_section = $general_tab->add_section_element(
			array(
				'name'       => 'qodef_passepartout_section',
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

		$general_tab->add_field_element(
			array(
				'field_type'  => 'select',
				'name'        => 'qodef_content_width',
				'title'       => esc_html__( 'Initial Width of Content', 'gracey-core' ),
				'description' => esc_html__( 'Choose the initial width of content which is in grid (applies to pages set to "Default Template" and rows set to "In Grid")', 'gracey-core' ),
				'options'     => gracey_core_get_select_type_options_pool( 'content_width' ),
			)
		);

		$general_tab->add_field_element(
			array(
				'field_type'    => 'yesno',
				'default_value' => 'no',
				'name'          => 'qodef_content_behind_header',
				'title'         => esc_html__( 'Always put content behind header', 'gracey-core' ),
				'description'   => esc_html__( 'Enabling this option will put page content behind page header', 'gracey-core' ),
			)
		);

		// Hook to include additional options after module options
		do_action( 'gracey_core_action_after_general_page_meta_box_map', $general_tab );
	}

	add_action( 'gracey_core_action_after_general_meta_box_map', 'gracey_core_add_general_page_meta_box', 9 );
}

if ( ! function_exists( 'gracey_core_add_general_page_meta_box_callback' ) ) {
	/**
	 * Function that set current meta box callback as general callback functions
	 *
	 * @param array $callbacks
	 *
	 * @return array
	 */
	function gracey_core_add_general_page_meta_box_callback( $callbacks ) {
		$callbacks['page'] = 'gracey_core_add_general_page_meta_box';

		return $callbacks;
	}

	add_filter( 'gracey_core_filter_general_meta_box_callbacks', 'gracey_core_add_general_page_meta_box_callback' );
}
