<?php

if ( ! function_exists( 'gracey_core_include_blog_single_author_info_template' ) ) {
	/**
	 * Function which includes additional module on single posts page
	 */
	function gracey_core_include_blog_single_author_info_template() {
		if ( is_single() ) {
			include_once GRACEY_CORE_INC_PATH . '/blog/templates/single/author-info/templates/author-info.php';
		}
	}

	add_action( 'gracey_action_after_blog_post_item', 'gracey_core_include_blog_single_author_info_template', 20 );  // permission 20 is set to define template position
}

if ( ! function_exists( 'gracey_core_get_author_social_networks' ) ) {
	/**
	 * Function which includes author info templates on single posts page
	 */
	function gracey_core_get_author_social_networks( $user_id ) {
		$icons           = array();
		$social_networks = array(
			'facebook',
			'twitter',
			'linkedin',
			'instagram',
			'pinterest',
		);

		foreach ( $social_networks as $network ) {
			$network_meta = get_the_author_meta( 'qodef_user_' . $network, $user_id );

            $icon = '';
            if($network !== 'instagram') {
                $icon = 'kiko-' . $network . ' kikor';
            } else {
                $icon = 'fab fa-' . $network;
            }

			if ( ! empty( $network_meta ) ) {
				$$network = array(
					'url'   => $network_meta,
                    'icon'  => $icon,
					'class' => 'qodef-user-social-' . $network,
				);

				$icons[ $network ] = $$network;
			}
		}

		return $icons;
	}
}
