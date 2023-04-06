<?php

if ( ! function_exists( 'gracey_core_add_portfolio_list_variation_info_below' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function gracey_core_add_portfolio_list_variation_info_below( $variations ) {
		$variations['info-below'] = esc_html__( 'Info Below', 'gracey-core' );

		return $variations;
	}

	add_filter( 'gracey_core_filter_portfolio_list_layouts', 'gracey_core_add_portfolio_list_variation_info_below' );
}

if ( ! function_exists( 'gracey_core_add_portfolio_list_options_info_below' ) ) {
	/**
	 * Function that add additional options for variation layout
	 *
	 * @param array $options
	 *
	 * @return array
	 */
	function gracey_core_add_portfolio_list_options_info_below( $options ) {
		$info_below_options   = array();
		$margin_option        = array(
			'field_type' => 'text',
			'name'       => 'info_below_content_margin_top',
			'title'      => esc_html__( 'Content Top Margin', 'gracey-core' ),
			'dependency' => array(
				'show' => array(
					'layout' => array(
						'values'        => 'info-below',
						'default_value' => '',
					),
				),
			),
			'group'      => esc_html__( 'Layout', 'gracey-core' ),
		);
		$info_below_options[] = $margin_option;

		return array_merge( $options, $info_below_options );
	}

	add_filter( 'gracey_core_filter_portfolio_list_extra_options', 'gracey_core_add_portfolio_list_options_info_below' );
}
