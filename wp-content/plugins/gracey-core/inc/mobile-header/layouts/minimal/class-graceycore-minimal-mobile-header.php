<?php

class GraceyCore_Minimal_Mobile_Header extends GraceyCore_Mobile_Header {
	private static $instance;

	public function __construct() {
		$this->set_layout( 'minimal' );
		$this->default_header_height = 70;

		add_action( 'gracey_action_before_wrapper_close_tag', array( $this, 'fullscreen_menu_template' ) );

        add_filter( 'gracey_core_filter_available_mobile_header_logo_images', array( $this, 'set_logo_image' ) );

		parent::__construct();
	}

	/**
	 * @return GraceyCore_Minimal_Mobile_Header
	 */
	public static function get_instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	function fullscreen_menu_template() {
		$header = gracey_core_get_post_value_through_levels( 'qodef_header_layout' );

		if ( 'minimal' != $header ) {
			$parameters = array(
				'fullscreen_menu_in_grid' => 'yes' === gracey_core_get_post_value_through_levels( 'qodef_fullscreen_menu_in_grid' ),
			);

			gracey_core_template_part( 'fullscreen-menu', 'templates/full-screen-menu', '', $parameters );
		}
	}

	function set_logo_image() {
		$logo_height         = gracey_core_get_post_value_through_levels( 'qodef_logo_height' );
		$logo_dark_image_id  = gracey_core_get_post_value_through_levels( 'qodef_logo_dark' );
		$logo_light_image_id = gracey_core_get_post_value_through_levels( 'qodef_logo_light' );
		$customizer_logo     = gracey_core_get_customizer_logo();

		$parameters = array(
			'logo_height'      => ! empty( $logo_height ) ? 'height:' . intval( $logo_height ) . 'px' : '',
			'logo_dark_image'  => '',
			'logo_light_image' => '',
		);

		if ( ! empty( $logo_dark_image_id ) ) {
			$logo_dark_image_attr = array(
				'class'    => 'qodef-header-logo-image qodef--dark',
				'itemprop' => 'image',
				'alt'      => esc_attr__( 'logo dark', 'gracey-core' ),
			);

			$image      = wp_get_attachment_image( $logo_dark_image_id, 'full', false, $logo_dark_image_attr );
			$image_html = ! empty( $image ) ? $image : qode_framework_get_image_html_from_src( $logo_dark_image_id, $logo_dark_image_attr );

			$parameters['logo_dark_image'] = $image_html;
		}

		if ( ! empty( $logo_light_image_id ) ) {
			$logo_light_image_attr = array(
				'class'    => 'qodef-header-logo-image qodef--light',
				'itemprop' => 'image',
				'alt'      => esc_attr__( 'logo light', 'gracey-core' ),
			);

			$image      = wp_get_attachment_image( $logo_light_image_id, 'full', false, $logo_light_image_attr );
			$image_html = ! empty( $image ) ? $image : qode_framework_get_image_html_from_src( $logo_light_image_id, $logo_light_image_attr );

			$parameters['logo_light_image'] = $image_html;
		}

		if ( ! empty( $logo_dark_image_id ) || ! empty( $logo_light_image_id ) ) {
			gracey_core_template_part( 'mobile-header/layouts/minimal/templates', 'parts/mobile-logo-light-dark', '', $parameters );
		} elseif ( ! empty( $customizer_logo ) ) {
			echo qode_framework_wp_kses_html( 'html', $customizer_logo );
		}
	}
}
