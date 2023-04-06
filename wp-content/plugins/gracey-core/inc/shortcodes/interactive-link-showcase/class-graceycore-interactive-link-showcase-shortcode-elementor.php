<?php

class GraceyCore_Interactive_Link_Showcase_Shortcode_Elementor extends GraceyCore_Elementor_Widget_Base {

	function __construct( array $data = [], $args = null ) {
		$this->set_shortcode_slug( 'gracey_core_interactive_link_showcase' );

		parent::__construct( $data, $args );
	}
}

gracey_core_get_elementor_widgets_manager()->register_widget_type( new GraceyCore_Interactive_Link_Showcase_Shortcode_Elementor() );
