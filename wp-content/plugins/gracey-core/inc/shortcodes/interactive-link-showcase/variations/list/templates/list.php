<div <?php qode_framework_class_attribute( $holder_classes ); ?> <?php qode_framework_inline_style( $holder_styles ); ?>>
	<div class="qodef-m-items">
		<?php foreach ( $items as $item ) { ?>
			<div class="qodef-m-item qodef-e">
                <a itemprop="url" class="qodef-m-link" href="<?php echo esc_url( $item['item_link'] ); ?>" target="<?php echo esc_attr( $link_target ); ?>">
                    <?php if( !empty($item['item_number']) ) : ?>
                        <span class="qodef-e-number"><?php echo esc_html( $item['item_number'] ); ?></span>
                    <?php endif;?>
                    <span class="qodef-e-title"><?php echo esc_html( $item['item_title'] ); ?></span>
                </a>
                <div class="qodef-m-image">
                    <?php echo wp_get_attachment_image( $item['item_image'], 'full' ); ?>
                </div>
            </div>
		<?php } ?>
	</div>
</div>
