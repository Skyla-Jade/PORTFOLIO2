<div class="qodef-header-sticky">
	<div class="qodef-header-sticky-inner">
		<div class="qodef-divided-header-left-wrapper">
			<?php
			// Include widget area two
			gracey_core_get_header_widget_area( 'sticky', 'two' );

			// Include divided left navigation
			gracey_core_template_part( 'header/layouts/divided', 'templates/parts/left-navigation' );
			?>
		</div>
		<?php
		// Include logo
		gracey_core_get_header_logo_image( array( 'sticky_logo' => true ) );
		?>
		<div class="qodef-divided-header-right-wrapper">
			<?php
			// Include divided right navigation
			gracey_core_template_part( 'header/layouts/divided', 'templates/parts/right-navigation' );

			// Include widget area one
			gracey_core_get_header_widget_area( 'sticky' );
			?>
		</div>
		<?php do_action( 'gracey_core_action_after_sticky_header' ); ?>
	</div>
</div>
