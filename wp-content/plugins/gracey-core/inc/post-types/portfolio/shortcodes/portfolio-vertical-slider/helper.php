<?php

if ( ! function_exists( 'gracey_core_add_portfolio_vertical_slider_description_meta_box' ) ) {
    /**
     * Function that add general meta box options for this module
     */
    function gracey_core_add_portfolio_vertical_slider_description_meta_box( $page, $general_tab ) {

        if ( $page ) {

            $general_tab->add_field_element(
                array(
                    'field_type'  => 'text',
                    'name'        => 'qodef_portfolio_vertical_slider_description',
                    'title'       => esc_html__( 'Description', 'gracey-core' ),
                    'description' => esc_html__( 'Enter description that will be displayed on Vertical Portfolio Slider', 'gracey-core' ),
                )
            );
        }
    }

    add_action( 'gracey_core_action_after_portfolio_meta_box_map', 'gracey_core_add_portfolio_vertical_slider_description_meta_box', 10, 2 );
}
