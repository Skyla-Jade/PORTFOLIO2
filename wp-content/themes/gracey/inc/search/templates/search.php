<div class="qodef-grid-item <?php echo esc_attr( gracey_get_page_content_sidebar_classes() ); ?>">
	<div class="qodef-search qodef-m">
		<?php
		// Include search form
		gracey_template_part( 'search', 'templates/parts/search-form' );

		// Include posts loop
		gracey_template_part( 'search', 'templates/parts/loop' );

		// Include pagination
		gracey_template_part( 'pagination', 'templates/pagination-wp' );
		?>
	</div>
</div>
