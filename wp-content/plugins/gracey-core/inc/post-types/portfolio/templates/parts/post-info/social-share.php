<?php if ( class_exists( 'GraceyCore_Social_Share_Shortcode' ) ) { ?>
	<div class="qodef-e qodef-inof--social-share">
		<?php
		$params = array(
			'title'     => esc_html__( 'Share:', 'gracey-core' ),
			'layout'    => 'list',
			'icon_font' => 'kiko',
		);

		echo GraceyCore_Social_Share_Shortcode::call_shortcode( $params );
		?>
	</div>
<?php } ?>
