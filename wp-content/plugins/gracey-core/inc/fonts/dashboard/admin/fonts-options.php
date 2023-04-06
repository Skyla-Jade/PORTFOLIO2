<?php

if ( ! function_exists( 'gracey_core_add_fonts_options' ) ) {
	/**
	 * Function that add options for this module
	 */
	function gracey_core_add_fonts_options() {
		$qode_framework = qode_framework_get_framework_root();

		$page = $qode_framework->add_options_page(
			array(
				'scope'       => GRACEY_CORE_OPTIONS_NAME,
				'type'        => 'admin',
				'slug'        => 'fonts',
				'title'       => esc_html__( 'Fonts', 'gracey-core' ),
				'description' => esc_html__( 'Global Fonts Options', 'gracey-core' ),
				'icon'        => 'fa fa-cog',
			)
		);

		if ( $page ) {
			$page->add_field_element(
				array(
					'field_type'    => 'yesno',
					'name'          => 'qodef_enable_google_fonts',
					'title'         => esc_html__( 'Enable Google Fonts', 'gracey-core' ),
					'default_value' => 'yes',
					'args'          => array(
						'custom_class' => 'qodef-enable-google-fonts',
					),
				)
			);

			$google_fonts_section = $page->add_section_element(
				array(
					'name'       => 'qodef_google_fonts_section',
					'title'      => esc_html__( 'Google Fonts Options', 'gracey-core' ),
					'dependency' => array(
						'show' => array(
							'qodef_enable_google_fonts' => array(
								'values'        => 'yes',
								'default_value' => '',
							),
						),
					),
				)
			);

			$page_repeater = $google_fonts_section->add_repeater_element(
				array(
					'name'        => 'qodef_choose_google_fonts',
					'title'       => esc_html__( 'Google Fonts to Include', 'gracey-core' ),
					'description' => esc_html__( 'Choose Google Fonts which you want to use on your website', 'gracey-core' ),
					'button_text' => esc_html__( 'Add New Google Font', 'gracey-core' ),
				)
			);

			$page_repeater->add_field_element(
				array(
					'field_type'  => 'googlefont',
					'name'        => 'qodef_choose_google_font',
					'title'       => esc_html__( 'Google Font', 'gracey-core' ),
					'description' => esc_html__( 'Choose Google Font', 'gracey-core' ),
					'args'        => array(
						'include' => 'google-fonts',
					),
				)
			);

			$google_fonts_section->add_field_element(
				array(
					'field_type'  => 'checkbox',
					'name'        => 'qodef_google_fonts_weight',
					'title'       => esc_html__( 'Google Fonts Weight', 'gracey-core' ),
					'description' => esc_html__( 'Choose a default Google Fonts weights for your website. Impact on page load time', 'gracey-core' ),
					'options'     => array(
						'100'  => esc_html__( '100 Thin', 'gracey-core' ),
						'100i' => esc_html__( '100 Thin Italic', 'gracey-core' ),
						'200'  => esc_html__( '200 Extra-Light', 'gracey-core' ),
						'200i' => esc_html__( '200 Extra-Light Italic', 'gracey-core' ),
						'300'  => esc_html__( '300 Light', 'gracey-core' ),
						'300i' => esc_html__( '300 Light Italic', 'gracey-core' ),
						'400'  => esc_html__( '400 Regular', 'gracey-core' ),
						'400i' => esc_html__( '400 Regular Italic', 'gracey-core' ),
						'500'  => esc_html__( '500 Medium', 'gracey-core' ),
						'500i' => esc_html__( '500 Medium Italic', 'gracey-core' ),
						'600'  => esc_html__( '600 Semi-Bold', 'gracey-core' ),
						'600i' => esc_html__( '600 Semi-Bold Italic', 'gracey-core' ),
						'700'  => esc_html__( '700 Bold', 'gracey-core' ),
						'700i' => esc_html__( '700 Bold Italic', 'gracey-core' ),
						'800'  => esc_html__( '800 Extra-Bold', 'gracey-core' ),
						'800i' => esc_html__( '800 Extra-Bold Italic', 'gracey-core' ),
						'900'  => esc_html__( '900 Ultra-Bold', 'gracey-core' ),
						'900i' => esc_html__( '900 Ultra-Bold Italic', 'gracey-core' ),
					),
				)
			);

			$google_fonts_section->add_field_element(
				array(
					'field_type'  => 'checkbox',
					'name'        => 'qodef_google_fonts_subset',
					'title'       => esc_html__( 'Google Fonts Style', 'gracey-core' ),
					'description' => esc_html__( 'Choose a default Google Fonts style for your website. Impact on page load time', 'gracey-core' ),
					'options'     => array(
						'latin'        => esc_html__( 'Latin', 'gracey-core' ),
						'latin-ext'    => esc_html__( 'Latin Extended', 'gracey-core' ),
						'cyrillic'     => esc_html__( 'Cyrillic', 'gracey-core' ),
						'cyrillic-ext' => esc_html__( 'Cyrillic Extended', 'gracey-core' ),
						'greek'        => esc_html__( 'Greek', 'gracey-core' ),
						'greek-ext'    => esc_html__( 'Greek Extended', 'gracey-core' ),
						'vietnamese'   => esc_html__( 'Vietnamese', 'gracey-core' ),
					),
				)
			);

			$page_repeater = $page->add_repeater_element(
				array(
					'name'        => 'qodef_custom_fonts',
					'title'       => esc_html__( 'Custom Fonts', 'gracey-core' ),
					'description' => esc_html__( 'Add custom fonts', 'gracey-core' ),
					'button_text' => esc_html__( 'Add New Custom Font', 'gracey-core' ),
				)
			);

			$page_repeater->add_field_element(
				array(
					'field_type' => 'file',
					'name'       => 'qodef_custom_font_ttf',
					'title'      => esc_html__( 'Custom Font TTF', 'gracey-core' ),
					'args'       => array(
						'allowed_type' => 'application/octet-stream',
					),
				)
			);

			$page_repeater->add_field_element(
				array(
					'field_type' => 'file',
					'name'       => 'qodef_custom_font_otf',
					'title'      => esc_html__( 'Custom Font OTF', 'gracey-core' ),
					'args'       => array(
						'allowed_type' => 'application/octet-stream',
					),
				)
			);

			$page_repeater->add_field_element(
				array(
					'field_type' => 'file',
					'name'       => 'qodef_custom_font_woff',
					'title'      => esc_html__( 'Custom Font WOFF', 'gracey-core' ),
					'args'       => array(
						'allowed_type' => 'application/octet-stream',
					),
				)
			);

			$page_repeater->add_field_element(
				array(
					'field_type' => 'file',
					'name'       => 'qodef_custom_font_woff2',
					'title'      => esc_html__( 'Custom Font WOFF2', 'gracey-core' ),
					'args'       => array(
						'allowed_type' => 'application/octet-stream',
					),
				)
			);

			$page_repeater->add_field_element(
				array(
					'field_type' => 'text',
					'name'       => 'qodef_custom_font_name',
					'title'      => esc_html__( 'Custom Font Name', 'gracey-core' ),
				)
			);

			// Hook to include additional options after module options
			do_action( 'gracey_core_action_after_page_fonts_options_map', $page );
		}
	}

	add_action( 'gracey_core_action_default_options_init', 'gracey_core_add_fonts_options', gracey_core_get_admin_options_map_position( 'fonts' ) );
}
