<span <?php qode_framework_class_attribute( $holder_classes ); ?>  <?php echo qode_framework_get_inline_style( $holder_styles ); ?> <?php echo qode_framework_get_inline_attrs( $holder_data, true ); ?>>
	<span class="qodef-m-text" data-count="<?php echo esc_attr( $text_data['count'] ); ?>"><?php echo qode_framework_wp_kses_html( 'content', $text_data['text'] ); ?></span>
	<?php if ( !empty( $centered_icon ) ){ ?>
		<span class="qodef-m-centred-icon qodef-icon-<?php echo esc_attr($centered_icon); ?>">
			<?php if ( $centered_icon != 'predefined') { ?>
				<?php gracey_render_svg_icon( 'button-arrow' ); ?>
			<?php } else { ?>
				<?php gracey_render_svg_icon( 'spinner' ); ?>
			<?php } ?>
		</span>
	<?php } ?>
	<?php if ( !empty( $link ) ) { ?>
		<a href="<?php echo esc_url( $link ); ?>" target="<?php echo esc_attr( $target ); ?>"></a>
	<?php } ?>
</span>
