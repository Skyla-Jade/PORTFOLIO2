<?php

class GraceyCore_Working_Hours_List_Shortcode_Elementor extends GraceyCore_Elementor_Widget_Base {

	function __construct( array $data = [], $args = null ) {
		$this->set_shortcode_slug( 'gracey_core_working_hours_list' );

		parent::__construct( $data, $args );
	}
}

gracey_core_get_elementor_widgets_manager()->register_widget_type( new GraceyCore_Working_Hours_List_Shortcode_Elementor() );
