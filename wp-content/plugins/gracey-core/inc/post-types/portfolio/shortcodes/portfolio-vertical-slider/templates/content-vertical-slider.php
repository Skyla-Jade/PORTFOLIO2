<div <?php qode_framework_class_attribute( $holder_classes ); ?>>
    <div <?php qode_framework_class_attribute( $holder_inner_classes ); ?> <?php qode_framework_inline_attr( $slider_attr, 'data-options' ); ?>>
		<div class="swiper-wrapper">
			<?php
			// Include items
			gracey_core_template_part( 'post-types/portfolio/shortcodes/portfolio-vertical-slider', 'templates/loop', '', $params );
			?>
		</div>
	    <?php if ( $distort_animation ) { ?>
		    <svg class="qodef-svg-distort-filter" width="100%" height="100%">
			    <filter id="<?php echo esc_attr( $unique_id ); ?>" x="-25%" y="-25%" width="150%" height="150%">
				    <feTurbulence type="fractalNoise" baseFrequency="0.01 0.09" numOctaves="1" seed="0" result="warp">
				    </feTurbulence><feDisplacementMap xChannelSelector="R" yChannelSelector="G" scale="0" in="SourceGraphic" in2="warp"></feDisplacementMap>
			    </filter>
		    </svg>
	    <?php } ?>
	</div>
    <div class="qodef-pvs-fixed-content"></div>

    <?php if ( is_active_sidebar( $custom_widget_area ) && !empty( $custom_widget_area ) ) : ?>
        <div class="qodef-pvs-custom-widget-area">
            <?php dynamic_sidebar( $custom_widget_area ); ?>
        </div>
    <?php endif; ?>
</div>
