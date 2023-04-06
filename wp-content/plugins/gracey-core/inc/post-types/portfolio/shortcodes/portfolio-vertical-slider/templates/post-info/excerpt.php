<?php

if ( post_password_required() ) {
	echo get_the_password_form();
} else {
	$excerpt = gracey_core_get_custom_post_type_excerpt( isset( $excerpt_length ) ? intval( $excerpt_length ) : 0 );

	if ( ! empty( $excerpt ) ) { ?>
		<p itemprop="description" class="qodef-e-excerpt"><?php echo esc_html( $excerpt ); ?></p>
	<?php }
} ?>