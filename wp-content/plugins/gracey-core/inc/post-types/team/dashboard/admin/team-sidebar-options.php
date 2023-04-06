<?php

if ( ! function_exists( 'gracey_core_add_team_archive_sidebar_options' ) ) {
	/**
	 * Function that add sidebar options for team archive module
	 */
	function gracey_core_add_team_archive_sidebar_options( $tab ) {

		if ( $tab ) {
			$tab->add_field_element(
				array(
					'field_type'    => 'select',
					'name'          => 'qodef_team_archive_sidebar_layout',
					'title'         => esc_html__( 'Sidebar Layout', 'gracey-core' ),
					'description'   => esc_html__( 'Choose default sidebar layout for team archives', 'gracey-core' ),
					'default_value' => 'no-sidebar',
					'options'       => gracey_core_get_select_type_options_pool( 'sidebar_layouts', false ),
				)
			);

			$custom_sidebars = gracey_core_get_custom_sidebars();
			if ( ! empty( $custom_sidebars ) && count( $custom_sidebars ) > 1 ) {
				$tab->add_field_element(
					array(
						'field_type'  => 'select',
						'name'        => 'qodef_team_archive_custom_sidebar',
						'title'       => esc_html__( 'Custom Sidebar', 'gracey-core' ),
						'description' => esc_html__( 'Choose a custom sidebar to display on team archives', 'gracey-core' ),
						'options'     => $custom_sidebars,
					)
				);
			}

			$tab->add_field_element(
				array(
					'field_type'  => 'select',
					'name'        => 'qodef_team_archive_sidebar_grid_gutter',
					'title'       => esc_html__( 'Set Grid Gutter', 'gracey-core' ),
					'description' => esc_html__( 'Choose grid gutter size to set space between content and sidebar', 'gracey-core' ),
					'options'     => gracey_core_get_select_type_options_pool( 'items_space' ),
				)
			);
		}
	}

	add_action( 'gracey_core_action_after_team_options_archive', 'gracey_core_add_team_archive_sidebar_options' );
}

if ( ! function_exists( 'gracey_core_add_team_single_sidebar_options' ) ) {
	/**
	 * Function that add sidebar options for team single module
	 */
	function gracey_core_add_team_single_sidebar_options( $tab ) {

		if ( $tab ) {
			$tab->add_field_element(
				array(
					'field_type'    => 'select',
					'name'          => 'qodef_team_single_sidebar_layout',
					'title'         => esc_html__( 'Sidebar Layout', 'gracey-core' ),
					'description'   => esc_html__( 'Choose default sidebar layout for team singles', 'gracey-core' ),
					'default_value' => 'no-sidebar',
					'options'       => gracey_core_get_select_type_options_pool( 'sidebar_layouts', false ),
				)
			);

			$custom_sidebars = gracey_core_get_custom_sidebars();
			if ( ! empty( $custom_sidebars ) && count( $custom_sidebars ) > 1 ) {
				$tab->add_field_element(
					array(
						'field_type'  => 'select',
						'name'        => 'qodef_team_single_custom_sidebar',
						'title'       => esc_html__( 'Custom Sidebar', 'gracey-core' ),
						'description' => esc_html__( 'Choose a custom sidebar to display on team singles', 'gracey-core' ),
						'options'     => $custom_sidebars,
					)
				);
			}

			$tab->add_field_element(
				array(
					'field_type'  => 'select',
					'name'        => 'qodef_team_single_sidebar_grid_gutter',
					'title'       => esc_html__( 'Set Grid Gutter', 'gracey-core' ),
					'description' => esc_html__( 'Choose grid gutter size to set space between content and sidebar', 'gracey-core' ),
					'options'     => gracey_core_get_select_type_options_pool( 'items_space' ),
				)
			);
		}
	}

	add_action( 'gracey_core_action_after_team_options_single', 'gracey_core_add_team_single_sidebar_options' );
}
