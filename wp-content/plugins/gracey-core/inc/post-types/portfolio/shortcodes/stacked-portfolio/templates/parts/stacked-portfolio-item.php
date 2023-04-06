<?php
$offsets = $this_shortcode->get_article_offsets();
$image_src = '';
$portfolio_list_image = get_post_meta( get_the_ID(), 'qodef_portfolio_list_image', true );

if ( !empty($portfolio_list_image) ) {
    $image_src = wp_get_attachment_image_url($portfolio_list_image, 'full');
}

if ( empty($image_src) && has_post_thumbnail() ) {
    $image_src = get_the_post_thumbnail_url(get_the_ID());
}
?>

<div class="qodef-sp-item" data-index="<?php echo esc_attr($counter); ?>" data-x="<?php echo esc_attr($offsets['x']); ?>" data-y="<?php echo esc_attr($offsets['y']); ?>">
    <div class="qodef-sp-item-inner">
        <div>
            <a itemprop=" url" href="<?php echo esc_url($this_shortcode->get_item_link()); ?>" target="<?php echo esc_attr($this_shortcode->get_item_link_target()); ?>">
                <img src="<?php echo esc_html($image_src); ?>" alt="<?php get_the_title($image_src); ?>">
            </a>
        </div>
    </div>
</div> 