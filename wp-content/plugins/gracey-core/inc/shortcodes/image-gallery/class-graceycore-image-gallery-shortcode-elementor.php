<?php

class GraceyCore_Image_Gallery_Shortcode_Elementor extends GraceyCore_Elementor_Widget_Base {

	function __construct( array $data = [], $args = null ) {
		$this->set_shortcode_slug( 'gracey_core_image_gallery' );

		parent::__construct( $data, $args );
	}
}

gracey_core_get_elementor_widgets_manager()->register_widget_type( new GraceyCore_Image_Gallery_Shortcode_Elementor() );
