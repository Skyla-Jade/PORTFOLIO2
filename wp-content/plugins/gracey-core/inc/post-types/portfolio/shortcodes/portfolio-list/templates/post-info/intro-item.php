<div class="qodef-e qodef-grid-item qodef-intro-item">
    <div class="qodef-intro-item-content">
        <?php if( !empty($intro_item_background_text) ) : ?>
            <p class="qodef-bg-text"><?php echo esc_html($intro_item_background_text); ?></p>
        <?php endif; ?>
        <?php if( !empty($intro_item_subtitle) ) : ?>
            <p class="qodef-e-subtitle"><?php echo esc_html($intro_item_subtitle); ?></p>
        <?php endif; ?>
        <?php if( !empty($intro_item_title) ) : ?>
            <h2 class="qodef-e-title"><?php echo qode_framework_wp_kses_html( 'content', $intro_item_title ); ?></h2>
        <?php endif; ?>
        <?php if ( ! empty( $intro_item_link ) && class_exists( 'GraceyCore_Button_Shortcode' ) ) {
            $button_params = array(
                'link'          => esc_url($intro_item_link),
                'text'          => esc_html__( 'View More', 'gracey-core' ),
                'button_layout' => 'textual',
            );
            echo GraceyCore_Button_Shortcode::call_shortcode( $button_params );
        } ?>
    </div>
</div>