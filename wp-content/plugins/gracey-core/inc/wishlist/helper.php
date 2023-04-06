<?php

if ( ! function_exists( 'gracey_core_include_wishlist_widgets' ) ) {
	/**
	 * Function that includes widgets
	 */
	function gracey_core_include_wishlist_widgets() {
		foreach ( glob( GRACEY_CORE_PLUGINS_PATH . '/wishlist/widgets/*/include.php' ) as $widget ) {
			include_once $widget;
		}
	}

	add_action( 'qode_framework_action_before_widgets_register', 'gracey_core_include_wishlist_widgets' );
}

if ( ! function_exists( 'gracey_core_add_wishlist_button' ) ) {
	/**
	 * Function that add widhlist link to the item
	 */
	function gracey_core_add_wishlist_button() {
		gracey_core_template_part( 'wishlist', 'templates/wishlist-link' );
	}

	// Add wishlist link into module template
	add_action( 'gracey_core_action_listing_side_info_last', 'gracey_core_add_wishlist_button' );
}

if ( ! function_exists( 'gracey_core_add_rest_api_wishlist_global_variables' ) ) {
	/**
	 * Extend main rest api variables with new case
	 *
	 * @param array $global - list of variables
	 * @param string $namespace - rest namespace url
	 *
	 * @return array
	 */
	function gracey_core_add_rest_api_wishlist_global_variables( $global, $namespace ) {
		$global['wishlistRestRoute'] = $namespace . '/wishlist';

		return $global;
	}

	add_filter( 'gracey_filter_rest_api_global_variables', 'gracey_core_add_rest_api_wishlist_global_variables', 10, 2 );
}

if ( ! function_exists( 'gracey_core_add_rest_api_wishlist_route' ) ) {
	/**
	 * Extend main rest api routes with new case
	 *
	 * @param array $routes - list of rest routes
	 *
	 * @return array
	 */
	function gracey_core_add_rest_api_wishlist_route( $routes ) {
		$routes['wishlist'] = array(
			'route'               => 'wishlist',
			'methods'             => WP_REST_Server::CREATABLE,
			'callback'            => 'gracey_core_get_wishlist_content',
			'permission_callback' => function () {
				return is_user_logged_in();
			},
			'args'                => array(
				'options' => array(
					'required'          => true,
					'validate_callback' => function ( $param, $request, $key ) {
						// Simple solution for validation can be 'is_array' value instead of callback function
						return is_array( $param ) ? $param : (array) $param;
					},
					'description'       => esc_html__( 'Options data is array with reaction and id values', 'gracey-core' ),
				),
			),
		);

		return $routes;
	}

	add_filter( 'gracey_filter_rest_api_routes', 'gracey_core_add_rest_api_wishlist_route' );
}

if ( ! function_exists( 'gracey_core_get_wishlist_content' ) ) {
	/**
	 * Function that return a new widhlist content on ajax call
	 */
	function gracey_core_get_wishlist_content() {

		if ( isset( $_POST['options'] ) && is_user_logged_in() ) {
			$error            = false;
			$response_message = '';

			$data    = $_POST['options'];
			$type    = $data['type'];
			$item_id = $data['itemID'];

			// Validate fields
			if ( empty( $item_id ) ) {
				$error           = true;
				$response_message = esc_html__( 'Item ID is invalid.', 'gracey-core' );
			}

			// Update user meta
			if ( $error ) {
				qode_framework_get_ajax_status( 'error', $response_message );
			} else {
				$user_id   = get_current_user_id();
				$user_meta = get_user_meta( $user_id, 'qodef_user_wishlist_items', true );

				if ( 'add' === $type ) {

					if ( ! isset( $user_meta ) || empty( $user_meta ) ) {
						$user_meta = array();
					}

					$user_meta[ $item_id ] = get_the_title( $item_id );

					update_user_meta( $user_id, 'qodef_user_wishlist_items', $user_meta );

					qode_framework_get_ajax_status( 'success', esc_html__( 'Item is added', 'gracey-core' ), array( 'user_id' => $user_id ) );
				} elseif ( 'remove' === $type ) {

					if ( ! empty( $user_meta ) && isset( $user_meta[ $item_id ] ) ) {
						unset( $user_meta[ $item_id ] );

						update_user_meta( $user_id, 'qodef_user_wishlist_items', $user_meta );

						$count = gracey_core_get_number_of_wishlist_items();

						qode_framework_get_ajax_status( 'success', esc_html__( 'Removed', 'gracey-core' ), array( 'count' => $count ) );
					} else {
						qode_framework_get_ajax_status( 'error', esc_html__( 'User meta is empty.', 'gracey-core' ) );
					}
				}

				unset( $_POST['options'] ); // Remove data from global post variable after submission
			}
		} else {
			qode_framework_get_ajax_status( 'error', esc_html__( 'You are not authorized.', 'gracey-core' ) );
		}
	}
}

if ( ! function_exists( 'gracey_core_get_wishlist_items' ) ) {
	/**
	 * Function that return user wishlist items
	 *
	 * @return array
	 */
	function gracey_core_get_wishlist_items() {
		$items          = array();
		$wishlist_items = get_user_meta( get_current_user_id(), 'qodef_user_wishlist_items', true );

		if ( isset( $wishlist_items ) && ! empty( $wishlist_items ) ) {
			$items = $wishlist_items;
		}

		return $items;
	}
}

if ( ! function_exists( 'gracey_core_get_number_of_wishlist_items' ) ) {
	/**
	 * Function that return count of user wishlist items
	 *
	 * @return int
	 */
	function gracey_core_get_number_of_wishlist_items( $user_id = 0 ) {
		$count = 0;

		if ( is_user_logged_in() && 0 === $user_id ) {
			$wishlist_items = get_user_meta( get_current_user_id(), 'qodef_user_wishlist_items', true );
		} elseif ( ! empty( $user_id ) ) {
			$wishlist_items = get_user_meta( $user_id, 'qodef_user_wishlist_items', true );
		}

		if ( isset( $wishlist_items ) && ! empty( $wishlist_items ) ) {
			$count = intval( count( $wishlist_items ) );
		}

		return $count;
	}
}
