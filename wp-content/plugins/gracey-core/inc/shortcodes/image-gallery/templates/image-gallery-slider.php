<?php if ( isset( $enable_shadow ) && $enable_shadow) : ?>
<div class="qodef-image-gallery-holder">
<?php endif; ?>
<div <?php qode_framework_class_attribute( $holder_classes ); ?> <?php qode_framework_inline_attr( $slider_attr, 'data-options' ); ?>>
	<div class="swiper-wrapper">
		<?php
		// Include items
		if ( ! empty( $images ) ) {
			foreach ( $images as $image ) {
				gracey_core_template_part( 'shortcodes/image-gallery', 'templates/parts/image', '', array_merge( $params, $image ) );
			}
		}
		?>
	</div>
	<?php gracey_core_template_part( 'content', 'templates/swiper-nav', '', $params ); ?>
	<?php gracey_core_template_part( 'content', 'templates/swiper-pag', '', $params ); ?>
</div>
<?php if ( isset( $enable_shadow ) && $enable_shadow) : ?>
</div>
<?php endif; ?>
