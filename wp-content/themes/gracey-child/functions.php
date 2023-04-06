<?php

if ( ! function_exists( 'gracey_child_theme_enqueue_scripts' ) ) {
	/**
	 * Function that enqueue theme's child style
	 */
	function gracey_child_theme_enqueue_scripts() {
		$main_style = 'gracey-main';

		wp_enqueue_style( 'gracey-child-style', get_stylesheet_directory_uri() . '/style.css', array( $main_style ) );
	}

	add_action( 'wp_enqueue_scripts', 'gracey_child_theme_enqueue_scripts' );
}
