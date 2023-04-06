<?php

if ( ! function_exists( 'gracey_core_include_portfolio_single_post_navigation_template' ) ) {
	/**
	 * Function which includes additional module on single portfolio page
	 */
	function gracey_core_include_portfolio_single_post_navigation_template() {
		gracey_core_template_part( 'post-types/portfolio', 'templates/single/single-navigation/templates/single-navigation' );
	}

	add_action( 'gracey_core_action_after_portfolio_single_item', 'gracey_core_include_portfolio_single_post_navigation_template' );
}
