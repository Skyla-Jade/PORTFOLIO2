<?php do_action( 'gracey_action_before_page_header' ); ?>

<header id="qodef-page-header">
	<div id="qodef-page-header-inner" class="<?php echo implode( ' ', apply_filters( 'gracey_filter_header_inner_class', array(), 'default' ) ); ?>">
		<?php
		// Include logo
		gracey_core_get_header_logo_image();

		// Include divided left navigation
		gracey_core_template_part( 'header', 'layouts/vertical/templates/navigation' );

		// Include widget area one
		gracey_core_get_header_widget_area();
		?>
	</div>
</header>
