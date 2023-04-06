<div class="qodef-m-video">
	<?php if ( $image_action === 'custom-link' && ! empty( $link ) ) { ?>
	<a itemprop="url" href="<?php echo esc_url( $link ); ?>" target="<?php echo esc_attr( $target ); ?>">
		<?php } ?>
		<video src="<?php echo esc_url( $video_url ); ?>" poster="<?php echo esc_url( $image_params['url'] ); ?>" autoplay loop muted></video>
		<?php if ( $image_action === 'custom-link' && ! empty( $link ) ) { ?>
	</a>
<?php } ?>
</div>
