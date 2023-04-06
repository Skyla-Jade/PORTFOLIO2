<?php $description = get_post_meta( get_the_ID(), 'qodef_portfolio_vertical_slider_description', true ); ?>
<?php if( !empty($description) ) : ?>
    <span class="qodef-e-additional-info"><?php echo esc_html($description) ?></span>
<?php endif; ?>