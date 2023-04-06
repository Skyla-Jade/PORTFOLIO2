<?php

if ( ! function_exists( 'gracey_core_get_subscribe_popup' ) ) {
	/**
	 * Loads subscribe popup HTML
	 */
	function gracey_core_get_subscribe_popup() {
		if ( gracey_core_get_option_value( 'admin', 'qodef_enable_subscribe_popup' ) === 'yes' && gracey_core_get_option_value( 'admin', 'qodef_subscribe_popup_contact_form' ) !== '' ) {
			gracey_core_load_subscribe_popup_template();
		}
	}

	// Get subscribe popup HTML
	add_action( 'gracey_action_before_wrapper_close_tag', 'gracey_core_get_subscribe_popup' );
}

if ( ! function_exists( 'gracey_core_load_subscribe_popup_template' ) ) {
	/**
	 * Loads HTML template with params
	 */
	function gracey_core_load_subscribe_popup_template() {
		$params                     = array();
		$params['title']            = gracey_core_get_option_value( 'admin', 'qodef_subscribe_popup_title' );
		$params['subtitle']         = gracey_core_get_option_value( 'admin', 'qodef_subscribe_popup_subtitle' );
		$background_image           = gracey_core_get_option_value( 'admin', 'qodef_subscribe_popup_background_image' );
		$params['content_style']    = ! empty( $background_image ) ? 'background-image: url(' . esc_url( wp_get_attachment_url( $background_image ) ) . ')' : '';
		$params['contact_form']     = gracey_core_get_option_value( 'admin', 'qodef_subscribe_popup_contact_form' );
		$params['enable_prevent']   = gracey_core_get_option_value( 'admin', 'qodef_enable_subscribe_popup_prevent' );
		$params['prevent_behavior'] = gracey_core_get_option_value( 'admin', 'qodef_subscribe_popup_prevent_behavior' );

		$holder_classes           = array();
		$holder_classes[]         = ! empty( $params['prevent_behavior'] ) ? 'qodef-sp-prevent-' . $params['prevent_behavior'] : 'qodef-sp-prevent-session';
		$params['holder_classes'] = implode( ' ', $holder_classes );

		echo gracey_core_get_template_part( 'subscribe-popup', 'templates/subscribe-popup', '', $params );
	}
}
