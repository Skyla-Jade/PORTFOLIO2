<div <?php qode_framework_class_attribute( $holder_classes ); ?>>
	<div class="qodef-m-inner">
		<div class="qodef-m-items">
			<?php
				$i = 0;
				foreach ( $items as $item ) {
					$image_original = wp_get_attachment_image_src( $item['item_image'], 'full' );
					$item['url']    = $image_original[0];
					$item['alt']    = get_post_meta( $item['item_image'], '_wp_attachment_image_alt', true );
					
					?>
					<div class="qodef-e-item <?php echo ($this_shortcode->get_item_classes($item)) ?>" <?php qode_framework_inline_style( $this_shortcode->get_item_holder_styles($item) ); ?> >
						<div class="qodef-e-item-inner" <?php qode_framework_inline_style( $this_shortcode->get_item_styles($item) ); ?>>
							<img src="<?php echo esc_url( $item['url'] ); ?>" alt="<?php echo esc_attr( $item['alt'] ); ?>"/>
						</div>
					</div>
			<?php $i ++; } ?>
		</div>
		<div class="qodef-m-text-holder">
			<?php if ( ! empty( $title ) ) { ?>
				
				<?php
				$params = array(
					'title'             => $title,
					'distort_animation' => 'yes',
					'title_tag'         => $title_tag,
					'color'             => $color,
					'font_size'         => $font_size,
					'margin'            => $margin,
					)
				?>
				<?php echo GraceyCore_Custom_Font_Shortcode::call_shortcode($params); ?>
			<?php } ?>
        </div>
		<div class="qodef-m-stamp-holder">
			<?php if ( ! empty( $stamp_params ) ) { ?>
				<?php echo GraceyCore_Stamp_Shortcode::call_shortcode( $stamp_params ); ?>
			<?php } ?>
		</div>
	</div>
</div>

