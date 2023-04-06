<?php

class GraceyCore_Order_Tracking_Shortcode_Elementor extends GraceyCore_Elementor_Widget_Base {

	function __construct( array $data = [], $args = null ) {
		$this->set_shortcode_slug( 'gracey_core_order_tracking' );

		parent::__construct( $data, $args );
	}
}

if ( qode_framework_is_installed( 'woocommerce' ) ) {
	gracey_core_get_elementor_widgets_manager()->register_widget_type( new GraceyCore_Order_Tracking_Shortcode_Elementor() );
}


// class GraceyCore_Icon_Shortcode_Elementor extends GraceyCore_Elementor_Widget_Base {
//
// 	function __construct( array $data = [], $args = null ) {
// 		$this->set_shortcode_slug( 'gracey_core_icon' );
//
// 		parent::__construct( $data, $args );
// 	}
// }
//
// gracey_core_get_elementor_widgets_manager()->register_widget_type( new GraceyCore_Icon_Shortcode_Elementor() );
