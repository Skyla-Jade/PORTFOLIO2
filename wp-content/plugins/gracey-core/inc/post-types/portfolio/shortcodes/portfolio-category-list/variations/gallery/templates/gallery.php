<article <?php qode_framework_class_attribute( $item_classes ); ?>>
	<div class="qodef-e-inner">
		<?php gracey_core_template_part( 'post-types/portfolio/shortcodes/portfolio-category-list', 'templates/parts/image', '', $params ); ?>
		<div class="qodef-e-content">
			<?php gracey_core_template_part( 'post-types/portfolio/shortcodes/portfolio-category-list', 'templates/parts/title', '', $params ); ?>
		</div>
		<?php gracey_core_template_part( 'post-types/portfolio/shortcodes/portfolio-category-list', 'templates/parts/link', '', $params ); ?>
	</div>
</article>
