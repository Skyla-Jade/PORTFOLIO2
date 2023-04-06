<?php

if ( ! function_exists( 'gracey_core_add_page_mobile_header_meta_box' ) ) {
	/**
	 * Function that add general meta box options for this module
	 *
	 * @param object $page
	 */
	function gracey_core_add_page_mobile_header_meta_box( $page ) {

		if ( $page ) {
			$mobile_header_tab = $page->add_tab_element(
				array(
					'name'        => 'tab-mobile-header',
					'icon'        => 'fa fa-cog',
					'title'       => esc_html__( 'Mobile Header Settings', 'gracey-core' ),
					'description' => esc_html__( 'Mobile header layout settings', 'gracey-core' ),
				)
			);

			$mobile_header_tab->add_field_element(
				array(
					'field_type'  => 'select',
					'name'        => 'qodef_mobile_header_layout',
					'title'       => esc_html__( 'Mobile Header Layout', 'gracey-core' ),
					'description' => esc_html__( 'Choose a mobile header layout to set for your website', 'gracey-core' ),
					'args'        => array( 'images' => true ),
					'options'     => gracey_core_header_radio_to_select_options( apply_filters( 'gracey_core_filter_mobile_header_layout_option', array() ) ),
				)
			);

			$header_types = gracey_core_header_radio_to_select_options( apply_filters( 'gracey_core_filter_mobile_header_layout_option', array() ) );

			foreach ($header_types as $key => $value) {
			    if ( $key !== '' ) {
                    $mobile_header_tab->add_field_element(
                        array(
                            'field_type'  => 'color',
                            'name'        => 'qodef_' . $key . '_mobile_header_background_color',
                            'title'       => esc_html__( 'Mobile Header Background Color', 'gracey-core' ),
                            'dependency' => array(
                                'show' => array(
                                    'qodef_mobile_header_layout' => array(
                                        'values'        => $key,
                                        'default_value' => '',
                                    ),
                                ),
                            ),
                        )
                    );
                }
            }

            $mobile_header_tab->add_field_element(
                array(
                    'field_type'  => 'select',
                    'name'        => 'qodef_minimal_mobile_header_skin',
                    'title'       => esc_html__( 'Minimal Header Skin', 'gracey-core' ),
                    'description' => esc_html__( 'Choose a predefined header style for minimal mobile header', 'gracey-core' ),
                    'options'     => array(
                        ''      => esc_html__( 'Default', 'gracey-core' ),
                        'dark'  => esc_html__( 'Dark', 'gracey-core' ),
                        'light' => esc_html__( 'Light', 'gracey-core' ),
                    ),
                    'dependency'  => array(
                        'show' => array(
                            'qodef_mobile_header_layout' => array(
                                'values'        => 'minimal',
                                'default_value' => '',
                            ),
                        ),
                    ),
                )
            );

			// Hook to include additional options after module options
			do_action( 'gracey_core_action_after_page_mobile_header_meta_map', $mobile_header_tab );
		}
	}

	add_action( 'gracey_core_action_after_general_meta_box_map', 'gracey_core_add_page_mobile_header_meta_box' );
}

if ( ! function_exists( 'gracey_core_add_general_mobile_header_meta_box_callback' ) ) {
	/**
	 * Function that set current meta box callback as general callback functions
	 *
	 * @param array $callbacks
	 *
	 * @return array
	 */
	function gracey_core_add_general_mobile_header_meta_box_callback( $callbacks ) {
		$callbacks['mobile-header'] = 'gracey_core_add_page_mobile_header_meta_box';

		return $callbacks;
	}

	add_filter( 'gracey_core_filter_general_meta_box_callbacks', 'gracey_core_add_general_mobile_header_meta_box_callback' );
}
