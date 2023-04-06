<div <?php qode_framework_class_attribute( $outer_holder_classes ); ?>>

    <?php if ( !empty( $background_text) ) : ?>
        <div class="qodef-bg-text">
            <?php

            for($i = 0; $i < 7; $i++) {
                $text_marquee_params = array(
	                'text_1'             => esc_html( $background_text ),
	                'change_orientation' => 'no',
                    'custom_class'       => 'qodef-marquee-paused'
                );

                if( $i%2 !== 0 ) {
                    $text_marquee_params['change_orientation'] = 'yes';
                }

                echo GraceyCore_Text_Marquee_Shortcode::call_shortcode( $text_marquee_params );
            }
            ?>
        </div>
    <?php endif; ?>
	<div class="qodef-slider-holder">
		<div <?php qode_framework_class_attribute( $holder_classes ); ?> <?php qode_framework_inline_attr( $slider_attr, 'data-options' ); ?>>
			<div class="swiper-wrapper">
				<?php
				// Include items
				gracey_core_template_part( 'post-types/portfolio/shortcodes/portfolio-list', 'templates/loop', '', $params );
				?>
			</div>
			<?php gracey_core_template_part( 'content', 'templates/swiper-nav', '', $params ); ?>
			<?php gracey_core_template_part( 'content', 'templates/swiper-pag', '', $params ); ?>
		</div>
	</div>
</div>

