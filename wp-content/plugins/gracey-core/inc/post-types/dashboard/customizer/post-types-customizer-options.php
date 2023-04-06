<?php

if ( ! function_exists( 'gracey_core_add_post_types_customizer_options' ) ) {
	/**
	 * Function that add customizer options for this module
	 */
	function gracey_core_add_post_types_customizer_options( $page ) {

		if ( $page ) {

			$page->add_field_element(
				array(
					'field_type'  => 'section',
					'name'        => 'gracey_core_performance_post_types_section',
					'title'       => esc_html__( 'Custom Post Types', 'gracey-core' ),
					'description' => esc_html__( 'Here you can select specific features to disable. Note that disabling certain features and functionality which you will not be needing or which you are otherwise not utilizing in any way can have a positive effect to the overall performance of your site.', 'gracey-core' ),
				)
			);

			foreach ( glob( GRACEY_CORE_CPT_PATH . '/*', GLOB_ONLYDIR ) as $post_type ) {
				$post_type_name = basename( $post_type );

				if ( 'dashboard' !== $post_type_name ) {
					$post_type_label = ucwords( str_replace( '-', ' ', $post_type_name ) );
					$post_type_name  = str_replace( '-', '_', $post_type_name );

					$page->add_field_element(
						array(
							'field_type'        => 'setting',
							'option_type'       => 'option',
							'name'              => "gracey_core_performance_post_type_{$post_type_name}",
							'default_value'     => false,
							'sanitize_callback' => 'sanitize_checkbox',
						)
					);

					$page->add_field_element(
						array(
							'field_type'  => 'control',
							'option_type' => 'checkbox',
							'section'     => 'gracey_core_performance_post_types_section',
							'settings'    => "gracey_core_performance_post_type_{$post_type_name}",
							'name'        => "gracey_core_performance_post_type_{$post_type_name}_control",
							'title'       => $post_type_label,
						)
					);
				}
			}

			// Hook to include additional options after module options
			do_action( 'gracey_core_action_after_post_types_customizer_options', $page );
		}
	}

	add_action( 'gracey_core_action_performance_customizer_options', 'gracey_core_add_post_types_customizer_options' );
}
