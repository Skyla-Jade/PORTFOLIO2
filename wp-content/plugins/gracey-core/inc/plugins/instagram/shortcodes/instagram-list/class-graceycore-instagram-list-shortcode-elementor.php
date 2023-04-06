<?php

class GraceyCore_Instagram_List_Shortcode_Elementor extends GraceyCore_Elementor_Widget_Base {

	function __construct( array $data = [], $args = null ) {
		$this->set_shortcode_slug( 'gracey_core_instagram_list' );

		parent::__construct( $data, $args );
	}
}

if ( qode_framework_is_installed( 'instagram' ) ) {
	gracey_core_get_elementor_widgets_manager()->register_widget_type( new GraceyCore_Instagram_List_Shortcode_Elementor() );
}
