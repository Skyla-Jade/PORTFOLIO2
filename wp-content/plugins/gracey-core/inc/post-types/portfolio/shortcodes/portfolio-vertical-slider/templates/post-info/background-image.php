<?php
$portfolio_list_image_id = get_post_meta( get_the_ID(), 'qodef_portfolio_list_image', true );
$has_image            = ! empty( $portfolio_list_image_id ) || has_post_thumbnail();
$portfolio_list_image_src = '';
$portfolio_thumbnail_src = '';

if( !empty( $portfolio_list_image_id ) ) {
    $portfolio_list_image_src = wp_get_attachment_image_url($portfolio_list_image_id, 'full');
}

if ( has_post_thumbnail() ) {
    $portfolio_thumbnail_src = get_the_post_thumbnail_url( get_the_ID(), 'full' );
}

if ( $has_image ) {

    $style = '';

    if( $portfolio_list_image_src !== '' ) {
        $style = 'style=background-image:url(' . $portfolio_list_image_src . ')';
    } else {
        $style = 'style=background-image:url(' . $portfolio_thumbnail_src . ')';
    }
    ?>
    <div class="qodef-e-media-background-image" <?php echo esc_attr( $style ); ?>></div>
    <a itemprop="url" href="<?php the_permalink(); ?>"></a>
<?php } ?>
