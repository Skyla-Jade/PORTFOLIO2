<?php

class GraceyCore_Highlight_Shortcode_Elementor extends GraceyCore_Elementor_Widget_Base {

	function __construct( array $data = [], $args = null ) {
		$this->set_shortcode_slug( 'gracey_core_highlight' );

		parent::__construct( $data, $args );
	}
}

gracey_core_get_elementor_widgets_manager()->register_widget_type( new GraceyCore_Highlight_Shortcode_Elementor() );
