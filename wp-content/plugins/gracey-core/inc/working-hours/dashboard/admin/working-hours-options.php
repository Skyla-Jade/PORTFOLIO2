<?php

if ( ! function_exists( 'gracey_core_add_working_hours_options' ) ) {
	/**
	 * Function that add general options for this module
	 */
	function gracey_core_add_working_hours_options() {
		$qode_framework = qode_framework_get_framework_root();

		$page = $qode_framework->add_options_page(
			array(
				'scope'       => GRACEY_CORE_OPTIONS_NAME,
				'type'        => 'admin',
				'slug'        => 'working-hours',
				'icon'        => 'fa fa-book',
				'title'       => esc_html__( 'Working Hours', 'gracey-core' ),
				'description' => esc_html__( 'Global Working Hours Options', 'gracey-core' ),
			)
		);

		if ( $page ) {
			$page->add_field_element(
				array(
					'field_type' => 'text',
					'name'       => 'qodef_working_hours_monday',
					'title'      => esc_html__( 'Working Hours For Monday', 'gracey-core' ),
				)
			);

			$page->add_field_element(
				array(
					'field_type' => 'text',
					'name'       => 'qodef_working_hours_tuesday',
					'title'      => esc_html__( 'Working Hours For Tuesday', 'gracey-core' ),
				)
			);

			$page->add_field_element(
				array(
					'field_type' => 'text',
					'name'       => 'qodef_working_hours_wednesday',
					'title'      => esc_html__( 'Working Hours For Wednesday', 'gracey-core' ),
				)
			);

			$page->add_field_element(
				array(
					'field_type' => 'text',
					'name'       => 'qodef_working_hours_thursday',
					'title'      => esc_html__( 'Working Hours For Thursday', 'gracey-core' ),
				)
			);

			$page->add_field_element(
				array(
					'field_type' => 'text',
					'name'       => 'qodef_working_hours_friday',
					'title'      => esc_html__( 'Working Hours For Friday', 'gracey-core' ),
				)
			);

			$page->add_field_element(
				array(
					'field_type' => 'text',
					'name'       => 'qodef_working_hours_saturday',
					'title'      => esc_html__( 'Working Hours For Saturday', 'gracey-core' ),
				)
			);

			$page->add_field_element(
				array(
					'field_type' => 'text',
					'name'       => 'qodef_working_hours_sunday',
					'title'      => esc_html__( 'Working Hours For Sunday', 'gracey-core' ),
				)
			);

			$page->add_field_element(
				array(
					'field_type' => 'checkbox',
					'name'       => 'qodef_working_hours_special_days',
					'title'      => esc_html__( 'Special Days', 'gracey-core' ),
					'options'    => array(
						'monday'    => esc_html__( 'Monday', 'gracey-core' ),
						'tuesday'   => esc_html__( 'Tuesday', 'gracey-core' ),
						'wednesday' => esc_html__( 'Wednesday', 'gracey-core' ),
						'thursday'  => esc_html__( 'Thursday', 'gracey-core' ),
						'friday'    => esc_html__( 'Friday', 'gracey-core' ),
						'saturday'  => esc_html__( 'Saturday', 'gracey-core' ),
						'sunday'    => esc_html__( 'Sunday', 'gracey-core' ),
					),
				)
			);

			$page->add_field_element(
				array(
					'field_type' => 'text',
					'name'       => 'qodef_working_hours_special_text',
					'title'      => esc_html__( 'Featured Text For Special Days', 'gracey-core' ),
				)
			);

			// Hook to include additional options after module options
			do_action( 'gracey_core_action_after_working_hours_options_map', $page );
		}
	}

	add_action( 'gracey_core_action_default_options_init', 'gracey_core_add_working_hours_options', gracey_core_get_admin_options_map_position( 'working-hours' ) );
}
