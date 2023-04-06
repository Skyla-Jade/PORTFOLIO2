<?php if ( class_exists( 'GraceyCore_Button_Shortcode' ) ) { ?>
    <div class="qodef-e-read-more">
        <?php
        $button_params = array(
            'link' => get_the_permalink(),
            'text' => esc_html__( 'Learn more', 'gracey-core' ),
            'button_layout' => 'textual',
        );

        echo GraceyCore_Button_Shortcode::call_shortcode( $button_params );
        ?>
    </div>
<?php } ?>

