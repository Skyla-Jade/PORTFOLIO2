<?php do_action( 'gracey_action_before_page_header' ); ?>

<header id="qodef-page-header">
	<div id="qodef-page-header-inner" class="<?php echo implode( ' ', apply_filters( 'gracey_filter_header_inner_class', array(), 'default' ) ); ?>">
		<div class="qodef-vertical-sliding-area qodef--static">
			<?php
			// include opener
			gracey_core_get_opener_icon_html(
				array(
					'option_name'  => 'vertical_sliding_menu',
					'custom_class' => 'qodef-vertical-sliding-menu-opener',
				),
				true
			);

            // include logo
            gracey_core_get_header_logo_image();

			// include widget area one
			gracey_core_get_header_widget_area();
			?>
		</div>
		<div class="qodef-vertical-sliding-area qodef--dynamic">
			<?php
			// include vertical sliding navigation
			gracey_core_template_part( 'header', 'layouts/vertical-sliding/templates/navigation' );

			// include widget area two
			gracey_core_get_header_widget_area( '', 'two' );
			?>
		</div>
	</div>
</header>
