<?php

if ( ! function_exists( 'gracey_core_add_team_single_meta_box' ) ) {
	/**
	 * Function that add general options for this module
	 */
	function gracey_core_add_team_single_meta_box() {
		$qode_framework = qode_framework_get_framework_root();
		$has_single     = gracey_core_team_has_single();

		$page = $qode_framework->add_options_page(
			array(
				'scope' => array( 'team' ),
				'type'  => 'meta',
				'slug'  => 'team',
				'title' => esc_html__( 'Team Single', 'gracey-core' ),
			)
		);

		if ( $page ) {
			$section = $page->add_section_element(
				array(
					'name'        => 'qodef_team_general_section',
					'title'       => esc_html__( 'General Settings', 'gracey-core' ),
					'description' => esc_html__( 'General information about team member.', 'gracey-core' ),
				)
			);

			if ( $has_single ) {
				$section->add_field_element(
					array(
						'field_type'  => 'select',
						'name'        => 'qodef_team_single_layout',
						'title'       => esc_html__( 'Single Layout', 'gracey-core' ),
						'description' => esc_html__( 'Choose default layout for team single', 'gracey-core' ),
						'options'     => array(
							'' => esc_html__( 'Default', 'gracey-core' ),
						),
					)
				);
			}

			$section->add_field_element(
				array(
					'field_type'  => 'text',
					'name'        => 'qodef_team_member_role',
					'title'       => esc_html__( 'Role', 'gracey-core' ),
					'description' => esc_html__( 'Enter team member role', 'gracey-core' ),
				)
			);

			$social_icons_repeater = $section->add_repeater_element(
				array(
					'name'        => 'qodef_team_member_social_icons',
					'title'       => esc_html__( 'Social Networks', 'gracey-core' ),
					'description' => esc_html__( 'Populate team member social networks info', 'gracey-core' ),
					'button_text' => esc_html__( 'Add New Network', 'gracey-core' ),
				)
			);

			$social_icons_repeater->add_field_element(
				array(
					'field_type' => 'iconpack',
					'name'       => 'qodef_team_member_icon',
					'title'      => esc_html__( 'Icon', 'gracey-core' ),
				)
			);

			$social_icons_repeater->add_field_element(
				array(
					'field_type' => 'text',
					'name'       => 'qodef_team_member_icon_link',
					'title'      => esc_html__( 'Icon Link', 'gracey-core' ),
				)
			);

			$social_icons_repeater->add_field_element(
				array(
					'field_type' => 'select',
					'name'       => 'qodef_team_member_icon_target',
					'title'      => esc_html__( 'Icon Target', 'gracey-core' ),
					'options'    => gracey_core_get_select_type_options_pool( 'link_target' ),
				)
			);

			if ( $has_single ) {
				$section->add_field_element(
					array(
						'field_type'  => 'date',
						'name'        => 'qodef_team_member_birth_date',
						'title'       => esc_html__( 'Birth Date', 'gracey-core' ),
						'description' => esc_html__( 'Enter team member birth date', 'gracey-core' ),
					)
				);

				$section->add_field_element(
					array(
						'field_type'  => 'text',
						'name'        => 'qodef_team_member_email',
						'title'       => esc_html__( 'E-mail', 'gracey-core' ),
						'description' => esc_html__( 'Enter team member e-mail address', 'gracey-core' ),
					)
				);

				$section->add_field_element(
					array(
						'field_type'  => 'text',
						'name'        => 'qodef_team_member_address',
						'title'       => esc_html__( 'Address', 'gracey-core' ),
						'description' => esc_html__( 'Enter team member address', 'gracey-core' ),
					)
				);

				$section->add_field_element(
					array(
						'field_type'  => 'text',
						'name'        => 'qodef_team_member_education',
						'title'       => esc_html__( 'Education', 'gracey-core' ),
						'description' => esc_html__( 'Enter team member education', 'gracey-core' ),
					)
				);

				$section->add_field_element(
					array(
						'field_type'  => 'file',
						'name'        => 'qodef_team_member_resume',
						'title'       => esc_html__( 'Resume', 'gracey-core' ),
						'description' => esc_html__( 'Upload team member resume', 'gracey-core' ),
						'args'        => array(
							'allowed_type' => '[application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document]',
						),
					)
				);
			}

			// Hook to include additional options after module options
			do_action( 'gracey_core_action_after_team_meta_box_map', $page, $has_single );
		}
	}

	add_action( 'gracey_core_action_default_meta_boxes_init', 'gracey_core_add_team_single_meta_box' );
}
