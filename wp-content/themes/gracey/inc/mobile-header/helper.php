<?php

if ( ! function_exists( 'gracey_load_page_mobile_header' ) ) {
	/**
	 * Function which loads page template module
	 */
	function gracey_load_page_mobile_header() {
		// Include mobile header template
		echo apply_filters( 'gracey_filter_mobile_header_template', gracey_get_template_part( 'mobile-header', 'templates/mobile-header' ) ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}

	add_action( 'gracey_action_page_header_template', 'gracey_load_page_mobile_header' );
}

if ( ! function_exists( 'gracey_register_mobile_navigation_menus' ) ) {
	/**
	 * Function which registers navigation menus
	 */
	function gracey_register_mobile_navigation_menus() {
		$navigation_menus = apply_filters( 'gracey_filter_register_mobile_navigation_menus', array( 'mobile-navigation' => esc_html__( 'Mobile Navigation', 'gracey' ) ) );

		if ( ! empty( $navigation_menus ) ) {
			register_nav_menus( $navigation_menus );
		}
	}

	add_action( 'gracey_action_after_include_modules', 'gracey_register_mobile_navigation_menus' );
}
