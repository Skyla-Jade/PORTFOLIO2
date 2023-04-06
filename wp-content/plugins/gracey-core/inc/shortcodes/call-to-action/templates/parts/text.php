<?php if ( ! empty( $main_text) ) { ?>
	<<?php echo esc_attr( $text_tag ); ?> class="qodef-m-text"><?php echo wp_kses($main_text, array('br' => true, 'span' => array('class' => true))); ?></<?php echo esc_attr( $text_tag ); ?>>
<?php } ?>
