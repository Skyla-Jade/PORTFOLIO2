<?php
// Load title image template
gracey_core_get_page_title_image();
?>
<div class="qodef-m-content <?php echo esc_attr( gracey_core_get_page_title_content_classes() ); ?>">
	<?php
	// Load breadcrumbs template
	gracey_core_breadcrumbs();
	?>
</div>
