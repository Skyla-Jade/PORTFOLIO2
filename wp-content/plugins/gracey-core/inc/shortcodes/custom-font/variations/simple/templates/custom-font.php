<?php if( !empty($fullwidth_text) && $fullwidth_text === 'yes') : ?>
    <<?php echo esc_attr( $title_tag ); ?> <?php qode_framework_class_attribute( $holder_classes ); ?> <?php echo qode_framework_inline_style( $holder_styles ); ?>>
        <span class="qodef-custom-font-holder-inner">
            <span class="qodef-custom-font"><?php echo qode_framework_wp_kses_html( 'content', $title ); ?></span>
        </span>
    </<?php echo esc_attr( $title_tag ); ?>>
<?php else: ?>
    <<?php echo esc_attr( $title_tag ); ?> <?php qode_framework_class_attribute( $holder_classes ); ?> <?php qode_framework_inline_style( $holder_styles ); ?>><?php echo qode_framework_wp_kses_html( 'content', $title ); ?></<?php echo esc_attr( $title_tag ); ?>>
<?php endif; ?>