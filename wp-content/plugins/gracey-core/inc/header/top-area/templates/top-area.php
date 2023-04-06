<?php if ( $show_header_area ) { ?>
	<div id="qodef-top-area">
		<div id="qodef-top-area-inner" class="<?php echo apply_filters( 'gracey_core_filter_top_area_inner_class', '' ); ?>">
			<?php
			// Include widget area top right
			gracey_core_get_top_area_header_widget_area( 'left' );

			// Include widget area top right
			gracey_core_get_top_area_header_widget_area( 'right' );

			do_action( 'gracey_core_action_after_top_area' );
			?>
		</div>
	</div>
<?php } ?>
