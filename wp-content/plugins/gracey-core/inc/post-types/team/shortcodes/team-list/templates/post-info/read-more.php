<?php if ( ! post_password_required() && class_exists( 'GraceyCore_Button_Shortcode' ) ) { ?>
	<div class="qodef-e-read-more">
		<?php
		$button_params = array(
			'link' => get_the_permalink(),
			'text' => esc_html__( 'Read More', 'gracey-core' ),
		);

		echo GraceyCore_Button_Shortcode::call_shortcode( $button_params );
		?>
	</div>
<?php } ?>
