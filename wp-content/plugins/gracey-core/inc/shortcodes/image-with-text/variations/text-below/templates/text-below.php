<div <?php qode_framework_class_attribute( $holder_classes ); ?>>
	<?php if ( empty ( $video_url ) ) {
		gracey_core_template_part( 'shortcodes/image-with-text', 'templates/parts/image', '', $params );
	} else {
		gracey_core_template_part( 'shortcodes/image-with-text', 'templates/parts/video', '', $params );
	} ?>
	<div class="qodef-m-content">
		<?php gracey_core_template_part( 'shortcodes/image-with-text', 'templates/parts/title', '', $params ); ?>
		<?php gracey_core_template_part( 'shortcodes/image-with-text', 'templates/parts/text', '', $params ); ?>
	</div>
</div>
