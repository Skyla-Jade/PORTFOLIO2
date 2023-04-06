<?php

class GraceyCore_Numbered_Text_Shortcode_Elementor extends GraceyCore_Elementor_Widget_Base {

    function __construct( array $data = [], $args = null ) {
        $this->set_shortcode_slug( 'gracey_core_numbered_text' );

        parent::__construct( $data, $args );
    }
}

gracey_core_get_elementor_widgets_manager()->register_widget_type( new GraceyCore_Numbered_Text_Shortcode_Elementor() );