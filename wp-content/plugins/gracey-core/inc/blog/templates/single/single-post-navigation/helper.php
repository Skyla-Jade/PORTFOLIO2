<?php

if ( ! function_exists( 'gracey_core_include_blog_single_post_navigation_template' ) ) {
	/**
	 * Function which includes additional module on single posts page
	 */
	function gracey_core_include_blog_single_post_navigation_template() {
		if ( is_single() ) {
			include_once GRACEY_CORE_INC_PATH . '/blog/templates/single/single-post-navigation/templates/single-post-navigation.php';
		}
	}

	add_action( 'gracey_action_after_blog_post_item', 'gracey_core_include_blog_single_post_navigation_template', 15 ); // permission 15 is set to define template position
}
