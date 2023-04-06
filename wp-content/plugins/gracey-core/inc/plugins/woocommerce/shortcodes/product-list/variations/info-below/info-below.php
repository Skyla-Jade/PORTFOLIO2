<?php

if ( ! function_exists( 'gracey_core_add_product_list_variation_info_below' ) ) {
	/**
	 * Function that add variation layout for this module
	 *
	 * @param array $variations
	 *
	 * @return array
	 */
	function gracey_core_add_product_list_variation_info_below( $variations ) {
		$variations['info-below'] = esc_html__( 'Info Below', 'gracey-core' );

		return $variations;
	}

	add_filter( 'gracey_core_filter_product_list_layouts', 'gracey_core_add_product_list_variation_info_below' );
}

if ( ! function_exists( 'gracey_core_register_shop_list_info_below_actions' ) ) {
	/**
	 * Function that override product item layout for current variation type
	 */
	function gracey_core_register_shop_list_info_below_actions() {

		// IMPORTANT - THIS CODE NEED TO COPY/PASTE ALSO INTO THEME FOLDER MAIN WOOCOMMERCE FILE - set_default_layout method

		// Add additional tags around product list item
		add_action( 'woocommerce_before_shop_loop_item', 'gracey_add_product_list_item_holder', 5 ); // permission 5 is set because woocommerce_template_loop_product_link_open hook is added on 10
		add_action( 'woocommerce_after_shop_loop_item', 'gracey_add_product_list_item_holder_end', 30 ); // permission 30 is set because woocommerce_template_loop_add_to_cart hook is added on 10

		// Add additional tags around product list item image
		add_action( 'woocommerce_before_shop_loop_item_title', 'gracey_add_product_list_item_image_holder', 5 ); // permission 5 is set because woocommerce_show_product_loop_sale_flash hook is added on 10
		add_action( 'woocommerce_before_shop_loop_item_title', 'gracey_add_product_list_item_image_holder_end', 30 ); // permission 30 is set because woocommerce_template_loop_product_thumbnail hook is added on 10

        add_action( 'woocommerce_before_shop_loop_item_title', 'gracey_add_product_list_item_additional_image_link', 6 ); // permission 5 is set because woocommerce_show_product_loop_sale_flash hook is added on 10
        add_action( 'woocommerce_before_shop_loop_item_title', 'gracey_add_product_list_item_additional_image_link_end', 29 ); // permission 30 is set because woocommerce_template_loop_product_thumbnail hook is added on 10

		// Add additional tags around product list item content
		add_action( 'woocommerce_shop_loop_item_title', 'gracey_add_product_list_item_content_holder', 5 ); // permission 5 is set because woocommerce_template_loop_product_title hook is added on 10
		add_action( 'woocommerce_after_shop_loop_item', 'gracey_add_product_list_item_content_holder_end', 20 ); // permission 30 is set because woocommerce_template_loop_add_to_cart hook is added on 10
	}

	add_action( 'gracey_core_action_shop_list_item_layout_info-below', 'gracey_core_register_shop_list_info_below_actions' );
}
