<?php

if ( ! function_exists( 'gracey_core_add_portfolio_single_meta_box' ) ) {
	/**
	 * Function that add general options for this module
	 */
	function gracey_core_add_portfolio_single_meta_box() {
		$qode_framework = qode_framework_get_framework_root();

		$page = $qode_framework->add_options_page(
			array(
				'scope'  => array( 'portfolio-item' ),
				'type'   => 'meta',
				'slug'   => 'portfolio-item',
				'title'  => esc_html__( 'Portfolio Settings', 'gracey-core' ),
				'layout' => 'tabbed',
			)
		);

		if ( $page ) {

			$general_tab = $page->add_tab_element(
				array(
					'name'        => 'tab-general',
					'icon'        => 'fa fa-cog',
					'title'       => esc_html__( 'General Settings', 'gracey-core' ),
					'description' => esc_html__( 'General portfolio settings', 'gracey-core' ),
				)
			);

			$general_tab->add_field_element(
				array(
					'field_type'  => 'select',
					'name'        => 'qodef_portfolio_single_layout',
					'title'       => esc_html__( 'Single Layout', 'gracey-core' ),
					'description' => esc_html__( 'Choose default layout for portfolio single', 'gracey-core' ),
					'options'     => apply_filters( 'gracey_core_filter_portfolio_single_layout_options', array( '' => esc_html__( 'Default', 'gracey-core' ) ) ),
				)
			);

			$section_columns = $general_tab->add_section_element(
				array(
					'name'       => 'qodef_portfolio_columns_section',
					'dependency' => array(
						'show' => array(
							'qodef_portfolio_single_layout' => array(
								'values'        => array(
									'masonry-big',
									'masonry-small',
									'gallery-big',
									'gallery-small',
								),
								'default_value' => '',
							),
						),
					),
				)
			);

			$section_columns->add_field_element(
				array(
					'field_type' => 'select',
					'name'       => 'qodef_portfolio_columns_number',
					'title'      => esc_html__( 'Number of Columns', 'gracey-core' ),
					'options'    => gracey_core_get_select_type_options_pool( 'columns_number' ),
				)
			);

			$section_columns->add_field_element(
				array(
					'field_type' => 'select',
					'name'       => 'qodef_portfolio_space_between_items',
					'title'      => esc_html__( 'Space Between Items', 'gracey-core' ),
					'options'    => gracey_core_get_select_type_options_pool( 'items_space' ),
				)
			);

			$section_media = $general_tab->add_section_element(
				array(
					'name'        => 'qodef_portfolio_media_section',
					'title'       => esc_html__( 'Media Settings', 'gracey-core' ),
					'description' => esc_html__( 'Media that will be displayed on portfolio page', 'gracey-core' ),
				)
			);

			$media_repeater = $section_media->add_repeater_element(
				array(
					'name'        => 'qodef_portfolio_media',
					'title'       => esc_html__( 'Media Items', 'gracey-core' ),
					'description' => esc_html__( 'Enter media items for this portfolio', 'gracey-core' ),
					'button_text' => esc_html__( 'Add Media', 'gracey-core' ),
				)
			);

			$media_repeater->add_field_element(
				array(
					'field_type'    => 'select',
					'name'          => 'qodef_portfolio_media_type',
					'title'         => esc_html__( 'Media Item Type', 'gracey-core' ),
					'options'       => array(
						'gallery' => esc_html__( 'Gallery', 'gracey-core' ),
						'image'   => esc_html__( 'Image', 'gracey-core' ),
						'video'   => esc_html__( 'Video', 'gracey-core' ),
						'audio'   => esc_html__( 'Audio', 'gracey-core' ),
					),
					'default_value' => 'gallery',
				)
			);

			$media_repeater->add_field_element(
				array(
					'field_type' => 'image',
					'name'       => 'qodef_portfolio_gallery',
					'title'      => esc_html__( 'Upload Portfolio Images', 'gracey-core' ),
					'multiple'   => 'yes',
					'dependency' => array(
						'show' => array(
							'qodef_portfolio_media_type' => array(
								'values'        => 'gallery',
								'default_value' => 'gallery',
							),
						),
					),
				)
			);

			$media_repeater->add_field_element(
				array(
					'field_type' => 'image',
					'name'       => 'qodef_portfolio_image',
					'title'      => esc_html__( 'Upload Portfolio Image', 'gracey-core' ),
					'dependency' => array(
						'show' => array(
							'qodef_portfolio_media_type' => array(
								'values'        => 'image',
								'default_value' => 'gallery',
							),
						),
					),
				)
			);

			$media_repeater->add_field_element(
				array(
					'field_type'  => 'text',
					'name'        => 'qodef_portfolio_video',
					'title'       => esc_html__( 'Video URL', 'gracey-core' ),
					'description' => esc_html__( 'Enter your video URL', 'gracey-core' ),
					'dependency'  => array(
						'show' => array(
							'qodef_portfolio_media_type' => array(
								'values'        => 'video',
								'default_value' => 'gallery',
							),
						),
					),
				)
			);

			$media_repeater->add_field_element(
				array(
					'field_type'  => 'text',
					'name'        => 'qodef_portfolio_audio',
					'title'       => esc_html__( 'Audio URL', 'gracey-core' ),
					'description' => esc_html__( 'Enter your audio URL', 'gracey-core' ),
					'dependency'  => array(
						'show' => array(
							'qodef_portfolio_media_type' => array(
								'values'        => 'audio',
								'default_value' => 'gallery',
							),
						),
					),
				)
			);

			$section_info = $general_tab->add_section_element(
				array(
					'name'        => 'qodef_portfolio_info_section',
					'title'       => esc_html__( 'Info Settings', 'gracey-core' ),
					'description' => esc_html__( 'Info that will be displayed on portfolio page', 'gracey-core' ),
				)
			);

			$info_items_repeater = $section_info->add_repeater_element(
				array(
					'name'        => 'qodef_portfolio_info_items',
					'title'       => esc_html__( 'Info Items', 'gracey-core' ),
					'description' => esc_html__( 'Enter additional info for portoflio item', 'gracey-core' ),
					'button_text' => esc_html__( 'Add Item', 'gracey-core' ),
				)
			);

			$info_items_repeater->add_field_element(
				array(
					'field_type' => 'text',
					'name'       => 'qodef_info_item_label',
					'title'      => esc_html__( 'Item Label', 'gracey-core' ),
				)
			);

			$info_items_repeater->add_field_element(
				array(
					'field_type' => 'text',
					'name'       => 'qodef_info_item_value',
					'title'      => esc_html__( 'Item Text', 'gracey-core' ),
				)
			);

			$info_items_repeater->add_field_element(
				array(
					'field_type' => 'text',
					'name'       => 'qodef_info_item_link',
					'title'      => esc_html__( 'Item Link', 'gracey-core' ),
				)
			);

			$info_items_repeater->add_field_element(
				array(
					'field_type' => 'select',
					'name'       => 'qodef_info_item_target',
					'title'      => esc_html__( 'Item Target', 'gracey-core' ),
					'options'    => gracey_core_get_select_type_options_pool( 'link_target' ),
				)
			);

			// Hook to include additional options after module options
			do_action( 'gracey_core_action_after_portfolio_meta_box_map', $page, $general_tab );
		}
	}

	add_action( 'gracey_core_action_default_meta_boxes_init', 'gracey_core_add_portfolio_single_meta_box' );
}

if ( ! function_exists( 'gracey_core_include_general_meta_boxes_for_portfolio_single' ) ) {
	/**
	 * Function that add general meta box options for this module
	 */
	function gracey_core_include_general_meta_boxes_for_portfolio_single() {
		$callbacks = gracey_core_general_meta_box_callbacks();

		if ( ! empty( $callbacks ) ) {
			foreach ( $callbacks as $module => $callback ) {

				if ( 'page-sidebar' !== $module ) {
					add_action( 'gracey_core_action_after_portfolio_meta_box_map', $callback );
				}
			}
		}
	}

	add_action( 'gracey_core_action_default_meta_boxes_init', 'gracey_core_include_general_meta_boxes_for_portfolio_single', 8 ); // Permission 8 is set in order to load it before default meta box function
}
