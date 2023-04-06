<?php

class GraceyCore_Product_Category_List_Shortcode_Elementor extends GraceyCore_Elementor_Widget_Base {

	function __construct( array $data = [], $args = null ) {
		$this->set_shortcode_slug( 'gracey_core_product_category_list' );

		parent::__construct( $data, $args );
	}
}

if ( qode_framework_is_installed( 'woocommerce' ) ) {
	gracey_core_get_elementor_widgets_manager()->register_widget_type( new GraceyCore_Product_Category_List_Shortcode_Elementor() );
}
