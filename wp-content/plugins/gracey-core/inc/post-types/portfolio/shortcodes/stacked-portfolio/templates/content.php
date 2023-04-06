<div <?php qode_framework_class_attribute( $holder_classes ); ?>>
    <?php
    // Include items
    gracey_core_template_part( 'post-types/portfolio/shortcodes/stacked-portfolio', 'templates/loop', '', $params );
    ?>

    <div class="qodef-sp-end-of-scroll">
        <div>
            <<?php echo esc_attr( $eos_title_tag ); ?> class="qodef-eos-title" <?php qode_framework_inline_style( $title_styles ); ?>>
                <span><?php echo wp_kses($title, array('br' => true, 'span' => array('class' => true))); ?></span>
            </<?php echo esc_attr( $eos_title_tag ); ?>>
        </div>
    </div>
    <div class="qodef-sp-scroll-note">
        <div>
	        <div class="qodef-sp-scroll-note-inner">
		        <span class="qodef-sp-down"><span class="qodef-sp-arrow"><?php gracey_render_svg_icon( 'button-arrow' ); ?></span><span><?php _e('Scroll down', 'gracey-core'); ?></span></span>
		        <span class="qodef-sp-up"><span><?php _e('Scroll up', 'gracey-core'); ?></span><span class="qodef-sp-arrow"><?php gracey_render_svg_icon( 'button-arrow' ); ?></span></span>
	        </div>
        </div>
    </div>
    <?php if (!empty($widget_area) && is_active_sidebar($widget_area)) : ?>
    <div class="qodef-sp-widget-area">
        <div>
            <?php dynamic_sidebar($widget_area); ?>
        </div>
        <?php endif; ?>
    </div>
</div>
