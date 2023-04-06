<?php

if ( ! function_exists( 'gracey_core_add_info_section_variation_background_text' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function gracey_core_add_info_section_variation_background_text( $variations ) {
		$variations['background-text'] = esc_html__( 'Background Text', 'gracey-core' );

		return $variations;
	}

	add_filter( 'gracey_core_filter_info_section_layouts', 'gracey_core_add_info_section_variation_background_text' );
}

if ( ! function_exists( 'gracey_core_add_info_section_options_background_text' ) ) {
	/**
	 * Function that add additional options for variation layout
	 *
	 * @param array $options
	 * @param string $default_layout
	 *
	 * @return array
	 */
	function gracey_core_add_info_section_options_background_text( $options, $default_layout ) {
		$background_text_options   = array();
		$background_text_option    = array(
			'field_type' => 'text',
			'name'       => 'background_text_text',
			'title'      => esc_html__( 'Background Text', 'gracey-core' ),
			'group'      => esc_html__( 'Background Text', 'gracey-core' ),
		);
		$background_text_options[] = $background_text_option;

		$background_text_position_option = array(
			'field_type' => 'select',
			'name'       => 'background_text_position',
			'title'      => esc_html__( 'Background Text Position', 'gracey-core' ),
			'options'    => array(
				'top-left'     => esc_html__( 'Top Left', 'gracey-core' ),
				'top-right'    => esc_html__( 'Top Right', 'gracey-core' ),
				'bottom-right' => esc_html__( 'Bottom Left', 'gracey-core' ),
				'bottom-left'  => esc_html__( 'Bottom Right', 'gracey-core' ),
				'center'       => esc_html__( 'Center', 'gracey-core' ),
			),
			'group'      => esc_html__( 'Background Text', 'gracey-core' ),
		);

		$background_text_options[] = $background_text_position_option;

		return array_merge( $options, $background_text_options );
	}

	add_filter( 'gracey_core_filter_info_section_extra_options', 'gracey_core_add_info_section_options_background_text', 10, 2 );
}

if ( ! function_exists( 'gracey_core_add_info_section_classes_background_text' ) ) {
	/**
	 * Function that return additional holder classes for this module
	 *
	 * @param array $holder_classes
	 * @param array $atts
	 *
	 * @return array
	 */
	function gracey_core_add_info_section_classes_background_text( $holder_classes, $atts ) {

		if ( 'background-text' === $atts['layout'] ) {
			$holder_classes[] = ! empty( $atts['background_text_position'] ) ? 'qodef-background-text-pos--' . $atts['background_text_position'] : 'qodef-background-text-pos--top-left';
		}

		return $holder_classes;
	}

	add_filter( 'gracey_core_filter_info_section_variation_classes', 'gracey_core_add_info_section_classes_background_text', 10, 2 );
}
