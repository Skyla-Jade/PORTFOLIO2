<?php

if ( ! function_exists( 'gracey_core_add_portfolio_item_list_meta_boxes' ) ) {
	/**
	 * Function that add general meta box options for this module
	 *
	 * @param object $page
	 */
	function gracey_core_add_portfolio_item_list_meta_boxes( $page ) {

		if ( $page ) {

			$list_tab = $page->add_tab_element(
				array(
					'name'        => 'tab-list',
					'icon'        => 'fa fa-cog',
					'title'       => esc_html__( 'List Settings', 'gracey-core' ),
					'description' => esc_html__( 'Portfolio list settings', 'gracey-core' ),
				)
			);

			$list_tab->add_field_element(
				array(
					'field_type'  => 'image',
					'name'        => 'qodef_portfolio_list_image',
					'title'       => esc_html__( 'Portfolio List Image', 'gracey-core' ),
					'description' => esc_html__( 'Upload image to be displayed on portfolio list instead of featured image', 'gracey-core' ),
				)
			);

			$list_tab->add_field_element(
				array(
					'field_type'  => 'select',
					'name'        => 'qodef_masonry_image_dimension_portfolio_item',
					'title'       => esc_html__( 'Image Dimension', 'gracey-core' ),
					'description' => esc_html__( 'Choose an image layout for "masonry behavior" portfolio list. If you are using fixed image proportions on the list, choose an option other than default', 'gracey-core' ),
					'options'     => gracey_core_get_select_type_options_pool( 'masonry_image_dimension' ),
				)
			);

			// Hook to include additional options after module options
			do_action( 'gracey_core_action_after_portfolio_list_meta_box_map', $list_tab );
		}
	}

	add_action( 'gracey_core_action_after_portfolio_meta_box_map', 'gracey_core_add_portfolio_item_list_meta_boxes' );
}
