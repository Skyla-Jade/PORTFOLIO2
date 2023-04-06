<?php
// Include logo
gracey_core_get_header_logo_image();
?>
<div class="qodef-centered-header-wrapper">
	<?php
	// Include widget area two
	gracey_core_get_header_widget_area( '', 'two' );

	// Include main navigation
	gracey_core_template_part( 'header', 'templates/parts/navigation' );

	// Include widget area one
	gracey_core_get_header_widget_area();
	?>
</div>
