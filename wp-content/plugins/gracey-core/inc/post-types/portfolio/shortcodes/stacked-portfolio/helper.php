<?php

if ( ! function_exists( 'gracey_core_add_stacked_portfolio_offset_meta_box' ) ) {
    /**
     * Function that add general meta box options for this module
     */
    function gracey_core_add_stacked_portfolio_offset_meta_box( $page, $general_tab ) {

        if ( $page ) {

            $general_tab->add_field_element(
                array(
                    'field_type'  => 'text',
                    'name'        => 'qodef_stacked_portfolio_x_meta',
                    'title'       => esc_html__( 'Stacked Portfolio X Offset(%)', 'gracey-core' ),
                    'description' => esc_html__( 'Horiztonal offset for the article shown in Stacked Portfolio shortcode', 'gracey-core' ),
                )
            );

            $general_tab->add_field_element(
                array(
                    'field_type'  => 'text',
                    'name'        => 'qodef_stacked_portfolio_y_meta',
                    'title'       => esc_html__( 'Stacked Portfolio Y Offset(%)', 'gracey-core' ),
                    'description' => esc_html__( 'Vertical offset for the article shown in Stacked Portfolio shortcode', 'gracey-core' ),
                )
            );
        }
    }

    add_action( 'gracey_core_action_after_portfolio_meta_box_map', 'gracey_core_add_stacked_portfolio_offset_meta_box', 10, 2 );
}
