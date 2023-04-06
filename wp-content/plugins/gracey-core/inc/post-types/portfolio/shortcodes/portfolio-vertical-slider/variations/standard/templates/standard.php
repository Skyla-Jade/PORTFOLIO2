<article <?php post_class( $item_classes ); ?>>
	<div class="qodef-e-inner">
		<div class="qodef-e-image">
			<?php gracey_core_list_sc_template_part( 'post-types/portfolio/shortcodes/portfolio-vertical-slider', 'post-info/image', '', $params ); ?>
		</div>
		<div class="qodef-e-content">
            <?php gracey_core_list_sc_template_part( 'post-types/portfolio/shortcodes/portfolio-vertical-slider', 'post-info/number', '', $params ); ?>
            <?php gracey_core_list_sc_template_part( 'post-types/portfolio/shortcodes/portfolio-vertical-slider', 'post-info/description', '', $params ); ?>
            <?php gracey_core_list_sc_template_part( 'post-types/portfolio/shortcodes/portfolio-vertical-slider', 'post-info/title', '', $params ); ?>
            <?php gracey_core_list_sc_template_part( 'post-types/portfolio/shortcodes/portfolio-vertical-slider', 'post-info/excerpt', '', $params ); ?>
            <?php gracey_core_list_sc_template_part( 'post-types/portfolio/shortcodes/portfolio-vertical-slider', 'post-info/read-more', '', $params ); ?>
		</div>
	</div>
</article>
