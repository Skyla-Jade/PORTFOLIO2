<article <?php post_class( $item_classes ); ?>>
	<div class="qodef-e-inner">
		<?php gracey_core_template_part( 'blog/shortcodes/blog-list', 'templates/post-info/image', '', $params ); ?>
        <div class="qodef-e-info qodef-info--top">
            <?php
            // Include post date info
            gracey_core_theme_template_part( 'blog', 'templates/parts/post-info/date' );
            ?>
        </div>
		<div class="qodef-e-content">
			<?php
            gracey_core_template_part( 'blog/shortcodes/blog-list', 'templates/post-info/title', '', $params );

            // Include post excerpt
            gracey_core_theme_template_part( 'blog', 'templates/parts/post-info/excerpt', '', $params );
            ?>
			<div class="qodef-e-info qodef-info--bottom">
                <?php
                // Include post read more
                gracey_core_theme_template_part( 'blog', 'templates/parts/post-info/read-more' );
                ?>
			</div>
		</div>
	</div>
</article>
