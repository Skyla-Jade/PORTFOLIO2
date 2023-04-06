<div class="qodef-e-media">
	<?php
	switch ( get_post_format() ) {
		case 'gallery':
			gracey_template_part( 'blog', 'templates/parts/post-format/gallery' );
			break;
		case 'video':
			gracey_template_part( 'blog', 'templates/parts/post-format/video' );
			break;
		case 'audio':
			gracey_template_part( 'blog', 'templates/parts/post-format/audio' );
			break;
		default:
			gracey_template_part( 'blog', 'templates/parts/post-info/image' );
			break;
	}
	?>
</div>
