<?php

if ( ! function_exists( 'gracey_core_is_cursor_enabled' ) ) {
	/**
	 * Function that check is module enabled
	 *
	 * @return bool
	 */
	function gracey_core_is_cursor_enabled() {
		return gracey_core_get_post_value_through_levels( 'qodef_cursor' ) !== 'no';
	}
}

if ( ! function_exists( 'gracey_core_add_cursor_to_body_classes' ) ) {
	/**
	 * Function that add additional class name into global class list for body tag
	 *
	 * @param array $classes
	 *
	 * @return array
	 */
	function gracey_core_add_cursor_to_body_classes( $classes ) {
		$classes[] = gracey_core_is_cursor_enabled() ? 'qodef-theme-cursor' : '';
		
		return $classes;
	}
	
	add_filter( 'body_class', 'gracey_core_add_cursor_to_body_classes' );
}

if ( ! function_exists( 'gracey_core_load_cursor' ) ) {
	/**
	 * Loads Scroll Down HTML
	 */
	function gracey_core_load_cursor() {
		
		if ( gracey_core_is_cursor_enabled() ) {
			$parameters = array();
			
			gracey_core_template_part( 'cursor', 'templates/cursor', '', $parameters );
		}
	}
	
	add_action( 'gracey_action_before_wrapper_close_tag', 'gracey_core_load_cursor' );
}