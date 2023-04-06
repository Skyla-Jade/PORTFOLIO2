<div <?php qode_framework_class_attribute( $holder_classes ); ?>>
    <?php if ( 'horizontal_slider' === $custom_behavior ) { ?>
        <div class="qodef-horizontal-custom-content">
	        <div class="qodef-horizontal-custom-content-inner" >
	            <?php if( !empty($horizontal_info_subtitle) ) : ?>
		            <?php if ( !empty( $horizontal_info_button_link ) ) : ?>
			            <a class='qodef-item-subtitle-link' href="<?php echo esc_url( $horizontal_info_button_link ); ?>" target="<?php echo esc_attr( $horizontal_info_button_link_target ); ?>">
		            <?php endif; ?>
	                    <span class="qodef-item-subtitle"><?php echo esc_attr( $horizontal_info_subtitle ); ?></span>
		            <?php if ( !empty( $horizontal_info_button_link ) ) : ?>
			            </a>
		            <?php endif; ?>
	            <?php endif; ?>
	            <?php if( !empty($horizontal_info_title) ) : ?>
	                <h4 class="qodef-item-title"><?php echo esc_attr( $horizontal_info_title ); ?></h4>
	            <?php endif; ?>
	            <?php if ( class_exists( 'GraceyCore_Button_Shortcode' ) && !empty( $horizontal_info_button_text ) ) {
	                $button_params = array(
	                    'link'          => $horizontal_info_button_link,
	                    'target'        => $horizontal_info_button_link_target,
	                    'text'          => $horizontal_info_button_text,
	                    'button_layout' => 'textual',
	                );
	                echo GraceyCore_Button_Shortcode::call_shortcode( $button_params );
	             } ?>
	        </div>
        </div>
    <?php } ?>
    <div class="qodef-items-holder">
        <div class="qodef-items-holder-inner">
            <?php
            // Include items
            gracey_core_template_part( 'post-types/portfolio/shortcodes/portfolio-list', 'templates/loop', '', $params );
            ?>
        </div>
    </div>
</div>