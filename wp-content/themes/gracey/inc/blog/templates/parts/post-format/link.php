<?php
$link_url_meta  = get_post_meta( get_the_ID(), 'qodef_post_format_link', true );
$link_url       = ! empty( $link_url_meta ) ? $link_url_meta : get_the_permalink();
$link_text_meta = get_post_meta( get_the_ID(), 'qodef_post_format_link_text', true );

if ( ! empty( $link_url ) ) {
	$link_text = ! empty( $link_text_meta ) ? $link_text_meta : get_the_title();
	$title_tag = isset( $title_tag ) && ! empty( $title_tag ) ? $title_tag : 'h5';
	$author_position = get_the_author_meta( 'qodef_user_position' );
	?>
	<div class="qodef-e-link">
		<?php gracey_render_svg_icon( 'link', 'qodef-e-link-icon' ); ?>
		<<?php echo esc_attr( $title_tag ); ?> class="qodef-e-link-text"><?php echo esc_html( $link_text ); ?></<?php echo esc_attr( $title_tag ); ?>>
        <span class="qodef-e-author"><?php echo esc_html( get_the_author_meta( 'display_name' ) ); ?></span>
        <?php if( !empty($author_position) ) : ?>
            <span class="qodef-e-author-position">/ <?php echo esc_html( $author_position ); ?></span>
        <?php endif; ?>
		<a itemprop="url" class="qodef-e-link-url" href="<?php echo esc_url( $link_url ); ?>" target="_blank"></a>
	</div>
<?php } ?>
