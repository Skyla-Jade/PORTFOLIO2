<?php if ( ! empty( $title ) ) { ?>
	<<?php echo esc_attr( $title_tag ); ?> class="qodef-m-title" <?php qode_framework_inline_style( $title_styles ); ?>>
        <?php echo wp_kses_post( $title ); ?>
	</<?php echo esc_attr( $title_tag ); ?>>
<?php } ?>