<?php

if ( ! function_exists( 'gracey_core_register_left_fixed_widget_area' ) ) {
    /**
     * Register side area sidebar
     */
    function gracey_core_register_left_fixed_widget_area() {

        register_sidebar(
            array(
                'id'            => 'qodef-left-fixed-area',
                'name'          => esc_html__( 'Left Fixed Area', 'gracey-core' ),
                'description'   => esc_html__( 'Widgets added here will appear in Left Fixed area', 'gracey-core' ),
                'before_widget' => '<div id="%1$s" class="widget %2$s" data-area="left-fixed-area">',
                'after_widget'  => '</div>'
            )
        );
    }

    add_action( 'widgets_init', 'gracey_core_register_left_fixed_widget_area' );
}

if ( ! function_exists( 'gracey_left_side_fixed' ) ) {
    function gracey_left_side_fixed() {

        if ( gracey_core_get_post_value_through_levels( 'qodef_left_fixed_area' ) === 'yes' ) { ?>

            <div id="qodef-left-fixed-area">
                <?php if ( is_active_sidebar( 'qodef-left-fixed-area' ) ) : ?>
                    <div class="qodef-left-fixed-area-inner">
                        <?php dynamic_sidebar( 'qodef-left-fixed-area' ); ?>
                    </div>
                <?php endif; ?>
            </div>

            <?php
        }
    }
    add_action( 'gracey_action_left_fixed_area', 'gracey_left_side_fixed' );
}