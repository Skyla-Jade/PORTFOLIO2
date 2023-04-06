<?php if ( class_exists( 'GraceyCore_Social_Share_Shortcode' ) ) { ?>
	<div class="qodef-e-info-item qodef-e-info-social-share">
		<?php
		$params               = array();
        $params['layout']     = 'list';
        $params['icon_font']  = 'kiko';
		$params['title']      = ' ';

		echo GraceyCore_Social_Share_Shortcode::call_shortcode( $params );
		?>
	</div>
<?php } ?>
