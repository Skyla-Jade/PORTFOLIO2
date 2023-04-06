<?php
if ( has_post_thumbnail() ) {
    $image_src = get_the_post_thumbnail_url( get_the_ID(), 'full' );
}
$style = 'style=background-image:url(' . $image_src . ')';
?>
<div class="qodef-e-media-image" <?php echo esc_attr( $style ); ?>></div>
<a itemprop="url" href="<?php the_permalink(); ?>"></a>
