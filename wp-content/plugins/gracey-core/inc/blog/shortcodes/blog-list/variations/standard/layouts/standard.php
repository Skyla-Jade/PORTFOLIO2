<article <?php post_class( $item_classes ); ?>>
	<div class="qodef-e-inner">
		<?php
		// Include post media
		gracey_core_template_part( 'blog/shortcodes/blog-list', 'templates/post-info/media', '', $params );
		?>
		<div class="qodef-e-content">
			<div class="qodef-e-info qodef-info--top">
				<?php
                // Include post date info
                gracey_core_theme_template_part( 'blog', 'templates/parts/post-info/date' );
				?>
			</div>
			<div class="qodef-e-text">
				<?php
				// Include post title
                gracey_core_template_part( 'blog/shortcodes/blog-list', 'templates/post-info/title', '', $params );

				// Include post excerpt
				gracey_core_theme_template_part( 'blog', 'templates/parts/post-info/excerpt', '', $params );

				// Hook to include additional content after blog single content
				do_action( 'gracey_action_after_blog_single_content' );
				?>
			</div>
			<div class="qodef-e-info qodef-info--bottom">
				<div class="qodef-e-info-left">
					<?php
					// Include post read more
					gracey_core_theme_template_part( 'blog', 'templates/parts/post-info/read-more' );
					?>
				</div>
				<div class="qodef-e-info-right">
					<?php
					// Include post author info
					gracey_core_theme_template_part( 'blog', 'templates/parts/post-info/social-share' );
					?>
				</div>
			</div>
		</div>
	</div>
</article>
