<div <?php qode_framework_class_attribute( $holder_classes ); ?>>
	<div class="qodef-m-icon-wrapper">
		<?php gracey_core_template_part( 'shortcodes/icon-with-text', 'templates/parts/' . $icon_type, '', $params ); ?>
	</div>
	<div class="qodef-m-content">
		<?php gracey_core_template_part( 'shortcodes/icon-with-text', 'templates/parts/title', '', $params ); ?>
		<?php gracey_core_template_part( 'shortcodes/icon-with-text', 'templates/parts/text', '', $params ); ?>
	</div>
</div>
