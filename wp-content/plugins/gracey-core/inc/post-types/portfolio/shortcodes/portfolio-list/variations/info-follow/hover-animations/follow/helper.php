<?php

if ( ! function_exists( 'gracey_core_filter_portfolio_list_info_follow' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function gracey_core_filter_portfolio_list_info_follow( $variations ) {
		$variations['follow'] = esc_html__( 'Follow', 'gracey-core' );

		return $variations;
	}

	add_filter( 'gracey_core_filter_portfolio_list_info_follow_animation_options', 'gracey_core_filter_portfolio_list_info_follow' );
}

if ( ! function_exists( 'gracey_core_add_portfolio_list_options_info_follow' ) ) {
	/**
	 * Function that add additional options for variation layout
	 *
	 * @param array $options
	 *
	 * @return array
	 */
	function gracey_core_add_portfolio_list_options_info_follow( $options ) {
		$info_follow_options   = array();
		$bg_option        = array(
			'field_type' => 'select',
			'name'       => 'info_follow_background',
			'title'      => esc_html__( 'Enable Info Follow Background', 'gracey-core' ),
			'options'    => gracey_core_get_select_type_options_pool( 'yes_no', false ),
			'dependency' => array(
				'show' => array(
					'layout' => array(
						'values'        => 'info-follow',
						'default_value' => '',
					),
				),
			),
			'group'      => esc_html__( 'Layout', 'gracey-core' ),
		);
		$info_follow_options[] = $bg_option;
		
		return array_merge( $options, $info_follow_options );
	}
	
	add_filter( 'gracey_core_filter_portfolio_list_extra_options', 'gracey_core_add_portfolio_list_options_info_follow' );
}
