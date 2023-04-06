<div <?php qode_framework_class_attribute( $holder_classes ); ?> <?php qode_framework_inline_attr( $slider_attr, 'data-options' ); ?>>
    <?php gracey_render_svg_icon( 'quote', 'qodef-e-quote-icon' ); ?>
    <?php gracey_core_list_sc_template_part( 'post-types/testimonials/shortcodes/testimonials-list', 'post-info/static-title', '', $params ); ?>
	<div class="swiper-wrapper">
		<?php
		// Include items
		gracey_core_template_part( 'post-types/testimonials/shortcodes/testimonials-list', 'templates/loop', '', $params );
		?>
	</div>
	<?php gracey_core_template_part( 'content', 'templates/swiper-pag', '', $params ); ?>
</div>
<?php gracey_core_template_part( 'content', 'templates/swiper-nav', '', $params ); ?>
